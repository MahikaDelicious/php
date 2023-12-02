<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crud";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// DELETE function
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $deleteQuery = "DELETE FROM products WHERE id = ?";
    
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
}

// UPDATE function
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $productCode = $_POST['productCode'];
    $product = $_POST['product'];
    $qty = $_POST['qty'];
    $perPrice = $_POST['perPrice'];

    $updateQuery = "UPDATE products SET productCode=?, product=?, qty=?, perPrice=? WHERE id=?";
    
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssidi", $productCode, $product, $qty, $perPrice, $id);
    
    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $stmt->error;
    }
    $stmt->close();
}
if(isset($_POST['submit'])) {
    $productCode = $_POST['productCode'];
    $product = $_POST['product'];
    $qty = $_POST['qty'];
    $perPrice = $_POST['perPrice'];

    $res = mysqli_query($conn, "INSERT into products values('', '$productCode', '$product', '$qty', '$perPrice')");

    if ($res) {
        echo "Success";
    } else {
        echo "Failed";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>CRUD</title>
</head>
<body style="color: white; background-color: #1b1661">

<div class="container mt-5">
    <div class="text-center">
        <h1 class="display-5 mb-5"><strong>CRUD</strong></h1>
    </div>
    <div class="main row justify-content-center">
    <form action="index.php" method="post" id="store-form" class="row justify-content-center">
            <label for="productCode">Product Code</label>
            <div class="col-12 mb-3">
                <input class="form-control" id="productCode" name="productCode" type="text" placeholder="Product Code" value="<?php echo isset($productCode) ? $productCode : ''; ?>">
            </div>
            <label for="productCode">Product</label>
            <div class="col-12 mb-3">
                <input class="form-control" id="product" name="product" type="text" placeholder="Product Name" value="<?php echo isset($product) ? $product : ''; ?>">
            </div>
            <label for="productCode">Quantity</label>
            <div class="col-12 mb-3">
                <input class="form-control" id="qty" name="qty" type="number" placeholder="Quantity" value="<?php echo isset($qty) ? $qty : ''; ?>">
            </div>
            <label for="productCode">Price</label>
            <div class="col-12 mb-3">
                <input class="form-control" id="perPrice" name="perPrice" type="number" placeholder="Price" value="<?php echo isset($perPrice) ? $perPrice : ''; ?>">
            </div>
            <div class="col-12 mb-3">
                <input class="btn btn-success" type="submit" name="submit" value="Submit">
                <input class="btn btn-success" type="submit" name="<?php echo isset($id) ? 'update' : 'submit'; ?>" value="<?php echo isset($id) ? 'Update' : 'Submit'; ?>">
            </div>
            <input type="hidden" name="action" value="<?php echo isset($id) ? 'update' : 'submit'; ?>">
        </form>
        <div class="col-12 mt-5">
            <table class="table table-striped table-dark">
                <thead>

                </thead>
                <tbody id="store-list">
                    <tr>
                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM products");
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['productCode']}</td>";
                            echo "<td>{$row['product']}</td>";
                            echo "<td>{$row['qty']}</td>";
                            echo "<td>{$row['perPrice']}</td>";
                            echo "<td><a href='#' class='btn btn-warning btn-sm edit'>EDIT</a></td>";
                            echo "<td><a href='?action=delete&id={$row['id']}' class='btn btn-danger btn-sm delete'>DELETE</a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
<script src="script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>