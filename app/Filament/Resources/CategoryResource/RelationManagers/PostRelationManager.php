<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use App\Models\Category;
use App\Models\Post;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostRelationManager extends RelationManager
{
    protected static string $relationship = 'post';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('content')
                    ->required()
                    ->maxLength(65535),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->multiple()
                    ->options(Category::pluck('name', 'id'))

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('content')
                    ->words(5)
                    ->tooltip(fn (Model $record): string => $record->content) //TextColumn $column, Post $record) {return $record->content;}
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault : true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('category_id')
                    ->searchable()
                    ->label('Cateory')
                    ->getStateUsing(function (Model $record): string {
                       // var_dump($record);
                        //    model->category);
                        $category = Category::query()->find($record->category_id);
                        return $category ? $category->name : '-';
                    }),
                TextColumn::make('created_at')
                    ->toggleable(isToggledHiddenByDefault : true)
                    ->dateTime(),
                TextColumn::make('updated_at')
                    ->toggleable(isToggledHiddenByDefault : true)
                    ->dateTime(),
            ])
            ->defaultSort('title')
            ->filters([
                //
            ])
            ->headerActions([
                // ...
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([

                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'view' => Pages\ViewPost::route('/{record}'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
