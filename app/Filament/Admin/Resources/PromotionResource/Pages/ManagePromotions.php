<?php

namespace App\Filament\Admin\Resources\PromotionResource\Pages;

use App\Filament\Admin\Resources\PromotionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePromotions extends ManageRecords
{
    protected static string $resource = PromotionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
