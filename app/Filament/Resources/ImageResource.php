<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImageResource\Pages;
use App\Filament\Resources\ImageResource\RelationManagers;
use App\Models\Image;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use App\Constants\ImageConstants;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class ImageResource extends Resource
{
    protected static ?string $model = Image::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('url')
                    ->directory('real-estates')
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('sort_order')
                    ->unique(ignoreRecord: true)
                    ->numeric()
                    ->required(),
                Toggle::make('main_image')
                    ->default(false)
                    ->disabled(function($livewire, $state, $context){
                        $mainImage = $livewire->ownerRecord->images()->where('main_image', true)->first();
                        if($context == 'edit'){
                            if($mainImage)

                            return $state ? false : true;
                        }elseif($context == 'create'){
                            return $mainImage ? true : false;
                        }
                    }),
                Select::make('status')
                    ->options(ImageConstants::getStatuses())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('url'),
                TextColumn::make('sort_order')
                    ->sortable()
                    ->badge(),
                IconColumn::make('main_image')
                    ->label('is main')
                    ->boolean(),
                TextColumn::make('status')
                    ->getStateUsing(function($record){
                        return ImageConstants::getStatuses()[$record->status];
                    })
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(ImageConstants::getStatuses()),
                TernaryFilter::make('main_image')
                    ->label('is main')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListImages::route('/'),
            'create' => Pages\CreateImage::route('/create'),
            'edit' => Pages\EditImage::route('/{record}/edit'),
            'view' => Pages\ViewImage::route('/{record}'),
        ];
    }
}
