<?php

namespace App\Http\Controllers;

use App\Models\Buys;
use App\Models\File;
use App\Models\Music;
use App\Paydriver\Zarinpal;
use App\Setting\SettingSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class home extends Controller
{
    public function index()
    {
        return view('home', [
            'title' => SettingSystem::get('home_title'),
            'bg_page' => SettingSystem::get_bg_page(),
            'musics' => Music::query()->where('is_active', 1)->get(['title', 'cover', 'slug','bg_page']),
        ]);
    }

    public function show($slug)
    {
        $music = Music::query()->where('slug', $slug)->firstOrFail();
        $topProtection = Buys::query()->where('music',$music->id)
            ->orderByDesc('amount')
            ->limit(5)
            ->join('users','buys.user','=','users.id')
            ->select(['buys.amount','buys.comment','buys.accept_commend','users.name'])->get();

        return view('show', [
            'title' => $music->title,
            'data' => $music,
            'topProtection' => $topProtection,
            'bg_page' => SettingSystem::get_bg_page($music),
            'routeDl' => route('dl',$slug),
            'payed' => Gate::allows('payed',$music)
        ]);
    }

    public function comment(Request $request)
    {
        $validData = $request->validate([
            'textComment' => ['required','string','max:255'],
            'musicId' => ['required','exists:musics,id'],
        ]);
        Buys::query()->where('music',$validData['musicId'])->where('user',Auth::id())->update([
            'comment' => $validData['textComment'],
            'accept_commend' => null,
        ]);
        return back()->with('success','نظر شما با موفقیت ثبت شد و پس از تایید مدیر منتشر خواهد شد.');
    }

    public function pay(Request $request,$slug)
    {
        $music = Music::query()->where('slug',$slug)->firstOrFail();

        $MerchantID 	= SettingSystem::get('mid');
        $Amount 		= 0;
        $Description 	= "خرید ($music->title)";
        $Email 			= Auth::user()->email;
        $Mobile 		= "";

        $ZarinGate 		= false;
        $SandBox 		= true;

        if (is_null($music->amount)){
            $min_amount = is_null($music->min_amount) ? SettingSystem::get('min_amount') : $music->min_amount;
            $validData = $request->validate([
                'amount' => ['required', 'numeric', "min:$min_amount"],
            ]);
            $Amount = $validData['amount'];
        }else{
            $Amount = $music->amount;
        }

        $CallbackURL 	= route('verify',[$slug]).'?amount='.$Amount;

        $zp 	= new Zarinpal();
        $result = $zp->request($MerchantID, $Amount, $Description, $Email, $Mobile, $CallbackURL, $SandBox, $ZarinGate);

        if (isset($result["Status"]) && $result["Status"] == 100)
        {
            // Success and redirect to pay
            $zp->redirect($result["StartPay"]);
        } else {
            // error
            echo "خطا در ایجاد تراکنش";
            echo "<br />کد خطا : ". $result["Status"];
            echo "<br />تفسیر و علت خطا : ". $result["Message"];
        }


    }

    public function verify(Request $request,$slug)
    {
        $music = Music::query()->where('slug',$slug)->firstOrFail();

        $MerchantID 	= SettingSystem::get('mid');
        $Amount 		= 0;
        $ZarinGate 		= false;
        $SandBox 		= true;

        if (is_null($music->amount)){
            $validData = $request->validate([
                'amount' => ['required', 'numeric', 'min:10000'],
            ]);
            $Amount = $validData['amount'];
        }else{
            $Amount = $music->amount;
        }

        $zp 	= new Zarinpal();
        $result = $zp->verify($MerchantID, $Amount, $SandBox, $ZarinGate);

        $data = [];
        if (isset($result["Status"]) && $result["Status"] == 100)
        {
            // Success
            Buys::query()->insert([
                'amount' => $Amount,
                'user' => Auth::id(),
                'music' => $music->id,
            ]);
            $data['message'] = "تراکنش با موفقیت انجام شد . کد پیگیری : ". $result["RefID"];
            $data['success'] = true;
            $data['presell'] = $music->presell == 1;
            $data['routeDl'] = route('dl',$slug);
        } else {
            // error
            $data['message'] = "پرداخت ناموفق . ".$result['Message'];
            $data['success'] = false;
        }
        $data['description_download'] = $music->description_download;
        $data['bg_page'] = SettingSystem::get_bg_page($music);
        $data['routeBack'] = route('show',$music->slug);
        return view('verifyAndDownload', $data);
    }

    public function download($slug)
    {
        $music = Music::query()->where('slug',$slug)->firstOrFail(['id','presell','is_active']);

        if (Gate::allows('download',$music)) {
            $path = File::query()->where('music_id',$music->id)->first('path')->path;
            return Storage::disk('private')->download(
                $path,basename($path),[
                    'Content-Length' => Storage::disk('private')->size($path)
                ]
            );
        } else {
            abort(403, 'شما دسترسی دانلود این فایل را ندارید!');
        }
    }

}
