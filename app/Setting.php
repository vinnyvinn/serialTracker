<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['default_value','title','description'];
   // protected $dateFormat = 'Y-m-d H:i:s';

}
