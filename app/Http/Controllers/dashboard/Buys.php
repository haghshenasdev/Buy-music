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

class Buys extends Dashboard
{
    public string $viewFolder = 'dashboard.buys';
    public string $showAllTemplate = 'buys';
    public string $oneTemplate = 'seBuys';
    public string $canUpdate = 'admin';
    public string $canDelete = 'admin';
    public string $routeShowAll = 'buys';

    public function repository(): \Illuminate\Database\Eloquent\Builder
    {
        return \App\Models\Buys::query();
    }


    public function getValidator(Request $request,$forCreate = true): array
    {
        $ruls =[
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['unique:musics,slug','required', 'string', 'max:19'],
            'cover' => ['required', 'url'],
            'bg_page' => ['url','nullable'],
            'amount' => ['numeric','nullable'],
            'min_amount' => ['numeric','nullable'],
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
