<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserCategory;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /* Website User/Guest Register **/
    public function register(UserStoreRequest $request, UserService $userService)
    {

        $isExsist = User::whereEmail($request->email)->first();

        $user = $userService->createUser($request, $isExsist);

        event(new Registered($user));

        return $this->successResponse($user, 200, 'User register successfully.');
    }

    /* Website User Login **/
    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(
                [
                    'email' => ['The provided credentials are incorrect.'],
                ]
            );
        }

        $user['token'] = $user->createToken($request->email)->plainTextToken;
        return $user;
    }

    /** Check Email already Exits */
    public function emailVerification(User $user)
    {
        return $this->successResponse($user, 200, 'The provided email is exits.');
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return $this->successResponse(' ', 200, 'Logged out.');
    }
}
