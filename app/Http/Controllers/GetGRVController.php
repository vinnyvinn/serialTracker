<?php

namespace App\Http\Controllers;

use App\Dnote;
use App\Grv;
use App\GrvSerialized;
use App\Sageitemsserial;
use App\Warrant;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

use App\Http\Requests;
use Serial\GetSageDate;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Serial\AllGrv;
use Serial\Helper;
use Serial\Serializing;
use Serial\IssueSo;
use App\Setting;
use Serial\Warranty;
use Auth;

class GetGRVController extends Controller
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
  
        
                return view('grv.index')
                    ->with('grvs',Grv::all()->sortByDesc('DeliveryDate')->where('state','Processed'));

    }
    public function index_unprocessed()
    {
        return view('grv.index_unprocessed')
            ->with('grvs',Grv::all()->sortByDesc('DeliveryDate')->where('state','Unprocessed'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataReceived  = Serializing::Serializing()->receivingGrvSerials($request);
        return $dataReceived;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($autoindexid)
    {
        $grvDetails= collect(AllGrv::allGrv()->getGrvDetails($autoindexid))->first();
        $grvInlines = GrvSerialized::where('autoindex_id',$autoindexid)->get();
        return view('grv.show')
            ->with('grvItems',$grvInlines)
            ->with('details',$grvDetails);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($autoindexid)
    {
        $grvDetails= collect(AllGrv::allGrv()->getGrvDetails($autoindexid))->first();
       // dd($grvDetails);

        $grvInlines = GrvSerialized::where('autoindex_id',$autoindexid)->get();
        $grvline_with_warranty_id = Warranty::warranty()
            ->getGrvlinesWarrantyDetails($grvInlines);

        return view('grv.edit')
            ->with('grvItems',$grvline_with_warranty_id)
            ->with('details',$grvDetails)
            ->withAutoindexid($autoindexid);
    }
//unprocessed Grv
    public function edit_un($autoindexid)
    {

        $grvDetails= collect(AllGrv::allGrv()->getGrvDetails($autoindexid))->first();
        $detail = Grv::where('autoindex_id',$autoindexid)->first();
        $Inlines = GrvSerialized::where('autoindex_id',$autoindexid)->first();

       $grvInlines = GrvSerialized::where('autoindex_id',$autoindexid)->get();
        $grvline_with_warranty_id = Warranty::warranty()
            ->getGrvlinesWarrantyDetails($grvInlines);

        return view('grv.edit-unprocessed')
            ->with('grvItems',$grvline_with_warranty_id)
            ->with('details',$grvDetails)
            ->with('detail',$detail)
            ->with('inlines',$Inlines)
            ->withAutoindexid($autoindexid)
            ->withDnote(Helper::helper()->getDnoteNumber());
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
        dd($request->all());
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

    public function receive(Request $request)
    {
        $autoindexid = $request->get('check');
        $grvDetails= collect(AllGrv::allGrv()->getGrvDetails($autoindexid))->first();
        $grvInlines = GrvSerialized::where('autoindex_id',$autoindexid)->get();
        $grvline_with_warranty_id = Warranty::warranty()
            ->getGrvlinesWarrantyDetails($grvInlines);
        return view('grv.edit')
            ->with('grvItems',$grvline_with_warranty_id)
            ->with('details',$grvDetails)
            ->withAutoindexid($autoindexid);

    }
//Receive Unprocessed GRV
    public function receive_un(Request $request)
    {

        $autoindexid = $request->get('check');
        $grvDetails= collect(AllGrv::allGrv()->getGrvDetails($autoindexid))->first();
        $grvInlines = GrvSerialized::where('autoindex_id',$autoindexid)->get();
        $grvline_with_warranty_id = Warranty::warranty()
            ->getGrvlinesWarrantyDetails($grvInlines);
        return view('grv.edit-unprocessed')
            ->with('grvItems',$grvline_with_warranty_id)
            ->with('details',$grvDetails)
            ->withAutoindexid($autoindexid);

    }


    public function sync()
    {
        IssueSo::issueSo()->getInvoice();
        AllGrv::allGrv()->getAllGrves();
        AllGrv::allGrv()->getUnprocessedGrvs();
        return redirect()->route('grv.index');
    }


}
