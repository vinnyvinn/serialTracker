<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 9/29/16
 * Time: 4:12 PM
 */

namespace Serial;


use App\Issuelines;
use App\Sageitemsserial;
use App\Serialdates;
use App\Warrant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ActivateSerial
{
    public static function activateserial()
    {
        return new self();
    }

    public function activateWarranty($item_id,$data)
    {
        $now = Carbon::now();
        $now1 = Carbon::now();
        $now2 = Carbon::now();
        $now3 = Carbon::now();
        $item_details = Sageitemsserial::findorfail($item_id);
//        dd($item_details->id);
        $allWarranties = Warrant::select('id', 'item_codes', 'labour', 'service', 'parts')
            ->get()->toArray();
        $insertArray = [];

        if (!empty($allWarranties))
                {
                    foreach ($allWarranties as $allWarranty) {
                        if (in_array($item_details->code, json_decode($allWarranty['item_codes']))) {
                            $insertArray = [
                                'user' => Auth::user()->id,
                                'sageitemsserial_id' => $item_id,
                                'labour_start_date' => $now,
                                'service_start_date' => $now,
                                'parts_start_date' => $now,
                                'labour_end_date' => $now1->addYears($allWarranty['labour']),
                                'service_end_date' => $now2->addYears($allWarranty['service']),
                                'parts_end_date' => $now3->addYears($allWarranty['parts']),
                                'created_at' => $now,
                                'updated_at' => $now
                            ];
                        } else {
                            $insertArray = [
                                'user' => Auth::user()->id,
                                'sageitemsserial_id' => $item_id,
                                'labour_start_date' => $now,
                                'service_start_date' => $now,
                                'parts_start_date' => $now,
                                'labour_end_date' => $now1,
                                'service_end_date' => $now2,
                                'parts_end_date' => $now3,
                                'created_at' => $now,
                                'updated_at' => $now
                            ];
                        }
                    }
//                    dd($insertArray);
                    Serialdates::insert($insertArray);
            }

        return true;
    }

    public function serialActivation($item_id,$inv_lineid)
    {
        $sage_item = Sageitemsserial::findorfail($item_id);
        $sage_item->update(['status'=>Sageitemsserial::ISSUED_SERIAL]);
        $sage_item->update(['inv_idInvoiceLines'=>$inv_lineid]);
    }
}