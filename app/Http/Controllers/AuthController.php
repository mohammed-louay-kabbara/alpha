<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\user;
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
use App\Models\follower;
use App\Models\product;
use App\Models\reels;

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

    public function getusers()
    {
        $users=user::get();
        return view('users',compact('users'));
    }


    public function editpassword(Request $request)
    {
     $user = Auth::user(); // أو user::find(Auth::id());

    if (Hash::check($request->oldpassword, $user->password)) {
        $user->update([
            'password' => Hash::make($request->newpassword),
        ]);
        return response()->json('تم التعديل بنجاح', 200);
    } else {
        return response()->json(['error' => 'كلمة السر غير صحيحة'], 401);
    }
    }

    public function info_user(Request $request){
        $user=user::where('id',$request->user_id)->first();
        return response()->json($user, 200);
    }
    public function count_profile(Request $request){
        if ($request->user_id) {
        $count_follower=follower::where('followed_id',$request->user_id)->count();
        $count_product=product::where('user_id',$request->user_id)->count();
        $count_reels=reels::where('user_id',$request->user_id)->count();
        return response()->json([
            'count_follower' => $count_follower, 
            'count_product' => $count_product,
            'count_reels' => $count_reels], 200);
        }
    }

        public function my_profile(){
        if (Auth::id()) {
        $user_id=Auth::id();
        $user=user::where('id',$user_id)->first();
        $count_follower=follower::where('followed_id',$user_id)->count();
        $count_product=product::where('user_id',$user_id)->count();
        $count_reels=reels::where('user_id',$user_id)->count();
        return response()->json([
            'user' => $user,
            'count_follower' => $count_follower, 
            'count_product' => $count_product,
            'count_reels' => $count_reels,
        ], 200);
        }
    }

    public function my_products()
    {
        $user_id=Auth::id();
        $product=product::with('files')->where('user_id',$user_id)->get();
        return response()->json([
            'product' =>$product,
        ], 200);
    }

    public function my_reels(){
        $user_id=Auth::id();
        $reels=reels::where('user_id',$user_id)->get();
        return response()->json([
            'reels'=>$reels
        ], 200);
    }

    public function forgot_password(Request $request)
    {
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->newpassword),
        ]);
        return response()->json('تم التعديل بنجاح', 200);
    }

       public function searchusers(Request $request)
    {
        $query = $request->input('query');
        if (strlen($query) < 1) {
            return response()->json(['error' => 'يرجى إدخال حرف واحد على الأقل'], 400);
        }
        $users = user::where('name', 'like', "%$query%")->get();
        return response()->json([$users]);
    }

    public function users()
    {
         $authUser = Auth::user();

    // اجلب كل المستخدمين ما عدا نفسه
    $users = User::where('id', '!=', $authUser->id)->get();

    // اجلب قائمة من يتابعهم المستخدم الحالي (IDs فقط)
    $authFollowingIds = $authUser->followings->pluck('followed_id');

    $result = [];

    foreach ($users as $user) {
        // اجلب من يتابعهم هذا المستخدم
        $userFollowingIds = $user->followings->pluck('followed_id');

        // تقاطع بين من تتابعهم أنت ومن يتابعهم هو = أصدقاء مشتركين
        $mutualIds = $authFollowingIds->intersect($userFollowingIds);

        // اجلب بيانات الأصدقاء المشتركين
        $mutualFriends = User::whereIn('id', $mutualIds)->get();

        $result[] = [
            'id' => $user->id,
            'name' => $user->name,
            'picture' => $user->picture,
            'mutual_count' => $mutualFriends->count(),
            'mutual_friends' => $mutualFriends->map(function ($mf) {
                return [
                    'id' => $mf->id,
                    'name' => $mf->name,
                    'picture' => $mf->picture,
                ];
            }),
        ];
    }

    return response()->json($result, 200);
    }


public function sendVerificationCode(Request $request)
{
    $user = user::where('email', $request->email)->first();
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
        $user = user::create([
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
      $token = JWTAuth::fromuser($user);

        return response()->json([
            'status' => true,
            'message' => 'user registered successfully',
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Get the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    public function login_admin(Request $request){

        $credentials = $request->only('email', 'password');
        if (!$token = JWTAuth::attempt($credentials)) {
            return redirect()->back()->with('error', 'بيانات الدخول غير صحيحة');
        }

        $user = Auth::user();
        if ($user->role != 1) {
            return redirect()->back()->with('error', 'ليس لديك صلاحية الدخول');
        }

        session(['jwt_token' => $token]); // تخزين التوكن في الجلسة

        return redirect('/dashboard_admin');
    }

    // public function logout()
    // {
    //     session()->forget('jwt_token');
    //     return redirect()->route('login');
    // }
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
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->picture=="profile_pictures/defoult_image.jpg") {
            $user->delete();
        return back()->with('success', 'تم حذف الصنف بنجاح');
        }
        elseif ($user->picture && Storage::disk('public')->exists($user->picture)) {
            Storage::disk('public')->delete($user->picture);
            $user->delete();
        return back()->with('success', 'تم حذف الصنف بنجاح');
        }
        

        }
}