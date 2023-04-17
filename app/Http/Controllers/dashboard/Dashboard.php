<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\queries\Queries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

abstract class Dashboard extends Controller
{
    public string $viewFolder = 'dashboard.projects';
    public string $showAllTemplate = 'projects';
    public string $oneTemplate = 'seProjects';
    public string $canUpdate = 'update-projects';
    public string $canDelete = 'delete-projects';
    public string $routeShowAll = 'projects';

    public function repository(): \Illuminate\Database\Eloquent\Builder
    {
        return Queries::getProjects();
    }

    public function index()
    {
        return view($this->viewFolder . '.' .$this->showAllTemplate);
    }

    public function show(Request $request)
    {
        $data = $this->repository()->findOrFail($request->integer('id'));
        return view($this->viewFolder . '.' . $this->oneTemplate,compact('data'));
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

    public function new()
    {
        return view($this->viewFolder . '.' . $this->oneTemplate);
    }

    public function create(Request $request)
    {
        $validData = $this->getValidator($request);

        $this->repository()->insert($validData);

        return redirect()->back()->with(['success' => ' با موفقیت ایجاد شد .']);
    }

    public function delete(Request $request)
    {
        $item = $this->repository()->findOrFail($request->integer('id'));
        if (Gate::allows($this->canDelete,$item)){
            $item->delete();
        }else{
            abort(403);
        }
        return redirect()->route($this->routeShowAll);
    }

    public function getValidator(Request $request,$forCreate = true): array {
        return [];
    }

}
