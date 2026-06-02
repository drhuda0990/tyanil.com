<?php

namespace App\Exports;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
class AccountReportExport implements FromArray , WithHeadings
{ protected $data;
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
  public function array(): array
{
    return $this->data;
}
   public function collection()
    {
        return User::all();
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings() :array
      {
        return [
                 '#',
                'المرجع',
                'التاريخ',
                'مدين',
                'دائن',
                'الرصيد',
                'النوع',
        ];
    }
}
