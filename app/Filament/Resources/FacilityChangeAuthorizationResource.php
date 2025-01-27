<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FacilityChangeAuthorizationResource\Pages;
use App\Filament\Resources\FacilityChangeAuthorizationResource\RelationManagers;
use App\Models\FacilityChangeAuthorization;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FacilityChangeAuthorizationResource extends Resource
{
    protected static ?string $navigationGroup = 'Types';

    protected static ?string $model = FacilityChangeAuthorization::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('value')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('value')
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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListFacilityChangeAuthorizations::route('/'),
            'create' => Pages\CreateFacilityChangeAuthorization::route('/create'),
            'view' => Pages\ViewFacilityChangeAuthorization::route('/{record}'),
            'edit' => Pages\EditFacilityChangeAuthorization::route('/{record}/edit'),
        ];
    }
}
