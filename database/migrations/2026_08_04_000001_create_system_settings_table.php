<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();

            // Unique key for each configuration parameter
            $table->string('setting_key', 100)->unique();
            $table->text('setting_value')->nullable();

            $table->timestamps();
        });

        // Insert default system settings
        $defaults = [
            // Platform Operations & Maintenance
            ['setting_key' => 'maintenance_mode', 'setting_value' => 'false'],
            ['setting_key' => 'app_timezone', 'setting_value' => 'UTC'],
            ['setting_key' => 'default_language', 'setting_value' => 'en'],

            // Notification & Communication Defaults
            ['setting_key' => 'system_sender_email', 'setting_value' => 'noreply@unigrowth.com'],
            ['setting_key' => 'notifications_enabled', 'setting_value' => 'true'],

            // Content & Moderation Policies
            ['setting_key' => 'content_approval_required', 'setting_value' => 'false'],

            // User Registration & Access Controls
            ['setting_key' => 'allow_user_registration', 'setting_value' => 'true'],
            ['setting_key' => 'require_email_verification', 'setting_value' => 'true'],
            ['setting_key' => 'max_login_attempts', 'setting_value' => '5'],
        ];

        DB::table('system_settings')->insert($defaults);
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};

