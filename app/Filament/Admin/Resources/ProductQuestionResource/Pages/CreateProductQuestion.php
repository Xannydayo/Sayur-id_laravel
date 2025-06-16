<?php

namespace App\Filament\Admin\Resources\ProductQuestionResource\Pages;

use App\Filament\Admin\Resources\ProductQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProductQuestion extends CreateRecord
{
    protected static string $resource = ProductQuestionResource::class;
}
