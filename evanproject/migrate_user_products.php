<?php
require_once __DIR__ . '/includes/init.php';

// Add user_id column to products table
$sql = "ALTER TABLE products ADD COLUMN user_id INT UNSIGNED NOT NULL AFTER id";
echo "Adding user_id column to products table...<br>";

if ($conn->query($sql)) {
    echo "✅ user_id column added successfully<br>";
} else {
    echo "❌ Error adding user_id column: " . $conn->error . "<br>";
}

// Add foreign key constraint
$sql = "ALTER TABLE products ADD CONSTRAINT fk_products_user_id 
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE";
echo "Adding foreign key constraint...<br>";

if ($conn->query($sql)) {
    echo "✅ Foreign key constraint added successfully<br>";
} else {
    echo "❌ Error adding foreign key: " . $conn->error . "<br>";
}

// Add index for user_id
$sql = "CREATE INDEX idx_products_user_id ON products(user_id)";
echo "Adding index for user_id...<br>";

if ($conn->query($sql)) {
    echo "✅ Index added successfully<br>";
} else {
    echo "❌ Error adding index: " . $conn->error . "<br>";
}

echo "<br><strong>Migration completed!</strong><br>";
echo "<a href='client_products.php'>Go to Client Products</a>";
?>
