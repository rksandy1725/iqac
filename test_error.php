<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $result = App\Models\Criterion::with(['keyIndicators.activities', 'keyIndicators.metrics'])->withCount('activities')->get();
    print_r($result->toArray());
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}