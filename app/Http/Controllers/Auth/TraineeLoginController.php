<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Trainee;
use App\General;
use App\Cart;
use App\ContestQuestion;
use App\ContestQuestionTrainee;
use Illuminate\Support\Facades\Hash;
use Auth;
use Route;


class TraineeLoginController extends Controller
{

      public function __construct()
      {
        $this->middleware('guest:trainee', ['except' => ['logout']]);
      }

      public function showLoginForm()
      {
        return view('auth.trainee.login');
      }


      public function showForgetForm()
      {
        return view('auth.trainee.forget');
      }
      public function login(Request $request)
      {

        // Validate the form data
        $this->validate($request, [
          'input_send'     => 'required|string|min:5|max:255',
          'select_input'   => 'required|string|min:0|max:2',
          'password' => 'required|min:6'
        ]);
        //------------
        $select_input   = $request->select_input;
        $input_send     = $request->input_send;
        $type_send      = $request->type_send;
        //------------

        switch ($select_input) {
          case 1:
              $this->validate($request, [
                  'input_send'=>'email|regex:/(.+)@(.+)\.(.+)/i',
              ]);
              $select_input = 'email';
            break;
          case 2:
              $this->validate($request, [
                  'input_send'=>'string|regex:/^([0-9\s\-\+\(\)]*)$/|min:8|max:14'
              ]);
              $select_input = 'phone';
            break;
          case 3:
              $select_input = 'identity';
            break;
          default:
          abort(404);
        }
        //------------
        $Trainee = Trainee::where($select_input, '=', $input_send)->first();
        if(!$Trainee){
          return redirect()->back()->withErrors('لم يتم إيجاد أي من البيانات المدخلة بالشكل الصحيح');
        }
        // elseif($Trainee->count() > 1 ){
        //   return redirect()->back()->withErrors('لقد تم إيجاد تشابه بالبيانات المدخلة ، الرجاء التواصل مع إدارة المعهد');
        // }


        //------------
   
        //------------
        // if($input_send=='test@trainee.com'||$input_send=='0511111111')
        // {
        //  $code=111111;   
        // }
        // else{
        // $code = General::generate_codes(6 , 2);
        // }
        
        // $type_send_text  = '';
        // $title = "رمز الدخول للوحة انا متدرب : ";
        // $body = $code;
        // Trainee::where($select_input, '=', $input_send)->update(['last_code' => $code]);

        // switch ($type_send) {
        //   case 1: // Email

        //     $get_return = General::sendMail($title , $body , 'Trainee Login' , $Trainee[0]->email);
        //     $type_send_text = " تم إرسال الرمز إلى بريدك الإلكتروني المحفوظ لدينا ";
        //     break;
        //   case 2: // Sned SMS
        //     $get_return = General::sendSMS( $title , $body,  'Trainee Login' , $Trainee[0]->phone);
        //     $type_send_text = "تم إرسال الرمز إلى جوالك ";
        //     break;
        //   case 3:  // Sned Whatsapp

        //     $type_send_text = " تم إرسال رسالة نصية إلى ال Whatsapp الخاص بجوالك المحفوظ ";
        //     break;
        //   default:
        //   abort(404);
        // }
      

     
        // return redirect()->back()
        //             		->with( 'code_send', $type_send_text)
        //             		->with( 'id_login', encrypt($Trainee[0]->id) );

        // exit();
        // Attempt to log the user in

        if (Hash::check($request->password, $Trainee->password)) {
         if(Auth::guard('trainee')->loginUsingId($Trainee->id)){
              $ip=$_SERVER['REMOTE_ADDR'];
             
              $carts   = Cart::where([['user_ip',$ip],['trainee_id',null]])->get();   
            //  dd($carts);
             if($carts)
             {
             foreach($carts as $cart)
             {
                 $cart->trainee_id=$Trainee->id;
                 $cart->save();
             }}
             $contestQuestions   = ContestQuestionTrainee::where([['trainee_ip',$ip],['trainee_id',null]])->get();   
           
             if($contestQuestions)
             {
             foreach($contestQuestions as $contestQuestion)
             {
              $exsitContestQuestion   = ContestQuestionTrainee::where([['contest_question_id',$contestQuestion->contest_question_id],['trainee_id',$Trainee->id]])->first();   
              if(!$exsitContestQuestion)
              {
                 $contestQuestion->trainee_id=$Trainee->id;
                 $contestQuestion->save();
             }}}
            //  dd($contestQuestions);
             if($contestQuestions)
             {
              return redirect()->intended(route('trainee.dashboard'))->with(['message'=>'تم تسجيل بياناتك بنجاح']);
             }
             else{
              return redirect()->intended(route('trainee.dashboard'));

             }
            }   
            
}
else{
  return redirect()->back()->withErrors('خطأ في كلمة المرور  ');
          
}
        // if (Auth::guard('trainee')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
        //   // if successful, then redirect to their intended location
        //   return redirect()->intended(route('trainee.dashboard'));
        // }
        // if unsuccessful, then redirect back to the login with the form data
        // return redirect()->back()->withInput($request->only('email', 'remember'));
      }

 public function forget(Request $request)
      {

        // Validate the form data
        $this->validate($request, [
          'input_send'     => 'required|string|min:5|max:255',
          'select_input'   => 'required|string|min:0|max:2',
          'type_send'      => 'required|string|min:0|max:15',
        ]);
        //------------
        $select_input   = $request->select_input;
        $input_send     = $request->input_send;
        $type_send      = $request->type_send;
        //------------

        switch ($select_input) {
          case 1:
              $this->validate($request, [
                  'input_send'=>'email|regex:/(.+)@(.+)\.(.+)/i',
              ]);
              $select_input = 'email';
            break;
          case 2:
              $this->validate($request, [
                  'input_send'=>'string|regex:/^([0-9\s\-\+\(\)]*)$/|min:8|max:14'
              ]);
              $select_input = 'phone';
            break;
          case 3:
              $select_input = 'identity';
            break;
          default:
          abort(404);
        }
        //------------
        $Trainee = Trainee::where($select_input, '=', $input_send)->get();
        if($Trainee->count() <= 0 ){
           return redirect()->back()->withErrors('لم يتم إيجاد أي من البيانات المدخلة بالشكل الصحيح');
        }elseif($Trainee->count() > 1 ){
          return redirect()->back()->withErrors('لقد تم إيجاد تشابه بالبيانات المدخلة ، الرجاء التواصل مع إدارة المعهد');
        }


       
        $code = General::generate_codes(6 , 2);
        $type_send_text  = '';
        $title = "رمز الدخول للوحة انا متدرب : ";
        $body = $code;
        Trainee::where($select_input, '=', $input_send)->update(['last_code' => $code]);

        switch ($type_send) {
          case 1: // Email

            $get_return = General::sendMail($title , $body , 'Trainee Login' , $Trainee[0]->email);
        
            $type_send_text = " تم إرسال الرمز إلى بريدك الإلكتروني المحفوظ لدينا ";
            break;
          case 2: // Sned SMS
            $get_return = General::sendSMS( $title , $body,  'Trainee Login' , $Trainee[0]->phone);
            $type_send_text = "تم إرسال الرمز إلى جوالك ";
            break;
          case 3:  // Sned Whatsapp

            $type_send_text = " تم إرسال رسالة نصية إلى ال Whatsapp الخاص بجوالك المحفوظ ";
            break;
          default:
          abort(404);
        }
        return redirect()->back()
                    		->with( 'code_send', $type_send_text)
                    		->with( 'id_login', encrypt($Trainee[0]->id) );

        exit();
        // Attempt to log the user in
        if (Auth::guard('trainee')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
          // if successful, then redirect to their intended location
          return redirect()->intended(route('trainee.dashboard'));
        }
        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email', 'remember'));
      }

      public function access_code(Request $request)
      {
        $this->validate($request, [
          'id_login'      => 'required|string',
          'code_send'     => 'required|numeric|min:5',
          'password' => 'required|min:6|confirmed'
        ]);

        $id_login_en    = $request->id_login;
        $id_login       = decrypt($id_login_en);
        $code_send      = $request->code_send;

        $Trainee = Trainee::where('id', '=', $id_login)->where('last_code', '=', $code_send)->first();
        if(empty($Trainee)){
          $type_send_text = "الرمز المدخل خطأ فضلاً تأكد من البيانات المدخلة";
          return redirect()->back()
                      		->with( 'code_send', $type_send_text)
                      		->with( 'id_login', $id_login_en );
        }else{
$Trainee->password=Hash::make($request->password);
$Trainee->save();
$message='نرحب بك في '.env('APP_NAME').PHP_EOL.'بيانات الدخول:'
.PHP_EOL.'الإيميل:'.PHP_EOL.$Trainee->email.PHP_EOL.'كلمة المرور:'.PHP_EOL.$request->password;
General::sendSMS( 'بيانات الدخول للمستخدم الجديد' , $message,  'new trainee'.$Trainee->name ,$Trainee->phone);

          if(Auth::guard('trainee')->loginUsingId($Trainee->id)){
              return redirect()->intended(route('trainee.dashboard'));
          }
        }

      }

      public function logout()
      {
          Auth::guard('trainee')->logout();
          return redirect('/trainee');
      }
}
