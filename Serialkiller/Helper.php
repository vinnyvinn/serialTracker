<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 10/5/16
 * Time: 3:58 PM
 */

namespace Serial;
use App\Setting;
use App\DnoteNumber;


class Helper
{
    public static function helper()
    {
        return new self();
    }

    public function dateFormat()
    {
        $dateFormat = 'd-F-y';
        return $dateFormat;
    }

    function getPrimarySerialColn()
    {
        $primary_serial = Setting::where('setting_id',2)->first()->default_value;
        $serialcolm = 'serial_one';
        if ($primary_serial == 4)
        {
            $serialcolm = 'serial_four';
        }
        elseif ($primary_serial == 3)
        {
            $serialcolm = 'serial_three';
        }
        elseif ($primary_serial == 2)
        {
            $serialcolm = 'serial_two';
        }
        elseif ($primary_serial == 1)
        {
            $serialcolm = 'serial_one';
        }
//dd($serialcolm);
        return $serialcolm;
    }

    public function assignColnChecker()
    {
        $primary_serial = Setting::where('setting_id',2)->first()->default_value;
        $serialcolm = 'serial_one';
        $valuetocheck = 'serialno_0';
        if ($primary_serial == 4)
        {
            $serialcolm = 'serial_four';
            $valuetocheck = 'serialno_3';
        }
        elseif ($primary_serial == 3)
        {
            $serialcolm = 'serial_three';
            $valuetocheck = 'serialno_2';
        }
        elseif ($primary_serial == 2)
        {
            $serialcolm = 'serial_two';
            $valuetocheck = 'serialno_1';
        }
        elseif ($primary_serial == 1)
        {
            $serialcolm = 'serial_one';
            $valuetocheck = 'serialno_0';
        }
        //todo return array to minimize code
        return $valuetocheck;
    }

    public function getDnoteNumber()
    {
        $numblength = Setting::where('setting_id',5)->first()->default_value;

        $dnotenumber = DnoteNumber::findorfail(1)->first();
        $dnote = '';
        $diff = $numblength - strlen($dnotenumber->dnote_number);
        for ($i = 0; $i < $diff; $i++)
        {
            $dnote = $dnote.'0';
        }
        $dnote = Setting::where('setting_id',4)->first()->default_value.'-'.$dnote.($dnotenumber->dnote_number + 1);


        return $dnote;
    }

}