<?php namespace Hambern\Company\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class ChangeEmployeesTable20160816 extends Migration
{

    public function up()
    {
        Schema::table('hambern_company_employees', function ($table) {
            $table->text('social_media')->nullable();
        });
    }

    public function down()
    {
        Schema::table('hambern_company_employees', function ($table) {
            $table->dropColumn('social_media');
        });
    }
}
