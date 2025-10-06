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
                Forms\Components\Tabs::make('Tabs')
                    ->tabs([
                        // TAB 1: KONTEN UTAMA
                        Forms\Components\Tabs\Tab::make('Konten Utama')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\Section::make('Informasi Dasar')
                                    ->description('Informasi dasar dan pengaturan halaman')
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
                                            ->helperText('Pilih tipe halaman untuk kategorisasi')
                                            ->native(false),

                                        Forms\Components\Select::make('parent_id')
                                            ->label('Halaman Induk')
                                            ->relationship('parent', 'title')
                                            ->searchable()
                                            ->preload()
                                            ->nullable()
                                            ->helperText('Kosongkan jika ini adalah halaman utama/parent')
                                            ->native(false),
                                    ])
                                    ->columns(2),

                                Forms\Components\Section::make('Detail Halaman')
                                    ->description('Judul, URL, dan konten halaman')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Judul Halaman')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                                            ->maxLength(255)
                                            ->placeholder('Masukkan judul halaman'),

                                        Forms\Components\TextInput::make('slug')
                                            ->label('Slug (URL)')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255)
                                            ->helperText('URL akan menjadi: /{parent-slug}/{slug} atau /{slug}')
                                            ->placeholder('url-halaman'),

                                        Forms\Components\RichEditor::make('content')
                                            ->label('Konten Halaman')
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
                                            ])
                                            ->placeholder('Tulis konten halaman di sini...'),
                                    ])
                                    ->columns(2),
                            ]),

                        // TAB 2: MEDIA & GAMBAR
                        Forms\Components\Tabs\Tab::make('Media & Gambar')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\Section::make('Gambar Konten')
                                    ->description('Upload gambar untuk konten halaman')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('featured_image')
                                            ->label('Gambar Utama')
                                            ->collection('featured_image')
                                            ->image()
                                            ->imageEditor()
                                            ->maxSize(5120)
                                            ->helperText('Gambar utama yang ditampilkan di konten halaman (Max: 5MB)')
                                            ->imageEditorAspectRatios([
                                                '16:9',
                                                '4:3',
                                                '1:1',
                                            ]),

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
                            ]),

                        // TAB 3: HEADER & BREADCRUMB
                        Forms\Components\Tabs\Tab::make('Header & Breadcrumb')
                            ->icon('heroicon-o-rectangle-stack')
                            ->schema([
                                Forms\Components\Section::make('Pengaturan Header')
                                    ->description('Kustomisasi tampilan header dan breadcrumb halaman')
                                    ->schema([
                                        Forms\Components\Placeholder::make('info')
                                            ->label('ℹ️ Informasi')
                                            ->content('Header breadcrumb adalah bagian atas halaman yang menampilkan judul, badge, dan navigasi. Anda dapat mengkustomisasi gambar dan icon yang ditampilkan.')
                                            ->columnSpanFull(),

                                        SpatieMediaLibraryFileUpload::make('header_image')
                                            ->label('Gambar Header')
                                            ->collection('header_image')
                                            ->image()
                                            ->imageEditor()
                                            ->maxSize(5120)
                                            ->helperText('Gambar yang ditampilkan di header breadcrumb. Jika kosong, akan menggunakan Gambar Utama.')
                                            ->imageEditorAspectRatios([
                                                '1:1',
                                                '4:3',
                                            ])
                                            ->columnSpanFull(),

                                        SpatieMediaLibraryFileUpload::make('header_icon')
                                            ->label('Icon Dekorasi SVG')
                                            ->collection('header_icon')
                                            ->acceptedFileTypes(['image/svg+xml'])
                                            ->maxSize(1024)
                                            ->helperText('Icon SVG untuk dekorasi di samping header (opsional, Max: 1MB)')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        // TAB 4: PENGATURAN & SEO
                        Forms\Components\Tabs\Tab::make('Pengaturan & SEO')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Forms\Components\Section::make('Pengaturan Tampilan')
                                    ->description('Atur urutan dan status aktif halaman')
                                    ->schema([
                                        Forms\Components\TextInput::make('order')
                                            ->label('Urutan Tampilan')
                                            ->numeric()
                                            ->default(0)
                                            ->required()
                                            ->helperText('Urutan halaman di menu navigasi (angka kecil tampil lebih dulu)')
                                            ->minValue(0)
                                            ->suffix('(0 = paling atas)'),

                                        Forms\Components\Toggle::make('is_active')
                                            ->label('Status Aktif')
                                            ->default(true)
                                            ->required()
                                            ->helperText('Halaman yang tidak aktif tidak akan ditampilkan di website')
                                            ->inline(false),
                                    ])
                                    ->columns(2),

                                Forms\Components\Section::make('SEO & Meta Data')
                                    ->description('Optimasi untuk mesin pencari (SEO)')
                                    ->schema([
                                        Forms\Components\Placeholder::make('seo_info')
                                            ->label('💡 Tips SEO')
                                            ->content('Gunakan meta_title dan meta_description untuk SEO yang lebih baik. Meta keywords bisa diisi dengan kata kunci yang relevan.')
                                            ->columnSpanFull(),

                                        Forms\Components\KeyValue::make('meta')
                                            ->label('Meta Data')
                                            ->keyLabel('Kunci')
                                            ->valueLabel('Nilai')
                                            ->helperText('Contoh: meta_title, meta_description, meta_keywords, author, etc.')
                                            ->addActionLabel('Tambah Meta Data')
                                            ->reorderable()
                                            ->columnSpanFull()
                                            ->default([
                                                'meta_title' => '',
                                                'meta_description' => '',
                                                'meta_keywords' => '',
                                            ]),
                                    ])
                                    ->collapsible(),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
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
