<?php

namespace App\Http\Controllers;

use App\Dnote;
use App\Dnoteline;
use App\DnoteNumber;
use App\Grv;
use App\Issue;
use Serial\GetSageDate;
use Serial\Helper;
use Serial\IssueSo;
use Serial\AllGrv;
use App\Issuelines;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

class IssueDnoteController extends Controller
{
    function issue(Request $request)
    {
        $autoindexid = $request->id;
        $now = Carbon::now();
        $issueinv = Issue::where('autoindex_id',$autoindexid)->first();

//        dd($issueinv->status);
        if($issueinv->status == Issue::NOT_ISSUED ||
            $issueinv->status == Issue::DELIVERED )
        {
            flash()->error('Not Allowed','You cannot issue empty delivery note');
            return Redirect::route('issue.edit',['id'=>$autoindexid]);
        }

        $grvlinesdetails = Issuelines::where('autoindex_id',$autoindexid)
            ->whereIn('status',[Issuelines::ISSUED,Issuelines::PARTIALLY_DELIVERED])
            ->get();

        if($grvlinesdetails->isEmpty()){
            flash()->error('Not Allowed','You cannot issue empty delivery note');
            return Redirect::route('issue.edit',['id'=>$autoindexid]);
        }
//        $issueinv =Issue::where('autoindex_id',$autoindexid)->first();
        $dnote = [
            'dnote_num'=> Helper::helper()->getDnoteNumber(),
            'invoice_id'=>$autoindexid,
            'invoice_num'=>$issueinv->InvNumber,
            'client_name'=>$issueinv->clientAccount,
            'invoice_date'=>$issueinv->DeliveryDate,
            'created_at'=>$now,
            'updated_at'=>$now
        ];
        Dnote::insert($dnote);

        $dnotedetails = Dnote::where('dnote_num',$dnote['dnote_num'])
            ->where('invoice_id',$autoindexid)->first();

        $insertDnoteline = [];

            foreach ($grvlinesdetails as $grvlinesdetail)
            {
//                dd('kkk');
                $grvlinesdetail->update(['issued_amount'=>
                    ($grvlinesdetail->issued_amount == 0 ? $grvlinesdetail->previous_amount : ($grvlinesdetail->issued_amount + $grvlinesdetail->previous_amount))]);
                $grvlinesdetail->update(['previous_amount'=>0]);
                if($grvlinesdetail->remaining_amount <= 0)
                {
                    $grvlinesdetail->update(['status'=>Issuelines::DELIVERED]);
                }
                else
                {
                    $grvlinesdetail->update(['status'=>Issuelines::PARTIALLY_DELIVERED]);
//                    $grvlinesdetail->update(['previous_amount'=>0]);
                }
                $insertDnoteline [] =
                    [
                        'dnote_id' =>$dnotedetails->id,
                        'item_code' =>$grvlinesdetail->code,
                        'description' =>$grvlinesdetail->cDescription,
                        'qty'=>$grvlinesdetail->issued_amount,
                        'created_at'=>$now,
                        'updated_at'=>$now
                    ];

            }
            Dnoteline::insert($insertDnoteline);
        $dnote_update = DnoteNumber::find(1)->first();
        $dnote_update->update(['dnote_number'=>($dnote_update->dnote_number + 1)]);

        $grvlinesqty = Issuelines::where('autoindex_id',$autoindexid)->get();
        $remaining_amount = $grvlinesqty->sum('remaining_amount');
//        dd($issueinv->status,$remaining_amount);

        if($remaining_amount <= 0)
        {
            $issueinv->update(['status'=>Issue::DELIVERED]);
            return 'Delivery note issued successfully';
        }

        $issueinv->update(['status' => Issue::PARTIALLY_DELIVERED]);


       return 'Delivery note issued successfully';
//        return Redirect::route('issue.edit',['id'=>$autoindexid]);

    }

    public function receive(Request $request)
    {
//        dd($request->all());
    }
}
