<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 10/4/16
 * Time: 3:00 PM
 */

namespace Serial;


trait GetSageDate
{
    public function __construct()
    {
        IssueSo::issueSo()->getInvoice();
        AllGrv::allGrv()->getAllGrves();

    }
}