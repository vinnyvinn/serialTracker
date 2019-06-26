<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 9/17/16
 * Time: 11:14 AM
 */

namespace Serial;

use App\BtblInvoiceLine;
use App\Grv;
use App\GrvSerialized;
use App\Invnum;
use DB;
use Carbon\Carbon;
use App\Sageitemsserial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class Serializing
{
    public static function Serializing()
    {
        return new self();
    }

    public function checkGrvs($autoIndex_id,$grvlines_id)
    {

        $grvlines = GrvSerialized::where('autoindex_id',$autoIndex_id)->get();
        $total_grvlines = $grvlines->sum('fQuantity');
        $issued_grvlinnes = $grvlines->sum('qty_serialized');

                if($issued_grvlinnes >= $total_grvlines)
                {
                    return ['status'=>Grv::SERIALIZED_GRV];
                }

                if ($issued_grvlinnes < $total_grvlines && $issued_grvlinnes >0)
                {
                    return [
                        'status'=>Grv::PARTIALLY_SERIALIZED_GRV,
                        'remaining_qty' => GrvSerialized::where('autoindex_id',$autoIndex_id)
                            ->where('grvlines_id',$grvlines_id)->first()->qty_remaining
                    ];
                }

                return ['status'=>Grv::UNSERIALIZED_GRV];
    }

    public function receivingGrvSerials(Request $request)
    {

        $helper = Helper::helper();
        $serialcolm = $helper->getPrimarySerialColn();
        $valuetocheck = $helper->assignColnChecker();

        $autoindex_id = $request->get('autoindexid');
        $getGrv = Grv::where('autoindex_id',$autoindex_id)->first();
//            $getGrv->id = $getGrv->id;
        $serialedItems = count($request->get('serials'));
        $data = $request->all();

        $itemDetails = [];
        $serialErros = [];

        $allserials = array_flatten(Sageitemsserial::select($serialcolm)
            ->get()->toArray());
        $now = Carbon::now();

        $detailsOfItem = json_decode($request->get('wholedata'));

        $item_sage_details = AllGrv::allGrv()
            ->getItemDetails($detailsOfItem->grvlines_id);
        foreach ($data as $key => $value) {
            if (starts_with($key, 'serials')) {
                foreach ($value as $itemkey => $itemvalue)
                {
                    if(!empty($allserials) && in_array($itemvalue[$valuetocheck],$allserials))
                    {
                        $serialErros [] = [
                            'serials' => $itemvalue[$valuetocheck]
                        ];
                    }
                    else{
                        $itemDetails [] = [
                            'grv_id' => $getGrv->id,
                            'warrant' => json_encode($request->get('waranty')),
                            'idInvoiceLines' => $item_sage_details->idInvoiceLines,
                            'autoindex_id' =>$autoindex_id,
                            'inv_idInvoiceLines' => 0,
                            'cDescription' => $item_sage_details->cDescription,
                            'fUnitcost' => $item_sage_details->fUnitcost,
                            'code' => $item_sage_details->code,
                            'user' => Auth::user()->id,
                            'fUnitPriceExcl' => $item_sage_details->fUnitPriceExcl,
                            'serial_one' => array_key_exists('serialno_0',$itemvalue) ? $itemvalue['serialno_0'] : null,
                            'serial_two' => array_key_exists('serialno_1',$itemvalue) ? $itemvalue['serialno_1'] : null,
                            'serial_three' => array_key_exists('serialno_2',$itemvalue) ? $itemvalue['serialno_2'] : null,
                            'serial_four' => array_key_exists('serialno_3',$itemvalue) ? $itemvalue['serialno_3'] : null,
                            'status' => Sageitemsserial::VALID_SERIAL,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    }
                }
            }
        }

        if(!empty($serialErros))
        {
            return $serialErros;
        }

        Sageitemsserial::insert($itemDetails);

        $getGrvInlineItemId = GrvSerialized::where('grvlines_id',$detailsOfItem->grvlines_id)->first();

        GrvSerialized::where('grvlines_id',$detailsOfItem->grvlines_id)
            ->update([
                'qty_serialized' => $getGrvInlineItemId->qty_serialized + $serialedItems,
                'qty_remaining' => $detailsOfItem->fQuantity - ($getGrvInlineItemId->qty_serialized + $serialedItems),
            ]);

        $status =Serializing::Serializing()->checkGrvs($autoindex_id,$detailsOfItem->grvlines_id);
        $getStatus = collect($status);
        $getGrv->update(['status'=>$getStatus->get('status')]);

        $getquantity = GrvSerialized::where('grvlines_id',$detailsOfItem->grvlines_id)->first();

            BtblInvoiceLine::where('iInvoiceID',$autoindex_id)->update(['_btblInvoiceLines_dModifiedDate' => Carbon::now()]);
            BtblInvoiceLine::where('iInvoiceID',$autoindex_id)->where('iStockCodeID',$getquantity->code)->decrement('fQtyToProcess',1);


        return [
            'idInvoiceLines'=>$detailsOfItem->grvlines_id,
            'numb'=>$serialedItems,
            'status'=>$getStatus->get('status')
        ];


    }

    public function updateSerial($serial_result,$dataReceived)
    {
//        dd($serial_result,$dataReceived);
        ActivateSerial::activateserial()->activateWarranty($serial_result->id,$dataReceived);
        ActivateSerial::activateserial()->serialActivation($serial_result->id,$dataReceived['idInvoiceLines']);
        IssueInlines::issueinlines()->updateInline($dataReceived['idInvoiceLines'],$dataReceived['serial']);
//        IssueInlines::issueinlines()->updateIssues($autoindex);
    }

}
