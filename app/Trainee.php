<?php


namespace App;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Auth;
class Trainee extends Authenticatable // implements MustVerifyEmail
{

  use Notifiable, LogsActivity;
  public $table = "trainees";
  protected $guard = 'trainee';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'name_en',
    'email',
    'country_live',
    'city',
    'nationality',
    'phone',
    'gender',
    'identity',
    'password',
  ];
  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()->logAll();
  }
  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];
  public static function traineeNameHash($name)
  {

    $name_fragments = explode(" ", $name);

    $result = "";
    foreach ($name_fragments as $fragment) {
      if (strlen($result) !== 0) {
        $result .= " ";
      }

      // Add clear first letter
      if (isset($fragment[0])) {

        $result .= $fragment[0];
      }
      // Add asterisks
      if (isset($fragment[strlen($fragment) - 1])) {
        $result .= str_repeat("*", strlen($fragment) - 1);
      }
    }

    return ($result);
  }
  public function CourseTrainee()
  {

    return $this->belongsToMany(Course::class, 'course_trainee', 'trainee_id', 'course_id')->withPivot('attend_course', 'certificate_request', 'certificate', 'registration_type', 'course_program_type', 'activate', 'time', 'created_at', 'id', 'certificate_enable')->wherePivot('activate', 1);
  }
  public function courseDiscussions()
  {
    return $this->hasMany(courseDiscussion::class);
  }
  public function EnglishCourseProgress()
  {

    return $this->belongsToMany(Course::class, 'english_program_trainee_progress', 'trainee_id', 'course_id')->withPivot('level_id', 'degree', 'pass');
  }
  public function EnglishCourseTraineeLevels()
  {

    return $this->hasMany(EnglishProgramTraineeProgress::class, 'trainee_id')->where([['for_girls', 0]]);
  }
  public function EnglishGirlsCourseTraineeLevels()
  {

    return $this->hasMany(EnglishProgramTraineeProgress::class, 'trainee_id')->where([['for_girls', 1]]);
  }
  public function EnglishCourseTraineePassedLevels()
  {

    return $this->hasMany(EnglishProgramTraineeProgress::class, 'trainee_id')->where([['degree', '>=', 50], ['for_girls', 0]]);
  }
  public function EnglishGirlsCourseTraineePassedLevels()
  {

    return $this->hasMany(EnglishProgramTraineeProgress::class, 'trainee_id')->where([['degree', '>=', 50], ['for_girls', 1]]);
  }
  public function EnglishCourseTraineePassLevels()
  {

    return $this->hasMany(EnglishProgramTraineeProgress::class, 'trainee_id')->where([['degree', '>=', 50], ['for_girls', 0]])->pluck('level_id');
  }
  public function EnglishGirlsCourseTraineePassMaxLevel()
  {

    return $this->hasMany(EnglishProgramTraineeProgress::class, 'trainee_id')->where([['degree', '>=', 50], ['for_girls', 1]])->max('level_id');
  }
  public function EnglishGirlsCourseTraineePassLevels()
  {

    return $this->hasMany(EnglishProgramTraineeProgress::class, 'trainee_id')->where([['degree', '>=', 50], ['for_girls', 1]])->pluck('level_id');
  }
  public function EnglishCourseTraineePassMaxLevel()
  {

    return $this->hasMany(EnglishProgramTraineeProgress::class, 'trainee_id')->where([['degree', '>=', 50], ['for_girls', 0]])->max('level_id');
  }
  public function EnglishFirstLevel()
  {
    return $this->hasMany(EnglishProgramTraineeProgress::class, 'trainee_id')->where([['for_girls', 0]])->orderBy('created_at', 'asc')->first();
  }
  public function EnglishGirlsFirstLevel()
  {
    return $this->hasMany(EnglishProgramTraineeProgress::class, 'trainee_id')->where([['for_girls', 1]])->orderBy('created_at', 'asc')->first();
  }
  public function nationalityName()
  {
    return $this->belongsTo(Countries::class, 'nationality', 'country_code');
  }
  public function EnglishCurrentLevel()
  {

    return $this->hasMany(EnglishProgramTraineeProgress::class, 'trainee_id')->orderBy('created_at', 'desc')->first();
  }
  public function CourseTraineeActivity()
  {

    return $this->belongsToMany(Course::class, 'course_trainee_activities', 'trainee_id', 'course_id')->withPivot('progress', 'attempt_num');
  }
  public function allRatings()
  {
    return $this->hasMany(Rating::class);
  }
  public function cashbackHestories()
  {
    $check = $this->cashbackHestoriesExpire();
    return $this->hasMany(CashbackHistory::class, 'trainee_id');
  }
  public function cashbackHestoriesActivate()
  {
    $check = $this->cashbackHestoriesExpire();
    return $this->hasMany(CashbackHistory::class, 'trainee_id')->where('cashback_activate', 1)->orderBy('expiration_date', 'ASC');
  }
  public function availableCashbackHestories()
  {
    $check = $this->cashbackHestoriesExpire();
    return $this->hasMany(CashbackHistory::class, 'trainee_id')->where([['cashback_activate', 1], ['expire', null]])->doesntHave('cashbackUsages')->orderBy('expiration_date', 'ASC');
  }
  
  public function cashCartBackUsage()
  {
    return $this->hasMany(CashbackUsage::class, 'trainee_id')->where('cart_ids','!=',null);
  }
  public function cashBackUsage()
  {
    return $this->hasMany(CashbackUsage::class, 'trainee_id');
  }
  public function cashBackUsageAmount()
  {
    return $this->hasMany(CashbackUsage::class, 'trainee_id');
  }
  public static function cashbackHestoriesExpire()
  {
    $cashbackHistories = CashbackHistory::where([['cashback_activate', 1], ['expire', null], ['use', null], ['amount', '!=', 0]])->whereDate('expiration_date', '<', now())->get();
    //  dd($cashbackHistories);
    foreach ($cashbackHistories as $cashbackHistory) {
      $cashbackHistory->expire = 1;
      $cashbackHistory->save();
      $trainee = $cashbackHistory->trainee;
      if ($trainee->walletBalance) {
        $trainee->walletBalance->balance -= $cashbackHistory->used_amount;
        $trainee->walletBalance->save();
      }
    }


    return 1;
  }

  public function walletBalance()
  {

    return $this->hasOne(Wallet::class, 'trainee_id');
  }

  public function ratings()
  {
    return $this->belongsToMany(Course::class, 'ratings', 'course_id', 'trainee_id')->withPivot('comment', 'stars');
  }
  public function CourseTraineeWithoutBag()
  {

    return $this->belongsToMany(Course::class, 'course_trainee', 'trainee_id', 'course_id')->withPivot('attend_course', 'certificate_request', 'certificate', 'registration_type', 'course_program_type', 'activate', 'time', 'created_at', 'id', 'certificate_enable')->wherePivot('activate', 1)->where('training_bag', '!=', 1);
  }
  public function CourseBagTrainee()
  {

    return $this->belongsToMany(Course::class, 'course_trainee', 'trainee_id', 'course_id')->withPivot('attend_course', 'certificate_request', 'certificate', 'registration_type', 'course_program_type', 'activate', 'time', 'created_at', 'id', 'certificate_enable')->wherePivot('activate', 1)->where('training_bag', 1);
  }
  public function pendingCourses()
  {

    return $this->belongsToMany(Course::class, 'course_trainee', 'trainee_id', 'course_id')->withPivot('attend_course',  'certificate_request', 'certificate', 'registration_type', 'course_program_type', 'activate', 'manual_enrollment', 'id', 'certificate_enable')->wherePivot('activate', 0)->wherePivot('manual_enrollment', 1);
  }

  public function ActivateCourseTrainee()
  {

    return $this->belongsToMany(Course::class, 'course_trainee', 'trainee_id', 'course_id')->where('activate', 1);
  }
  public function ActivateCoursesTrainee()
  {

    return $this->hasMany(CourseTrainee::class)->where('activate', 1);
  }

  public function financials()
  {
    return $this->hasMany(Financial::class);
  }
  public function reports()
  {
    return $this->hasMany(TraineeReports::class);
  }

  public function coursesTrainee()
  {
    return $this->hasMany(CourseTrainee::class);
  }
  public function pendingCoursesTrainee()
  {
    return $this->hasMany(CourseTrainee::class)->where([['activate', 0], ['manual_enrollment', 1]]);
  }
  public function pendingBankCoursesTrainee()
  {
    return $this->hasMany(CourseTrainee::class)->where([['activate', 0], ['manual_enrollment', 1], ['method', 28]]);
  }
  public function account()
  {
    return $this->belongsTo(Account::class);
  }
  public function carts()
  {
    return $this->hasMany(Cart::class)->whereHas('course', function ($q) {
      $q->where([['is_activate', 1], ['publish_in_website', 1]])->orWhere([['is_activate', 1], ['is_available_hidden', 1]]);
    });
  }
  public function notifications()
  {
    return $this->hasMany(TraineeNotification::class)->orderBy('id', 'desc');
  }
  public function unreadNotification()
  {
    return $this->hasMany(TraineeNotification::class)->where('read_at', null);
  }
}
