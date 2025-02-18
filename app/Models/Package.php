<?php

namespace App\Models;

use App\Enum\PackageStatusEnum;
use App\Observers\PackageObserver;
use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use App\Traits\HasAttachment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class Package extends Model
{
    use HasFactory, Filterable, HasTranslations, HasAttachment, EscapeUnicodeJson;

    const SEARCHFLAG = 4;
    public $translatable = ['name'];
    protected $fillable = [
        'center_id',
        'name',
        'num_nabadat',
        'price',
        'start_date',
        'end_date',
        'discount_percentage',
        'status',
        'is_active',
        'package_category_id',
    ];

    public function subscriber(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserPackage::class);
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class, 'center_id');
    }

    public function getSearchFlagTextAttribute(): string
    {
        return trans('lang.packages') ;
    }

    public function getSearchFlagAttribute(): int
    {
        return self::SEARCHFLAG;
    }

    public function attachments()
    {
        return $this->morphOne(Attachment::class,'attachmentable');
    }

    public function getStatusAttribute($value)
    {
        switch ($value) {
            case PackageStatusEnum::UNDERACHIEVING:
                return trans('lang.under_reviewing');
                break;
            case PackageStatusEnum::APPROVED:
                return trans('lang.approved');
                break;
            case PackageStatusEnum::REJECTED:
                return trans('lang.rejected');
                break;
            default:
                return "-";
        }
    }

    public function getUserPriceAttribute(): float
    {
        return $this->price * ((100 - $this->discount_percentage) / 100);
    }

    public function getPriceAfterDiscountAttribute()
    {
        return $this->price - ($this->price * ($this->discount_percentage / 100));
    }

    public function scopeActive(Builder $builder): void
    {
        $builder->where('start_date' ,  '<=' , Carbon::now(config('app.africa_timezone'))->format('Y-m-d'))->where('end_date' ,  '>=' , Carbon::now(config('app.africa_timezone'))->format('Y-m-d'));
    }

    public function getImagePathAttribute(): string
    {
        return $this->relationLoaded('attachments') && isset($this->attachments) ? asset($this->attachments->path."/".$this->attachments->filename) : asset('assets/images/default-image.jpg');
    }

    public function getImageIdAttribute()
    {
        return $this->relationLoaded('attachments') && isset($this->attachments) ? $this->attachments->id : null;
    }

    protected static function boot()
    {
        parent::boot();
        static::observe(PackageObserver::class);
    }
}
