<?php

namespace App\Observers;

use App\Enum\PaymentStatusEnum;
use App\Models\Center;
use App\Models\Invoice;
use App\Models\Settlement;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserPackage;
use Carbon\Carbon;

class UserPackageObserver
{
    /**
     * Handle the UserPackage "created" event.
     *
     * @param \App\Models\UserPackage $userPackage
     * @return void
     */
    public function created(UserPackage $userPackage)
    {
        //user after paid for package earn point
        if ($userPackage->payment_status == PaymentStatusEnum::PAID) {
            $userPackage->load(['center','user']);
            $amount_after_discount = $userPackage->price - ($userPackage->price * ($userPackage->center->app_discount / 100));
//          set user points after pay the offer
            User::setPoints($userPackage->user, amount: $amount_after_discount);
//          set center points after pay the offer
            User::setPoints($userPackage->center->user, amount: $amount_after_discount);
//          set financial for center
            $final_discount = $userPackage->center->app_discount - $userPackage->discount_percentage;
            $center_dues = $userPackage->price - ($userPackage->price * ($userPackage->center->app_discount / 100));
            $nabadat_app_dues =($final_discount > 0) ?  ($userPackage->price * ($final_discount/ 100)):0;
            $invoice = Invoice::where('center_id',$userPackage->center->id)->where('status',Invoice::PENDING)->orderByDesc('id')->first();
            if ($invoice)
            {
                $center_dues = $invoice->total_center_dues + $center_dues ;
                $nabadat_app_dues = $invoice->total_nabadat_dues + $nabadat_app_dues;
                $invoice->update(['total_center_dues'=>$center_dues, 'total_nabadat_dues'=>$nabadat_app_dues]);
            }else
            {
                $invoice = Invoice::create(['total_center_dues'=>$center_dues, 'total_nabadat_dues'=>$nabadat_app_dues,'center_id'=>$userPackage->center->id]);
            }
            Transaction::createTransaction($userPackage,$invoice->id);
        }
    }

    /**
     * Handle the UserPackage "updated" event.
     *
     * @param \App\Models\UserPackage $userPackage
     * @return void
     */
    public function updated(UserPackage $userPackage)
    {
        //
    }

    /**
     * Handle the UserPackage "deleted" event.
     *
     * @param \App\Models\UserPackage $userPackage
     * @return void
     */
    public function deleted(UserPackage $userPackage)
    {
        //
    }

    /**
     * Handle the UserPackage "restored" event.
     *
     * @param \App\Models\UserPackage $userPackage
     * @return void
     */
    public function restored(UserPackage $userPackage)
    {
        //
    }

    /**
     * Handle the UserPackage "force deleted" event.
     *
     * @param \App\Models\UserPackage $userPackage
     * @return void
     */
    public function forceDeleted(UserPackage $userPackage)
    {
        //
    }
}
