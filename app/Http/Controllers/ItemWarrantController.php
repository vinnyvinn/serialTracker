<?php

namespace App\Http\Controllers;

use App\Sageitemsserial;
use App\Serialdates;
use App\User;
use App\Warrant;
use Serial\GetSageDate;
use Serial\Helper;
use Serial\IssueSo;
use Serial\AllGrv;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Setting;
use Serial\SerialTracker;
use Serial\Warranty;

class ItemWarrantController extends Controller
{
    public function __construct()
    {
        $this->middleware('setting');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_warranties = Serialdates::all();
        $items = Sageitemsserial::where('status',Sageitemsserial::ISSUED_SERIAL)->get();
        $all_items = Sageitemsserial::select('id')
            ->where('status',Sageitemsserial::ISSUED_SERIAL)
            ->get()->toArray();
//        dd($all_items,$all_warranties);
        $warranty_date = $all_warranties->map(function ($values_ar,$key_ar)
        {
           return  $values_ar->sageitemsserial_id;
        })->toArray();

        $warranties_details = $all_warranties->map(function ($values,$key) use($warranty_date,$items,$all_items)
        {
            $coln = Helper::helper()->getPrimarySerialColn();
            $now = Carbon::now();
            foreach ($all_items as $all_item)
            {
//                dd($warranty_date,$all_item['id']);
                $insert = Sageitemsserial::find($values->sageitemsserial_id);
                $serial = $insert->$coln;

                if (in_array($all_item['id'],$warranty_date))
                {
                    return [
                        'code' =>$insert ->code,
                        'description' =>$insert->cDescription,
                        'serial' =>$serial,
                        'user' =>User::findorfail($values->user)->name,
                        'labour_status' => $values->labour_end_date > $now ? 'Active':'Expired',
                        'service_status' => $values->service_end_date > $now ? 'Active':'Expired',
                        'parts_status' =>$values->parts_end_date > $now ? 'Active':'Expired',
                        'labour_start_date' =>$values->labour_start_date,
                        'service_start_date' => $values->service_start_date,
                        'parts_start_date'=>$values->parts_start_date,
                        'labour_end_date'=>$values->labour_end_date,
                        'service_end_date'=>$values->service_end_date,
                        'parts_end_date'=>$values->parts_end_date
                    ];
                }

            }
        });
//        dd($warranties_details);

        return view('itemwarrant.index')
            ->with('warranties',$warranties_details);
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
//        dd($request->all());
        $serialcolm = Helper::helper()->getPrimarySerialColn();
        $allDetails = Sageitemsserial::where($serialcolm,$request->get('serial'))->first();
//        dd($allDetails);
        if(empty($allDetails)){
            return 'Serial not found';
        }

        elseif ($allDetails->status == null) {
            return 'Serial not found';
        }

        return SerialTracker::serialtracker()->getSerialDetails($allDetails);

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