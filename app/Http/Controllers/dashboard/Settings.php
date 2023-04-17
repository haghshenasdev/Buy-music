<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\DarkhastType;
use App\Models\Music;
use App\Models\Project;
use App\Models\Seting;
use App\queries\Queries;
use App\Rules\CharityValidator;
use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Morilog\Jalali\CalendarUtils;

class Settings extends Dashboard
{
    public string $viewFolder = 'dashboard.settings';
    public string $showAllTemplate = 'musics';
    public string $oneTemplate = 'seSettings';
    public string $canUpdate = 'admin';
    public string $canDelete = 'admin';
    public string $routeShowAll = 'musics';

    public function repository(): \Illuminate\Database\Eloquent\Builder
    {
        return Seting::query();
    }

    public function show(Request $request)
    {
        $data = [];
        foreach (Seting::all()->toArray() as $item){
            $data[$item['name']] = $item['value'];
        }

        return view($this->viewFolder . '.' . $this->oneTemplate,compact('data'));
    }

    public function update(Request $request)
    {
        $validData = $this->getValidator($request,false);

        if (Gate::allows($this->canUpdate)){
            foreach ($validData as $key => $val){
                $this->repository()->where('name',$key)->update([
                    'value' => $val
                ]);
            }
        }else{
            abort(403);
        }

        return redirect()->back()->with(['success' => 'بروز رسانی با موفقیت انجام شد .']);
    }

    public function getValidator(Request $request,$forCreate = true): array
    {
        $ruls =[
            'home_title' => ['required', 'string', 'max:255'],
            'mid' => ['required', 'string'],
            'bg_page' => ['url','nullable'],
            'description_download' => ['string','nullable'],
        ];

        return $request->validate($ruls);
    }

}
