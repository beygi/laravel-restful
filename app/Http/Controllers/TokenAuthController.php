<?php
/**
 * @SWG\Info(title="My API", version="0.1")
 */
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class TokenAuthController extends Controller
{
    /**
     * @SWG\Post(path="/api/user/authenticate",
     *   tags={"user"},
     *   summary="Authenticate user",
     *   description="",
     *   operationId="authUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="email",
     *     type="string",
     *     description="email address",
     *     required=true
     *   ),
     *   @SWG\Parameter(
     *     in="formData",
     *     name="password",
     *     type="string",
     *     description="password",
     *     required=true
     *   ),
     *   @SWG\Response(response="default", description="successful operation")
     * )
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // if no errors are encountered we can return a JWT
        return response()->json(compact('token'));
    }

    /**
     * @SWG\Get(path="/api/user",
     *   tags={"user"},
     *   summary="Get user object",
     *   description="This can only be done by the logged in user.",
     *   operationId="getUser",
     *   produces={"application/json"},
     *   @SWG\Response(response="200", description="successful operation")
     * )
     */

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }

    /**
     * @SWG\Post(path="/api/user",
     *   tags={"user"},
     *   summary="Create user",
     *   description="This can only be done by the logged in user.",
     *   operationId="createUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="email",
     *     type="string",
     *     description="Email address",
     *     required=true
     *   ),
     *   @SWG\Parameter(
     *     in="formData",
     *     name="password",
     *     type="string",
     *     description="Password",
     *     required=true
     *   ),
     *   @SWG\Parameter(
     *     in="formData",
     *     name="name",
     *     type="string",
     *     description="User's Name",
     *     required=true
     *   ),
     *   @SWG\Response(response="default", description="successful operation")
     * )
     */
    public function register(Request $request){
	//TODO validation
        $newuser= $request->all();
        $password=Hash::make($request->input('password'));

        $newuser['password'] = $password;

        return User::create($newuser);
    }
}
