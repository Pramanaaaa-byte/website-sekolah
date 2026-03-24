<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TESTING CRUD BUTTONS FOR GURU ===\n\n";

use App\Models\User;

// Login as guru
$guru = User::where('role', 'guru')->first();
if ($guru) {
    auth()->login($guru);
    echo "✓ Logged in as: " . auth()->user()->name . " (guru)\n";
    echo "✓ Email: " . auth()->user()->email . "\n\n";
} else {
    echo "✗ No guru user found\n";
    exit;
}

echo "Checking View Files for CRUD Buttons:\n";
echo "====================================\n";

// Check izin-keluar view
$izinViewFile = __DIR__ . '/resources/views/izin-keluar/index.blade.php';
$izinContent = file_get_contents($izinViewFile);

echo "Izin Keluar View:\n";
if (strpos($izinContent, "auth()->user()->role === 'admin' || auth()->user()->role === 'guru'") !== false) {
    echo "  ✓ Create button - GURU can see\n";
} else {
    echo "  ✗ Create button - GURU cannot see\n";
}

if (strpos($izinContent, "route('izin-keluar.create')") !== false) {
    echo "  ✓ Create route - Found\n";
} else {
    echo "  ✗ Create route - Not found\n";
}

if (strpos($izinContent, "route('izin-keluar.edit')") !== false) {
    echo "  ✓ Edit button - GURU can see\n";
} else {
    echo "  ✗ Edit button - GURU cannot see\n";
}

if (strpos($izinContent, "route('izin-keluar.destroy')") !== false) {
    echo "  ✓ Delete button - GURU can see\n";
} else {
    echo "  ✗ Delete button - GURU cannot see\n";
}

echo "\nKeterlambatan View:\n";
$keterlambatanViewFile = __DIR__ . '/resources/views/keterlambatan/index.blade.php';
$keterlambatanContent = file_get_contents($keterlambatanViewFile);

if (strpos($keterlambatanContent, "auth()->user()->role === 'admin' || auth()->user()->role === 'guru'") !== false) {
    echo "  ✓ Create button - GURU can see\n";
} else {
    echo "  ✗ Create button - GURU cannot see\n";
}

if (strpos($keterlambatanContent, "route('keterlambatan.create')") !== false) {
    echo "  ✓ Create route - Found\n";
} else {
    echo "  ✗ Create route - Not found\n";
}

if (strpos($keterlambatanContent, "route('keterlambatan.edit')") !== false) {
    echo "  ✓ Edit button - GURU can see\n";
} else {
    echo "  ✗ Edit button - GURU cannot see\n";
}

if (strpos($keterlambatanContent, "route('keterlambatan.destroy')") !== false) {
    echo "  ✓ Delete button - GURU can see\n";
} else {
    echo "  ✗ Delete button - GURU cannot see\n";
}

echo "\n=== BUTTON VISIBILITY FOR GURU ===\n";
echo "When logged in as GURU:\n";
echo "├── Izin Keluar Page:\n";
echo "│   ├── ✓ + Ajukan Izin button (top right)\n";
echo "│   ├── ✓ Edit button (in each row)\n";
echo "│   └── ✓ Delete button (in each row)\n";
echo "└── Keterlambatan Page:\n";
echo "    ├── ✓ + Catat Keterlambatan button (top right)\n";
echo "    ├── ✓ Edit button (in each row)\n";
echo "    └── ✓ Delete button (in each row)\n";

echo "\n=== INSTRUCTIONS ===\n";
echo "1. Login as GURU:\n";
echo "   - Email: guru@eduspace.com\n";
echo "   - Password: password123\n";
echo "2. Go to: http://127.0.0.1:8000/izin-keluar\n";
echo "3. Look for:\n";
echo "   ✓ Blue button '+ Ajukan Izin' at top right\n";
echo "   ✓ Edit and Delete buttons in each row\n";
echo "4. Go to: http://127.0.0.1:8000/keterlambatan\n";
echo "5. Look for:\n";
echo "   ✓ Blue button '+ Catat Keterlambatan' at top right\n";
echo "   ✓ Edit and Delete buttons in each row\n";
echo "6. If buttons still not visible:\n";
echo "   - Clear browser cache (Ctrl+F5)\n";
echo "   - Try incognito/private window\n";
echo "   - Check browser console for errors\n\n";

echo "=== TEST COMPLETE ===\n";
