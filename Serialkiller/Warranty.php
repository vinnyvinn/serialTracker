<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 10/5/16
 * Time: 6:38 PM
 */

namespace Serial;
use App\Sageitemsserial;
use App\Serialdates;
use App\Warrant;
use App\User;
use Carbon\Carbon;
use DB;


class Warranty
{
    public static function warranty()
    {
        return new self();
    }

    public function getAllcodes()
    {


       $codes = DB::select(DB::raw(' select code from StkItem'));

      return $codes;
        $unset_codes = [];
        foreach ($codes as $code)
        {
                $result = self::checkCodeWarranty($code->code);

            if ($result != 'found')
            {
                //array_push($unset_codes,$code->code);
                $unset_codes [] = $code->code;

            }

        }
        dd($unset_codes);
        return collect($unset_codes);
    }

    public function storeWarranty($data)
    {
        $now = Carbon::now();
        $insertWarranty = [
            'item_codes' => json_encode($data->get('codes')),
            'labour' =>$data->get('labour'),
            'service' =>$data->get('service'),
            'parts'=>$data->get('parts'),
            'created_at'=>$now,
            'updated_at'=>$now
        ];
        Warrant::insert($insertWarranty);
    }

    private function checkCodeWarranty($item_code)
    {
        $itemcodes_array = [];
        $allWarranties = Warrant::select('item_codes')->get();
        foreach (array_flatten($allWarranties->toArray()) as $array)
        {
           array_push($itemcodes_array,json_decode($array));
        }
        if(in_array($item_code,array_flatten($itemcodes_array)))
        {
            return 'found';
        }
    }

    public function getGrvlinesWarrantyDetails($grvlines)
    {

        $allWarranties= Warrant::select('id','item_codes','labour','service','parts')
            ->get()->toArray();
//        dd($grvlines,$allWarranties);
        $resultArray = $grvlines->map(function ($values,$key) use($allWarranties)
        {
            if (empty($allWarranties))
            {
                return [
                    'id' => $values->id,
                    'autoindex_id' => $values->autoindex_id,
                    'grvlines_id' => $values->grvlines_id,
                    'description' => $values->description,
                    'qty_serialized' => $values->qty_serialized,
                    'qty_remaining'=>$values->qty_serialized > 0 ?($values->qty_serialized ==$values->fQuantity ? 0 : $values->qty_remaining) :$values->fQuantity,
                    'code'=> $values->code,
                    'fQuantity'=>$values->fQuantity,
                    'labour'=>0,
                    'service'=>0,
                    'parts'=>0,
                    'has_warranty' => 'no'
                ];
            }
            foreach ($allWarranties as $allWarranty)
            {
                if(empty($allWarranties) || in_array($values->code,json_decode($allWarranty['item_codes'])))
                {
                    return [
                       'id' => $values->id,
                        'autoindex_id' => $values->autoindex_id,
                        'grvlines_id' => $values->grvlines_id,
                        'description' => $values->description,
                        'qty_serialized' => $values->qty_serialized,
                        'code'=> $values->code,
                        'fQuantity'=>$values->fQuantity,
                        'qty_remaining'=>$values->qty_serialized > 0 ?($values->qty_serialized ==$values->fQuantity ? 0 : $values->qty_remaining) :$values->fQuantity,
                        'labour'=>$allWarranty['labour'],
                        'service'=>$allWarranty['service'],
                        'parts'=>$allWarranty['parts'],
                        'has_warranty'=>'yes'
                        ];
                }
                else{
                    return [
                        'id' => $values->id,
                        'autoindex_id' => $values->autoindex_id,
                        'grvlines_id' => $values->grvlines_id,
                        'description' => $values->description,
                        'qty_serialized' => $values->qty_serialized,
                        'qty_remaining'=>$values->qty_serialized > 0 ?($values->qty_serialized ==$values->fQuantity ? 0 : $values->qty_remaining) :$values->fQuantity,
                        'code'=> $values->code,
                        'fQuantity'=>$values->fQuantity,
                        'labour'=>0,
                        'service'=>0,
                        'parts'=>0,
                        'has_warranty' => 'no'
                    ];
                }
            }
        });

        return $resultArray;
    }

    public function getItemWarrant()
    {
        $all_warranties = Serialdates::all();
        $all_items = Sageitemsserial::select('id')
            ->where('status',Sageitemsserial::ISSUED_SERIAL)
            ->get()->toArray();
        $items = Sageitemsserial::where('status',Sageitemsserial::ISSUED_SERIAL)->get();

        $warranties_details = $all_warranties->map(function ($values,$key) use($items,$all_items)
        {
            $coln = Helper::helper()->getPrimarySerialColn();
            $now = Carbon::now();
            foreach ($all_items as $all_item)
            {
                $insert = $items->where('id',$values->sageitemsserial_id)->first();
//                dd();

                if (in_array($values->sageitemsserial_id,$all_item))
                {
                    return [
                        'code' =>$insert ->code,
                        'description' =>$insert->cDescription,
                        'serial' =>$insert->$coln,
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

        return $warranties_details;

    }

}
