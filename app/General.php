<?php

namespace App;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\ServiceInvoiceItem;
use App\Institute;
use App\Instructor;
use App\CourseTrainee;
use App\Course;
use App\Message;
use App\Picture;
use App\Definition;
use App\Discount;
use App\Trainee;
use App\Mail\MainMail;
use App\CourseTraineeActivity;
use Mail;
use Auth;
use App\GeneralSetting;
use App\Support\StoreSettings;
use Session;


class General extends Model
{
  use LogsActivity;
  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()->logAll();
  }
  public static function duobleSlashStorag($text)
  {
    if (strpos($text, '//storage') == true) {

      $text = str_replace("//storage", "/storage", $text);
    }
    return $text;
  }

  public static function DB_Message($title, $message, $section, $sender, $sender_has, $json, $type, $state)
  {
    $DB_Message = new Message();

    $DB_Message->title        = $title;
    $DB_Message->message      = $message;
    $DB_Message->section      = $section;
    $DB_Message->sender       = $sender;
    $DB_Message->sender_has   = $sender_has;
    $DB_Message->json         = $json;
    $DB_Message->type         = $type; // 1 SMS  - 2 Whatsapp - 3 Email
    $DB_Message->state        = $state;

    $DB_Message->save();
  }

  public static function sendMail($title, $body, $section, $to, $BCC = "", $course = null)
  {
    $General_class = new General();
    // dd($to);
    // dd($body);
    if ($course) {
      $body = $General_class->messageEdit($body, $course, $to);
      $body = $General_class->emailMessageEdit($body);
    }
    $body = str_replace("&nbsp;", "<br>", $body);
    $body = self::sanitizeEmailHtml($body);

    //-----------------
    $data = array(
      "title" => $title,
      "body" => $body,
    );
    try {
      //-----------------
      if (empty($BCC)) {
        $check_email_validate = $General_class->check_email_validate($to);
        //   dd($title , $body , $section , $to  , $BCC,$check_email_validate);
        if ($check_email_validate == 1) {
          Mail::to($to)->send(new MainMail($data));
        }
      } else {
        // dd($title , $body , $section , $to  , $BCC);
        //$attributes = ['replyTo' => $email_given_by_the_user];
        $data['bcc'] = $BCC;

        Mail::to($to)

          ->send(new MainMail($data));
        $to =  json_encode($BCC);
      }

      $sender  = config("mail.from.address");
      $state = true;
      //-----------------
      $General_class->DB_Message($title, $body, $section, $sender, $to, $body, 3, $state);
    } catch (\Throwable $e) {
      report($e); // ignored
    }
  }
  public static function sanitizeEmailHtml($html)
  {
    $allowedTags = '<p><br><strong><b><em><i><u><ul><ol><li><a><h1><h2><h3><h4><span><div><small>';
    $html = strip_tags((string) $html, $allowedTags);
    $html = preg_replace("/\s+on[a-z]+\s*=\s*(\"[^\"]*\"|'[^']*'|[^\s>]+)/i", '', $html);
    $html = preg_replace('/javascript\s*:/i', '#', $html);

    return $html;
  }
  public static function messageEdit($messageContent, $course_id = null, $trainee_email = null)
  {
    $course = Course::find($course_id);
    $trainee = Trainee::where('email', $trainee_email)->first();
    if (strpos($messageContent, '[lesson_url]') == true && $course) {
      if (count($course->activateLessons) > 0) {
        $allLesson = Course::firstLesson(encrypt($course->id));

        $messageContent = str_replace("[lesson_url]", " " . route('trainee.lesson', ['id' => encrypt($allLesson)]) . " ", $messageContent);
      }
    }
    if (strpos($messageContent, '[rating_url]') == true && $course && $trainee) {
      $messageContent = str_replace("[rating_url]", " " . route('course.rating.get', ['id' => encrypt($trainee->id), 'course' => encrypt($course->id)]) . " ", $messageContent);
    }

    if (strpos($messageContent, '[certificate_url]') == true && $course && $trainee) {
      if ($course->certificate == 1) {
        $messageContent = str_replace("[certificate_url]", " " . route('certificate', ['id' => encrypt($trainee->id), 'course' => encrypt($course->id)]) . " ", $messageContent);
      }
    }
    // dd($messageContent,$course,$trainee,$trainee_email);

    return $messageContent;
  }
  public static function emailMessageEdit($messageContent)
  {
    $text = strip_tags($messageContent);
    $textWithLinks = preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<br><a href="$1" style="display: block;color:white;background:black;" target="_blank" rel="nofollow">اضغط هنا</a> <br>', $text);

    return $textWithLinks;
  }
  public static function sendSMS($title, $messageContent, $section,  $mobileNumber)
  {


    $gSetting = StoreSettings::get();
    if (!(empty($gSetting))) {
      if (empty($gSetting->sender_user) || empty($gSetting->sender_password) || empty($gSetting->sender_name)) {
        return;
      }
      $state = 0;
      $app_id       = $gSetting->sender_user;
      $app_sec   = $gSetting->sender_password;
      $sendername = $gSetting->sender_name;

      $messageContent = strip_tags($messageContent, '<br>');
      $messageContent = str_replace("&nbsp;", " ", $messageContent);
      $messageContent = str_replace("<br>", PHP_EOL, $messageContent);
      $text       = $messageContent;
      $to         = $mobileNumber;
      // auth call
      //new configration of sms
      $curl = curl_init();
      $app_hash  = base64_encode("$app_id:$app_sec");
      $messages = [];
      $messages["messages"] = [];
      $messages["messages"][0]["text"] = $text;
      $messages["messages"][0]["numbers"][] = $to;
      $messages["messages"][0]["sender"] = $sendername;

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api-sms.4jawaly.com/api/v1/account/area/sms/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($messages),
        CURLOPT_HTTPHEADER => array(
          'Accept: application/json',
          'Content-Type: application/json',
          'Authorization: Basic ' . $app_hash
        ),
      ));

      $response = curl_exec($curl);
      curl_close($curl);
      // dd(json_decode($response),$text,$mobileNumber);

      $instance = new General();

      $var = $instance->DB_Message($title, $text, $section, $sendername, $to, $response, 1, 1);
    }
  }
  public  static function addCustomerCart()
  {
    $ip = $_SERVER['REMOTE_ADDR'];
    $customer = Auth::guard('customer')->user();
    $carts   = Cart::where([['user_ip', $ip], ['customer_id', null]])->get();
    if ($carts) {
      foreach ($carts as $cart) {
        $cartExist   = Cart::where([['service_id', $cart->service_id], ['customer_id', $customer->id]])->get();
        // if (!$cartExist) {
        $cart->customer_id = $customer->id;
        $cart->save();
        // }
      }
    }
  }
  //-----------------
  public  static function generate_codes($length = 20, $type = 1)
  {
    if ($type == 1) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    } elseif ($type == 2) {
      $characters = '0123456789';
    } elseif ($type == 3) {
      $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  //-----------------
  public  static function check_email_validate($email)
  {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return 1;
    }
    return 0;
  }
  //-----------------

  public static function get_definition_id($name)
  {
    $Definition = Definition::where('slug', '=', $name)->select('id')->first();
    if (empty($Definition)) {
      $Definition = 0;
    } else {
      $Definition = $Definition->id;
    }
    return $Definition;
  }
  public static function enToArNum($number)
  {
    $western_arabic = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    $eastern_arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');

    $str = str_replace($western_arabic, $eastern_arabic, $number);
    return $str;
  }
  //-----------------

  public static function get_search_services($search_input = null)
  {
    $Service    = Service::where('activate', 1);
    if ($search_input != null) {
      $Service->where('title', 'like', '%' . $search_input . '%')->orwhere('summry', 'like', '%' . $search_input . '%')->orwhere('body', 'like', '%' . $search_input . '%');
    }
    return $Service->get();
  }

  //-----------------

  //-----------------
  public static function send_notification_customer($type, $id_course, $id_trainee, $Email_User = "", $Phone_User = "")
  {
    // Nova | type = 1 [PageNotificationTrainee.php] |  type = 2 [PageActivateTrainee.php]
    //**************
    $Get_Courses = Course::where('id', '=', $id_course)
      ->select("title", "notification_email", "notification_sms", "lesson_link", "lesson_id", "lesson_username", "lesson_password")
      ->first();

    $title       = $Get_Courses->title;
    $section     = "Send Notification";

    if ($type ==  2) {
      //$Trainee    = Trainee::where('id', '=', $id_trainee)->select('email' , 'phone' )->get()->first();
      $Trainee    = DB::table("trainees")->select('email', 'phone')->where('id', '=', $id_trainee)->get()->first();

      $Email_User =  $Trainee->email;
      $Phone_User =  $Trainee->phone;
    }

    if ((!(empty($Get_Courses))) and  (!(empty($Email_User)))) {

      $General = new General();
      //------- إرسال إيميل
      if ($Get_Courses->notification_email != 0) {
        $notification_email = Definition::where('id', '=', $Get_Courses->notification_email)->pluck('content')->first();
        if (!(empty($notification_email))) {
          $body       = $notification_email;

          if (($Get_Courses->lesson_type  == 2) and (!(empty($Get_Courses->lesson_link)))) {

            if (!(empty($Get_Courses->lesson_link))) {
              $body = $body . "
                  ";
              $body = $body . "
                    URL : " . $Get_Courses->lesson_link . "
                  ";
            }
            if (!(empty($Get_Courses->lesson_id))) {
              $body = $body . "
                    ID : " . $Get_Courses->lesson_id . "
                  ";
            }
            if (!(empty($Get_Courses->lesson_username))) {
              $body = $body . "
                    User Name : " . $Get_Courses->lesson_username . "
                  ";
            }
            if (!(empty($Get_Courses->lesson_password))) {
              $body = $body . "
                    Password : " . $Get_Courses->lesson_password . "
                  ";
            }
          }

          $to         = $Email_User;
          $get_return = $General->sendMail($title, $body, $section, $to, null, $id_course);
        }
      }
      //------- إرسال SMS
      if ($Get_Courses->notification_sms != 0) {
        $notification_sms = Definition::where('id', '=', $Get_Courses->notification_sms)->pluck('content')->first();
        if (!(empty($notification_sms))) {
          $get_return       = $General->sendSMS($title, $notification_sms, $section,  $Phone_User, $id_course);
        }
      }
      //**************
      return 1;
    }

    //-----------------
  }


  public static function getWeekendDatesInRange($startDate, $endDate)
  {
    $dates = [];
    $date = Carbon::parse($startDate);
    $endDate = Carbon::parse($endDate);

    while ($date->lte($endDate)) {
      if ($date->isFriday() || $date->isSaturday()) {
        $dates[] = $date->copy();  // Add each Friday and Saturday
      }
      $date->addDay();
    }

    return $dates;
  }
  public static function  getWeekdaysInRange($startDate, $endDate)
  {
    $dates = [];
    $date = Carbon::parse($startDate);
    $endDate = Carbon::parse($endDate);

    while ($date->lte($endDate)) {
      // Check if the day is not Friday or Saturday
      if (!$date->isFriday() && !$date->isSaturday()) {
        $dates[] = $date->copy();  // Add the weekday
      }
      $date->addDay();
    }

    return $dates;
  }
  public static function  getAllWeekdaysInRange($startDate, $endDate)
  {
    $dates = [];
    $date = Carbon::parse($startDate);
    $endDate = Carbon::parse($endDate);

    while ($date->lte($endDate)) {
      $dates[] = $date->copy();  // Add the weekday
      $date->addDay();
    }
    return $dates;
  }
  public static function createZoomMeeting($startDateTime, $topic = 'Meeting Title', $duration = 60)
  {
    $zoomToken = env('ZOOM_JWT_TOKEN');

    $response = Http::withHeaders([
      'Authorization' => 'Bearer ' . $zoomToken,
    ])->post('https://api.zoom.us/v2/users/me/meetings', [
      'topic' => $topic,
      'type' => 2, // Scheduled meeting
      'start_time' => Carbon::parse($startDateTime)->toIso8601String(),
      'duration' => $duration, // duration in minutes
      'timezone' => config('app.timezone'), // Specify the timezone if needed
      'settings' => [
        'host_video' => true,
        'participant_video' => true,
        'join_before_host' => false,
        'mute_upon_entry' => true,
        'waiting_room' => true,
      ],
    ]);

    if ($response->successful()) {
      return $response->json();
    } else {
      throw new \Exception("Failed to create Zoom meeting: " . $response->body());
    }
  }
  public static function scheduleMeeting($date)
  {
    $date = $request->input('date'); // e.g., 2023-11-20
    $time = $request->input('time'); // e.g., 15:30

    $dateTime = Carbon::createFromFormat('Y-m-d H:i', "$date $time", 'Asia/Riyadh'); // Adjust timezone if needed

    try {
      $meeting = $this->createZoomMeeting($dateTime, 'Your Custom Meeting Title');

      return response()->json([
        'message' => 'Zoom meeting created successfully!',
        'meeting_link' => $meeting['join_url'],
        'meeting_details' => $meeting,
      ]);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }
  public static function existRegTime($service_id, $time)
  {
    $existRegTime = ServiceInvoiceItem::where([['service_id', $service_id], ['time', $time]])->first();
    if ($existRegTime) {
      return true;
    }
    return false;
  }
  public static function ServiceAdminNotify($service, $title, $body, $email, $sms)

  {
    $service_admins = $service->service_admins;
    if ($service_admins != null && $service_admins != "[]") {
      $service_admins = str_replace('["', '', $service_admins);
      $service_admins = str_replace('"]', '', $service_admins);
      $service_admins = explode('","', $service_admins);
    } else {
      $service_admins = null;
    }
    if ($service_admins) {

      foreach ($service_admins as $service_admin) {
        $admin = ServiceAdmind::find($service_admin);
        if ($admin) {
          if ($email == 1) {
            General::sendMail($title, $body, $title, $admin->email);
          }
          if ($sms == 1) {
            General::sendSMS($title, $body,  $title, $admin->phone);
          }
        }
      }
    }
  }
  public static function extractDateTime($text)

  {
    preg_match('/(\d{4}-\d{2}-\d{2}) (\d{2}:\d{2} (?:AM|PM)) - (\d{2}:\d{2} (?:AM|PM))/', $text, $matches);

    if ($matches) {
      $date = $matches[1];
      $startTime = $matches[2];
      $endTime = $matches[3];

      // Convert times to 24-hour format
      $startTime24 = date("H:i", strtotime($startTime));
      $endTime24 = date("H:i", strtotime($endTime));
      return [
        'date' => $date,
        'sTime' => $startTime24,
        'eTime' => $endTime24
      ];
    } else {
      return [];
    }
  }

  public static function extractFromArray($text)
  {
    if ($text != null && $text != "[]") {
      $text = str_replace('["', '', $text);
      $text = str_replace('"]', '', $text);
      $text = explode('","', $text);
    } else {
      $text = null;
    }
    return $text;
  }

  //-----------------
}
