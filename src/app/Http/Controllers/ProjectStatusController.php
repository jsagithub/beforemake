<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\ProjectStatus;
use App\Http\Resources\ProjectStatus as ProjectStatusResource;

class ProjectStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project_status = ProjectStatus::paginate(15);

        return ProjectStatusResource::collection($project_status);
    }
}
