<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "BaseUrl: '" . request()->getBaseUrl() . "'\n";
echo "BasePath: '" . request()->getBasePath() . "'\n";
echo "Asset: '" . asset('uploads/test.jpg') . "'\n";
