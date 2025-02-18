<?php

namespace App\Services;

use App\Enum\ImageTypeEnum;
use App\Exceptions\NotFoundException;
use App\Models\Center;
use App\Models\Product;
use App\Models\Slider;
use App\QueryFilters\SlidersFilter;
use Illuminate\Database\Eloquent\Builder;

class SliderService extends BaseService
{

    public function getAll(array $where_condition = [], array $withRelations = [])
    {
        $sliders = $this->queryGet($where_condition, $withRelations);
        return $sliders->get();
    }

    public function listing(array $where_condition = [], array $withRelations = [])
    {
        $perPage = config('app.perPage');
        return $this->queryGet($where_condition, $withRelations)->cursorPaginate($perPage);
    }

    public function queryGet(array $where_condition = [], array $withRelation = []): Builder
    {
        $sliders = Slider::query()->orderBy('order')->with($withRelation);
        return $sliders->filter(new SlidersFilter($where_condition));
    }

    public function store($data)
    {
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $model = match ((int)$data['type']) {
            Slider::CENTER  => Center::find($data['sliderable_id']),
            Slider::PRODUCT => Product::find($data['sliderable_id']),
        };
        if (isset($model))
            $slider = $model->sliders()->create($data);
        if (!$slider)
            return false ;
        if (isset($data['logo']))
        {
            $fileData = FileService::saveImage(file: $data['logo'],path: 'uploads/sliders', field_name: 'logo');
            $fileData['type'] = ImageTypeEnum::LOGO;
            $slider->storeAttachment($fileData);
        }
    } //end of store

    public function delete($id)
    {
        $slider = $this->find($id);
        if (!$slider)
            return false;
        $slider->deleteAttachments();
        return $slider->delete();

    } //end of find

    /**
     * @throws NotFoundException
     */
    public function find($id, $withRelation = [])
    {
        $slider = Slider::with($withRelation)->find($id);
        if (!$slider)
           throw  new NotFoundException(trans('lang.not_found'));
        return $slider;
    } //end of delete

    public function update($id, $data): bool|int
    {
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $slider = $this->find($id);
        if (!$slider)
            return false;
        if (isset($data['logo']))
        {
            $slider->deleteAttachmentsLogo();
            $fileData = FileService::saveImage(file: $data['logo'],path: 'uploads/sliders', field_name: 'logo');
            $fileData['type'] = ImageTypeEnum::LOGO;
            $slider->storeAttachment($fileData);
        }
        return $slider->update($data);
    } //end of update

    public function status($id): bool
    {
        $slider = $this->find($id);
        $slider->is_active = !$slider->is_active;
        return $slider->save();

    }//end of status
}
