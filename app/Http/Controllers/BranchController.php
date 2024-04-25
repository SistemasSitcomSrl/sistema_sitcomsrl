<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.branch.index')->only('index');
    }
    
    public function index()
    {
        return view('admin.branch.index');
    }
}
