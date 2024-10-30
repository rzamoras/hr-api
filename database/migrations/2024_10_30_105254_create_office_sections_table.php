<?php

use App\Imports\OfficeSectionImport;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('office_sections', function (Blueprint $table) {
            $table->id();
            $table->string('office_code')->index();
            $table->string('name');
            $table->string('code')->index();
            $table->timestamps();
        });

        Excel::import(new OfficeSectionImport, './public/csv/section.csv');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_sections');
    }
};
