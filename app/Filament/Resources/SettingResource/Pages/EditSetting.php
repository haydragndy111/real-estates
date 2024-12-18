<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['content'] = json_encode($data['content']);
        return $data;
    }

    protected function  mutateFormDataBeforeFill(array $data): array
    {
        $data['content'] = json_decode($data['content'], true);
        return $data;
    }
}
