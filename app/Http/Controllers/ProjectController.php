<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{  
    public function __construct(){
        $this->middleware('can:admin.users.index')->only('index');
    }
    public function index()
    {
        return view('admin.projecto.index');
    }    
}
