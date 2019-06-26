<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\PDF;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\App;
use App\Setting;
use App\Warrant;
use Serial\GetSageDate;

class DnotePdfController extends Controller
{
    use GetSageDate;
    public function pdfview()
    {
     return view('dnote.dnotepdf');
    }
}
