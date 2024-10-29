<?php

use App\Models\Office;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable()->default(null);
            $table->string('department')->nullable()->default(null);
            $table->string('short_name')->nullable()->default(null);
            $table->timestamps();
        });

        $offices = [
            ['code' => '1011', 'department' => "CITY MAYOR'S OFFICE", 'abbreviation' => 'CMO'],
            ['code' => '1016', 'department' => "CITY VICE MAYOR'S OFFICE", 'abbreviation' => 'CVMO'],
            ['code' => '1022', 'department' => "SANGGUNIANG PANGLUNGSOD", 'abbreviation' => 'SP'],
            ['code' => '1021', 'department' => "SANGGUNIANG PANGLUNGSOD LEGISLATION", 'abbreviation' => 'SPL'],
            ['code' => '1031', 'department' => "CITY ADMINISTRATOR'S OFFICE", 'abbreviation' => 'CADO'],
            ['code' => '8721', 'department' => "CITY VETERINARY OFFICE", 'abbreviation' => 'CVO'],
            ['code' => '7611', 'department' => "CITY SOCIAL WELFARE AND DEVELOPMENT OFFICE", 'abbreviation' => 'CSWDO'],
            ['code' => '1071', 'department' => "CITY BUDGET OFFICE", 'abbreviation' => 'CBO'],
            ['code' => '4411', 'department' => "CITY HEALTH OFFICE", 'abbreviation' => 'CHO'],
            ['code' => '1061', 'department' => "CITY GENERAL SERVICES OFFICE", 'abbreviation' => 'CGSO'],
            ['code' => '1999', 'department' => "BIDS AND AWARDS COMMITTEE", 'abbreviation' => 'BAC'],
            ['code' => '1081', 'department' => "CITY ACCOUNTING OFFICE", 'abbreviation' => 'CACCO'],
            ['code' => '1091', 'department' => "CITY TREASURER'S OFFICE", 'abbreviation' => 'CTO'],
            ['code' => '1041', 'department' => "CITY PLANNING AND DEVELOPMENT OFFICE", 'abbreviation' => 'CPDO'],
            ['code' => '1032', 'department' => "CITY HUMAN RESOURCE AND MANAGEMENT OFFICE", 'abbreviation' => 'CHRMO'],
            ['code' => '1101', 'department' => "CITY ASSESSOR'S OFFICE", 'abbreviation' => 'CASSO'],
            ['code' => '1051', 'department' => "CITY CIVIL REGISTRAR'S OFFICE", 'abbreviation' => 'CCR'],
            ['code' => '1131', 'department' => "CITY LEGAL OFFICE", 'abbreviation' => 'CLO'],
            ['code' => '8711', 'department' => "CITY AGRICULTURE'S OFFICE", 'abbreviation' => 'CAGRO'],
            ['code' => '8751', 'department' => "CITY ENGINEERING OFFICE", 'abbreviation' => 'CEO'],
            ['code' => '8731', 'department' => "CITY ENVIRONMENT AND NATURAL RESOURCES OFFICE", 'abbreviation' => 'CENRO'],
            ['code' => '8992', 'department' => "CITY INVESTMENT AND TOURISM OFFICE", 'abbreviation' => 'CITO']
        ];


        foreach ($offices as $office) {
            Office::insert([
                'code' => $office['code'],
                'department' => $office['department'],
                'short_name' => $office['abbreviation'],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offices');
    }
};
