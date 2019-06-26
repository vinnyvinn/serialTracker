<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grv extends Model
{
    const UNSERIALIZED_GRV = 'Not Received';
    const SERIALIZED_GRV = 'Fully Received';
    const PARTIALLY_SERIALIZED_GRV = 'Partially Received';

    const PROCESSED_GRV ='Processed';
    const UNPROCESSED_GRV ='Unprocessed';

  //  protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = ['grv_id','autoindex_id','InvNumber','GrvNumber','Description','DeliveryDate',
        'OrderNum','cAccountName','status','sagegrv_id','state'];

    public function itemsserials(){
        return $this->hasMany(Sageitemsserial::class);
    }



}
