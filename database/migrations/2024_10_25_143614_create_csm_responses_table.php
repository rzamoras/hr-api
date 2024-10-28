<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('csm_responses', function (Blueprint $table) {
            $table->id();
            $table->string('control_no');
            $table->string('client_type')->nullable()->default(null);
            $table->dateTime('response_date')->nullable()->default(null);
            $table->string('sex')->nullable()->default(null);
            $table->string('age')->nullable()->default(null);
            $table->string('region')->nullable()->default(null);
            $table->string('service_availed')->nullable()->default(null);
            $table->string('service_type')->nullable()->default(null);
            $table->string('cc1')->nullable()->default(null);
            $table->string('cc2')->nullable()->default(null);
            $table->string('cc3')->nullable()->default(null);
            $table->string('sqd0')->nullable()->default(null);
            $table->string('sqd1')->nullable()->default(null);
            $table->string('sqd2')->nullable()->default(null);
            $table->string('sqd3')->nullable()->default(null);
            $table->string('sqd4')->nullable()->default(null);
            $table->string('sqd5')->nullable()->default(null);
            $table->string('sqd6')->nullable()->default(null);
            $table->string('sqd7')->nullable()->default(null);
            $table->string('sqd8')->nullable()->default(null);
            $table->text('suggestion')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('csm_responses');
    }
};
