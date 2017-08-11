<?php namespace Hambern\Company\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class CreateTestimonialsTable extends Migration
{

    public function up()
    {
        Schema::create('hambern_company_testimonials', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('content');
            $table->string('source');
            $table->string('url');
            $table->date('published_at')->nullable();
            $table->nullableTimestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hambern_company_testimonials');
    }

}
