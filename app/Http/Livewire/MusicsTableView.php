<?php

namespace App\Http\Livewire;

use App\Actions\ActivateOrDeactiveAction;
use App\Actions\DeleteCommentAction;
use App\Actions\MailingAction;
use App\Actions\ShowAction;
use App\Actions\ShowBuysAction;
use App\Actions\ShowCommentsAction;
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
            'دریافتی (تومان)',
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
            new DeleteCommentAction('موزیک','admin'),
            new ShowAction('MusicShowAndEdit'),
            new ShowMusicAction(),
            new MailingAction(),
            new ShowCommentsAction(),
            new ShowBuysAction(),
        ];
    }
}
