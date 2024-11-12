<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSettings extends ListRecords
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->hidden(fn ($livewire) => (bool) $livewire->getTableQuery()->count() == 1 ? true : false)
                // ->hidden(function($livewire){
                //     $recordsCount = $livewire->getTableQuery()->count();
                //     return false;
                //     if($recordsCount == 1){
                //         return false;
                //     }else{
                //         return true;
                //     }
                // }),
        ];
    }
}
