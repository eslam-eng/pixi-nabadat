<?php

namespace App\QueryFilters;

use App\Abstracts\QueryFilter;
use Illuminate\Support\Arr;

class ReservationsFilter extends QueryFilter
{

    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    public function id($term)
    {
        return $this->builder->where('id',$term);
    }


    public function is_active($term)
    {
        return $this->builder->where('is_active',$term);
    }

    public function name($term)
    {
        return $this->builder->where('name',$term);
    }

    public function user_id($term)
    {
        return $this->builder->where('customer_id',$term);
    }

    public function center_id($term)
    {
        return $this->builder->where('center_id',$term);
    }

    public function status($term)
    {
        return $this->builder->whereHas('latestStatus', function ($query) use ($term) {
            $query->where('status', $term);
        });
    }

    public function status_in($term)
    {
        $term = Arr::wrap($term);
        return $this->builder->whereHas('latestStatus', function ($query) use ($term) {
            $query->whereIn('status', $term);
        });
    }

}
