<?php

namespace App\Actions;

use App\Models\CharitiesMeta;
use Illuminate\Support\Facades\Gate;
use LaravelViews\Actions\Action;
use LaravelViews\Actions\Confirmable;
use LaravelViews\Views\View;

class DeleteAction extends Action
{
    use Confirmable;

    /**
     * Any title you want to be displayed
     * @var String
     * */
    public $title = "حذف";

    /**
     * This should be a valid Feather icon string
     * @var String
     */
    public $icon = "trash";

    public function __construct(public $title_text, public $allows)
    {
        return parent::__construct();
    }

    /**
     * Execute the action when the user clicked on the button
     *
     * @param $model Model object of the list where the user has clicked
     * @param $view Current view where the action was executed from
     */
    public function handle($model, View $view)
    {
        if (Gate::allows($this->allows, $model)) {
            $model->delete();
            $this->success("$this->title_text مورد نظر حذف شد!");
        } else {
            $this->error('شما دسترسی این کار را ندارید!');
        }
    }

    public function getConfirmationMessage($item = null): string
    {
        return "آیا از حذف $item->title اطمینان دارید ؟ " . " با این کار تمام اطلاعات این $this->title_text پاک می شود و قابل بازیابی نیستند . ترجیحا آن را غیر فعال کنید.";
    }

    public function renderIf($item, View $view)
    {
        return Gate::allows($this->allows, $item);
    }

}
