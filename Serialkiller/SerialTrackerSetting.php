<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 10/11/16
 * Time: 11:50 AM
 */

namespace Serial;


//use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Setting;

class SerialTrackerSetting
{
    public function updateSetting(Request $request)
    {
        $setting_update = Setting::all();
       $setting_update ->where('setting_id',4)
            ->first()
            ->update(['default_value'=>$request->get('Delivery_note_Number_Prefix')]);

        $setting_update ->where('setting_id',5)
            ->first()->update(['default_value'=>$request->get('Delivery_note_Number_length')]);

        $setting_update ->where('setting_id',3)
            ->first()->update(['default_value'=>$request->get('Delivery_note_Type')]);

//        Setting::where('title','Primary Serials Column')
//            ->first()->update(['default_value'=>$request->get('Primary_Serial_Column')]);

        $setting_update ->where('setting_id',1)
            ->first()->update(['default_value'=>$request->get('Number_of_Serials')]);

        $setting_update ->where('setting_id',2)
            ->first()->update(['default_value'=>$request->get('Primary_Serial_Column')]);
        $setting_update ->where('setting_id',7)
            ->first()->update(['default_value'=>$request->get('grv_po')]);
        $setting_update ->where('setting_id',8)
            ->first()->update(['default_value'=>$request->get('strict_tracking')]);
        $setting_update ->where('setting_id',9)
            ->first()->update(['default_value'=>$request->get('tracking_method') ]);
        return $this;
    }
}
