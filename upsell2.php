<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Connect to your database
    $servername = "localhost";
    $username = "root"; 
    $password = ""; 
    $dbname = "nadsoft"; 

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind SQL statement to insert product into the table
    $stmt = $conn->prepare("INSERT INTO member_orders (member_id, product_name, price) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $member_id, $product_name, $price);

    // Set parameters and execute
    $member_id = $_POST['member_id']; // Assuming you have a field for member ID in your form
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];

    if ($stmt->execute() === TRUE) {
        // Redirect to the "thankyou.php" page
        header("Location: thankyou.php");
        exit(); // Make sure to exit after sending the header to prevent further execution
    } else {
        echo "Error: " . $stmt->error;
    }


    // Close statement and database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Product Form</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <style>
    body {
      background-color: #f8f9fa;
    }
    .container {
      margin-top: 50px;
    }
    .form-container {
      background-color: #fff;
      padding: 30px;
      border-radius: 5px;
      box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="form-container">
          <h2 class="text-center">Add Product</h2>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
              <label for="member_id">Member ID:</label>
              <input type="text" class="form-control" id="member_id" name="member_id" required>
            </div>
            <div class="form-group">
              <label for="product_name">Product Name:</label>
              <input type="text" class="form-control" id="product_name" name="product_name" required>
            </div>
            <div class="form-group">
              <label for="price">Price:</label>
              <input type="text" class="form-control" id="price" name="price" required>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary" name="submit">Add to My Order</button>
              <a href="Nothankyoupage.php" class="btn btn-secondary">No Thanks</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
