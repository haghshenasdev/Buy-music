<?php

namespace App\Http\Livewire;

use App\Actions\ActivateOrDeactiveAction;
use App\Actions\DeleteAction;
use App\Actions\MailingAction;
use App\Actions\ShowAction;
use App\Actions\ShowMusicAction;
use App\Models\Buys;
use App\Models\Music;
use LaravelViews\Views\TableView;

class MusicsTableView extends TableView
{
    /**
     * Sets a model class to get the initial data
     */
    protected function repository()
    {
        return Music::query();
    }

    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */
    public function headers(): array
    {
        return [
            'عنوان',
            'تعداد خرید',
            'دریافتی',
        ];
    }

    /**
     * Sets the data to every cell of a single row
     *
     * @param $model Current model for each row
     */
    public function row($model): array
    {
        return [
            $model->title,
            Buys::query()->where('music',$model->id)->count('id'),
            number_format(Buys::query()->where('music',$model->id)->sum('amount')),
        ];
    }

    protected function actionsByRow()
    {
        return [
            new ActivateOrDeactiveAction('music','admin'),
            new DeleteAction('موزیک','admin'),
            new ShowAction('MusicShowAndEdit'),
            new ShowMusicAction(),
            new MailingAction(),
        ];
    }
}
