<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Warrant;
use Serial\Warranty;
use Illuminate\Http\Request;

use App\Http\Requests;
use Serial\GetSageDate;
use Serial\IssueSo;
use Serial\AllGrv;

class SettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('setting.index')
            ->withSettings(Setting::all());

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
      //dd($request->all());
        $setting = new \Serial\SerialTrackerSetting();
//        Warranty::warranty()->storeWarranty($request);
        if($request->get('Primary_Serial_Column') > $request->get('Number_of_Serials'))
            {
                flash()->error('Setting','Primary serial column number cannot exceed Number of serials');
                return view('setting.index')
                    ->withSettings(Setting::all());

            }
        //Todo change this whole code crap lot f query

        $setting->updateSetting($request);
//                flash()->success('Setting','Setting saved successfully');

        return view('setting.index')
            ->withSettings(Setting::all())
            ->withMessage(['type'=>'success','msg'=>'Setting saved successfully']);
//            ->withWarrants(Warrant::all())
//            ->with('codes',Warranty::warranty()->getAllcodes())
            ;
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

    }
}
