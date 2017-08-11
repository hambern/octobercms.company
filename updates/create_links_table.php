<?php namespace Hambern\Company\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateLinksTable extends Migration
{

    public function up()
    {
        Schema::create('hambern_company_links', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('icon');
            $table->string('url');
            $table->text('description');
            $table->date('published_at')->nullable();
            $table->nullableTimestamps();
        });
        Schema::table('hambern_company_pivots', function ($table) {
            $table->integer('link_id')->unsigned()->nullable()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hambern_company_links');

        if (Schema::hasColumn('hambern_company_pivots', 'link_id')) {
            Schema::table('hambern_company_pivots', function ($table) {
                $table->dropColumn('link_id');
            });
        }
    }

}
