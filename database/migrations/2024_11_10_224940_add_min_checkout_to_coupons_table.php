<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMinCheckoutToCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('coupons', function (Blueprint $table) {
        $table->decimal('min_checkout_amount', 8, 2)->nullable()->default(0);
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
{
    Schema::table('coupons', function (Blueprint $table) {
        $table->dropColumn('min_checkout_amount');
    });
}
}
