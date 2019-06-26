<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 9/27/16
 * Time: 4:06 PM
 */

namespace Serial;

use App\Issuelines;
use Carbon\Carbon;
use DB;
use App\Issue;


class IssueSo
{
    public static function issueSo()
    {
        return new self();
    }

    public function getInvoice()
    {

        $saleOrderInvoice = collect(DB::table('InvNum')
            ->join('Client', 'Client.DCLink', '=', 'InvNum.AccountID')
            ->select('InvNum.AutoIndex', 'InvNum.InvNumber', 'InvNum.GrvID', 'InvNum.Description', 'InvNum.InvDate', 'InvNum.DeliveryDate', 'Client.Name')
            ->whereIn('InvNum.DocType', [0, 4])
            ->where('InvNum.DocState', 4)
            ->get());
//dd($saleOrderInvoice->count());

        $syncedSo = Issue::select('autoindex_id')->get()->flatten()->toArray();

        $ids = [];
        foreach ($syncedSo as $gr) {
            $ids [] = $gr['autoindex_id'];
        }
        $itemWeWanted = [];
        foreach ($saleOrderInvoice as $grvKey => $grvValue) {
            if (!in_array($grvValue->AutoIndex, $ids)) {

                $itemWeWanted [] = $grvValue;
            }
        }

        if (count($itemWeWanted) > 0) {

            self::storeSo($itemWeWanted);

        }

        return 'Sale Order updated successfully';


    }

    public function storeSo($insertSo)
    {

        $now = Carbon::now();
        foreach ($insertSo as $value) {
			self::storeINVlines($value->AutoIndex);
            Issue::create([
                'sagegrv_id' => 1,
                'autoindex_id' => $value->AutoIndex,
                'InvNumber' => $value->InvNumber,
                'GrvNumber' => $value->GrvID,
                'Description' => $value->Description,
                'DeliveryDate' => $value->DeliveryDate,
                'clientAccount' => $value->Name,
                'status' => Issue::NOT_ISSUED,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }



               //dd(Issuelines::all());
    }

    public function storeINVlines($autoindex)
    {
        $now = Carbon::now();
        $inlineDetails = AllGrv::allGrv()->getInlinesDetails($autoindex);
		
        $inertInlines = $inlineDetails->map(function ($invvalues, $invkey) use ($now, $autoindex) {
            return [
                'grv_id' => $invvalues->GRvid,
                'autoindex_id' => $autoindex,
                'idInvoiceLines' => $invvalues->idInvoiceLines,
                'cDescription' => $invvalues->cDescription,
                'fUnitcost' => $invvalues->fUnitcost,
                'code' => $invvalues->code,
                'fUnitPriceExcl' => $invvalues->fUnitPriceExcl,
                'previous_amount' => 0,
                'issued_amount' => 0,
                'remaining_amount' => $invvalues->fQuantity,
                'status' => Issuelines::PROCESSING,
                'serial' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ];
        })->toArray();

        Issuelines::insert($inertInlines);

        //dd($inertInlines,Issuelines::all());
    }

}
