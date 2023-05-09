<?php

namespace App\Http\Livewire;

use App\Actions\ActivateOrDeactiveAction;
use App\Actions\DeleteAction;
use App\Actions\ShowAction;
use App\Actions\ShowBuysAction;
use App\Http\Livewire\Current;
use App\Models\Buys;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use LaravelViews\Facades\Header;
use LaravelViews\Views\TableView;
use Morilog\Jalali\Jalalian;

class BuysTableView extends TableView
{
    /**
     * Sets a model class to get the initial data
     */
    protected function repository()
    {
        $q = Buys::query();

        if (Request::has('mid')){
            $q->where('music',Request::integer('mid'));
        }
        return $q->join('users','buys.user','=','users.id')
            ->join('musics','buys.music','=','musics.id')
            ->select(['buys.id','buys.amount','buys.created_at','buys.is_presell','buys.RefID','users.name','users.email','musics.title']);
    }

    public $searchBy = ['name', 'email'];

    public $sortOrder = 'desc';

    public $sortBy = 'id';

    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */
    public function headers(): array
    {
        $headers = [
            Header::title('id')->sortBy('id'),
            'کاربر',
            Header::title('مبلغ (تومان)')->sortBy('amount'),
            'تاریخ خرید',
            'نوع خرید',
            'کد پیگیری تراکنش',
        ];

        if (!Request::has('mid')) $headers[] = 'موزیک';

        return $headers;
    }

    /**
     * Sets the data to every cell of a single row
     *
     * @param $model Current model for each row
     */
    public function row($model): array
    {
        $row = [
            $model->id,
            $model->name . '<br>' . $model->email,
            number_format($model->amount),
            Jalalian::fromDateTime($model->created_at),
            $model->is_presell ? 'پیش خرید' : 'خرید',
            $model->RefID,
        ];

        if (!Request::has('mid')) $row[] = $model->title;

        return $row;
    }

    protected function actionsByRow()
    {
        return [
            new DeleteAction('خرید','admin'),
        ];
    }
}
