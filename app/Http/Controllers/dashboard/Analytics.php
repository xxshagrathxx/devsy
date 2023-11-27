<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Analytics extends Controller
{
  public function index()
  {
    // dd(LaravelLocalization::getCurrentLocale());
    return view('content.dashboard.dashboards-analytics');
  }
}
