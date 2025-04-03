<?php

namespace App\Filament\Resources;

use App\Enums\DiscountType;
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Leandrocfe\FilamentPtbrFormFields\Money;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('filament-panels::resources/product-resource.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-panels::resources/product-resource.label.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('filament-panels::resources/product-resource.form.name.label')
                    ->translateLabel()
                    ->required()
                    ->maxLength(55),
                Money::make('price')
                    ->label('filament-panels::resources/product-resource.form.price.label')
                    ->translateLabel()
                    ->default('0,00')
                    ->required(),
                Repeater::make('discounts')
                    ->relationship('discounts')
                    ->label('filament-panels::resources/product-resource.form.discounts.label')
                    ->translateLabel()
                    ->addActionLabel(__('filament-panels::resources/product-resource.form.discounts.action.label'))
                    ->schema([
                        Select::make('type')
                            ->label('filament-panels::resources/product-resource.form.discounts.type.label')
                            ->translateLabel()
                            ->options(DiscountType::class)
                            ->default(DiscountType::FIXED)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('value', null);

                                if ($state === DiscountType::PERCENTAGE) {
                                    $set('value', 0);
                                }
                            })
                            ->required(),
                        TextInput::make('value')
                            ->label('filament-panels::resources/product-resource.form.discounts.value.label')
                            ->translateLabel()
                            ->suffix('%')
                            ->inputMode('decimal')
                            ->rule('numeric')
                            ->type('number')
                            ->step(0.01)
                            ->minValue(0)
                            ->required(fn($get) => $get('type') !== null)
                            ->hidden(fn($get) => !in_array($get('type'), [DiscountType::PERCENTAGE, DiscountType::PERCENTAGE->value])),
                        Money::make('value')
                            ->label('filament-panels::resources/product-resource.form.discounts.value.label')
                            ->translateLabel()
                            ->default('0,00')
                            ->required(fn($get) => in_array($get('type'), [DiscountType::FIXED, DiscountType::FIXED->value]))
                            ->hidden(fn($get) => !in_array($get('type'), [DiscountType::FIXED, DiscountType::FIXED->value])),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('filament-panels::resources/product-resource.table.name.label')
                    ->translateLabel()
                    ->searchable(),
                TextColumn::make('price')
                    ->label('filament-panels::resources/product-resource.form.price.label')
                    ->translateLabel()
                    ->money('BRL')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('filament-panels::resources/product-resource.table.created_at.label')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('filament-panels::resources/product-resource.table.updated_at.label')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
