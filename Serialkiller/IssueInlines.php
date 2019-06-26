<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 9/29/16
 * Time: 6:02 PM
 */

namespace Serial;


use App\Issue;
use App\Issuelines;

class IssueInlines
{
    public static function issueinlines()
    {
        return new self();
    }

    public function updateInline($inline_id,$itemserial)
    {

        $get_inline = Issuelines::where('idInvoiceLines',$inline_id)->first();
            self::updateValues($get_inline);

        if($get_inline->status != Issuelines::PARTIALLY_DELIVERED &&
        $get_inline->status != Issuelines::DELIVERED) {
            $get_inline->update(['status' => Issuelines::ISSUED]);
        }
//        dd($get_inline->status,'kk');
        $get_inline->update(['serial'=>$itemserial]);

        self::updateIssues($get_inline->autoindex_id);
        return true;
    }

    private static function updateValues($itemDetails)
    {
        $new_remaining_value = $itemDetails->remaining_amount - 1;
        $new_issued_value = $itemDetails->issued_amount + 1;
//        dd($itemDetails->previous_amount + $new_issued_value);
        $issue_lines = Issuelines::findorfail($itemDetails->id);
        $issue_lines ->update(['remaining_amount'=>$new_remaining_value]);
//        $issue_lines->update(['issued_amount'=>$new_issued_value]);
        $issue_lines->update(['previous_amount'=>($itemDetails->previous_amount + 1)]);

    }

    public function updateIssues($issue_id)
    {
        $issue_details = Issue::where('autoindex_id',$issue_id)->first();
        $get_all_issue_inlines = Issuelines::where('autoindex_id',$issue_id)->get();
        $remaining = $get_all_issue_inlines->sum('remaining_amount');
        $issued_amount = $get_all_issue_inlines->sum('issued_amount');

        if($issue_details->status != Issue::DELIVERED)
        {
            if($issue_details->status == Issue::PARTIALLY_DELIVERED && $remaining <= 0)
            {
                Issue::findorfail($issue_details->id)
                    ->update(['status'=>Issue::PARTIALLY_DELIVERED]);
            }
            elseif($issue_details->status != Issue::PARTIALLY_DELIVERED && $remaining <= 0)
            {
                Issue::findorfail($issue_details->id)
                    ->update(['status'=>Issue::FULLY_ISSUED]);
                return true;
            }
            elseif($issue_details->status == Issue::PARTIALLY_DELIVERED && $remaining <= 0)
            {
                Issue::findorfail($issue_details->id)
                    ->update(['status'=>Issue::DELIVERED]);
                return true;
            }
            elseif($issue_details->status == Issue::PARTIALLY_DELIVERED && $remaining > 0)
            {
                Issue::findorfail($issue_details->id)
                    ->update(['status'=>Issue::PARTIALLY_DELIVERED]);
                return true;
            }
            elseif ($issue_details->status != Issue::PARTIALLY_DELIVERED  && $issued_amount > 0)
            {
                Issue::findorfail($issue_details->id)
                    ->update(['status'=>Issue::PARTIALLY_ISSUED]);
            }
            elseif ($issue_details->status == Issue::NOT_ISSUED  && $issued_amount <= 0)
            {
                Issue::findorfail($issue_details->id)
                    ->update(['status'=>Issue::PARTIALLY_ISSUED]);
            }
            else{
                Issue::findorfail($issue_details->id)
                    ->update(['status'=>Issue::NOT_ISSUED]);
            }
        }

        return true;

    }
}
