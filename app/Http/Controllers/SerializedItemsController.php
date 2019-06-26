<?php

namespace App\Http\Controllers;

use App\Grv;
use App\GrvSerialized;
use Illuminate\Http\Request;
use Serial\Warranty;

use App\Http\Requests;
use Serial\AllGrv;
use Serial\GetSageDate;
use Serial\IssueSo;
//use Serial\AllGrv

class SerializedItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Serialized.index')
            ->with('grvlines',Grv::whereIn('status',[Grv::PARTIALLY_SERIALIZED_GRV,Grv::SERIALIZED_GRV])->where('state',GRV::PROCESSED_GRV)
                ->get());
    }

    public function index_unprocessed()
    {
        return view('Serialized.index_unprocessed')
            ->with('grvlines',Grv::whereIn('status',[Grv::PARTIALLY_SERIALIZED_GRV,Grv::SERIALIZED_GRV])->where('state',GRV::UNPROCESSED_GRV)
                ->get());
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
    public function show($autoindexid)
    {

        $getId = Grv::where('autoindex_id',$autoindexid)
                ->whereIn('status',[Grv::PARTIALLY_SERIALIZED_GRV,Grv::SERIALIZED_GRV])->where('state',GRV::PROCESSED_GRV);

        $grvDetails = GrvSerialized::where('autoindex_id',$autoindexid)
            ->where('qty_serialized','>',0)->get();

        $grvline_with_warranty_id = Warranty::warranty()
            ->getGrvlinesWarrantyDetails($grvDetails);

        return view('Serialized.show')
            ->with('details',$getId)
            ->with('grvItems',$grvline_with_warranty_id)
            ->with('id',$autoindexid);
    }

    //show unprocesed
    public function show_un($autoindexid)
    {

        $getId = Grv::where('autoindex_id',$autoindexid)
            ->whereIn('status',[Grv::PARTIALLY_SERIALIZED_GRV,Grv::SERIALIZED_GRV])->where('state',GRV::UNPROCESSED_GRV);

        $grvDetails = GrvSerialized::where('autoindex_id',$autoindexid)
            ->where('qty_serialized','>',0)->get();

        $grvline_with_warranty_id = Warranty::warranty()
            ->getGrvlinesWarrantyDetails($grvDetails);

        return view('Serialized.show_unprocessed')
            ->with('details',$getId)
            ->with('grvItems',$grvline_with_warranty_id)
            ->with('id',$autoindexid);
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
