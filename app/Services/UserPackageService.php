<?php

namespace App\Services;

use App\Enum\PaymentMethodEnum;
use App\Enum\PaymentStatusEnum;
use App\Enum\UserPackageStatusEnum;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Api\BuyCustomPulsesController;
use App\Models\Center;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserPackage;
use App\QueryFilters\UserPackagesFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class UserPackageService extends BaseService
{

    protected $userPackageData;
    public function listing(array $filters = [], array $withRelation = []): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        $perPage = config('app.perPage');
        return $this->queryGet(where_condition: $filters, withRelation: $withRelation)->cursorPaginate($perPage);
    }

    public function queryGet(array $where_condition = [], $withRelation = []): Builder
    {
        $userPackages = UserPackage::query()->with($withRelation);
        return $userPackages->filter(new UserPackagesFilter($where_condition));
    }

    /**
     * @throws NotFoundException
     */
    public function update(int $id, array $data=[]): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|Builder|array
    {
        $userPackage = $this->find(id:$id,with:['user','package'] );
        if (!$userPackage)
            throw new NotFoundException(trans("lang.offers_not_found_or_package_paid"));
        if($userPackage->payment_status == PaymentStatusEnum::PAID)
            throw new NotFoundException(trans("lang.package_is_paid"));
        $ongoingPackage = $userPackage->user->package->where('center_id', $data['center_id'])->where('status', UserPackageStatusEnum::ONGOING)->first();
        if(!$ongoingPackage)
            $data['status'] = $data['payment_status'] == PaymentStatusEnum::PAID ? UserPackageStatusEnum::ONGOING: UserPackageStatusEnum::PENDING;
        else
            $data['status'] = $data['payment_status'] == PaymentStatusEnum::PAID ? UserPackageStatusEnum::READYFORUSE: UserPackageStatusEnum::PENDING;
        $data['remain'] = $data['num_nabadat'];
        $currentUserPackageStatus = $userPackage->payment_status;
        $is_updated =  $userPackage->update($data);
        $userPackage->refresh();
        $user = $userPackage->user;
        if($currentUserPackageStatus == PaymentStatusEnum::UNPAID && $data['payment_status'] == PaymentStatusEnum::PAID)
        {
            $userPackage->expire_date = Carbon::now()->setTimezone('Africa/Cairo')->addYear()->format('Y-m-d');
            $userPackage->save();
            app()->make(UserService::class)->updateOrCreateNabadatWallet(user: $user, userPackage: $userPackage);
        }
        return $userPackage;
    }

    public function create(array $data =[]){
        return UserPackage::create($data);
    }

    public function store(array $data)
    {
        $user = User::find($data['user_id']);
        if(!$user)
            throw new NotFoundException(trans('lang.user_not_found'));
        $userPackages = $user->package->where('center_id', $data['center_id'])->where('status', UserPackageStatusEnum::ONGOING)->first();
        if(!$userPackages)
            $data['status'] = $data['payment_status'] == PaymentStatusEnum::PAID ? UserPackageStatusEnum::ONGOING: UserPackageStatusEnum::PENDING;
        else
            $data['status'] = $data['payment_status'] == PaymentStatusEnum::PAID ? UserPackageStatusEnum::READYFORUSE: UserPackageStatusEnum::PENDING;
        $data['remain'] = $data['num_nabadat'];
        $userPackage = UserPackage::create($data);
        if($data['payment_status'] == PaymentStatusEnum::PAID)
        {
            $userPackage->expire_date = Carbon::now()->setTimezone('Africa/Cairo')->addYear()->format('Y-m-d');
            $userPackage->save();
            app()->make(UserService::class)->updateOrCreateNabadatWallet(user: $user, userPackage: $userPackage);
        }
        /**
         * TODO
         * add user package financial code here
         */
        return  $userPackage;
    }


    /**
     * @throws NotFoundException
     */
    public function find(int $id, array $with = []): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|bool|Builder|array
    {
        $userPackage = UserPackage::with($with)->find($id);
        if (!$userPackage)
            throw new NotFoundException(trans('user package not found'));
        return $userPackage;
    }

    public function delete(int $id)
    {
        $userPackage = $this->find($id);
        if(!$userPackage)
            new NotFoundException(trans('lang.user_package_not_found'));
        $paymentStatus = $userPackage->payment_status;
        if($paymentStatus != PaymentStatusEnum::UNPAID)
            new NotFoundException(trans('lang.not_allowed'));
        return $userPackage->delete();

    } //end of delete

    // public function decreaseFromOffer(User $user, Center $center, int $number_of_pulses)
    // {
    //     if ($number_of_pulses == 0)
    //         return true ;
    //     $activeUserPackage = $user->package->where('status',UserPackageStatusEnum::ONGOING)->where('payment_status',PaymentStatusEnum::PAID)->where('remain','!=',0)->first();
    //     if ($activeUserPackage)
    //     {
    //         if ($number_of_pulses > $activeUserPackage->remain)
    //         {

    //             $remain_pulses = $number_of_pulses - $activeUserPackage->remain;
    //             $activeUserPackage->used = $activeUserPackage->used + $activeUserPackage->remain;
    //             $userPackageRemain = $activeUserPackage->remain;
    //             $activeUserPackage->remain = 0;
    //             $activeUserPackage->status = UserPackageStatusEnum::COMPLETED;
    //             $this->getNextReadyUserPackage(user: $user);
    //             $activeUserPackage->save();
    //             $activeUserPackage->refresh();

    //             //start update user wallet
    //             $this->decreaseUserWallet(user: $user, pulses: $userPackageRemain);
    //             //end update user wallet
                
    //             $this->decreaseFromOffer(user: $user, center: $center, number_of_pulses: $remain_pulses);
    //         }else{
    //             $old_remain = $activeUserPackage->remain ;
    //             $activeUserPackage->remain = $old_remain - $number_of_pulses ;
    //             $activeUserPackage->used = $activeUserPackage->used + $number_of_pulses ;
    //             if ($old_remain - $number_of_pulses == 0)
    //             {
    //                 $activeUserPackage->status = UserPackageStatusEnum::COMPLETED ;
    //                 $this->getNextReadyUserPackage(user: $user);
    //             }
    //             $activeUserPackage->save();
    //             $activeUserPackage->refresh();

    //             //start update user wallet
    //             $this->decreaseUserWallet(user: $user, pulses: $number_of_pulses);
    //             //end update user wallet
    //             return true;
    //         }
    //     }else{
    //         //there is no userpackage and number_of_pulses != 0
    //         //start create transaction
    //         $userPackageData = [
    //             'user_id' => $user->id,
    //             'num_nabadat' => $number_of_pulses,
    //             'price' => $number_of_pulses * $center->pulse_price,
    //             'center_id' => $center->id,
    //             'discount_percentage' => $center->pulse_discount,
    //             'payment_method' => PaymentMethodEnum::CASH,
    //             'payment_status' => PaymentStatusEnum::PAID,
    //             'status' => UserPackageStatusEnum::COMPLETED,
    //             'used' => $number_of_pulses,
    //             'remain' => 0,
    //             'deleted_at' => isset($deleted_at) ? Carbon::now() : null
    //         ];
    //         UserPackage::create($userPackageData);
    //         //end create transaction

    //     }
    // }


    // /**
    //  * get the next ready userPackage and convert it to ONGOING
    //  * @param User $user
    //  * @return bool
    //  */
    // private function getNextReadyUserPackage(User $user): bool
    // {
    //     $readyUserPackage =  $user->package->where('status',UserPackageStatusEnum::READYFORUSE)->where('payment_status',PaymentStatusEnum::PAID)->first();
        
    //     if(!$readyUserPackage)
    //         return false;

    //     $readyUserPackage->update([
    //         'status'=>UserPackageStatusEnum::ONGOING,
    //     ]);

    //     return true;
    // }

    // /**
    //  * get the user wallet and decrease it
    //  * @param User $user
    //  * @param int $pulses
    //  * @return bool
    //  */
    // private function decreaseUserWallet(User $user, int $pulses): bool
    // {
    //     $old_pulses = $user->nabadatWallet->total_pulses ?? 0;
    //     $old_used_pulses = $user->nabadatWallet->used_amount ?? 0;
    //     $total_pulses = $old_pulses - $pulses;
    //     $used_amount = $old_used_pulses + $pulses;

    //     $user->nabadatWallet->total_pulses = $total_pulses;
    //     $user->nabadatWallet->used_amount = $used_amount;
    //     $user->nabadatWallet->save();

    //     return true;
    // }

    /**
     * calculate the user and center points and create transaction
     * @param UserPackage $userPackage
     */
    public function completeUserPackage(UserPackage $userPackage)
    {
        //user after paid for package earn point
        if ($userPackage->payment_status == PaymentStatusEnum::PAID) {
            $userPackage->load(['center','user']);
            $amount_after_discount = $userPackage->price - ($userPackage->price * ($userPackage->discount_percentage / 100));
//          set user points after pay the offer
            User::setPoints($userPackage->user, amount: $amount_after_discount);
//          set center points after pay the offer
            // User::setPoints($userPackage->center->user, amount: $amount_after_discount);
//          set financial for center
            $final_discount = $userPackage->center->app_discount - $userPackage->discount_percentage;
            $center_dues = $userPackage->price - ($userPackage->price * ($userPackage->center->app_discount / 100));
            $nabadat_app_dues =($final_discount > 0) ?  ($userPackage->price * ($final_discount/ 100)):0;
            
            if($userPackage->payment_method == PaymentMethodEnum::CASH)
            {
                $center_cash_dues = $center_dues;
                $nabadat_cash_dues = $nabadat_app_dues;
                $center_credit_dues = 0;
                $nabadat_credit_dues = 0;
            }

            if($userPackage->payment_method == PaymentMethodEnum::CREDIT)
            {
                $center_credit_dues = $center_dues;
                $nabadat_credit_dues = $nabadat_app_dues;
                $center_cash_dues = 0;
                $nabadat_cash_dues = 0;
            }

            $invoice = Invoice::where('center_id',$userPackage->center->id)->where('status',Invoice::PENDING)->orderByDesc('id')->first();
            if ($invoice)
            {
                if($userPackage->payment_method == PaymentMethodEnum::CASH)
                {
                    $center_cash_dues = $invoice->center_cash_dues + $center_dues;
                    $nabadat_cash_dues = $invoice->nabadat_cash_dues + $nabadat_app_dues;

                    $center_credit_dues = $invoice->center_credit_dues;
                    $nabadat_credit_dues = $invoice->nabadat_credit_dues;

                }

                if($userPackage->payment_method == PaymentMethodEnum::CREDIT)
                {
                    $center_cash_dues = $invoice->center_cash_dues;
                    $nabadat_cash_dues = $invoice->nabadat_cash_dues;

                    $center_credit_dues = $invoice->center_credit_dues + $center_dues;
                    $nabadat_credit_dues = $invoice->nabadat_credit_dues + $nabadat_app_dues;
                }
                $center_dues = $invoice->total_center_dues + $center_dues ;
                $nabadat_app_dues = $invoice->total_nabadat_dues + $nabadat_app_dues;

                $invoice->update([
                    'total_center_dues'=>$center_dues,
                    'total_nabadat_dues'=>$nabadat_app_dues,

                    'center_cash_dues'=>$center_cash_dues,
                    'nabadat_cash_dues'=>$nabadat_cash_dues,

                    'center_credit_dues'=>$center_credit_dues,
                    'nabadat_credit_dues'=>$nabadat_credit_dues
                ]);
            }else
            {
                $invoice = Invoice::create([
                    'total_center_dues'=>$center_dues,
                    'total_nabadat_dues'=>$nabadat_app_dues,

                    'center_cash_dues'=>$center_cash_dues,
                    'nabadat_cash_dues'=>$nabadat_cash_dues,

                    'center_credit_dues'=>$center_credit_dues,
                    'nabadat_credit_dues'=>$nabadat_credit_dues,

                    'center_id'=>$userPackage->center->id
                ]);
            }
            Transaction::createTransaction($userPackage,$invoice->id);
        }
    }

}
