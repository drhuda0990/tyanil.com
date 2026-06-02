<?php

namespace App\Exports;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;

use Maatwebsite\Excel\Events\AfterSheet;


class EnglishLevelReport implements FromArray , WithHeadings,WithStyles,ShouldAutoSize,WithEvents
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
                 'م',
                'اسم المنشأة',
                'رقم الرخصة',
                'مرخص من قبل المؤسسة نعم \ لا',
                'اسم الدورة',
                'اسم الدبلوم',
                'تاريخ البداية',
                'تاريخ النهاية',
                'اسم المتدرب',
                'رقم الهوية',
                'الجنسية',
                'الجوال',
                'البريد الالكتروني',
                'درجة اختبار المعهد ( يعاد ارسل  الملف مع المصادقة )',
                'التقدير',

        ];
    }
    public function styles(Worksheet $sheet)
    {
        
        return [
           
        
            // Style the first row as bold text.
            'A1'    => ['font' => ['bold' => true]],
     
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
  
                $event->sheet->getDelegate()->getStyle('A1:O1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('efee44');
  
            },
        ];
    }
}
