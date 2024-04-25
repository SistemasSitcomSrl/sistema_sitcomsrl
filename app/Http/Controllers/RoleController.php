<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.rol.index')->only('index');
    }
    public function index()
    {
        return view('admin.role.index');
    }
}
