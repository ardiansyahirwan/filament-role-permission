<?php

namespace App\Filament\Clusters\AuthorizationManagement\Resources;

use App\Filament\Clusters\AuthorizationManagement;
use App\Filament\Clusters\AuthorizationManagement\Resources\RoleResource\Pages;
use App\Filament\Clusters\AuthorizationManagement\Resources\RoleResource\RelationManagers;
use App\Filament\Clusters\AuthorizationManagement\Resources\RoleResource\RelationManagers\PermissionsRelationManager;
use App\Filament\Clusters\AuthorizationManagement\Resources\RoleResource\RelationManagers\UsersRelationManager;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = AuthorizationManagement::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            RelationGroup::make('user and permission', [
                UsersRelationManager::class,
                PermissionsRelationManager::class,
            ])->badge('new')->badgeColor('danger'),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
