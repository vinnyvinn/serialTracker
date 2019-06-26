<?php

namespace App\Http\Controllers;

use App\Sageitemsserial;
use App\Warrant;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Serial\Warranty;

class WarrantyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('warranty.index')
            ->withWarranties(Warrant::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('warranty.create')
            ->with('codes',Warranty::warranty()->getAllcodes())
            ->withSuccess('home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Warranty::warranty()->storeWarranty($request);
        return view('warranty.create')
            ->withCodes(Warranty::warranty()->getAllcodes())
            ->withSuccess('success');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $details = Warrant::findorfail($id);
//        dd($details);
        return view('warranty.edit')
            ->with('details',$details)
            ->withId($id)
            ->with('codes',Warranty::warranty()->getAllcodes())
            ->withSuccess('home');
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
        Warrant::destroy($id);
        Warranty::warranty()->storeWarranty($request);
        return view('warranty.create')
            ->withCodes(Warranty::warranty()->getAllcodes())
            ->withSuccess('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Warrant::destroy($id);
        return view('warranty.index')
            ->withWarranties(Warrant::all())
            ->withSuccess('success');
    }
}
