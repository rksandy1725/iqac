<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Use the actual builder from the Eloquent connection
$builder = Capsule::connection()->table(new class {})->query();

echo "Testing parseWithRelations\n";

$results = $builder->parseWithRelations(["keyIndicators.activities", "keyIndicators.metrics"]);
print_r($results);