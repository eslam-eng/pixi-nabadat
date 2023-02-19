<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Center;
use App\Models\CenterDevice;
use App\QueryFilters\CenterDevicesFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class CenterDeviceService extends BaseService
{

    /**
     * @throws NotFoundException
     */
    public function find(int $id, array $withRelations = [])
    {
        $center = Center::with($withRelations)->find($id);
        if (!$center)
            throw new NotFoundException(trans('lang.center_not_found'));
        return $center;

    }
    //get center devices api
    /**
     * @throws NotFoundException
     */
    public function getAllCenterDevices($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|Builder|array
    {
        $withRelations = ['devices.attachments'];
        $center = $this->find(id:$id,withRelations: $withRelations);
        return $center;
    }
    public function store(array $data = [])
    {
        $withRelations = ['devices.attachments'];
        $center   = $this->find(id:$data['center_id'],withRelations:$withRelations );
        $data['auto_service'] = isset($data['auto_service']) ? 1 : 0;
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $center->devices()->syncWithoutDetaching([$data['device_id']=> Arr::except($data, 'device_id')]);
        return $center->refresh();
    }

    /**
     * @throws NotFoundException
     */
    public function delete(int $id)
    {
        $centerId     = auth('sanctum')->user()->center_id;
        $center       = $this->find($centerId);
        $centerDevice = $center->devices()->detach($id);
        if (!$centerDevice)
            throw new NotFoundException(trans('lang.center_device_not_found'));
        return true;
    }

    /**
     * @throws NotFoundException
     */
    public function supportAutoService($id): bool
    {
        $centerId = auth('sanctum')->user()->center_id;
        $center = $this->find($centerId);
        $centerDevice = $center->devices()->where('device_id', $id)->first();
        $centerDevice->pivot->auto_service = !$centerDevice->pivot->auto_service;
        return $centerDevice->pivot->save();
    }//end of is_support_auto_service

    public function status($id): bool
    {
        $centerId = auth('sanctum')->user()->center_id;
        $center = $this->find($centerId);
        $centerDevice = $center->devices()->where('device_id', $id)->first();
        $centerDevice->pivot->is_active = !$centerDevice->pivot->is_active;
        return $centerDevice->pivot->save();

    }//end of status

}
