<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSettingsOptionToReviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
			$table->boolean('isReviewCatalog')->default(false);
			$table->boolean('isMainReview')->default(false);
			$table->boolean('isProjectGallery')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
			$table->dropColumn('isReviewCatalog');
			$table->dropColumn('isMainReview');
			$table->dropColumn('isProjectGallery');
		});
    }
}
