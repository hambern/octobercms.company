<?php namespace Hambern\Company\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class CreateEmployeesTable extends Migration
{

    public function up()
    {
        Schema::create('hambern_company_employees', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->text('description');
            $table->string('quote');
            $table->string('email');
            $table->string('phone');
            $table->date('born_at')->nullable();
            $table->date('published_at')->nullable();
            $table->nullableTimestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hambern_company_employees');
    }

}
