<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $statuses = [
            ['name' => 'новый', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'в работе', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'на тестировании', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'завершен', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($statuses as $status) {
            DB::table('task_statuses')->insertOrIgnore($status);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('task_statuses')->whereIn('name', [
            'новый',
            'в работе',
            'на тестировании',
            'завершен',
        ])->delete();
    }
};
