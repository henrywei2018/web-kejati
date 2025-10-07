<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NavigationResource\Pages;
use App\Models\Navigation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NavigationResource extends Resource
{
    protected static ?string $model = Navigation::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    protected static ?string $navigationGroup = 'Sites';

    protected static ?string $navigationLabel = 'Menu Navigasi';

    protected static ?string $modelLabel = 'Navigasi';

    protected static ?string $pluralModelLabel = 'Navigasi';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Menu')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('Tipe Menu')
                            ->options([
                                'page' => 'Link ke Halaman',
                                'custom' => 'Link Custom',
                                'external' => 'Link External',
                                'dropdown' => 'Dropdown (Parent Menu)',
                            ])
                            ->required()
                            ->default('custom')
                            ->reactive()
                            ->native(false)
                            ->helperText('Pilih tipe menu'),

                        Forms\Components\Select::make('parent_id')
                            ->label('Parent Menu')
                            ->options(function ($record) {
                                return \App\Models\Navigation::query()
                                    ->when($record, fn ($q) => $q->where('id', '!=', $record->id))
                                    ->orderBy('order')
                                    ->get()
                                    ->mapWithKeys(function ($nav) {
                                        $label = $nav->parent
                                            ? "{$nav->parent->label} > {$nav->label}"
                                            : $nav->label;
                                        return [$nav->id => $label];
                                    })
                                    ->toArray();
                            })
                            ->searchable()
                            ->nullable()
                            ->helperText('Kosongkan untuk menu utama, atau pilih menu lain sebagai parent'),

                        Forms\Components\TextInput::make('label')
                            ->label('Label Menu')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Nama yang ditampilkan di menu')
                            ->hidden(fn (Forms\Get $get) => $get('type') === 'page'),

                        Forms\Components\Select::make('page_id')
                            ->label('Pilih Halaman')
                            ->options(function () {
                                return \App\Models\Page::query()
                                    ->active()
                                    ->orderBy('title')
                                    ->get()
                                    ->mapWithKeys(function ($page) {
                                        $label = $page->parent
                                            ? "{$page->parent->title} > {$page->title}"
                                            : $page->title;
                                        return [$page->id => $label];
                                    })
                                    ->toArray();
                            })
                            ->searchable()
                            ->required()
                            ->helperText('Label dan URL akan otomatis dari halaman')
                            ->visible(fn (Forms\Get $get) => $get('type') === 'page'),

                        Forms\Components\TextInput::make('url')
                            ->label('URL')
                            ->maxLength(255)
                            ->helperText('Contoh: /contact atau https://example.com')
                            ->required(fn (Forms\Get $get) => in_array($get('type'), ['custom', 'external']))
                            ->hidden(fn (Forms\Get $get) => in_array($get('type'), ['page', 'dropdown'])),

                        Forms\Components\Select::make('target')
                            ->label('Target Link')
                            ->options([
                                '_self' => 'Same Tab (_self)',
                                '_blank' => 'New Tab (_blank)',
                            ])
                            ->default('_self')
                            ->required()
                            ->native(false)
                            ->hidden(fn (Forms\Get $get) => $get('type') === 'dropdown'),

                        Forms\Components\TextInput::make('icon')
                            ->label('Icon Class')
                            ->maxLength(255)
                            ->helperText('Contoh: fas fa-home (opsional)'),

                        Forms\Components\TextInput::make('order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->helperText('Urutan tampilan (angka kecil muncul lebih dulu)'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->required(),
                    ])
                    ->columns(2),
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
                        'success' => 'custom',
                        'warning' => 'external',
                        'info' => 'dropdown',
                    ])
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'page' => 'Page',
                        'custom' => 'Custom',
                        'external' => 'External',
                        'dropdown' => 'Dropdown',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('label')
                    ->label('Label')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Navigation $record): ?string => $record->computed_url),

                Tables\Columns\TextColumn::make('parent.label')
                    ->label('Parent Menu')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->placeholder('Menu Utama'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
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
                        'custom' => 'Custom',
                        'external' => 'External',
                        'dropdown' => 'Dropdown',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('Semua menu')
                    ->trueLabel('Hanya aktif')
                    ->falseLabel('Hanya tidak aktif'),

                Tables\Filters\Filter::make('parent')
                    ->label('Hanya Parent')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->whereNull('parent_id')),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNavigations::route('/'),
            'create' => Pages\CreateNavigation::route('/create'),
            'edit' => Pages\EditNavigation::route('/{record}/edit'),
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
