<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
    public function editpassword(Request $request)
    {
      
        $user=User::where('id', Auth::id())->first();
        if (Hash::make($request->oldpassword) == Hash::make($user->password)) 
        {
            User::where('id', Auth::id())->update([
                'password' => Hash($request->newpassword)
            ]);
            return response()->json('تم التعديل بنجاح', 200);
        }
        else {
            return response()->json(['error' => 'كلمة السر غير صحية'], 401);
        }
    }


    public function register(Request $request)
    {
       

        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'phone'         => 'required|string|max:20',
            'datebirthday'  => 'required|date',
            'picture'       => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'address'       => 'required|string|max:255',
            'password'      => 'required|string|min:8', // password + password_confirmation
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $picturePath = null;
    if ($request->hasFile('picture')) {
    
        $picturePath = $request->file('picture')->store('profile_pictures', 'public');
    }

      
        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'datebirthday' => $request->datebirthday,
            'picture'      => $picturePath,
            'description'  => $request->description,
            'address'      => $request->address,
            'password'     => Hash::make($request->password),
        ]);
         
      JWTAuth::factory()->setTTL(43200); // 30 يوم
      $token = JWTAuth::fromUser($user);

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}