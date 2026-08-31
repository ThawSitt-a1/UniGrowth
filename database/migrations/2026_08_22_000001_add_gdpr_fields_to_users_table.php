<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('terms_version', 20)->nullable()->after('preferences');
            $table->string('privacy_policy_version', 20)->nullable()->after('terms_version');
            $table->timestamp('consented_at')->nullable()->after('privacy_policy_version');
            $table->boolean('is_anonymized')->default(false)->after('consented_at');
            $table->timestamp('anonymized_at')->nullable()->after('is_anonymized');
        });

        DB::table('users')
            ->where('agreed_to_terms', true)
            ->update([
                'terms_version' => '1.0',
                'privacy_policy_version' => '1.0',
                'consented_at' => now(),
            ]);

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('agreed_to_terms');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('agreed_to_terms')->default(false)->after('university_name');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['terms_version', 'privacy_policy_version', 'consented_at', 'is_anonymized', 'anonymized_at']);
        });
    }
};
