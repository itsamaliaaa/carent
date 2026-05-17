<?php

namespace App\Http\Controllers\AdminRental;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    public function index()
    {
        return view('admin.mobil.index');
    }
}
