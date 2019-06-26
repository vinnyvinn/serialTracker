<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 9/9/16
 * Time: 4:51 PM
 */

namespace Serial;

use App\Grv;
use App\GrvSerialized;
use Carbon\Carbon;
use App\Invnum;
use DB;
use Illuminate\Support\Facades\Session;
use function MongoDB\BSON\fromPHP;


class AllGrv
{
    /**
     * AllGrv constructor.
     */
    protected $allGrvs;

    public static function allGrv()
    {
        $grvAll = new AllGrv;
        return $grvAll;

    }

    public function getAllGrves()
    {


//DocState = 1,3;

        $grv = collect(DB::select(DB::raw('select AutoIndex,InvNumber,GrvNumber,GrvID,Description,DeliveryDate,OrderNum,cAccountName 
from InvNum where (DocType = 5) 
and DocState = 4  and  DocFlag =2 and OrigDocID <> 0')));

        $alreadyReceivedGrv = Grv::select('autoindex_id')->get()->toArray();
        $ids = [];
        foreach ($alreadyReceivedGrv as $gr) {
            $ids [] = $gr['autoindex_id'];
        }
        $itemWeWanted = [];
        foreach ($grv as $grvKey => $grvValue) {
            if (!in_array($grvValue->AutoIndex, $ids)) {
                $itemWeWanted [] = $grvValue;
            }
        }

        if (empty(array_flatten($alreadyReceivedGrv))) {

            self::storeGrv($grv);
            return 'Grvs imported successfully';
        }

        if (count($itemWeWanted) == null) {

            return 'stop';
        }
        self::storeGrv(collect($itemWeWanted));
        return 'Grvs imported successfully';
    }

    public function getUnprocessedGrvs()
    {

        $grvs = Invnum::select('OrderNum', 'AutoIndex', 'GrvNumber', 'GrvNumber', 'GrvID', 'Description', 'DeliveryDate', 'OrderNum', 'cAccountName')->where('DocType', 5)->whereIn('DocState', [1,3])->where('DocFlag', 1)->get();
        $alreadyReceivedGrv = Grv::select('autoindex_id')->get()->toArray();


        $ids = [];
        foreach ($alreadyReceivedGrv as $gr) {
            $ids [] = $gr['autoindex_id'];
        }
        $itemWeWanted = [];
        foreach ($grvs as $grvKey => $grvValue) {
            if (!in_array($grvValue->AutoIndex, $ids)) {

                $itemWeWanted [] = $grvValue;
            }
        }

        if (count($itemWeWanted) > 0) {

            self::storeUnprocessed($itemWeWanted);

        }

        return 'Grvs imported successfully';
    }

    private function storeGrv($grvs)
    {
        $now = Carbon::now();
        foreach ($grvs as $key => $item) {
            self::storeGrvInlinesItems($item->AutoIndex);
            Grv::create([
                'sagegrv_id' => (int)$item->GrvID,
                'autoindex_id' => (int)$item->AutoIndex,
                'InvNumber' => (int)$item->InvNumber,
                'GrvNumber' => $item->GrvNumber,
                'Description' => $item->Description,
                'DeliveryDate' => $item->DeliveryDate,
                'OrderNum' => $item->OrderNum,
                'cAccountName' => $item->cAccountName,
                'status' => Grv::SERIALIZED_GRV,
                'state' => Grv::PROCESSED_GRV,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

    }

    private function storeUnprocessed($grvs_found)
    {

        $now = Carbon::now();
        foreach ($grvs_found as $key => $item) {
            self::storeGrvInlinesItems($item->AutoIndex);
            Grv::create([
                'sagegrv_id' => (int)$item->GrvID,
                'autoindex_id' => (int)$item->AutoIndex,
                'InvNumber' => (int)$item->InvNumber,
                'GrvNumber' => $item->GrvNumber,
                'Description' => $item->Description,
                'DeliveryDate' => $item->DeliveryDate,
                'OrderNum' => $item->OrderNum,
                'cAccountName' => $item->cAccountName,
                'status' => Grv::UNSERIALIZED_GRV,
                'state' => Grv::UNPROCESSED_GRV,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

    }

    public function storeGrvInlinesItems($autoindex)
    {

        $allgrvinlines = self::getInlinesDetails($autoindex);
        $now = Carbon::now();
        foreach ($allgrvinlines as $key => $itemInlines) {
            GrvSerialized::create([
                'autoindex_id' => $itemInlines->iInvoiceID,
                'grvlines_id' => $itemInlines->idInvoiceLines,
                'description' => $itemInlines->cDescription,
                'qty_serialized' => 0,
                'code' => (int)$itemInlines->code,
                'fQuantity' => (int)$itemInlines->fQuantity,
                'qty_remaining' => '',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
//dd('fine');
        return true;
    }


    public function getInlinesDetails($autoindex)
    {
        $inlinesDetails = collect(DB::select(DB::raw("
        select iInvoiceID,Invdate,idInvoiceLines,GRvid,invnum.GrvNumber,OrderNum,
        cAccountName,cDescription,fUnitcost,ItemGroup,fQuantity,fQtyToProcess,
        fUnitPriceExcl,_btblInvoiceLines.iStockCodeID as code from _btblInvoiceLines inner join InvNum 
        on _btblInvoiceLines .iInvoiceID=invnum.AutoIndex 
        inner join StkItem on StkItem.StockLink=_btblInvoiceLines.iStockCodeID 
        where AutoIndex =" . $autoindex)));
        
		return $inlinesDetails;

    }

    public function getItemDetails($item_id)
    {
        $line_details = collect(DB::select(DB::raw("
        select iInvoiceID,Invdate,idInvoiceLines,GRvid,invnum.GrvNumber,OrderNum,
        cAccountName,cDescription,fUnitcost,ItemGroup,fQuantity,fQtyToProcess,_btblInvoiceLines.iStockCodeID as code,
        fUnitPriceExcl from _btblInvoiceLines inner join InvNum 
        on _btblInvoiceLines .iInvoiceID=invnum.AutoIndex 
        inner join StkItem on StkItem.StockLink=_btblInvoiceLines.iStockCodeID 
        where idInvoiceLines = " . $item_id)))->first();

        return $line_details;
    }

    public function getGrvDetails($autoindex)
    {
//        session(['autoindex_id'=>$autoindex]);
        return DB::select(DB::raw("select OrderNum,GrvID,GrvNumber,Description,InvDate,OrderDate,DeliveryDate,cAccountName from InvNum where AutoIndex = " . $autoindex));
    }


}


//        $grvlines = collect(DB::select(DB::raw("select iInvoiceID,Invdate,idInvoiceLines,GRvid,invnum.GrvNumber,OrderNum,cAccountName,cDescription,fUnitcost,code,ItemGroup,fQuantity,fQtyToProcess,fUnitPriceExcl from _btblInvoiceLines inner join InvNum on _btblInvoiceLines .iInvoiceID=invnum.AutoIndex inner join StkItem on StkItem.StockLink=_btblInvoiceLines.iStockCodeID where DocType=5 and DocFlag=2 and DocState=1"))
//        )->take(10);


//gettinginlines for a given grv
