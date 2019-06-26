<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 10/3/16
 * Time: 1:27 PM
 */

namespace Serial;

use App\Warrant;
use App\Sageitemsserial;
use Carbon\Carbon;
use  App\Setting;


class SerialTracker
{
    public static function serialtracker()
    {
        return new self();
    }

    public function getAllSerialDetails()
    {

    }

    public function getSerialDetails($itemdetails)
    {
        $warrants = Warrant::all();
        $details = [];
        $serialcolmn = Helper::helper()->getPrimarySerialColn();
            $alldatedetails = Sageitemsserial::findorfail($itemdetails->id)
                ->serialdates()->get();

            foreach ($alldatedetails as $alldatedetail)
            {
                if(array_key_exists($warrants->where('id',$alldatedetail->warrant_id)
                    ->first()->wrty_type,$details))
                {
                    array_push($details[$warrants->where('id',$alldatedetail->warrant_id)
                        ->first()->wrty_type],
                        [
                            'Description' => $itemdetails->cDescription,
                            'code'=>$itemdetails->code,
                            'status'=>$itemdetails->status,
                            'starts'=>$alldatedetail->start_date,
                            'end_date'=>$alldatedetail->end_date,
                            'serial'=>$itemdetails->$serialcolmn,
                            'duration'=>$warrants->where('id',$alldatedetail->warrant_id)
                                ->first()->wrty_duration == 0 ? 'No Warranty' :
                                $warrants->where('id',$alldatedetail->warrant_id)
                                    ->first()->wrty_duration. ' Years',
                            'warrant_status' =>Carbon::parse($alldatedetail->end_date) < Carbon::now()
                                ? 'Expired' : 'Active'
                        ]
                    );
                }

                 else {
                    $details [$warrants->where('id', $alldatedetail->warrant_id)
                        ->first()->wrty_type][0] =
                        [
                            'Description' => $itemdetails->cDescription,
                            'code' => $itemdetails->code,
                            'status' => $itemdetails->status,
                            'serial'=>$itemdetails->$serialcolmn,
                            'starts' => Carbon::parse($alldatedetail->start_date)
                                ->format(Helper::helper()->dateFormat()),
                            'end_date' => Carbon::parse($alldatedetail->end_date)
                                ->format(Helper::helper()->dateFormat()),
                            'duration' => $warrants->where('id', $alldatedetail->warrant_id)
                                ->first()->wrty_duration == 0 ? 'No Warranty' :
                                $warrants->where('id', $alldatedetail->warrant_id)
                                    ->first()->wrty_duration . ' Years',
                            'warrant_status' => Carbon::parse($alldatedetail->end_date) < Carbon::now()
                                ? 'Expired' : 'Active'
                        ];
                }
            }

            return $details;
        }
        public function getValidSerials()
        {
            $allserials = Sageitemsserial::where('status','!=',Sageitemsserial::INVALID_SERIAL)
                ->get();
            return $allserials;
        }
        public function searchSerials($serials)
        {
            $serial_primary_coln = Helper::helper()->getPrimarySerialColn();
            $list_of_array = array_flatten(Sageitemsserial::select($serial_primary_coln)
                ->get()->toArray());
            $error = [];
            foreach ($serials as $serial)
            {
                if(!empty($serial) && in_array($serial,$list_of_array))
                {
                    array_push($error,$serial);
                }
            }
//            dd($serials,$error);
            return $error;
        }

    public function getCodes($inlinesdetails)
    {
         $codes = [];
         foreach ($inlinesdetails as $serial){
             $codes[]=$serial->code;
         }
         return collect($codes);
    }
}
