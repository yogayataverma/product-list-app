<?php
$host = 'sql12.freesqldatabase.com:3306';
$dbname = 'sql12722596';
$username = 'sql12722596';
$password = 'MaalpgbfL5';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve filters from URL parameters
$min_price = isset($_GET['min_price']) ? $_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? $_GET['max_price'] : 1000000;
$category = isset($_GET['category']) ? $_GET['category'] : '';
$on_sale = isset($_GET['on_sale']) ? "sale_status = 'ON_SALE'" : "1=1";

// Build the SQL query dynamically
$sql_filters = " WHERE price >= $min_price AND price <= $max_price AND ($on_sale)";

if (!empty($category)) {
    $sql_filters .= " AND category = '$category'";
}

$sql = "SELECT product_id, name, image, price, category, sale_status, created_at FROM products $sql_filters LIMIT $start, $limit";

$limit = 12; // Number of products per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit; // Calculate the starting point

// Retrieve the rows for the current page
$sql = "SELECT product_id, name, image, price, category, sale_status, created_at FROM products LIMIT $start, $limit";
$result = $conn->query($sql);

// Calculate total number of pages
$total_results = $conn->query("SELECT COUNT(product_id) AS total FROM products")->fetch_assoc()['total'];
$total_pages = ceil($total_results / $limit);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='card'>
                <img src='data:image/jpeg;base64," . base64_encode($row['image']) . "' alt='{$row['name']}'>
                <h4>{$row['name']}</h4>
                <p class='price'>\${$row['price']}</p>
              </div>";
    }

    echo "<div class='pagination'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='index.php?page=$i'>$i</a> ";
    }
    echo "</div>";
} else {
    echo "0 results";
}

$conn->close();
?>