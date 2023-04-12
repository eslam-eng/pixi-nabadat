<?php

namespace App\Http\Controllers;

use App\Exceptions\UserNotFoundException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserUpdateLogoRequest;
use App\Models\User;
use App\Services\AuthService;
use App\Services\LocationService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Mpdf\Tag\Q;
use Session;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService, private LocationService $locationService)
    {
    }

    public function index()
    {
        return view('authentication.login');
    }

    public function login(LoginRequest $request)
    {
        try {
            $type = User::SUPERADMINTYPE ;
            $this->authService->loginWithUsernameOrPhone(identifier: $request->identifier, password: $request->password,type: $type);
            $toast = [
                'type'=>'success',
                'message'=>__('lang.sign_in'),
                'title'=>'ok'
            ];
            return redirect()->route('home')->with('toast',$toast);
        }catch (UserNotFoundException $e) {
            $toast=[
              'type'=>'error',
              'title'=>'error',
              'message'=>  $e->getMessage()
            ];
           return redirect()->route('login')->with('toast',$toast);
        }

    }

    public function registerForm(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('authentication.sign-up');
    }


    public function register(RegisterRequest $request)
    {

    }


    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect(route('login'));
    }

    public function getProfile()
    {
        $filters = ['depth' => 1, 'is_active' => 1];
        $governorates = $this->locationService->getAll($filters);
        return view('dashboard.users.profile', compact('governorates'));
    }

    public function updateProfile(UpdateUserProfileRequest $request)
    {
        try{
            $data = $request->validated();
            $user = Auth::user();
            $status = $this->authService->update(user: $user, data: $data);
            if(!$status)
                return redirect()->back();
            $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect(route('/'))->with('toast', $toast);

        }catch(Exception $e){
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.something_went_rong')];
            return back()->with('toast', $toast);
        }
    }

    public function updateLogo(UserUpdateLogoRequest $request)
    {
        try{
            $user = $this->authService->updateLogo(data: $request->validated());
            if(!$user)
                return redirect()->back();
            $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect(route('/'))->with('toast', $toast);
        }catch(Exception $e){
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.something_went_rong')];
            return back()->with('toast', $toast);
        }
    }
}
