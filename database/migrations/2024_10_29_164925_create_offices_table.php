<?php

use App\Imports\OfficeImport;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable()->default(null)->index();
            $table->string('department')->nullable()->default(null);
            $table->string('short_name')->nullable()->default(null);
            $table->timestamps();
        });

        Excel::import(new OfficeImport, './public/csv/department.csv');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offices');
    }
};
