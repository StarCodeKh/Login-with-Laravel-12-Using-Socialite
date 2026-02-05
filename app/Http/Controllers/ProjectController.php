<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function list()
    {
         return view('apps.projects.list');
    }

    public function overview()
    {
         return view('apps.projects.overview');
    }

    public function create(){
         return view('apps.projects.create');
    }
}
