<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkersController extends Controller
{
    public function index()
    {
        return view('admin.workers.index');
    }
}
