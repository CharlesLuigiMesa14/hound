<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRefundDateToReturnRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('return_requests', function (Blueprint $table) {
            $table->timestamp('refund_date')->nullable(); // Add the refund_date column
        });
    }
    
    public function down()
    {
        Schema::table('return_requests', function (Blueprint $table) {
            $table->dropColumn('refund_date'); // Remove the refund_date column
        });
    }
}
