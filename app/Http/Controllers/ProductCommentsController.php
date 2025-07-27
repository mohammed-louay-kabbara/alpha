<?php

namespace App\Http\Controllers;

use App\Models\product_comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'message' => 'required', 
            'product_id' => 'required',
        ]);

        product_comments::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'product_id' => $request->product_id,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'تم التقييم بنجاح.',
        ], 201);
    }


    public function show($id)
    {
        
        $array = ['علّق قبل ما يسبقك ابن خالتك وبتعرف أنت الباقي ! 🙃'
        , 'القرد بعين أمه غزال .. وبعين مرتوا كيس مصاري  🙂🙃',
        'زوجونا',
        'أبوك كل يوم جمعة لازم يرجع يعيد تأهيل السطح',
        '👽→وأنت رايح تخلص المنهاج بنص ساعة , فضائي ولو',
        'أسئلة الفحص كلها من الكتاب → دكتور الجامعة 🌚',
        'إذا ما علّقت . رح تصير القعدة كلها عن ابن خالتك 😬🙃',
        'أبن خالتك بشو أحسن منك   ',
        'أنا ما نسيت الجواب .. هو نسي يجي عالامتحان! 🙃',
        'بوظة .. كنافي .. سحلب , وعم تنغم كمان 🙂 مستقبلك↙️',
        'طب الجرى على تما بتطلع البنت لأمها 🙃🌚',
        'خانت التعليقات عنا صارت مثل الدّاي أم زكي ',
        'هون ساحة نقاش ... مو حضانة، احكي متل الكبار. 🌚',
        'علّق قبل ما يعلّقوك! 🙃',
        'بتهون نص الألف خمسمية',
        'لم أجد حل يحل محل الحل الحالي لحالتي حالياً 🙃',
        'والله لعيشك ملكة ',
        'أنا تمام، بس تمامي مو تمام التمام، هو تمام نص نص! ',
        'أنا ما نسيت، بس الذاكرة نسيتني إني نسيت!',
        'أنت تُكسر من الأسئلة ',
        'لا تتخلى عن حلمك... خليك نايم!',
        'إذا ما قدرت تسعد حالك... عكّر مزاج غيرك 🙃',
        'أنا مو فاشل... بس النجاح مو من أولوياتي حالياً!',
        'لا تبرر أخطائك... جلّطهم بالمزيد!',
        'علاوي حبيب قلبي أبو حسين 😎',
        'لا تتمادا خبزك خبز العباس',
        'إذا ضاقت عليك الدنيا... تذكّر إنها مو بنطلون!',
        'أنا مشاعري كلها ميتة .. إلا الجوع  ، شغّال 24 ساعة!',
        'لا تنظر للخلف أبداً إلا وقت الأمتحان ',
        'الكسل هو أم العادات السيئة، ولكنها أم ويجب احترامها.',
        'دعونا ننسى أخطاء الماضي ونرتكب أخطاء جديدة.',
        'لا تمشِ وراء قلبك لأن قلبك لا يملك أقدام',
        'أشعر بالوحدة التي شعر بها آخر ديناصور قبل انقراضه.',
        'لا يوجد انتظار أسوء من انتظار الأكل',
        'أنا و النوم قصة حب تدمرها ماما كل صباح'];
        
        $product_comments = product_comments::with(['user', 'likes']) // أضف likes هنا
            ->where('product_id', $id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($comment) {
                $comment->liked_by_user = $comment->likes->contains('user_id', auth()->id());
                unset($comment->likes);
                return $comment;
            });

        $randomPhrase = $array[array_rand($array)];
        return response()->json(['product_comments' => $product_comments ,'comment'=> $randomPhrase], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(product_comments $product_comments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, product_comments $product_comments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product_comments $product_comments)
    {
        //
    }
}
