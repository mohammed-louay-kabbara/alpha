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

    
// public function sendResetCode(Request $request)
// {
//     $request->validate([
//         'email' => 'required|email|exists:users,email'
//     ]);

//     // توليد رمز من 4 أرقام
//     $otp = rand(1000, 9999);

//     // حذف أي رموز سابقة
//     PasswordResetCustom::where('email', $request->email)->delete();

//     // حفظ الرمز الجديد
//     PasswordResetCustom::create([
//         'email' => $request->email,
//         'otp_code' => $otp,
//         'expires_at' => Carbon::now()->addMinutes(10),
//     ]);

//     // إرسال الرمز بالإيميل
//     Mail::raw("رمز إعادة تعيين كلمة المرور الخاص بك هو: $otp", function ($message) use ($request) {
//         $message->to($request->email)
//                 ->subject('رمز التحقق لإعادة تعيين كلمة المرور');
//     });

//     return response()->json(['message' => 'تم إرسال رمز التحقق إلى بريدك الإلكتروني']);
// }


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