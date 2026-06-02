<?php

namespace App\Imports;

use App\Trainee;
use Maatwebsite\Excel\Concerns\ToModel;

class TraineesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        $trainee=Trainee::where('identity',$row[2])->orWhere('phone',$row[3])->orWhere('email',$row[4])->first();
        if($trainee==null&&$row[2]!=null&&$row[3]!=null&&$row[4]!=null&&$row[6]!=null&&$row[0]!=null)
        {
        return new Trainee([

          'name'     => $row[0],
          'name_en'     => $row[1],
          'identity'    => $row[2],
           'phone'    => $row[3],
          'email'    => $row[4],
          'nationality'    => $row[5],
        'password'    => encrypt($row[6]),
        ]);
    }
    }
}
