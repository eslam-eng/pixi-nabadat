<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\StoreFcmTokenRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserUpdateLogoRequest;
use App\Http\Resources\AuthUserResource;
use App\Models\User;
use App\Services\AuthService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function login(LoginRequest $request)
    {

        try {
            $type = $request->type ?? User::CUSTOMERTYPE ;
            $user = $this->authService->loginWithUsernameOrPhone(identifier: $request->identifier, password: $request->password,type:$type);
            $this->authService->setUserFcmToken($user,$request->fcm_token);
            return new AuthUserResource($user);
        } catch (UserNotFoundException $e) {
            return apiResponse($e->getMessage(), 'phone or password incorrect', $e->getCode());
        }
    }

    public function register(RegisterRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $data = $request->validated();
        $result = $this->authService->register(data: $data);
        if ($result)
            return apiResponse( trans('lang.success'));
        return apiResponse(message: __('lang.error_message'), code: 422);
    }


    public function authUser(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $user = Auth::user()->load(['location','attachments']);
            if ($user->type == User::CENTERADMIN)
                $user->load(['center.attachments']);
            return apiResponse(data: new AuthUserResource($user));
        } catch (\Exception $exception) {
            logger('auth user exception');
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }

    public function update(UpdateUserRequest $request)//: \Illuminate\Http\RedirectResponse
    {
        try {
            $user = auth('sanctum')->user();
            $data = $request->validated();
            $data['name'] = ['ar'=>$data['name'],'en'=>$data['name']];
            $user = $this->authService->update($user, $data);
            return apiResponse(data: new AuthUserResource($user), message: trans('lang.success_operation'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }

    public function updateProfileImage(UserUpdateLogoRequest $request)
    {
        try{
            $user = $this->authService->updateLogo(data: $request->validated());
            if(!$user)
                return apiResponse(message: trans('lang.some_thing_went_rong'), code: 422);
            return apiResponse(data: new AuthUserResource($user), message: trans('lang.success_operation'));
        }catch(Exception $e){
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return apiResponse(message: __('lang.logout_success'));
    }

    public function setFcmToken(StoreFcmTokenRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $user = auth()->user() ;
        if (!$user)
            return apiResponse(message: trans('lang.Unauthenticated'));
        $this->authService->setUserFcmToken($user , $request->fcm_token);
        return apiResponse(message: trans('lang.success_operation'));
    }
}
