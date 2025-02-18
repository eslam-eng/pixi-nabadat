<?php

namespace App\Http\Controllers\Api;

use App\Enum\PackageStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\CentersResource;
use App\Http\Resources\CouponsResource;
use App\Http\Resources\HomeSearchResource;
use App\Http\Resources\LocationsResource;
use App\Http\Resources\PackagesResource;
use App\Http\Resources\product\ProductsResource;
use App\Http\Resources\SlidersResource;
use App\Models\Center;
use App\Models\Device;
use App\Models\Product;
use App\Services\CenterPackageService;
use App\Services\CenterService;
use App\Services\CouponService;
use App\Services\DeviceService;
use App\Services\DoctorService;
use App\Services\LocationService;
use App\Services\ProductService;
use App\Services\SliderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct(protected ProductService  $productService,
                                protected CenterService   $centerService,
                                protected LocationService $locationService,
                                protected SliderService   $sliderService,
                                protected CouponService   $couponService,
                                protected CenterPackageService $packageService,
                                protected DeviceService $deviceService,
                                protected DoctorService $doctorService)
    {
    }


    public function index(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $governorate_id = request()->input('governorate_id', null);
        $centers_filter = ['is_active' => 1, 'featured' => 1];
        if (isset($governorate_id))
            $centers_filter['governorate_id'] =  $governorate_id;

//        $data = Cache::remember('home-api', 60 * 60 * 24, function () use ($centers_filter) {
            $data['featured_products'] = ProductsResource::collection($this->productService->getAll(where_condition: ['is_active' => 1, 'featured' => 1], withRelation: ['attachments','defaultLogo']));
            $data['center_packages'] = PackagesResource::collection($this->packageService->listing(where_condition: ['is_active' => 1, 'in_duration' => true, 'status' => PackageStatusEnum::APPROVED, 'governorate_id'=>$governorate_id], withRelation: ['attachments','center.user:id,center_id,name', 'center.defaultLogo']));
            $data['locations'] = LocationsResource::collection($this->locationService->getAll(filters: ['depth' => 2]));
            $data['coupons'] = CouponsResource::collection($this->couponService->listing(filters: ['in_period' => true, 'is_active' => true]));
            $data['featured_centers'] = CentersResource::collection($this->centerService->listing(filters: $centers_filter, withRelation: ['defaultLogo']));
            $data['sliders'] = SlidersResource::collection($this->sliderService->listing(where_condition: ['is_active' => 1, 'in_duration'=> true], withRelations: ['attachments']));
//            return $data;
//        });
        return apiResponse(data: $data);
    }

    public function search(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $filters = $request->all();
        $filters['in_duration'] = 1;
        $filters['is_active']   = 1;
        $product = $this->productService->queryGet(where_condition: $filters, withRelation: ['defaultLogo'])->select(['id','name'])->limit(10)->get();
        $center  = $this->centerService->queryGet(where_condition:  $filters, withRelation: ['defaultLogo'])->select(['id','name'])->limit(10)->get();
        $device  = $this->deviceService->queryGet(where_condition:  $filters, withRelation: ['center', 'defaultImage'])->select(['id','name'])->limit(10)->get();
        $package = $this->packageService->queryGet(where_condition: $filters, withRelation: ['center', 'attachments'])->limit(10)->get();
        $doctor = $this->doctorService->queryGet(filters: $filters, withRelation: ['center', 'defaultLogo'])->limit(10)->get();

        $finalResult = collect([
            $product,
            $center,
            $device,
            $package,
            $doctor,
        ]);
        $search_results = new HomeSearchResource($finalResult);
        return apiResponse(data: $search_results);
    }

    public function companyData()
    {
        return apiResponse(data: [
            'company_name'         => [
                'ar' => config('global.company_name_ar'),
                'en' => config('global.company_name_en'),
            ],
            'phones' => [
                'primary_phone'=> config('global.primary_phone'),
                'phone2' => config('global.phone2'),
                'phone3' => config('global.phone3'),
                'phone4' => config('global.phone4'),
            ],
            'company_logo' => asset('uploads/settings/'.config('global.company_logo')),
            'address' => config('global.address'),
            'location_id' => config('global.location_id'),
            'description' => config('global.description'),
            'terms_and_conditions' => config('global.terms_and_conditions'),
        ], message: trans('lang.success_operation'));
    }
}
