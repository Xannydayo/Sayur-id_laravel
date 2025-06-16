<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductQuestionResource\Pages;
use App\Filament\Admin\Resources\ProductQuestionResource\RelationManagers;
use App\Models\ProductQuestion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductQuestionResource extends Resource
{
    protected static ?string $model = ProductQuestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Tanya Jawab Produk';
    protected static ?string $modelLabel = 'Tanya Jawab Produk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'nama')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Textarea::make('question')
                    ->required()
                    ->minLength(10)
                    ->maxLength(1000),
                Forms\Components\Textarea::make('answer')
                    ->minLength(10)
                    ->maxLength(1000),
                Forms\Components\Select::make('answered_by')
                    ->relationship('answerer', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\DateTimePicker::make('answered_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('question')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('answer')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('answerer.name')
                    ->label('Answered By')
                    ->searchable(),
                Tables\Columns\TextColumn::make('answered_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListProductQuestions::route('/'),
            'create' => Pages\CreateProductQuestion::route('/create'),
            'edit' => Pages\EditProductQuestion::route('/{record}/edit'),
        ];
    }
}
