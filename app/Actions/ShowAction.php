<?php

namespace App\Actions;

use LaravelViews\Actions\Action;
use LaravelViews\Views\View;

class ShowAction extends Action
{
    public function __construct(public $route)
    {
        parent::__construct();
    }

    /**
     * Any title you want to be displayed
     * @var String
     * */
    public $title = "نمایش و ویرایش";

    /**
     * This should be a valid Feather icon string
     * @var String
     */
    public $icon = "eye";

    /**
     * Execute the action when the user clicked on the button
     *
     * @param $model Model object of the list where the user has clicked
     * @param $view Current view where the action was executed from
     */
    public function handle($model, View $view)
    {
        return redirect(route($this->route).'?id='.$model->id);
    }
}
