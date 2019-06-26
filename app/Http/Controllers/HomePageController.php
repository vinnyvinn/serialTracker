<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Serial\IssueSo;
use Serial\AllGrv;
use Illuminate\Support\Facades\Redirect;

class HomePageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        AllGrv::allGrv()->getAllGrves();
//       $grv = collect(DB::select(DB::raw("select GRvid,invnum.GrvNumber,OrderNum,cAccountName,cDescription,fUnitcost,code,ItemGroup,fQuantity,fQtyToProcess,fUnitPriceExcl from _btblInvoiceLines inner join InvNum on _btblInvoiceLines .iInvoiceID=invnum.AutoIndex inner join StkItem on StkItem.StockLink=_btblInvoiceLines.iStockCodeID where DocType=5 and DocFlag=2 and DocState=1"))
//        )->groupBy('GrvNumber')->toArray();
//            return view('home.index')->with('grv',$grv);
        return redirect('unprocessed');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
