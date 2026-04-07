<?php

namespace App\Services;
use App\Contract\AuthProvider;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthService extends Services implements AuthProvider
{
    CONST TOKEN_NAME = 'user-token';
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * login
     *
     * @param  mixed $credentials
     * @return JsonResponse
     */
    public function login(array $credentials): JsonResponse
    {

        try {
            $username = $credentials['username'] ?? "";
            $password = $credentials['password'] ?? "";

            if(!$username && !$password){
                throw new \Exception("Missing credentials", 500);
            }
            $userInfo = User::where('username',$username)->first();

            if(!$userInfo){
                throw new \Exception("User does not exist", 500);
            }
            if(!Hash::check($password,$userInfo->password)){
                throw new \Exception("User credentials is invalid");
            }

            $token = $userInfo->createToken(self::TOKEN_NAME)->accessToken;
            return $this->successResponse([
                'token' => $token,
                'user' => $userInfo
            ],'Successfully Login');

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(),500,$th);
        }
    }
    /**
     * register
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $userInfo = User::where('username',$request->username)->exists();
            if($userInfo){
                throw new \Exception('Username is already taken');
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email ?? null,
                'username' => $request->username,
                'password' => Hash::make($request->password)
            ]);
            if($user){
                //  redirect user to login once registered
                return self::login([
                    'username' => $request->username,
                    'password' => $request->password
                ]);
            }
            throw new \Exception('Failed to create an acoount');

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(),500,$th);
        }
    }
    /**
     * logout
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            if(!$request->user()){
                throw new \Exception("Error while trying to logout , Please try again later");
            }
            $request->user()->tokens()->delete();

            return $this->successResponse("","Successfully logout.");
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
