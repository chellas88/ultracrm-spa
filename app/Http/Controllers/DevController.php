<?php

namespace App\Http\Controllers;

use App\Http\Resources\PipelineResource;
use App\Models\Crm;
use App\Models\Pipeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DevController extends Controller
{
    public function dev(){
        dd(PipelineResource::collection(Crm::with('pipelines')->get()));
    }
}
