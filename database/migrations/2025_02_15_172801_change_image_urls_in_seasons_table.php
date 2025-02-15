<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    protected const FIELDS = [
        'icon_image',
        'header_image',
        'footer_image',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach (self::FIELDS as $subject) {
            DB::table('seasons')
                ->whereNotNull($subject)
                ->update(
                    [
                        $subject => DB::raw("REPLACE(`{$subject}`, 'public/images/', 'images/')"),
                    ]
                );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach (self::FIELDS as $subject) {
            DB::table('seasons')
                ->whereNotNull($subject)
                ->update(
                    [
                        $subject => DB::raw("REPLACE(`{$subject}`, 'images/', 'public/images/')"),
                    ]
                );
        }
    }
};
