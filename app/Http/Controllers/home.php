<?php

namespace App\Http\Controllers;

use App\Models\Buys;
use App\Models\Comments;
use App\Models\File;
use App\Models\Music;
use App\Paydriver\Zarinpal;
use App\Setting\SettingSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class home extends Controller
{
    public function index()
    {
        return view('home', [
            'title' => SettingSystem::get('home_title'),
            'bg_page' => SettingSystem::get_bg_page(),
            'musics' => Music::query()->where('is_active', 1)->orderBy('sort')->orderBy('id')->paginate(10,['title', 'cover','presell', 'slug','bg_page']),
        ]);
    }

    public function show($slug)
    {
        $music = Music::query()->where('slug', $slug)->firstOrFail();

        $topProtection = $this->protectionQ($music)->orderByDesc('amount')->get();
        $lastProtection = $this->protectionQ($music)->orderByDesc('buys.id')->get();

        if (!str_starts_with($music->cover,"http")) $music->cover = Storage::url($music->cover);
        return view('show', [
            'title' => $music->title,
            'data' => $music,
            'topProtection' => $topProtection,
            'lastProtection' => $lastProtection,
            'bg_page' => SettingSystem::get_bg_page($music),
            'files' => $music->file()->get(),
            'routeDl' => route('dl',$slug),
            'payed' => Gate::allows('payed',$music)
        ]);
    }

    private function protectionQ($music)
    {
        return Buys::query()->where('music',$music->id)
            ->limit(5)
            ->join('users','buys.user','=','users.id')
            ->leftJoin('comments','buys.comment','=','comments.id')
            ->select(['buys.amount','comments.comment','comments.is_active','buys.is_presell','users.name']);
    }

    public function comment(Request $request)
    {
        $validData = $request->validate([
            'textComment' => ['required','string','max:255'],
            'musicId' => ['required','exists:musics,id'],
            'g-recaptcha-response' => 'required|captcha'
        ],[
                'g-recaptcha-response' => [
                    'required' => 'لطفا تیک ریکپچا را بزنید.',
                    'captcha' => 'کپچا درست نیست ، لطفا دوباره تلاش کنید.',
                ],
        ]);

        $commentData = [
            'comment' => $validData['textComment'],
            'is_active' => null,
            'created_at' => Date::now(),
        ];

        $buy = Buys::query()->where('music',$validData['musicId'])
            ->where('user',Auth::id())->firstOrFail();

        if ($buy->comment != null) {
            Comments::query()->find($buy->comment)->update($commentData);
        }else{
            $commentId = Comments::query()->insertGetId($commentData);
            $buy->update([
                'comment' => $commentId,
            ]);
            $buy->save();
        }

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
        $SandBox 		= Gate::allows('admin');

        if (is_null($music->amount)){
            $min_amount = is_null($music->min_amount) ? SettingSystem::get('min_amount') : $music->min_amount;
            $validData = $request->validate([
                'amount' => ['required', 'numeric', "min:$min_amount"],
                'g-recaptcha-response' => 'required|captcha',
            ],[
                'g-recaptcha-response' => [
                    'required' => 'لطفا تیک ریکپچا را بزنید.',
                    'captcha' => 'کپچا درست نیست ، لطفا دوباره تلاش کنید.',
                ],
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
        $SandBox 		= Gate::allows('admin');

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
                'RefID' => $result['RefID'],
                'is_presell' => $music->presell,
                'created_at' => Date::now(),
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

    public function download($slug,$fileId = null)
    {
        $music = Music::query()->where('slug',$slug)->firstOrFail(['id','presell','is_active']);

        if (Gate::allows('download',$music)) {
            $path = null;
            if ($fileId != null){
                $path = $music->file()->where('id',$fileId)->first('path')->path;
            }else{
                $path = File::query()->where('music_id',$music->id)->first('path')->path;
            }
            return $this->show_dl($path);
        } else {
            abort(403, 'شما دسترسی دانلود این فایل را ندارید!');
        }
    }

    private function show_dl($path){
        if ($path == null) abort(404,'فایلی برای دانلود یافت نشد ! احتمالا فایل حذف شده یا جا به جا شده است.');
        try {
            return Storage::disk('private')->download(
                $path,basename($path),[
                    'Content-Length' => Storage::disk('private')->size($path)
                ]
            );
        }catch (\Exception $e){
            abort(404,'فایلی برای دانلود یافت نشد !');
        }

    }

}
