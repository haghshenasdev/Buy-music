<?php

namespace App\Http\Livewire;

use App\Models\Buys;
use Livewire\Component;
use Livewire\WithPagination;

class CommentsComponent extends Component
{
    use WithPagination;

    public $musicId;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $comments = Buys::query()->where('music',$this->musicId)
            ->join('users','buys.user','=','users.id')
            ->join('comments','buys.comment','=','comments.id')
            ->join('musics','buys.music','=','musics.id')
            ->where('comments.is_active',1)
            ->select(['musics.title','comments.id','comments.comment','users.name'])
            ->paginate(10);

        return view('livewire.comments-component',[
            'comments' => $comments,
        ]);
    }
}
