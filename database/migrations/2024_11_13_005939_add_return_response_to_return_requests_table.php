<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReturnResponseToReturnRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('return_requests', function (Blueprint $table) {
            $table->text('return_response')->nullable(); // Add the return_response column
        });
    }
    
    public function down()
    {
        Schema::table('return_requests', function (Blueprint $table) {
            $table->dropColumn('return_response'); // Drop the column if rolled back
        });
    }
    
}
