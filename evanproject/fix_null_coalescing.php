<?php
// Fix null coalescing operators for PHP compatibility
// This script replaces all ?? operators with isset() ternary

$api_files = [
    'api/add_sale.php',
    'api/update_product.php', 
    'api/add_inventory_transaction.php',
    'api/update_setting.php',
    'api/delete_product.php'
];

foreach ($api_files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Replace ?? with isset() ternary
        $content = preg_replace('/\$_POST\[\'([^\']+)\'\]\s*\?\?\s*/', 'isset($_POST[\'$1\']) ? $_POST[\'$1\'] : ', $content);
        
        file_put_contents($file, $content);
        echo "Fixed: $file\n";
    }
}

echo "All null coalescing operators fixed for PHP compatibility!\n";
?>
