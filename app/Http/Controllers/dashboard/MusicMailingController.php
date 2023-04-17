<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Mail\ThemeMusicMail;
use App\Models\Buys;
use App\Models\Music;
use App\Models\Seting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use mysql_xdevapi\Exception;

class MusicMailingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('can:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $music = Music::query()->findOrFail($request->integer('id'));
        return view('dashboard.MusicMailing.seMusicMailing',[
            'data' => $music,
            'subject' => Seting::query()->where('name', 'presell_mail_subject')->get('value')->first()->value,
            'content' => Seting::query()->where('name', 'presell_mail_content')->get('value')->first()->value,
        ]);
    }

    public function send(Request $request)
    {
        $validData = $request->validate([
            'subject' => ['string','required'],
            'content' => ['string','required'],
        ]);
        $users = Buys::query()->where('music',$request->integer('id'))->join('users','buys.user','=','users.id')->get('users.email');
        foreach ($users as $user){
            try {
                Mail::to($user->email)->queue(new ThemeMusicMail($validData['subject'],$validData['content']));
            }catch (\Exception $exception){
                continue;
            }
        }
        return redirect()->back()->with(['success' => "تعداد {$users->count()} ایمیل در صف ارسال قرار گرفت و به زودی برای همه خریداران ارسال خواهد شد."]);
    }
}
