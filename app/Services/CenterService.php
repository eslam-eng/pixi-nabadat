<?php

namespace App\Services;


use App\Models\Center;
use App\Models\Location;
use App\Models\User;
use App\QueryFilters\CentersFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CenterService extends BaseService
{


    public function queryGet(array $where_condition = []): Builder
    {
        $centers = Center::query();
        return $centers->filter(new CentersFilter($where_condition));
    }

    public function getAll(array $where_condition = [])
    {
        $centers = $this->queryGet($where_condition);
        return $centers->get();
    }

    public function store(array $centerData = [], array $doctorIds =[])
    {
        $center = Center::create($centerData);
        if ($center)
            $center->doctors()->sync($doctorIds);
        return true;
    }

    public function getCenterById($id)
    {
        return Center::find($id);
    }

    public  function update(int $centerId, array $centerData, array $doctorIds)
    {
        $center = $this->getCenterById($centerId);
        $center->update($centerData);
        $center->doctors()->sync($doctorIds);
        return true;
    }

    public function delete($id): bool
    {
        $center = $this->getCenterById($id);
        if ($center)
            return $center->delete();
        return false;
    }
}
