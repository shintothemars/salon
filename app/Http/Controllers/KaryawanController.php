<?php

namespace App\Http\Controllers;

class KaryawanController extends Controller
{
    public function index()
    {
        return view('karyawan.dashboard');
    }
}
