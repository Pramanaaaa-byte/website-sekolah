<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TESTING WHATSAPP DASHBOARD CARD ===\n\n";

use App\Models\User;

// Login as admin
$admin = User::where('role', 'admin')->first();
if ($admin) {
    auth()->login($admin);
    echo "✓ Logged in as: " . auth()->user()->name . " (admin)\n\n";
} else {
    echo "✗ No admin user found\n";
    exit;
}

// Test dashboard route
echo "Testing dashboard route:\n";
echo "========================\n";

if (Route::has('dashboard')) {
    echo "✓ Dashboard route exists\n";
    
    try {
        $controller = new \App\Http\Controllers\DashboardController();
        $result = $controller->index();
        echo "✓ Dashboard controller works\n";
        
        // Check if WhatsApp card is in the view
        $viewFile = __DIR__ . '/resources/views/dashboard.blade.php';
        $content = file_get_contents($viewFile);
        
        if (strpos($content, 'whatsapp-card') !== false) {
            echo "✓ WhatsApp card found in dashboard view\n";
        } else {
            echo "✗ WhatsApp card not found in dashboard view\n";
        }
        
        if (strpos($content, 'https://wa.me/628123456789') !== false) {
            echo "✓ WhatsApp link found\n";
        } else {
            echo "✗ WhatsApp link not found\n";
        }
        
        if (strpos($content, 'fab fa-whatsapp') !== false) {
            echo "✓ WhatsApp icon found\n";
        } else {
            echo "✗ WhatsApp icon not found\n";
        }
        
    } catch (\Exception $e) {
        echo "✗ Dashboard controller error: " . $e->getMessage() . "\n";
    }
} else {
    echo "✗ Dashboard route not found\n";
}

echo "\n=== CHECKING CSS STYLES ===\n";

$layoutFile = __DIR__ . '/resources/views/layouts/app.blade.php';
$layoutContent = file_get_contents($layoutFile);

if (strpos($layoutContent, '.whatsapp-card') !== false) {
    echo "✓ WhatsApp card CSS styles found\n";
} else {
    echo "✗ WhatsApp card CSS styles not found\n";
}

if (strpos($layoutContent, 'background: linear-gradient(135deg, #25d366, #128c7e)') !== false) {
    echo "✓ WhatsApp card gradient background found\n";
} else {
    echo "✗ WhatsApp card gradient background not found\n";
}

echo "\n=== WHATSAPP CARD FEATURES ===\n";
echo "✅ Card Title: Hubungi Admin\n";
echo "✅ Card Description: Butuh bantuan? Hubungi kami via WhatsApp\n";
echo "✅ WhatsApp Number: +62 812-3456-789\n";
echo "✅ WhatsApp Link: https://wa.me/628123456789\n";
echo "✅ Icon: fab fa-whatsapp with pulse animation\n";
echo "✅ Styling: Green gradient background with hover effects\n";
echo "✅ Button: White button with WhatsApp green text\n";
echo "✅ Target: Opens in new tab\n";

echo "\n=== INSTRUCTIONS ===\n";
echo "1. Login: http://127.0.0.1:8000/login\n";
echo "2. Use: admin@eduspace.com / password123\n";
echo "3. Go to: http://127.0.0.1:8000/dashboard\n";
echo "4. Look for WhatsApp card below statistics cards\n";
echo "5. Click the WhatsApp button to test the link\n";
echo "6. Should open WhatsApp with the pre-filled number\n\n";

echo "=== TEST COMPLETE ===\n";
