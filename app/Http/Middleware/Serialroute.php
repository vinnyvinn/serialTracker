<?php

namespace App\Http\Middleware;

use App\Setting;
use Closure;
use Illuminate\Foundation\Testing\HttpException;
use Illuminate\Support\Facades\Auth;
use Serial\GetSageDate;
use Serial\IssueSo;
use Serial\AllGrv;


class Serialroute
{
//    use GetSageDate;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        IssueSo::issueSo()->getInvoice();
        AllGrv::allGrv()->getAllGrves();
            if(Setting::where('setting_id',4)->first()->default_value == 771) {
             return redirect()->route('setting.index');
            }

        return $next($request);
    }
}
