<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RestaurantResource\Pages;
use App\Filament\Resources\RestaurantResource\RelationManagers;
use App\Models\City;
use App\Models\Country;
use App\Models\Restaurant;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RestaurantResource extends Resource
{
    protected static ?string $model = Restaurant::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Restaurant Details')->columns(2)->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(200),
                    Forms\Components\TextInput::make('address')
                        ->required()
                        ->maxLength(200),
                    Select::make('country_id')
                        ->live()
                        ->dehydrated(false)
                        ->required()
                        ->label('Country')
                        ->searchable(true)
                        ->options(Country::pluck('name', 'id'))
                        ->afterStateUpdated(function (Set $set) {
                            $set('city_id', null);
                        }),
                    Forms\Components\Select::make('city_id')
                        ->required()
                        ->label('City')
                        ->searchable(true)
                        ->options(
                            // function (Get $get) {
                            //     return City::where('country_id', $get('country_id'))->pluck('name', 'id');
                            // }
                            //gak jalan ketika kita lakukan edit dan hanya berlaku create

                            // function (?Restaurant $record, Get $get, Set $set) {
                            //     if (! empty($record) && empty($get('country_id'))) {
                            //         $set('country_id', $record->city->country_id);
                            //         $set('city_id', $record->city_id);
                            //     }
                            //     return City::where('country_id', $get('country_id'))->pluck('name', 'id');
                            // }

                            function (callable $get) {
                                $countryId = $get('country_id');
                                if (!$countryId) {
                                    return [];
                                }

                                $country = Country::find($countryId);
                                $cities = $country?->cities;

                                if (!$cities || $cities->isEmpty()) {
                                    return ['' => 'Tidak ada data kota untuk negara ini'];
                                }

                                return $cities->pluck('name', 'id')->toArray();
                            }


                        ),
                    Forms\Components\Select::make('status')
                        ->options([
                            'open' => 'Open',
                            'closed' => 'Closed',
                        ])
                        ->required(),
                    Forms\Components\TextInput::make('website')
                        ->required()
                        ->maxLength(255),


                ]),
                Forms\Components\Section::make('Location Details')->columns(2)->schema([
                    Forms\Components\TextInput::make('latitude')
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make('longitude')
                        ->required()
                        ->numeric(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('city.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    #badge status open and close  with filament
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'open' => 'success',
                        'closed' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('website')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListRestaurants::route('/'),
            'create' => Pages\CreateRestaurant::route('/create'),
            'edit' => Pages\EditRestaurant::route('/{record}/edit'),
        ];
    }
}
