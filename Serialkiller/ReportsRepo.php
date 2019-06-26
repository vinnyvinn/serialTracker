<?php
/**
 * Created by PhpStorm.
 * User: vinnyvinny
 * Date: 3/20/19
 * Time: 12:03 PM
 */

namespace Serial;


use App\Grv;
use App\Issue;
use App\Issuelines;
use App\Sageitemsserial;

class ReportsRepo
{
static function init(){
   return new self();
}

    public function getGrvs($date_from,$date_to,$type)
    {
        $grvrs = Grv::with('itemsserials')->whereHas('itemsserials')->whereBetween('DeliveryDate', [$date_from, $date_to])->where('state',$type)->get();

       $all_data = [];
        foreach ($grvrs as $grv){
           $serials = Sageitemsserial::where('grv_id',$grv->id)->get();
           $all_serials = [];
           foreach ($serials as $serial) {
               $all_serials[] = $serial ? $serial->serial_one :'';
           }
               $all_data[] = [
                   'Invoice No' => $grv->InvNumber,
                   'Grv No' => $grv->GrvNumber,
                   'Description' => $grv->Description,
                   'Delivery Date' => $grv->DeliveryDate,
                   'Order No' => $grv->OrderNum,
                   'Account Name' => $grv->cAccountName,
                   'status' => $grv->status,
                   'Serial No' => implode(',',$all_serials)
               ];

        };


        return($all_data);
}

    public function getInvoices($date_from,$date_to)
    {
        $issues = Issue::whereHas('lines.serials')->whereBetween('DeliveryDate', [$date_from, $date_to])->get();
        $all_data = [];
        foreach ($issues as $issue){
            $serialo = Issuelines::with('serials')->whereHas('serials')->where('autoindex_id',$issue->autoindex_id)->get();

            $all_serials = [];
                foreach ($serialo as $serial) {

                    foreach ($serial->serials as $single){
                     $all_serials[] = $single ? $single->serial_one : '';
                    }
                }

            $all_data[] = [
                'Invoice No' => $issue->InvNumber,
                'Grv No' => $issue->GrvNumber,
                'Description' => $issue->Description,
                'Delivery Date' => $issue->DeliveryDate,
                'Client Account' => $issue->clientAccount,
                'status' => $issue->status,
                'Serial No' => implode(',',$all_serials)
            ];

        };

        return collect($all_data);
}

}
