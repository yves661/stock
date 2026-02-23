<?php
require_once __DIR__ . '/includes/init.php';

// Add user_id column to sales table
echo "<h3>Updating Sales Table...</h3>";

$sql = "ALTER TABLE sales ADD COLUMN user_id INT UNSIGNED NOT NULL AFTER id";
echo "Adding user_id column to sales table...<br>";

if ($conn->query($sql)) {
    echo "✅ user_id column added successfully<br>";
} else {
    echo "❌ Error adding user_id column: " . $conn->error . "<br>";
}

// Add foreign key constraint
$sql = "ALTER TABLE sales ADD CONSTRAINT fk_sales_user_id 
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE";
echo "Adding foreign key constraint...<br>";

if ($conn->query($sql)) {
    echo "✅ Foreign key constraint added successfully<br>";
} else {
    echo "❌ Error adding foreign key: " . $conn->error . "<br>";
}

// Add index for user_id
$sql = "CREATE INDEX idx_sales_user_id ON sales(user_id)";
echo "Adding index for user_id...<br>";

if ($conn->query($sql)) {
    echo "✅ Index added successfully<br>";
} else {
    echo "❌ Error adding index: " . $conn->error . "<br>";
}

// Add user_id to sale_items table as well
echo "<h3>Updating Sale Items Table...</h3>";

$sql = "ALTER TABLE sale_items ADD COLUMN user_id INT UNSIGNED NOT NULL AFTER id";
echo "Adding user_id column to sale_items table...<br>";

if ($conn->query($sql)) {
    echo "✅ user_id column added successfully<br>";
} else {
    echo "❌ Error adding user_id column: " . $conn->error . "<br>";
}

// Add foreign key constraint for sale_items
$sql = "ALTER TABLE sale_items ADD CONSTRAINT fk_sale_items_user_id 
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE";
echo "Adding foreign key constraint for sale_items...<br>";

if ($conn->query($sql)) {
    echo "✅ Foreign key constraint added successfully<br>";
} else {
    echo "❌ Error adding foreign key: " . $conn->error . "<br>";
}

// Add index for user_id in sale_items
$sql = "CREATE INDEX idx_sale_items_user_id ON sale_items(user_id)";
echo "Adding index for user_id in sale_items...<br>";

if ($conn->query($sql)) {
    echo "✅ Index added successfully<br>";
} else {
    echo "❌ Error adding index: " . $conn->error . "<br>";
}

echo "<br><strong>Database Migration Completed!</strong><br>";
echo "<a href='client_dashboard.php'>Go to Client Dashboard</a>";
?>
