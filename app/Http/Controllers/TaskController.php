<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function kanbanBoard()
    {
        return view('apps.task.kanban-board');
    }

    public function listView()
    {
        return view('apps.task.list-view');
    }

    public function taskDetails()
    {
        return view('apps.task.task-details');
    }
}
