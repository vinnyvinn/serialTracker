<?php

namespace App\Http\Controllers;

use App\Grv;
use App\Issue;
use Illuminate\Http\Request;

use Excel;
use Serial\ReportsRepo;


class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd(Issue::get()->where('state','Unprocessed')->take(20));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reports.grvs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date_from = date('Y-m-d',strtotime($request->get('start_date')));

        $date_to = date('Y-m-d',strtotime($request->get('end_date')));

        $reports = ReportsRepo::init()->getGrvs($date_from,$date_to,$request->get('type'));



        return Excel::create('grvs_report', function ($excel) use ($reports) {

            $excel->sheet('mySheet', function ($sheet) use ($reports) {

                $sheet->fromArray($reports);

            });

        })->download('xls');
    }

    public function invoiceCreate()
    {
        return view('reports.sales.create');
    }

    public function geInvoiceReport()
    {
        $date_from = date('Y-m-d',strtotime(request()->get('start_date')));

        $date_to = date('Y-m-d',strtotime(request()->get('end_date')));

        $reports = ReportsRepo::init()->getInvoices($date_from,$date_to);



        return Excel::create('sales_report', function ($excel) use ($reports) {

            $excel->sheet('mySheet', function ($sheet) use ($reports) {

                $sheet->fromArray($reports);

            });

        })->download('xls');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
