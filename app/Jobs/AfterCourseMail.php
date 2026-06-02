<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\CourseTrainee;
use App\General;
use App\Course;
use App\Definition;

use Auth;
use Carbon\Carbon;

class AfterCourseMail implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {

    $courses = Course::whereDate('after_course_mail_date', Carbon::today())->get();
    //  dd($courses);

    foreach ($courses as $course) {
      // $amount = 0;
      $notification_email = Definition::where('id', '=', $course->after_course_mail)->pluck('content')->first();
      if ($notification_email) {
        $CourseTrainees = $course->CourseTrainees;

        foreach ($CourseTrainees as $CourseTrainee) {
          if ($CourseTrainee->after_course_mail == null) {
            // dd($notification_email,$CourseTrainee);

            if ($CourseTrainee->trainee) {
              // dd($CourseTrainee->trainee);
              General::sendMail(' شكر بعد الدورة' . $course->titile, $notification_email, 'after course reminder', $CourseTrainee->trainee->email,null,$course->id);
              $CourseTrainee->after_course_mail = 1;
              $CourseTrainee->save();
            }
          }
        }
      }
    }
  }
}
