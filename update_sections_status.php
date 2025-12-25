<?php

/**
 * Quick script to update all sections status to 1
 * Run: php update_sections_status.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Update all sections
DB::table('sections')->update(['status' => 1]);

echo "✅ Barcha bo'limlar status = 1 ga yangilandi!\n";
echo "Bo'limlar soni: " . DB::table('sections')->count() . "\n";
