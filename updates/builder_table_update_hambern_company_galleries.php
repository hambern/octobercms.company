<?php namespace Hambern\Company\Updates;

use Hambern\Company\Models\Gallery;
use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHambernCompanyGalleries extends Migration
{
    public function up()
    {
        Schema::table('hambern_company_galleries', function ($table) {
            $table->string('slug')->index();
        });

        // Fill slug attributes
        Gallery::all()->each(function ($model) {
            $model->slugAttributes();
            $model->save();
        });
    }

    public function down()
    {
        Schema::table('hambern_company_galleries', function ($table) {
            $table->dropColumn('slug');
        });
    }
}