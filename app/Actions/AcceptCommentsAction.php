<?php

namespace App\Actions;

use App\Models\Comments;
use Illuminate\Support\Facades\Gate;
use LaravelViews\Actions\Action;
use LaravelViews\Views\View;

class AcceptCommentsAction extends ActivateOrDeactiveAction
{
    /**
     * Any title you want to be displayed
     * @var String
     * */
    public $title = "پذیرش/رد نظر";

    /**
     * This should be a valid Feather icon string
     * @var String
     */
    public $icon = "check";

    /**
     * Execute the action when the user clicked on the button
     *
     * @param $model Model object of the list where the user has clicked
     * @param $view Current view where the action was executed from
     */
    public function handle($model, View $view)
    {
        if (Gate::allows($this->allows)){
            $com = Comments::query()->find($model->comments_id);
            Comments::query()->find($model->comments_id)->update([
                'is_active' => (is_null($com->is_active) or !$com->is_active) ? 1 : null
            ]);
            $this->success('وضعیت نظر با موفقیت تغییر یافت .');
        }else abort(403);

    }

    public function getConfirmationMessage($item = null): string
    {
        return 'آیا از پذیرش یا رد این نظر مطئن هستید ؟';
    }
}
