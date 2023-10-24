<style>
    nav i {
        font-size: 20px !important;
    }
</style>
<div class="sidebar-wrapper">
	<div>
		<div class="logo-wrapper">
			 <a href="{{route('home')}}"><img class="img-fluid for-light" style="width:190px" src="{{asset('images/icons/5.png')}}" style="width:190px" alt=""><img class="img-fluid for-dark" style="width:190px" src="{{asset('images/icons/5.png')}}" alt=""></a>
			<div class="back-btn"><i class="fa fa-angle-left"></i></div>
			<div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
		</div>
		<div class="logo-icon-wrapper"><a href="{{route('home')}}"><img class="img-fluid" style="width:190px" src="{{asset('images/icons/5.png')}}" alt=""></a></div>
		<nav class="sidebar-main">
			<div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
			<div id="sidebar-menu">
				<ul class="sidebar-links" id="simple-bar">
					<li class="back-btn">
						<a href="{{route('home')}}"><img class="img-fluid" style="width:190px" src="{{asset('images/icons/5.png')}}" alt=""></a>
						<div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
					</li>
					<li class="sidebar-main-title">
						{{-- <div>
							<h6 class="lan-1">{{ trans('lang.general') }} </h6>
                     		<p class="lan-2">{{ trans('lang.general_routes') }}</p>
						</div> --}}
					</li>
					<li class="sidebar-list">
                        @can('view_country')
                        {{-- start country --}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/country' ? 'active' : '' }}" href="#"><i class="fa fa-solid fa-flag p-r-5"></i><span class="lan-6">{{ trans('lang.country') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == 'country' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/country' ? 'block;' : 'none;' }}">
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('country.index') ? 'active' : '' }}" href="{{route('country.index')}}">{{ trans('lang.countries') }}</a></li>
                            @can('create_country')
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('country.create') ? 'active' : '' }}" href="{{route('country.create')}}">{{ trans('lang.create_country') }}</a></li>
                            @endcan
                        </ul>
                        {{-- end country --}}
                        @endcan

                        @can('view_governorate')
                        {{-- start governorate --}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/governorate' ? 'active' : '' }}" href="#"><i class="fa fa-solid fa-globe p-r-5"></i><span class="lan-6">{{ trans('lang.governorate') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/governorate' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('governorate.index') ? 'active' : '' }}" href="{{route('governorate.index')}}">{{ trans('lang.governorate') }}</a></li>
                            @can('create_governorate')
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('governorate.create') ? 'active' : '' }}" href="{{route('governorate.create')}}">{{ trans('lang.create_governorate') }}</a></li>
                            @endcan
                        </ul>
                        {{-- end governorate --}}
                        @endcan

                        @can('view_city')
                        {{-- end city --}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/city' ? 'active' : '' }}" href="#"><i class="fa fa-map-marker p-r-5"></i><span class="lan-6">{{ trans('lang.city') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/city' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('city.index') ? 'active' : '' }}" href="{{route('city.index')}}">{{ trans('lang.city') }}</a></li>
                            @can('create_city')
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('city.create') ? 'active' : '' }}" href="{{route('city.create')}}">{{ trans('lang.create_city') }}</a></li>
                            @endcan
                        </ul>
                        {{-- end city --}}
                        @endcan

                        @can('view_client')
                        {{--start clients--}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/clients' ? 'active' : '' }}" href="#"><i class="fa fa-user p-r-5"></i><span class="lan-6">{{ trans('lang.clients') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/doctors' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/clients' ? 'block;' : 'none;' }}">
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('clients.index') ? 'active' : '' }}" href="{{route('clients.index')}}">{{ trans('lang.view') }}</a></li>
                            @can('create_client')
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('clients.index') ? 'active' : '' }}" href="{{route('clients.create')}}">{{ trans('lang.create') }}</a></li>
                            @endcan
                        </ul>
                        {{-- end clients --}}
                        @endcan

                        @can('view_center')
                        {{-- start center --}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/centers' ? 'active' : '' }}" href="#"><i class="fa fa-map-marker p-r-5"></i><span class="lan-6">{{ trans('lang.center') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/centers' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('centers.index') ? 'active' : '' }}" href="{{route('centers.index')}}">{{ trans('lang.center') }}</a></li>
                            @can('create_center')
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('centers.create') ? 'active' : '' }}" href="{{route('centers.create')}}">{{ trans('lang.create_center') }}</a></li>
                            @endcan
                        </ul>
                        {{-- end center --}}
                        @endcan

                        @can('view_doctor')
                        {{-- start doctors --}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/doctors' ? 'active' : '' }}" href="#"><i class="fa fa-user p-r-5"></i><span class="lan-6">{{ trans('lang.doctors') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/doctors' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('doctors.index') ? 'active' : '' }}" href="{{route('doctors.index')}}">{{ trans('lang.view') }}</a></li>
                            @can('create_doctor')
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('doctors.index') ? 'active' : '' }}" href="{{route('doctors.create')}}">{{ trans('lang.create') }}</a></li>
                            @endcan
                        </ul>
                        {{-- end doctors --}}
                        @endcan

                        @can('view_category')
                        {{-- start categories ---}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/categories' ? 'active' : '' }}" href="#"><i class="fa fa-cube p-r-5"></i><span class="lan-6">{{ trans('lang.category') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/categories' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-5 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('categories.index') ? 'active' : '' }}" href="{{route('categories.index')}}">{{ trans('lang.view') }}</a></li>
                            <li><a class="lan-5 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('categories.create') ? 'active' : '' }}" href="{{route('categories.create')}}">{{ trans('lang.create') }}</a></li>
                        </ul>
                        {{-- end categories --}}
                        @endcan

                        @can('view_slider')
                        {{-- start slider --}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/sliders' ? 'active' : '' }}" href="#"><i class="fa fa-solid fa-sliders p-r-5"></i><span class="lan-6">{{ trans('lang.slider') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/sliders' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('sliders.index') ? 'active' : '' }}" href="{{route('sliders.index')}}">{{ trans('lang.view') }}</a></li>
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('sliders.create') ? 'active' : '' }}" href="{{route('sliders.create')}}">{{ trans('lang.create') }}</a></li>
                        </ul>
                        {{--end slider --}}
                        @endcan

                        @can('view_coupon')
                        {{-- start coupon ---}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/coupons' ? 'active' : '' }}" href="#"><i class="fa fa-sort-numeric-asc p-r-5"></i><span class="lan-6">{{ trans('lang.coupon') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/coupons' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-5 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('coupons.index') ? 'active' : '' }}" href="{{route('coupons.index')}}">{{ trans('lang.view') }}</a></li>
                            <li><a class="lan-5 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('coupons.create') ? 'active' : '' }}" href="{{route('coupons.create')}}">{{ trans('lang.create') }}</a></li>
                        </ul>
                        {{-- end coupon --}}
                        @endcan

                        @can('view_rate')
                        {{-- start rate ---}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/rates' ? 'active' : '' }}" href="#"><i class="fa fa-bar-chart-o p-r-5"></i><span class="lan-6">{{ trans('lang.rate') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/rates' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-5 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('rates.index') ? 'active' : '' }}" href="{{route('rates.index')}}">{{ trans('lang.view') }}</a></li>
                        </ul>
                        {{-- end rate --}}
                        @endcan

                        @can('view_device')
						{{-- start devices --}}
						<a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/devices' ? 'active' : '' }}" href="#"><i class="fa fa-cubes p-r-5"></i><span class="lan-6">{{ trans('lang.devices') }}</span>
							<div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/devices' ? 'down' : 'right' }}"></i></div>
						</a>
						<ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
							<li><a class="lan-5 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('devices.index') ? 'active' : '' }}" href="{{route('devices.index')}}">{{ trans('lang.view') }}</a></li>
							@can('create_device')
                            <li><a class="lan-5 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('devices.create') ? 'active' : '' }}" href="{{route('devices.create')}}">{{ trans('lang.create') }}</a></li>
                            @endcan
						</ul>
						{{-- end devices --}}
                        @endcan

                        @can('view_product')
                         {{-- start product ---}}
                         <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/products' ? 'active' : '' }}" href="#"><i class="fa fa-solid fa-shopping-bag p-r-5"></i><span class="lan-6">{{ trans('lang.product') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/products' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('products.index') ? 'active' : '' }}" href="{{route('products.index')}}">{{ trans('lang.view') }}</a></li>
                            @can('create_product')
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('products.create') ? 'active' : '' }}" href="{{route('products.create')}}">{{ trans('lang.create') }}</a></li>
                            @endcan
                        </ul>
                        {{-- end product --}}
                        @endcan

                        @can('view_package')
                        {{-- start package --}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/packages' ? 'active' : '' }}" href="#"><i class="fa fa-solid fa-suitcase p-r-5"></i><span class="lan-6">{{ trans('lang.package') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/packages' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('packages.index') ? 'active' : '' }}" href="{{route('packages.index')}}">{{ trans('lang.view') }}</a></li>
                            @can('create_package')
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('packages.create') ? 'active' : '' }}" href="{{route('packages.create')}}">{{ trans('lang.create') }}</a></li>
                            @endcan
                        </ul>
                        {{--end package --}}
                        @endcan

                        @can('view_employee')
                        {{-- start employee --}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/employees' ? 'active' : '' }}" href="#"><i class="fa fa-users p-r-5"></i><span class="lan-6">{{ trans('lang.employee') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/employees' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('employees.index') ? 'active' : '' }}" href="{{route('employees.index')}}">{{ trans('lang.view') }}</a></li>
                            @can('create_employee')
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('employees.create') ? 'active' : '' }}" href="{{route('employees.create')}}">{{ trans('lang.create') }}</a></li>
                            @endcan
                        </ul>
                        {{--end employee --}}
                        @endcan

                        @can('view_reservation')
                        {{-- start reservations --}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/reservations' ? 'active' : '' }}" href="#"><i class="fa fa-check-circle p-r-5"></i><span class="lan-6">{{ trans('lang.reservations') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/reservations' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('reservations.index') ? 'active' : '' }}" href="{{route('reservations.index')}}">{{ trans('lang.view') }}</a></li>
                            @can('create_reservation')
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('reservations.create') ? 'active' : '' }}" href="{{route('reservations.create')}}">{{ trans('lang.create') }}</a></li>
                            @endcan
                        </ul>
                        {{--end reservations --}}
                        @endcan

                        @can('view_user_package')
                        {{-- start User Packages --}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/user-packages' ? 'active' : '' }}" href="#"><i class="fa fa-solid fa-cube p-r-5"></i><span class="lan-6">{{ trans('lang.user_packages') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/user-packages' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('user-packages.index') ? 'active' : '' }}" href="{{route('user-packages.index')}}">{{ trans('lang.view') }}</a></li>
                            @can('create_user_package')
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('user-packages.create') ? 'active' : '' }}" href="{{route('user-packages.create')}}">{{ trans('lang.create') }}</a></li>
                            @endcan
                        </ul>
                        {{--end User Packages --}}
                        @endcan

                        @can('view_cancel_reason')
                        {{--start Cancel Reason ---}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/cancelReasons' ? 'active' : '' }}" href="#"><i class="fa fa-ban p-r-5"></i><span class="lan-6">{{ trans('lang.cancel_reason') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/cancelReasons' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('cancelReasons.index') ? 'active' : '' }}" href="{{route('cancelReasons.index')}}">{{ trans('lang.view') }}</a></li>
                            @can('create_cancel_reason')
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('cancelReasons.create') ? 'active' : '' }}" href="{{route('cancelReasons.create')}}">{{ trans('lang.create') }}</a></li>
                            @endcan
                        </ul>
                        {{-- end Cancel Reason --}}
                        @endcan

                        @can('view_order')
                        {{--start orders ---}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/orders' ? 'active' : '' }}" href="#"><i class="fa fa-cart-plus p-r-5"></i><span class="lan-6">{{ trans('lang.orders') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/orders' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('orders.index') ? 'active' : '' }}" href="{{route('orders.index')}}">{{ trans('lang.view') }}</a></li>
                        </ul>
                        {{-- end orders --}}
                        @endcan

                        {{--start fcm ---}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/fcm' ? 'active' : '' }}" href="#"><i class="fa fa-bell p-r-5"></i><span class="lan-6">{{ trans('lang.fcm') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/fcm' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('fcm-messages.index') ? 'active' : '' }}" href="{{route('fcm-messages.index')}}">{{ trans('lang.fcm_messages') }}</a></li>
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('schedule-fcm.index') ? 'active' : '' }}" href="{{route('schedule-fcm.index')}}">{{ trans('lang.schedule_fcm') }}</a></li>
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('fcm-messages.create') ? 'active' : '' }}" href="{{route('fcm-messages.create')}}">{{ trans('lang.create') }}</a></li>
                        </ul>
                        {{-- end fcm --}}

                        @can('view_settings')
                        {{--start Settings ---}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/settings' ? 'active' : '' }}" href="#"><i class="fa fa-gear p-r-5"></i><span class="lan-6">{{ trans('lang.settings') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/settings' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('settings') ? 'active' : '' }}" href="{{route('settings')}}">{{ trans('lang.view') }}</a></li>
                        </ul>
                        {{-- end Settings --}}
                        @endcan

                        @can('view_invoice')
                        {{--start invoices  ---}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/invoices' ? 'active' : '' }}" href="#"><i class="fa fa-file p-r-5"></i><span class="lan-6">{{ trans('lang.invoices') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/centerDevices' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('invoices.index') ? 'active' : '' }}" href="{{route('invoices.index')}}">{{ trans('lang.view') }}</a></li>
                        </ul>
                        {{-- end envoices--}}
                        @endcan
					</li>
                </ul>
			</div>
			<div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
		</nav>
	</div>
</div>
