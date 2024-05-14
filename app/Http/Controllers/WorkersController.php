<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkersController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.workers.index')->only('index');  
    }
    public function index()
    {
        return view('admin.workers.index');
    }
}
