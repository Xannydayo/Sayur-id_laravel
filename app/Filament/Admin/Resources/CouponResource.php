<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CouponResource\Pages;
use App\Filament\Admin\Resources\CouponResource\RelationManagers;
use App\Models\Coupon;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'Kupon Diskon';
    protected static ?string $pluralLabel = 'Kupon';
    protected static ?string $label = 'Kupon';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->label('Kode Kupon')
                    ->required()
                    ->unique(ignoreRecord: true),
                Select::make('type')
                    ->label('Tipe Diskon')
                    ->options([
                        'percentage' => 'Persentase',
                        'fixed' => 'Nominal',
                    ])
                    ->required(),
                TextInput::make('value')
                    ->label('Nilai Diskon')
                    ->numeric()
                    ->required(),
                TextInput::make('min_order')
                    ->label('Minimal Order')
                    ->numeric(),
                TextInput::make('max_uses')
                    ->label('Maksimal Penggunaan')
                    ->numeric(),
                TextInput::make('used_count')
                    ->label('Sudah Digunakan')
                    ->numeric()
                    ->disabled(),
                DatePicker::make('start_date')
                    ->label('Mulai Berlaku'),
                DatePicker::make('end_date')
                    ->label('Berakhir'),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->label('Kode'),
                TextColumn::make('type')->label('Tipe'),
                TextColumn::make('value')->label('Nilai'),
                TextColumn::make('min_order')->label('Min Order'),
                TextColumn::make('max_uses')->label('Max Uses'),
                TextColumn::make('used_count')->label('Used'),
                TextColumn::make('start_date')->label('Mulai'),
                TextColumn::make('end_date')->label('Akhir'),
                BooleanColumn::make('is_active')->label('Aktif'),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
