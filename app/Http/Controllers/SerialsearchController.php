<?php

namespace App\Http\Controllers;

use App\Sageitemsserial;
use Illuminate\Http\Request;

use App\Http\Requests;
use Serial\GetSageDate;
use Serial\Helper;
use Serial\IssueSo;
use Serial\AllGrv;
use Serial\SerialTracker;

class SerialsearchController extends Controller
{/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allserials = SerialTracker::serialtracker()->getValidSerials();
        return view('Serials.index')
            ->withSerials($allserials)
            ->withSerialcoln(Helper::helper()->getPrimarySerialColn());

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
            $search_result = SerialTracker::serialtracker()->searchSerials($request->get('serials'));
            return $search_result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    public function getSerials()
    {
        $allserials = Sageitemsserial::where('status','!=',Sageitemsserial::INVALID_SERIAL)
            ->get();
        return response()->json($allserials);

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
