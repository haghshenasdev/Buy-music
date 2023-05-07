<?php

namespace App\Http\Livewire;

use App\Actions\AcceptCommentsAction;
use App\Actions\ActivateOrDeactiveAction;
use App\Actions\DeleteCommentAction;
use App\Actions\MailingAction;
use App\Actions\ShowAction;
use App\Actions\ShowCommentsAction;
use App\Actions\ShowMusicAction;
use App\Models\Buys;
use App\Models\Music;

use Illuminate\Support\Facades\Request;
use LaravelViews\Views\TableView;

class CommentsTableView extends TableView
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
            ->join('comments','buys.comment','=','comments.id')
            ->join('musics','buys.music','=','musics.id')
            ->select(['buys.id','musics.title','comments.id as comments_id','comments.comment','comments.is_active','users.name','users.name']);
    }

    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */
    public function headers(): array
    {
        $headers = [
            'نام کاربر',
            'نظر',
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
            $model->name,
            $model->comment,
        ];
        if (!Request::has('mid')) $row[] = $model->title;
        return $row;
    }

    protected function actionsByRow()
    {
        return [
            new AcceptCommentsAction('نظر','admin'),
            new DeleteCommentAction('نظر','admin'),
        ];
    }
}
