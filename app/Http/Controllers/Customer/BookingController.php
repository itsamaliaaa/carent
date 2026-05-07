<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function riwayat()
    {
    return view('customer.booking.riwayat');
    }
}
