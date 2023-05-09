<?php

namespace App\Actions;

use LaravelViews\Actions\Action;
use LaravelViews\Views\View;

class ShowBuysAction extends Action
{
    /**
     * Any title you want to be displayed
     * @var String
     * */
    public $title = "نمایش خرید ها";

    /**
     * This should be a valid Feather icon string
     * @var String
     */
    public $icon = "heart";

    /**
     * Execute the action when the user clicked on the button
     *
     * @param $model Model object of the list where the user has clicked
     * @param $view Current view where the action was executed from
     */
    public function handle($model, View $view)
    {
        return redirect()->route('buys',['mid' => $model->id]);
    }
}
