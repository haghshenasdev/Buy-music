<?php

namespace App\Http\Controllers\dashboard;

use App\Models\User;
use App\Rules\CharityValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class Users extends Dashboard
{
    public string $viewFolder = 'dashboard.users';
    public string $showAllTemplate = 'users';
    public string $oneTemplate = 'seUser';
    public string $canUpdate = 'admin';
    public string $canDelete = 'admin';
    public string $routeShowAll = 'users';

    public function repository(): \Illuminate\Database\Eloquent\Builder
    {
        return User::query();
    }

    public function update(Request $request)
    {
        $validData = $this->getValidator($request,false);

        $item = $this->repository()->findOrFail($request->integer('id'));
        if (Gate::allows($this->canUpdate,$item)){
            $item->update($validData);
        }else{
            abort(403);
        }

        return redirect()->back()->with(['success' => 'بروز رسانی با موفقیت انجام شد .']);
    }

    public function getValidator(Request $request,$forCreate = true): array
    {
        $ruls =[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['unique:'.User::class,'string', 'email', 'max:255'],
            'password' => [Rule::requiredIf($forCreate), 'confirmed']
        ];

        // for updating , جلوگیری از تداخل یونیک بودن
        if (!$forCreate){
            $u = User::query()->find($request->integer('id'),['email']);
            if ($u->email == $request->get('email')) unset($ruls['email'][0]);
        }

        $validData =  $request->validate($ruls);

        //pass hash
        if ($request->has('password')) $validData['password'] = Hash::make($validData['password']);

        return $validData;
    }

}
