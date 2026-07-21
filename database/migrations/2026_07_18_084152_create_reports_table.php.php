<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id(); // This acts as the report_id

            // Linking to the user who made the report
            // We use nullable() because if the user account is deleted later,
            // we might still want to keep the report for administrative review
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // Storing the email at the time of the report (Snapshot)
            $table->string('email', 254);

            // The content of the report
            $table->text('content');

            // Useful extra fields for an admin dashboard
            $table->string('status')->default('pending'); // pending, reviewed, resolved
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
