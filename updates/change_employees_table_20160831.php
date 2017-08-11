<?php namespace Hambern\Company\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class ChangeEmployeesTable20160831 extends Migration
{

    public function up()
    {
        Schema::table('hambern_company_employees', function ($table) {
            $table->text('social_media')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('hambern_company_employees', function ($table) {
            $table->text('social_media')->change();
        });
    }
}
