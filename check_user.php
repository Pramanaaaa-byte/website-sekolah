<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$user = User::find(1);
echo "User ID: " . $user->id . "\n";
echo "User Name: " . $user->name . "\n";
echo "User Role: " . $user->role . "\n";
echo "User Email: " . $user->email . "\n";
