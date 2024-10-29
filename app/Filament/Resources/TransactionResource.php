<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('customer_id')
                ->relationship('customer', 'first_name')
                ->required()
                ->label('Customer'),
            Forms\Components\TextInput::make('total_amount')
                ->numeric()
                ->required()
                ->label('Total Amount'),
            Forms\Components\Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'completed' => 'Completed',
                    'canceled' => 'Canceled',
                ])
                ->required()
                ->label('Status'),
            Forms\Components\DatePicker::make('transaction_date')
                ->default(now())
                ->label('Transaction Date'),
            Forms\Components\HasManyRepeater::make('products')
                ->relationship('products')
                ->schema([
                    Forms\Components\Select::make('product_id')
                        ->relationship('products', 'product_name')
                        ->required()
                        ->label('Product'),
                    Forms\Components\TextInput::make('quantity')
                        ->numeric()
                        ->required()
                        ->label('Quantity'),
                    Forms\Components\TextInput::make('price')
                        ->numeric()
                        ->required()
                        ->label('Price'),
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.first_name')
                ->label('Customer')->sortable()
                ->searchable(),

                Tables\Columns\TextColumn::make('total_amount')
                ->sortable(),

                Tables\Columns\TextColumn::make('status')
                ->sortable(),

                Tables\Columns\TextColumn::make('transaction_date')
                ->date(),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
