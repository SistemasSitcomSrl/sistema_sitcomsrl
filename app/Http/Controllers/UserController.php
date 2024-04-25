<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.users.index')->only('index');
    }

    public function index()
    {
        return view('admin.users.index');
    }    
}
