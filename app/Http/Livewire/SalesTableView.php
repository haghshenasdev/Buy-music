<?php

namespace App\Http\Livewire;

use App\Actions\DownloadMusicAction;
use App\Actions\ShowMusicAction;
use App\Models\Buys;
use Illuminate\Support\Facades\Auth;
use LaravelViews\Views\TableView;

class SalesTableView extends TableView
{
    /**
     * Sets a model class to get the initial data
     */
    protected function repository()
    {
        return Buys::query()->where('user',Auth::id())->join('musics','buys.music','=','musics.id')
            ->select(['musics.title','musics.slug','buys.*']);
    }

    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */
    public function headers(): array
    {
        return [
            'نام موزیک',
            'مبلغ (تومان)',
            'تاریخ خرید',
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
            number_format($model->amount),
            $model->created_at,
        ];
    }

    protected function actionsByRow()
    {
        return [
            new ShowMusicAction(),
            new DownloadMusicAction(),
        ];
    }
}
