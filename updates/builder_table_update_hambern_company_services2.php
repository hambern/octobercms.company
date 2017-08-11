<?php namespace Hambern\Company\Updates;

use Hambern\Company\Models\Service;
use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHambernCompanyServices2 extends Migration
{
    public function up()
    {
        Schema::table('hambern_company_services', function ($table) {
            $table->string('slug')->index();
        });

        // Fill slug attributes
        Service::all()->each(function ($model) {
            $model->slugAttributes();
            $model->save();
        });
    }

    public function down()
    {
        Schema::table('hambern_company_services', function ($table) {
            $table->dropColumn('slug');
        });
    }
}