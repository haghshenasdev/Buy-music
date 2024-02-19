<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MusicResource\Pages;
use App\Filament\Resources\MusicResource\RelationManagers;
use App\Models\Music;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class MusicResource extends Resource
{
    protected static ?string $model = Music::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->afterStateUpdated(function (Closure $get, Closure $set, ?string $state) {
                        if (! $get('is_slug_changed_manually') && filled($state)) {
                            $set('slug', Str::slug($state));
                        }
                    })
                    ->label("نام")
                    ->reactive()
                    ->required(),
                TextInput::make('slug')
                    ->afterStateUpdated(function (Closure $set) {
                        $set('is_slug_changed_manually', true);
                    })
                    ->label("آدرس")
                    ->required(),
                Hidden::make('is_slug_changed_manually')
                    ->default(false)
                    ->dehydrated(false),
                Forms\Components\Checkbox::make("is_active")->label("نمایش در سایت"),
                Forms\Components\Checkbox::make("presell")->label("پیش خرید"),
                TextInput::make("amount")->numeric()->label("قیمت"),
                TextInput::make("min_amount")->numeric()->label("حداقل قیمت"),
                FileUpload::make('cover')->image()->disk('public')->label("کاور")->required(),
                FileUpload::make('bg_page')->image()->disk('public')->label("تصویر زمینه"),
                TinyEditor::make('description')->label("توضیحات")->required(),
                TinyEditor::make('description_download')->label("توضیحات دانلود"),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover')->label("کاور"),
                Tables\Columns\TextColumn::make('title')->label("عنوان"),
                Tables\Columns\TextColumn::make('slug')->label("آدرس"),
                Tables\Columns\TextColumn::make('amount')->label("مبلغ")->default("دلخواه"),
                IconColumn::make('is_active')->label("نمایش درسایت")
                    ->boolean()
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
            ])
            ->reorderable()
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListMusic::route('/'),
            'create' => Pages\CreateMusic::route('/create'),
            'edit' => Pages\EditMusic::route('/{record}/edit'),
        ];
    }
}
