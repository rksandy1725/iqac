<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $criteria = App\Models\Criterion::with(['keyIndicators.activities', 'keyIndicators.metrics'])
        ->withCount('activities')
        ->get();

    foreach ($criteria as $criterion) {
        $criterion->completed_activities = $criterion->activities()->where('status', 'completed')->count();
        $criterion->completion_percentage = $criterion->activities_count > 0
            ? round(($criterion->completed_activities / $criterion->activities_count) * 100)
            : 0;
    }

    print_r("Success!");
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}