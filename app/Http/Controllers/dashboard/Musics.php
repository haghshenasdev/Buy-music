<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\DarkhastType;
use App\Models\Music;
use App\Models\Project;
use App\queries\Queries;
use App\Rules\CharityValidator;
use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Morilog\Jalali\CalendarUtils;

class Musics extends Dashboard
{
    public string $viewFolder = 'dashboard.musics';
    public string $showAllTemplate = 'musics';
    public string $oneTemplate = 'seMusics';
    public string $canUpdate = 'admin';
    public string $canDelete = 'admin';
    public string $routeShowAll = 'musics';

    public function repository(): \Illuminate\Database\Eloquent\Builder
    {
        return Music::query();
    }

    public function show(Request $request)
    {
        $data = $this->repository()->findOrFail($request->integer('id'))->toArray();
        $file = \App\Models\File::query()->where('music_id',$request->integer('id'))->first('path');
        $data['mfile'] = is_null($file) ? '' : $file->path;
        return view($this->viewFolder . '.' . $this->oneTemplate,compact('data'));
    }

    public function update(Request $request)
    {
        $validData = $this->getValidator($request,false);

        $item = $this->repository()->findOrFail($request->integer('id'));
        if (Gate::allows($this->canUpdate,$item)){
            $item->update($validData);
            \App\Models\File::query()->where('music_id',$request->integer('id'))->first()->update([
                'path' => $validData['mfile'],
            ]);
        }else{
            abort(403);
        }

        return redirect()->back()->with(['success' => 'بروز رسانی با موفقیت انجام شد .']);
    }

    public function create(Request $request)
    {
        $validData = $this->getValidator($request);

        $musicId = $this->repository()->insertGetId($validData);
        \App\Models\File::query()->insert([
            'music_id' => $musicId,
            'path' => $validData['mfile'],
        ]);

        return redirect()->back()->with(['success' => ' با موفقیت ایجاد شد .']);
    }


    public function getValidator(Request $request,$forCreate = true): array
    {
        $ruls =[
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['unique:musics,slug','required', 'string', 'max:19'],
            'cover' => ['required', 'url'],
            'bg_page' => ['url','nullable'],
            'amount' => ['numeric','nullable'],
            'presell' => ['bool','nullable'],
            'mfile' => ['string','nullable',Rule::requiredIf(!$request->has('presell'))],
            'description' => ['required', 'string'],
            'description_download' => ['string','nullable'],
        ];


        // for updating , جلوگیری از تداخل یونیک بودن
        if (!$forCreate){
            $u = Music::query()->find($request->integer('id'),'slug');

            if ($u->slug == $request->get('slug')) unset($ruls['slug'][0]);
        }

        $validData = $request->validate($ruls);
        if (!$request->has('presell')) $validData['presell'] = null;
        $validData['slug'] = Str::slug($validData['slug']);
        return $validData;
    }

}
