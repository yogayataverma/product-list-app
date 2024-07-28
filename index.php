<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Product List</title>
<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
}
.sidebar {
    height: 100vh;
    width: 250px;
    position: fixed;
    background-color: #2C3E50;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    color: #ECF0F1;
    font-size: 14px;
}
.sidebar h2 {
    font-size: 22px;
    color: #ECF0F1;
    margin-bottom: 20px;
}
.sidebar form {
    display: flex;
    flex-direction: column;
}
.sidebar label {
    margin-bottom: 5px;
    font-weight: bold;
}
.sidebar input[type='number'],
.sidebar select {
    padding: 8px;
    margin-bottom: 10px;
    border: none;
    border-radius: 4px;
    background-color: #fff;
    transition: all 0.3s ease;
}
.sidebar input[type='number']:focus,
.sidebar select:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(52, 152, 219,0.5);
}
.sidebar input[type='checkbox'] {
    margin-right: 5px;
}
.sidebar button {
    padding: 10px 15px;
    background-color: #3498DB;
    color: #ffffff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
.sidebar button:hover {
    background-color: #2980B9;
}
.sidebar a {
    color: #ECF0F1;
    text-decoration: none;
}
.navbar {
    background-color: #333;
    overflow: hidden;
    width: 100%;
    margin-left: 250px;
}
.navbar a {
    float: left;
    display: block;
    color: white;
    text-align: center;
    padding: 14px 20px;
    text-decoration: none;
}
.navbar a:hover {
    background-color: #ddd;
    color: black;
}
.container {
    margin-left: 300px;
    flex-grow: 1;
    padding: 10px;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}
.card {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    width: 20%;
    margin: 10px;
   
}
.card img {
    width: 100%;
    height: auto;
}
.card h4, .card p {
    padding: 0 16px;
}
.card .price {
    color: grey;
    font-size: 12px;
}
.pagination {
    text-align: center;
    width: 100%;
    padding: 20px 0;
}
.pagination a {
    padding: 8px 16px;
    text-decoration: none;
    color: black;
    border: 1px solid #ddd;
    margin: 0 4px;
}
.pagination a:hover {
    background-color: #f2f2f2;
}
</style>
</head>
<body>

<div class="sidebar">
    <h2>Filter Options</h2>
    <form action="" method="GET">
        <label for="price_from">Price from:</label>
        <input type="number" id="price_from" name="price_from" min="0" value="<?php echo isset($_GET['price_from']) ? $_GET['price_from'] : ''; ?>">
        <label for="price_to">Price to:</label>
        <input type="number" id="price_to" name="price_to" min="0" value="<?php echo isset($_GET['price_to']) ? $_GET['price_to'] : ''; ?>">
        <label for="category">Category:</label>
        <select id="category" name="category">
            <option value="">All</option>
            <option value="Xbox" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Xbox') ? 'selected' : ''; ?>>Xbox Games</option>
            <option value="PC" <?php echo (isset($_GET['category']) && $_GET['category'] == 'PC') ? 'selected' : ''; ?>>PC Games</option>
        </select>
        <label>On Sale:</label>
        <input style="margin-top:-7%;" type="checkbox" id="on_sale" name="on_sale" value="on_sale" <?php echo (isset($_GET['on_sale']) && $_GET['on_sale'] == 'on_sale') ? 'checked' : ''; ?>>
        <button type="submit">Apply Filters</button>
    </form>
</div>

<div class="navbar">
    <a href="#home" style="margin-left:300px;">Home</a>
    <a href="#xbox">Xbox Games</a>
    <a href="#pc">PC Games</a>
</div>

<div class="container">
<?php
$host = 'sql12.freesqldatabase.com:3306';
$dbname = 'sql12722596';
$username = 'sql12722596';
$password = 'MaalpgbfL5';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$limit = 12;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$whereClauses = [];
if (isset($_GET['price_from']) && $_GET['price_from'] != '') {
    $whereClauses[] = "price >= " . intval($_GET['price_from']);
}
if (isset($_GET['price_to']) && $_GET['price_to'] != '') {
    $whereClauses[] = "price <= " . intval($_GET['price_to']);
}
if (isset($_GET['category']) && $_GET['category'] != '') {
    $whereClauses[] = "category = '" . $conn->real_escape_string($_GET['category']) . "'";
}
if (isset($_GET['on_sale']) && $_GET['on_sale'] == '1') {
    $whereClauses[] = "sale_status = 'on sale'";
}

$sql = "SELECT product_id, name, image, price, category, sale_status, created_at FROM products";
if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(" AND ", $whereClauses);
}
$sql .= " LIMIT $start, $limit";
$result = $conn->query($sql);

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
        $link = 'index.php?' . generateQueryString(['page' => $i]);
        echo "<a href='$link'>$i</a> ";
    }
    echo "</div>";
} else {
    echo "0 results";
}

$conn->close();

function generateQueryString($overrides = []) {
    $query = array_merge($_GET, $overrides);
    return http_build_query($query);
}
?>
</div>

</body>
</html>
