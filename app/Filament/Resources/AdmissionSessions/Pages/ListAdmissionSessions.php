<?php

namespace App\Filament\Resources\AdmissionSessions\Pages;

use App\Filament\Resources\AdmissionSessions\AdmissionSessionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdmissionSessions extends ListRecords
{
    protected static string $resource = AdmissionSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
