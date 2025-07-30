<?php
// Connect to MySQL
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "testdb"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Receive form data
// Always sanitize input to prevent XSS (Cross-Site Scripting)
$full_name = htmlspecialchars($_POST['full_name']);
$phone_number = htmlspecialchars($_POST['phone_number']);
$cart_items_summary = htmlspecialchars($_POST['cart_items_summary']);
$quantity = htmlspecialchars($_POST['quantity']);
$meter_per_mabati = htmlspecialchars($_POST['meter_per_mabati']);
// Ensure this matches your HTML input name for mabati_type if you intend to use it
// Based on the HTML, it's not being sent, but the DB has it. If you add it to HTML, uncomment this:
// $mabati_type = htmlspecialchars($_POST['mabati_type']);
$color = htmlspecialchars($_POST['color']);
$payment_method = htmlspecialchars($_POST['payment_method']);
$production_date = htmlspecialchars($_POST['production_date']);

// Using Prepared Statements to prevent SQL Injection
// Enclose column names in backticks to avoid issues with potential SQL keywords
$stmt = $conn->prepare("INSERT INTO orders (full_name, phone_number, cart_items_summary, quantity, meter_per_mabati, `color`, `payment_method`, `production_date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
// "sssissss" -> s for string, i for integer. Adjust based on your actual column types in 'orders' table.
// Assuming quantity is integer, others are strings.
$stmt->bind_param("sssissss", $full_name, $phone_number, $cart_items_summary, $quantity, $meter_per_mabati, $color, $payment_method, $production_date);

if ($stmt->execute()) {
    echo "Registration successful!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>