<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefinitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('definitions', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->text('summary')->nullable();
            $table->text('content')->nullable();
            $table->text('icon')->nullable();
            
            $table->integer('type_id')->default(0)->nullable();

            $table->boolean('activate')->default(true)->nullable();
            $table->integer('user_id')->unsigned()->default(1);

            $table->timestamps();
        });

        /*-----------*/
        /*-----------*/

        $data = [
          [
            'name'      => 'دورات إدارية',
            'type_id'      => 1
          ],
          [
            'name'      => 'دورات لغة إنجليزية',
            'type_id'      => 1
          ],
          [
            'name'      => 'دورات حاسب آلي',
            'type_id'      => 1
          ],
          [
            'name'      => 'دورات مالية',
            'type_id'      => 1
          ],
          [
            'name'      => 'تسجيل',
            'type_id'      => 2
          ],
          [
            'name'      => 'جارية',
            'type_id'      => 2
          ],
          [
            'name'      => 'مؤجلة',
            'type_id'      => 2
          ],
          [
            'name'      => 'متوقفة',
            'type_id'      => 2
          ],
          [
            'name'      => 'منتهية',
            'type_id'      => 2
          ],
          [
            'name'      => 'الكل',
            'type_id'      => 3
          ],
          [
            'name'      => 'الطلاب',
            'type_id'      => 3
          ],
          [
            'name'      => 'طالبات',
            'type_id'      => 3
          ],
          [
            'name'      => 'أطفال',
            'type_id'      => 3
          ],
          [
            'name'      => 'دورة',
            'type_id'      => 4
          ],
          [
            'name'      => 'محاضرة',
            'type_id'      => 4
          ],
          [
            'name'      => 'أمسية',
            'type_id'      => 4
          ],
          [
            'name'      => 'ندوة',
            'type_id'      => 4
          ],
          [
            'name'      => 'لقاء',
            'type_id'      => 4
          ],
          [
            'name'      => 'ابتدائي',
            'type_id'      => 5
          ],
          [
            'name'      => 'متوسط',
            'type_id'      => 5
          ],
          [
            'name'      => 'ثانوي',
            'type_id'      => 5
          ],
          [
            'name'      => 'جامعي',
            'type_id'      => 5
          ],
          [
            'name'      => 'دراسات عليا',
            'type_id'      => 5
          ],
          [
            'name'      =>  'غير متعلم',
            'type_id'      => 5
          ],
          [
            'name'      => 'غير  ذلك',
            'type_id'      => 5
          ],
          [
            'name'      => 'نقد',
            'type_id'      => 6
          ],
          [
            'name'      => 'الدفع الإلكتروني',
            'type_id'      => 6
          ],
          [
            'name'      => 'تحويل بنكي',
            'type_id'      => 6
          ],
          [
            'name'      => 'شبكة',
            'type_id'      => 6
          ],
          [
            'name'      => 'شيك',
            'type_id'      => 6
          ]
      ];
      DB::table('definitions')->insert($data);





    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('definitions');
    }
}
