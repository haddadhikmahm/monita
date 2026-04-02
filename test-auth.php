<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$username = 'admin';
$password = 'admin123';

$user = User::where('username', $username)->first();

if (!$user) {
    echo "User not found!\n";
} else {
    echo "User found: " . $user->name . "\n";
    if (Hash::check($password, $user->password)) {
        echo "Password check: SUCCESS\n";
    } else {
        echo "Password check: FAILED\n";
    }
}
