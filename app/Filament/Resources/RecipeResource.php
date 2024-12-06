<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecipeResource\Pages;
use App\Filament\Resources\RecipeResource\RelationManagers;
use App\Models\Recipe;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RecipeResource extends Resource
{
    protected static ?string $model = Recipe::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';


    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(200),
                        Forms\Components\TextInput::make('video')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Radio::make('status')
                            ->required()
                            ->inline()
                            ->inlineLabel(false)
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                            ])
                            ->default('active'),
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->required(),
                    ]),
                Forms\Components\Section::make('Description and Allergens')
                    ->schema([
                        Forms\Components\RichEditor::make('description')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('ingridients')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('allergens')
                            ->required()
                            ->columnSpanFull(),
                    ]),
                Section::make('Steps')
                    ->schema([
                        Repeater::make('steps')
                            ->relationship() //relasi untuk stepnya sudah pakai laravel jadi gak perlu setting lagi
                            ->schema([
                                Forms\Components\RichEditor::make('description')
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('image')
                                    ->image()
                                    ->required()

                            ])
                    ])


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(
                        #add short funtion status active inactive
                        fn(string $state): string => match ($state) {
                            'active' => 'success',
                            'inactive' => 'danger',
                        },
                    ),
                Tables\Columns\TextColumn::make('steps_count')->counts('steps')
                    ->label('Steps'),
                Tables\Columns\TextColumn::make('video')
                    ->searchable(),

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
            'index' => Pages\ListRecipes::route('/'),
            'create' => Pages\CreateRecipe::route('/create'),
            'edit' => Pages\EditRecipe::route('/{record}/edit'),
        ];
    }
}
