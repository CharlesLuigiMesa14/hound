<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRefundColumnsToReturnRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('return_requests', function (Blueprint $table) {
            $table->decimal('refund_amount', 10, 2)->nullable(); // Refund amount
            $table->tinyInteger('refund_status')->default('0');
        });
    }
    
    public function down()
    {
        Schema::table('return_requests', function (Blueprint $table) {
            $table->dropColumn(['refund_amount', 'refund_status']);
        });
    }
}
