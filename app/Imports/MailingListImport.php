<?php

namespace App\Imports;

use App\Mailing_list;
use Maatwebsite\Excel\Concerns\ToModel;

class MailingListImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Mailing_list([
            'name'        => $row[0],
            'email'       => $row[1],
            'mobile'      => $row[2],
            //'whatsapp'    => $row[3],
        ]);
    }
}
