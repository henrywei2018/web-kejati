<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?string $navigationGroup = 'Sites';

    protected static ?string $navigationLabel = 'Halaman Dinamis';

    protected static ?string $modelLabel = 'Halaman';

    protected static ?string $pluralModelLabel = 'Halaman';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Halaman')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('Tipe Halaman')
                            ->options([
                                'page' => 'Page',
                                'profil' => 'Profil',
                                'layanan' => 'Layanan',
                                'berita' => 'Berita',
                            ])
                            ->required()
                            ->default('page')
                            ->helperText('Pilih tipe halaman untuk kategorisasi'),

                        Forms\Components\Select::make('parent_id')
                            ->label('Halaman Induk')
                            ->relationship('parent', 'title')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText('Pilih halaman induk jika ini adalah sub-halaman')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('title')
                            ->label('Judul Halaman')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('/{parent-slug}/{slug} or /{slug} if no parent'),

                        Forms\Components\RichEditor::make('content')
                            ->label('Konten')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'h2',
                                'h3',
                                'bulletList',
                                'orderedList',
                                'link',
                                'blockquote',
                                'codeBlock',
                            ]),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Media')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('featured_image')
                            ->label('Gambar Utama')
                            ->collection('featured_image')
                            ->image()
                            ->imageEditor()
                            ->maxSize(5120)
                            ->helperText('Upload gambar utama halaman (Max: 5MB)'),

                        SpatieMediaLibraryFileUpload::make('gallery')
                            ->label('Galeri Gambar')
                            ->collection('gallery')
                            ->image()
                            ->imageEditor()
                            ->multiple()
                            ->reorderable()
                            ->maxSize(5120)
                            ->helperText('Upload multiple gambar untuk galeri (Max: 5MB per gambar)')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\TextInput::make('order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->helperText('Urutan tampilan di menu (angka kecil muncul lebih dulu)'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->required()
                            ->helperText('Halaman yang tidak aktif tidak akan ditampilkan di website'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Meta Data (Opsional)')
                    ->schema([
                        Forms\Components\KeyValue::make('meta')
                            ->label('Meta Data')
                            ->keyLabel('Kunci')
                            ->valueLabel('Nilai')
                            ->helperText('Tambahkan data tambahan (contoh: meta_title, meta_description, dll)')
                            ->columnSpanFull(),
                    ])
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable()
                    ->width(80),

                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->colors([
                        'primary' => 'page',
                        'success' => 'profil',
                        'warning' => 'layanan',
                        'info' => 'berita',
                    ])
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Page $record): string => $record->full_slug),

                Tables\Columns\TextColumn::make('parent.title')
                    ->label('Halaman Induk')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->placeholder('Halaman Utama'),

                Tables\Columns\SpatieMediaLibraryImageColumn::make('featured_image')
                    ->label('Gambar')
                    ->collection('featured_image')
                    ->width(100),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),

                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipe')
                    ->options([
                        'page' => 'Page',
                        'profil' => 'Profil',
                        'layanan' => 'Layanan',
                        'berita' => 'Berita',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('Semua halaman')
                    ->trueLabel('Hanya aktif')
                    ->falseLabel('Hanya tidak aktif'),

                Tables\Filters\Filter::make('parent')
                    ->label('Hanya Parent')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->whereNull('parent_id')),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('order');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
