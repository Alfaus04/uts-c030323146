<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('product_name')
                ->required()
                ->label('Product Name'),
            Forms\Components\TextInput::make('product_code')
                ->unique(ignoreRecord: true)
                ->label('Product Code'),
            Forms\Components\Select::make('category_id')
                ->relationship('category', 'category_name')
                ->required()
                ->label('Category'),
            Forms\Components\TextInput::make('price')
                ->numeric()
                ->required()
                ->label('Price'),
            Forms\Components\TextInput::make('stock')
                ->numeric()
                ->default(0)
                ->label('Stock'),
            Forms\Components\Textarea::make('description')
                ->label('Description'),
            Forms\Components\TextInput::make('material')
                ->label('Material'),
            Forms\Components\TextInput::make('weight')
                ->numeric()
                ->label('Weight'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product_name')
                ->sortable()
                ->searchable(),
                
                Tables\Columns\TextColumn::make('product_code')
                ->sortable()
                ->searchable(),

                Tables\Columns\TextColumn::make('category.category_name')
                ->label('Category')
                ->sortable()
                ->searchable(),

                Tables\Columns\TextColumn::make('price')
                ->sortable(),

                Tables\Columns\TextColumn::make('stock')
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
