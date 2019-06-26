<?php

namespace App\Http\Controllers;

use App\DnoteNumber;
use App\Issue;
use App\Issuelines;
use App\Sageitemsserial;
use App\Setting;
use App\Dnote;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Serial\ActivateSerial;
use Serial\GetSageDate;
use Serial\Helper;
use Serial\IssueInlines;
use Serial\IssueSo;
use Serial\AllGrv;
use Serial\Serializing;
use Serial\SerialTracker;
class IssueController extends Controller
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
        return view('issue.index')->with('invoice',Issue::all()->sortBy('InvNumber'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource iserialno_2n storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $serialcolm = Helper::helper()->getPrimarySerialColn();
        //dd($serialcolm);


        $allDetails = Sageitemsserial::where($serialcolm,$request->get('serial'))->first();

           $detail = Sageitemsserial::where('id',$request->get('serial'))->first();
           $serial = $detail->serial_one ? ($detail->serial_one ? $detail->serial_one:$detail->serial_two):($detail->serial_three ? $detail->serial_three: $detail->serial_four);
        $allDetails = Sageitemsserial::where($serialcolm,$serial)->first();

        if(empty($allDetails)){
            return 'Serial not found';
        }
        elseif ($allDetails->status != Sageitemsserial::VALID_SERIAL)
        {
            return $allDetails->status;
        }

        elseif ($allDetails->status == null)
        {
            return 'Serial not found';
        }

        elseif ($request->get('code') != $allDetails->code)
        {
            return 'Item code does not match serial code';
        }

        else {
            Serializing::Serializing()->updateSerial($allDetails,$request->all());
            return $allDetails;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($autoindex)
    {
        $details = Issue::where('autoindex_id',$autoindex)->first();
        $inlinesdetails = Issuelines::where('autoindex_id',$autoindex)->get();
        return view('issue.show')
            ->with('inlines',$inlinesdetails)
            ->withDetails($details);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($autoindex)
    {

        $details = Issue::where('autoindex_id',$autoindex)->first();
        $inlinesdetails = Issuelines::where('autoindex_id',$autoindex)->get();
       // dd($inlinesdetails);
		$code=[];
		foreach($inlinesdetails as $detail){
			$code[] = $detail->code;
		}
		//dd(Sageitemsserial::where('code',$code)->get());
		 
        return view('issue.edit')
            ->with('inlines',$inlinesdetails)
            ->withDetails($details)
            ->with('items',Issue::all())
            ->with('serials',Sageitemsserial::where('status','!=',Sageitemsserial::INVALID_SERIAL)
                ->where('status','!=',Sageitemsserial::ISSUED_SERIAL)
				  //->where('code',$code)
                ->get())
            ->withDnote(Helper::helper()->getDnoteNumber());
    }

    public function receive(Request $request)
    {
        $autoindex = $request->get('check');

        $details = Issue::where('autoindex_id',$autoindex)->first();
        $inlinesdetails = Issuelines::where('autoindex_id',$autoindex)->get();
        // dd($details->created_at);
//        dd($details,$inlinesdetails);
        return view('issue.edit')
            ->with('inlines',$inlinesdetails)
            ->with('serials',$allserials = Sageitemsserial::where('status','!=',Sageitemsserial::INVALID_SERIAL)->where('status','!=',Sageitemsserial::ISSUED_SERIAL)
                ->get())
            ->withDetails($details)
            ->with('items',Issue::all())
            ->withDnote(Helper::helper()->getDnoteNumber());

    }

    public function deliver()
    {
      return view('issue.add_edit');
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
