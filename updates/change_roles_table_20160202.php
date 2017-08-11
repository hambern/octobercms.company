<?php namespace Hambern\Company\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class ChangeRolesTable20160202 extends Migration
{

    public function up()
    {
        Schema::table('hambern_company_roles', function ($table) {
            $table->text('description')->change();
            $table->date('published_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('hambern_company_roles', function ($table) {
            $table->string('description')->change();
            if (Schema::hasColumn('hambern_company_roles', 'published_at')) {
                $table->dropColumn('published_at');
            }
        });
    }

}
