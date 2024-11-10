<?php

namespace App\Filament\Resources;

use App\Constants\RealEstateConstants;
use App\Filament\Resources\RealEstateResource\Pages;
use App\Filament\Resources\RealEstateResource\RelationManagers;
use App\Filament\Resources\RealEstateResource\RelationManagers\ImagesRelationManager;
use App\Models\RealEstate;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RealEstateResource extends Resource
{
    protected static ?string $model = RealEstate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('district_id')
                    ->relationship('district', 'name')
                    ->required(),
                TextInput::make('title_en')
                    ->required(),
                TextInput::make('title_ar')
                    ->required(),
                RichEditor::make('description')
                    ->columnSpanFull()
                    ->required(),
                Select::make('status')
                    ->options(RealEstateConstants::getStatuses())
                    ->required(),
                Select::make('type')
                    ->options(RealEstateConstants::getTypes())
                    ->required(),
                TextInput::make('aed_price')
                    ->reactive()
                    ->numeric()
                    ->required(function(Get $get){
                        return filled($get('usd_price')) == null ? true : false;
                    }),
                TextInput::make('usd_price')
                    ->numeric()
                    ->reactive()
                    ->required(function(Get $get){
                        return filled($get('aed_price')) == null ? true : false;
                    }),
                TextInput::make('size')
                    ->required(),
                TextInput::make('rooms')
                    ->numeric()
                    ->required(),
                DatePicker::make('handover')
                    ->minDate(Carbon::now())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('district.name')
                    ->badge(),
                TextColumn::make('title_en')
                    ->badge(),
                TextColumn::make('title_ar')
                    ->badge(),
                TextColumn::make('status')
                    ->badge()
                    ->getStateUsing(function($record){
                        return RealEstateConstants::getStatuses()[$record->status];
                    }),
                TextColumn::make('aed_price')
                    ->default('###')
                    ->badge(),
                TextColumn::make('usd_price')
                    ->default('###')
                    ->badge(),
                TextColumn::make('type')
                    ->getStateUsing(function($record){
                        return RealEstateConstants::getTypes()[$record->type];
                    }),
                TextColumn::make('size')
                    ->badge(),
                TextColumn::make('rooms')
                    ->badge(),
                TextColumn::make('handover')
                    ->badge(),
            ])
            ->filters([
                //
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
            ImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRealEstates::route('/'),
            'create' => Pages\CreateRealEstate::route('/create'),
            'edit' => Pages\EditRealEstate::route('/{record}/edit'),
        ];
    }
}
