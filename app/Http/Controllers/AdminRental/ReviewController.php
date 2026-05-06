<?php

namespace App\Http\Controllers\AdminRental;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        return view('admin.review.index');
    }
}
