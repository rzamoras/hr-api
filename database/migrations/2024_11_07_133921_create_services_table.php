<?php

use App\Models\Service;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_custom')->default(true);
            $table->timestamps();
        });

        $services = [
            [
                'name' => 'Avail Basic Services',
                'is_custom' => false
            ],
            [
                'name' => 'Inquiry or Follow up Transactions',
                'is_custom' => false
            ],
            [
                'name' => 'Pick up or Drop Off Documents',
                'is_custom' => false
            ],
            [
                'name' => 'Meeting or Appointment',
                'is_custom' => false
            ]
        ];

        foreach ($services as $service) {
            $data = new Service($service);
            $data->save();
        }

        Schema::table('csm_responses', function (Blueprint $table) {
            $table->index('service_id');
            $table->foreign('service_id')->references('id')->on('services')->nullOnDelete()->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('csm_responses', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropIndex(['service_id']);
        });

        Schema::dropIfExists('services');
    }
};
