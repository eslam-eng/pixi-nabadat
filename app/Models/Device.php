<?php

namespace App\Models;

use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use App\Traits\HasAttachment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Device extends Model
{
    use HasFactory,HasTranslations,Filterable,HasAttachment,EscapeUnicodeJson;

    const SEARCHFLAG = 3 ;

    public $translatable =['name','description'];
    protected $fillable  =['name','description','is_active'];

    public function center(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Center::class);
    }

    public function getSearchFlagTextAttribute(): string
    {
        return trans('lang.devices') ;
    }
    public function getSearchFlagAttribute(): int
    {
        return self::SEARCHFLAG;
    }

}
