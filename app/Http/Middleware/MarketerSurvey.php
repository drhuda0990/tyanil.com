<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class MarketerSurvey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if(Auth::guard('marketer')&&count(Auth::guard('marketer')->user()->marketerSurveyAnswers)==0&&\Request::route()->getName()!='marketer.survey') 
      {
        
          return redirect()->route('marketer.survey');
           
      }
        return $next($request);
    }
}
