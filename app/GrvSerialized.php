<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrvSerialized extends Model
{
    protected $fillable = ['autoindex_id','grvlines_id','description','qty_serialized','code','fQuantity','qty_remaining'];
    //protected $dateFormat = 'Y-m-d H:i:s';
}



