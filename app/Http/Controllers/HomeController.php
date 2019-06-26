<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Serial\IssueSo;
use Serial\AllGrv;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        IssueSo::issueSo()->getInvoice();
       AllGrv::allGrv()->getAllGrves();
       AllGrv::allGrv()->getUnprocessedGrvs();
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
        {

        return Redirect::to('/unprocessed');
    }
}

