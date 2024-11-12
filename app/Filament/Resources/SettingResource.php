<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('header_title')
                    ->columnSpanFull()
                    ->required(),
                Textarea::make('header_text')
                    ->columnSpanFull()
                    ->required(),
                Repeater::make('content')
                    ->required()
                    ->columnSpanFull()
                    ->statePath('content')
                    ->schema([
                        TextInput::make('title')
                            ->required(),
                        RichEditor::make('text')
                            ->required(),
                    ]),
                Section::make('Contact Us')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('contact_header_title')
                            ->required()
                            ->label('Header Title'),
                        TextInput::make('contact_header_text')
                            ->required()
                            ->label('Header Text'),
                        TextInput::make('toll_free_number')
                            ->required(),
                        TextInput::make('email')
                            ->required()
                            ->email(),
                        TextInput::make('whatsapp')
                            ->required(),
                        TextInput::make('location')
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('header_title')
                    ->badge(),
                TextColumn::make('toll_free_number')
                    ->badge(),
                TextColumn::make('email')
                    ->badge(),
                TextColumn::make('whatsapp')
                    ->badge(),
                TextColumn::make('location')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                    // Tables\Actions\BulkActionGroup::make([
                    //     Tables\Actions\DeleteBulkAction::make(),
                    // ]),
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
