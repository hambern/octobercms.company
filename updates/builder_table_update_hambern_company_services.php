<?php namespace Hambern\Company\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHambernCompanyServices extends Migration
{
    public function up()
    {
        Schema::table('hambern_company_services', function ($table) {
            $table->string('link', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::table('hambern_company_services', function ($table) {
            $table->dropColumn('link');
        });
    }
}
