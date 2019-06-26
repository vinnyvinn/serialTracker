<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sageitemsserial extends Model
{
    const VALID_SERIAL = 'Valid';
    const ISSUED_SERIAL = 'Issued';
//    const ISSUED_ACTIVED = 'Issued and Active';
    const INVALID_SERIAL = 'Invalid';
    protected $fillable = ['grv_id','warrant','inv_idInvoiceLines','idInvoiceLines','cDescription','status','autoindex_id'];
    //protected $dateFormat = 'Y-m-d H:i:s';
    public function serialdates()
    {
        return $this->hasMany(Serialdates::class);
    }
}
