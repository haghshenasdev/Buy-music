<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class Profile extends Controller
{
    public function index()
    {
        return view('dashboard.profile',[
            'data' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $validData = $request->validate([
            'email' => ['string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update($validData);
        $user->save();

        return back()->with('success','پروفایل باموفقیت به روزرسانی شد.');
    }

    public function changePass(Request $request)
    {
        $user = Auth::user();
        $validData = $request->validate([
            'old_pas' => ['required','string'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        if (Hash::check($validData['old_pas'],$user->password)){
            $validData['password'] = Hash::make($validData['password']);
            $user->update($validData);
            $user->save();
        }else{
            return back()->withErrors(['old_pas','پسورد قدیمی به درستی وارد نشده است .'])->withInput();
        }

        return back()->with('success1','رمز عبور باموفقیت به روزرسانی شد.');
    }
}
