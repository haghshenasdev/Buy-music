<?php

namespace App\Http\Livewire;

use App\Actions\ActivateOrDeactiveAction;
use App\Actions\DeleteAction;
use App\Actions\ShowAction;
use App\Http\Livewire\Current;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use LaravelViews\Facades\Header;
use LaravelViews\Views\TableView;
use Morilog\Jalali\Jalalian;

class UsersTableView extends TableView
{
    /**
     * Sets a model class to get the initial data
     */
    protected function repository()
    {
        return User::query();
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
        return [
            Header::title('id')->sortBy('id'),
            'نام',
            'ایمیل',
            'تاریخ ثبت نام',
        ];
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
            $model->name,
            $model->email,
            Jalalian::fromDateTime($model->created_at),
        ];

        return $row;
    }

    protected function actionsByRow()
    {
        return [
            new ShowAction('showUser'),
//            new ActivateOrDeactiveAction('کاربر','update-user'),
            new DeleteAction('کاربر','admin')
        ];
    }
}
