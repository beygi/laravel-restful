<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

 /**
 * @SWG\Resource(
 * 	apiVersion="1.0",
 *	resourcePath="/user",
 *	description="User operations",
 *	produces="['application/json']"
 * )
 */
class TokenAuthController extends Controller
{
/**
 * @SWG\Api(
 * 	path="/user/authenticate",
 *      @SWG\Operation(
 *      	method="POST",
 *      	summary="Get token",
 *		@SWG\Parameter(
 *			name="email",
 *			description="user email",
 *			paramType="form",
 *      		required=true,
 *      		allowMultiple=false,
 *      		type="string"
 *      	),
 *		@SWG\Parameter(
 *			name="password",
 *			description="user password",
 *			paramType="form",
 *      		required=true,
 *      		allowMultiple=false,
 *      		type="string"
 *      	)*
 *   	)
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
 * @SWG\Api(
 * 	path="/user",
 *      @SWG\Operation(
 *      	method="GET",
 *      	summary="Get user"
 *   	)
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

    public function register(Request $request){

        $newuser= $request->all();
        $password=Hash::make($request->input('password'));

        $newuser['password'] = $password;

        return User::create($newuser);
    }
}
