<?php

namespace App\Http\Controllers;

use App\Models\Buys;
use App\Models\File;
use App\Models\Music;
use App\Models\Seting;
use App\Paydriver\Zarinpal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class home extends Controller
{
    public function index()
    {
        return view('home', [
            'title' => Seting::query()->where('name', 'home_title')->get('value')->first()->value,
            'bg_page' => $this->get_bg_page(),
            'musics' => Music::query()->where('is_active', 1)->get(['title', 'cover', 'slug','bg_page']),
        ]);
    }

    public function get_bg_page(Music $music = null)
    {
            if (is_null($music) || is_null($music->bg_page))
                return Seting::query()->where('name', 'bg_page')->get('value')->first()->value;

            return $music->bg_page;
    }

    public function show($slug)
    {
        $music = Music::query()->where('slug', $slug)->firstOrFail();

        return view('show', [
            'title' => $music->title,
            'data' => $music,
            'bg_page' => $this->get_bg_page($music),
            'routeDl' => route('dl',$slug),
            'payed' => (Auth::check() && Buys::query()->where('user', Auth::id())->where('music', $music->id)->count() != 0)
        ]);
    }

    public function pay(Request $request,$slug)
    {
        $music = Music::query()->where('slug',$slug)->firstOrFail();

        $MerchantID 	= Seting::query()->where('name', 'mid')->get('value')->first()->value;
        $Amount 		= 0;
        $Description 	= "خرید ($music->title)";
        $Email 			= Auth::user()->email;
        $Mobile 		= "";

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

        $MerchantID 	= Seting::query()->where('name', 'mid')->get('value')->first()->value;
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
            $data['message'] = "تراکنش با موفقیت انجام شد";
            $data['success'] = true;
            $data['presell'] = $music->presell == 1;
            $data['routeDl'] = route('dl',$slug);
//            echo "<br />مبلغ : ". $result["Amount"];
//            echo "<br />کد پیگیری : ". $result["RefID"];
//            echo "<br />Authority : ". $result["Authority"];
        } else {
            // error
            $data['message'] = "پرداخت ناموفق";
            $data['success'] = false;
//            echo "<br />کد خطا : ". $result["Status"];
//            echo "<br />تفسیر و علت خطا : ". $result["Message"];
        }
        $data['description_download'] = $music->description_download;
        $data['bg_page'] = $this->get_bg_page();
        return view('verifyAndDownload', $data);
    }

    public function download($slug)
    {
        $music = Music::query()->where('slug',$slug)->firstOrFail('id');

        if (Buys::query()->where('user',Auth::id())->where('music',$music->id)->count() >= 1) {
            return Storage::disk('private')->download(
                File::query()->where('music_id',$music->id)->first('path')->path
            );
        } else {
            abort(403, 'شما دسترسی دانلود این فایل را ندارید!');
        }
    }

}
