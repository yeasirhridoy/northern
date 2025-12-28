<?php

namespace App\Filament\Resources\AdmissionSessions\Pages;

use App\Filament\Resources\AdmissionSessions\AdmissionSessionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAdmissionSession extends EditRecord
{
    protected static string $resource = AdmissionSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
