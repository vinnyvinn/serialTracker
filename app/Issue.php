<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    const NOT_ISSUED = 'Not issued';
    const PARTIALLY_ISSUED = 'Partially issued';
    const FULLY_ISSUED = 'Fully issued';
    const DELIVERED = 'Fully Delivered';
    const PARTIALLY_DELIVERED = 'Partially Delivered';
    protected $table="issues";
    protected  $fillable = ['sagegrv_id','autoindex_id','InvNumber','GrvNumber','Description','DeliveryDate','clientAccount','status'];

    function lines(){
        return $this->hasMany(Issuelines::class,'autoindex_id','autoindex_id');
    }
}

