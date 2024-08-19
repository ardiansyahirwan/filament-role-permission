<?php

namespace App\Filament\Clusters\AuthorizationManagement\Resources\RoleResource\Pages;

use App\Filament\Clusters\AuthorizationManagement\Resources\RoleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
