<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issuelines extends Model
{
    const PROCESSING = 'Processing';
    const DELIVERED = 'Fully Delivered';
    const ISSUED = 'Issued';
    const PARTIALLY_DELIVERED = 'Partially Delivered';
   // protected $dateFormat = 'Y-m-d H:i:s';
    protected  $fillable = ['issued_amount','remaining_amount','status','previous_amount'];


    public function serials()
    {
        return $this->hasMany('App\Sageitemsserial','idInvoiceLines','idInvoiceLines');
}

}
