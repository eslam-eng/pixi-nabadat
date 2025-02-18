<?php

namespace App\Models;

use App\Enum\UserPackageStatusEnum;
use App\Exceptions\NotFoundException;
use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use App\Traits\HasAttachment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory,HasAttachment, Notifiable, Filterable, EscapeUnicodeJson, HasRoles;

    const SUPERADMINTYPE = 1;
    const CUSTOMERTYPE = 2;
    const CENTERADMIN = 4;
    const EMPLOYEE = 5;

    const ACTIVE = 1;
    const NONACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'type','device_token',
        'last_login', 'date_of_birth', 'is_active', 'allow_notification','location_id', 'points', 'points_expire_date','center_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @param User $user
     * @param float $amount
     */
    public static function setPoints(Model $model, float $amount): bool
    {

        if (is_null($model->center_id))
        {
            $pointsPerPound = config('global.patient_points_per_pound') !== null ? config('global.patient_points_per_pound') : Setting::get('points', 'patient_points_per_pound');
            $pointsExpireDaysCount = config('global.patient_points_expire_days_count') !== null ? config('global.patient_points_expire_days_count') : Setting::get('points', 'patient_points_expire_days_count');
        }else
        {
            $pointsPerPound = config('global.center_points_per_pound') !== null ? config('global.center_points_per_pound') : Setting::get('points', 'center_points_per_pound');
            $pointsExpireDaysCount = config('global.center_points_expire_days_count') !== null ? config('global.center_points_expire_days_count') : Setting::get('points', 'center_points_expire_days_count');
        }
        $model->points += $pointsPerPound * $amount;
        $model->points_expire_date = Carbon::now()->setTimezone('Africa/Cairo')->addDays($pointsExpireDaysCount);
        $model->save();
        return true;
    }

    /**
     * Get the user's first name.
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->createToken(config('app.name'))->plainTextToken;
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => bcrypt($value),
        );
    }

    public function getId()
    {
        return $this->id;
    }

    public function location(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function center(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Center::class);
    }

//    ovveried attchments relation in user model
    public function attachments(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Attachment::class,'attachmentable');
    }

    public function cart(): \Illuminate\Database\Eloquent\Relations\hasOne
    {
        return $this->hasOne(Cart::class);
    }

    public function coupons(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CouponUsage::class,  'user_id', );
    }

    public function defaultAddress(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->addresses()->where('is_default', true);
    }

    public function addresses(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    public function orders(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function nabadatWallet(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(UserNabadatWallet::class, 'user_id');
    }

    public function package(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserPackage::class, 'user_id');
    }

    public function reservation(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Reservation::class,'customer_id');
    }

    public function getImageAttribute(): string
    {
       return $this->relationLoaded('attachments') && isset($this->attachments)
           ? asset(optional($this->attachments)->path . "/" . optional($this->attachments)->filename)
           :asset('assets/images/default-image.jpg');

    }

    public function getUserTypeAttribute()
    {
        switch(Auth::user()->type){
            case 1:
                return trans('lang.super_admin_type');
                break;
            case 5:
                return trans('lang.employee_type');
                break;
        }
    }

    public function scopeWalletGreaterThan(Builder $builder , int $minimum_number_of_pulses, $days_number): Builder
    {
        return $builder->whereHas('nabadatWallet',fn($query)=>$query
        ->where('total_pulses','>', $minimum_number_of_pulses)
        ->where('updated_at', Carbon::parse(Carbon::now()->subDays($days_number))->format('Y-m-d'))
        );
    }

    public function decreaseUserWallet(int $pulses)
    {
        if(!$this->nabadatWallet)
            throw new NotFoundException(trans('lang.there_is_no_user_wallet'));
        $this->nabadatWallet->used_amount = $this->nabadatWallet->used_amount + $pulses;
        $this->nabadatWallet->save();
    }
    
    //this method is used after a user package expired
    public function decreaseUserWalletForExpirePackage(int $pulses)
    {
        $this->nabadatWallet->total_pulses = $this->nabadatWallet->total_pulses - $pulses;
        $this->nabadatWallet->save();
    }

    public function decreaseFromOffer(Center $center, int $reservationPulses = 0)
    {
        $currentOngoingPackage = $this->package()->where('center_id', $center->id)->where('status',UserPackageStatusEnum::ONGOING)->first();
        if(!$currentOngoingPackage)
            throw new NotFoundException(trans('lang.there_is_no_enough_pulses'));
        $packageRemain = $currentOngoingPackage->remain - $reservationPulses;
        if($packageRemain == 0)
        {
            $currentPackagePulses = $currentOngoingPackage->remain;
            $status = UserPackage::getNextReadyPackage(user: $this, center_id: $center->id);
            $this->decreaseUserWallet($currentPackagePulses);
        }else if($packageRemain < 0)
        {
            $currentPackagePulses = $currentOngoingPackage->remain;
            $remainPluses = $reservationPulses - $currentOngoingPackage->remain;
            $status = UserPackage::getNextReadyPackage(user: $this, center_id: $center->id);
            if(!$status)
                throw new NotFoundException(trans('lang.there_is_no_enough_pulses'));
            $this->decreaseUserWallet($currentPackagePulses);
            $this->decreaseFromOffer(center: $center, reservationPulses: $remainPluses);
        }else{
            $currentOngoingPackage->remain -= $reservationPulses;
            $currentOngoingPackage->used += $reservationPulses;
            $currentOngoingPackage->save();
            $currentOngoingPackage->refresh();
            $this->decreaseUserWallet($reservationPulses);
        }
    }
}
