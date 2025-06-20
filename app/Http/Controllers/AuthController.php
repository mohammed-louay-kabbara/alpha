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
use App\Models\PasswordResetCustom;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use App\Mail\VerificationCodeMail;

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
     $user = Auth::user(); // أو User::find(Auth::id());

    if (Hash::check($request->oldpassword, $user->password)) {
        $user->update([
            'password' => Hash::make($request->newpassword),
        ]);

        return response()->json('تم التعديل بنجاح', 200);
    } else {
        return response()->json(['error' => 'كلمة السر غير صحيحة'], 401);
    }
    }

       public function searchUsers(Request $request)
    {
        $query = $request->input('query');
        if (strlen($query) < 1) {
            return response()->json(['error' => 'يرجى إدخال حرف واحد على الأقل'], 400);
        }
        $users = User::where('name', 'like', "%$query%")->get();
        return response()->json([$users]);
    }

    public function users(){
        if (Auth::id()) {
            $adr=User::where('id',Auth::id())->first();
            $users= User::where('address',$adr->address)->get();
            return response()->json($users, 200);
        }
        User::where('address',);
    }


public function sendVerificationCode(Request $request)
{
    $user = User::where('email', $request->email)->first();
    if ($user) {
    $request->validate([
        'email' => 'required|email'
    ]);
    $code = random_int(1000, 9999); // رمز مكون من 4 أرقام
    session(['email_verification_code' => $code]);
    Mail::to($request->email)->send(new VerificationCodeMail($code));
    PasswordResetCustom::create([
        'email' => $request->email,
        'otp_code' => $code,
        'expires_at' => Carbon::now()->format('Y-m-d') ]);
    return response()->json(['message' => 'تم إرسال رمز التحقق إلى بريدك الإلكتروني.']);
    }
    else {
         return response()->json(['message' => 'الايميل غير موجود'], 401);
    }
}



public function verifyResetCode(Request $request)
{
    
    $request->validate([
        'otp_code' => 'required|digits:4',
    ]);
    
    $record = PasswordResetCustom::where('otp_code', $request->otp_code)->first();
   
    if (!$record) {
        return response()->json(['message' => 'الرمز غير صالح أو منتهي الصلاحية'], 401);
    }
    $record->delete();
    return response()->json(['message' => 'تم تعيين كلمة المرور الجديدة بنجاح']);
}

    public function register(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'phone'         => 'required|string|max:20',
            'datebirthday'  => 'required|date',
            'address'       => 'required|string|max:255',
            'password'      => 'required|string|min:8', // password + password_confirmation
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'errors'  => $validator->errors(),
            ], 422);
        }      
        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'datebirthday' => $request->datebirthday,
            // 'picture'      => $picturePath,
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

    public function login_admin(Request $request){
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    $user = User::where('email', $request->email)->first();
    if (!$user || $user->role !=1 ) {
      return back()->with('error', 'ليس لك صلاحية بالدخول');    
    }
    if (!$user || !Hash::check($request->password, $user->password)) {
          return back()->with('error', 'بيانات الدخول غير صحيحة، حاول مرة أخرى');    
    }
    Auth::login($user);
    return redirect()->intended('/dashboard');

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