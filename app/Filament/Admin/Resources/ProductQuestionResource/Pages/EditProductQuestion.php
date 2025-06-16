<?php

namespace App\Filament\Admin\Resources\ProductQuestionResource\Pages;

use App\Filament\Admin\Resources\ProductQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductQuestion extends EditRecord
{
    protected static string $resource = ProductQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
