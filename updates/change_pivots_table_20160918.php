<?php namespace Hambern\Company\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class ChangePivotsTable20160918 extends Migration
{

    public function up()
    {
        Schema::table('hambern_company_pivots', function ($table) {
            $table->integer('tag_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('hambern_company_pivots', function ($table) {
            $table->dropColumn('tag_id');
        });
    }
}
