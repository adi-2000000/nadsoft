<?php
// Database configuration
$host = 'localhost';
$dbname = 'nadsoft';
$username = 'root';
$password = '';

// Create connection
$dsn = "mysql:host=$host;dbname=$dbname";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Attempt connection
try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Save checkout details in database
    $stmt = $pdo->prepare("INSERT INTO member (firstname, lastname, username, email, address, address2, country, state, zip, payment_option, name_on_card, credit_card_number, expiration, cvv) 
                            VALUES (:firstname, :lastname, :username, :email, :address, :address2, :country, :state, :zip, :payment_option, :name_on_card, :credit_card_number, :expiration, :cvv)");
    $stmt->execute([
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname'],
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'address' => $_POST['address'],
        'address2' => $_POST['address2'],
        'country' => $_POST['country'],
        'state' => $_POST['state'],
        'zip' => $_POST['zip'],
        'payment_option' => $_POST['payment_option'],
        'name_on_card' => $_POST['name_on_card'],
        'credit_card_number' => $_POST['credit_card_number'],
        'expiration' => $_POST['expiration'],
        'cvv' => $_POST['cvv']
    ]);

    // Redirect to a thank you page or any other page
    header("Location: upsell1.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #696969;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 20px;
            color: #007bff;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .form-group {
        margin-bottom: 10px; /* Adjust the value as needed */
    }
    </style>
    <script>
        $(document).ready(function() {
            $('#checkoutForm').validate({
                rules: {
                    firstname: {
                        required: true
                    },
                    lastname: {
                        required: true
                    },
                    username: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    address: {
                        required: true
                    },
                    country: {
                        required: true
                    },
                    state: {
                        required: true
                    },
                    zip: {
                        required: true
                    },
                    payment_option: {
                        required: true
                    },
                    name_on_card: {
                        required: true
                    },
                    credit_card_number: {
                        required: true
                    },
                    expiration: {
                        required: true
                    },
                    cvv: {
                        required: true
                    }
                },
                messages: {
                    email: "Please enter a valid email address."
                },
                errorElement: 'div',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
</head>
<body>
<div class="container">
        <h2>Checkout Form</h2>
        <form method="post" id="checkoutForm">
        <div class="form-row">
    <div class="form-group">
        <label for="firstname">First Name:</label>
        <input type="text" class="form-control" name="firstname" required>
    </div>
    <div class="form-group">
        <label for="lastname">Last Name:</label>
        <input type="text" class="form-control" name="lastname" required>
    </div>
</div>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" name="address" required>
            </div>
            <div class="form-group">
                <label for="address2">Address 2:</label>
                <input type="text" class="form-control" name="address2">
            </div>
            <div class="form-row">
            <div class="form-group col-md-6">
    <label for="country">Country:</label>
    <select class="form-control" name="country" id="country" required>
        <option value="">Select Country</option>
    </select>
</div>
                <div class="form-group col-md-4">
    <label for="state">State:</label>
    <select class="form-control" name="state" id="state" required>
    <option value="">Select State</option>
        <option value="maharashtra">maharashtra</option>
        <option value="Gujrat">Gujrat</option>
        <option value="Assam">Assam</option>
        <option value="Bihar">Bihar</option>
        <option value="Chhattisgarh">Chhattisgarh</option>
        <option value="Goa">Goa</option>
        <option value="Andhra Pradesh">Andhra Pradesh</option>
        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
        <option value="Gujarat">Gujarat</option>
        <option value="Haryana">Haryana</option>
        <option value="Himachal Pradesh">Himachal Pradesh</option>
        <option value="Jharkhand">Jharkhand</option>
        <option value="Karnataka">Karnataka</option>
        <option value="Kerala">Kerala</option>
        <option value="Madhya Pradesh">Madhya Pradesh</option>
        <option value="Maharashtra">Maharashtra</option>
        <option value="Manipur">Manipur</option>
        <option value="Meghalaya">Meghalaya</option>
        <option value="Mizoram">Mizoram</option>
        <option value="Nagaland">Nagaland</option>
        <option value="Odisha">Odisha</option>
        <option value="Punjab">Punjab</option>
        <option value="Rajasthan">Rajasthan</option>
        <option value="Sikkim">Sikkim</option>
        <option value="Tamil Nadu">Tamil Nadu</option>
        <option value="Telangana">Telangana</option>
        <option value="Tripura">Tripura</option>
        <option value="Uttar Pradesh">Uttar Pradesh</option>
        <option value="Uttarakhand">Uttarakhand</option>
        <option value="West Bengal">West Bengal</option>
    </select>
</div>
                <div class="form-group col-md-2">
                    <label for="zip">ZIP:</label>
                    <input type="text" class="form-control" name="zip" required>
                </div>
                </div>
                <div class="form-row">
    <div class="form-group">
        <label>Payment Option:</label>
        <div class="custom-control custom-radio">
            <input type="radio" id="credit_card" name="payment_option" class="custom-control-input" value="credit_card" required>
            <label class="custom-control-label" for="credit_card">Credit Card</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" id="debit_card" name="payment_option" class="custom-control-input" value="debit_card">
            <label class="custom-control-label" for="debit_card">Debit Card</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" id="paypal" name="payment_option" class="custom-control-input" value="paypal">
            <label class="custom-control-label" for="paypal">PayPal</label>
        </div>
    </div>
</div>
            <div class="form-row">
            <div class="form-group md-2">
                <label for="name_on_card">Name on Card:</label>
                <input type="text" class="form-control" name="name_on_card" required>
            </div>
            
            <div class="form-group md-2">
                <label for="credit_card_number">Credit Card Number:</label>
                <input type="numbar" class="form-control" name="credit_card_number" required>
            </div>
            </div>
    
            <div class="form-row">
            <div class="form-group">
                <label for="expiration">Expiration (MM/YYYY):</label>
                <input type="text" class="form-control" name="expiration" required>
            </div>
            <div class="form-group">
                <label for="cvv">CVV:</label>
                <input type="number" class="form-control" name="cvv" required>
            </div>
            </div>
            <input type="submit" class="btn btn-primary" name="submit" value="Continue to Checkout">
        </form>
    </div>

    <!-- Bootstrap JS and jQuery (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- jQuery Validation Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#checkoutForm').validate({
                // Validation rules and messages...
            });
        });
    </script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    // List of countries
    const countries = [
        "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia", "Australia", "Austria",
        "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan",
        "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cabo Verde", "Cambodia",
        "Cameroon", "Canada", "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros", "Congo", "Costa Rica",
        "Croatia", "Cuba", "Cyprus", "Czech Republic", "Democratic Republic of the Congo", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor",
        "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Eswatini", "Ethiopia", "Fiji", "Finland",
        "France", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Grenada", "Guatemala", "Guinea",
        "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq",
        "Ireland", "Israel", "Italy", "Ivory Coast", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati",
        "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania",
        "Luxembourg", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius",
        "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique", "Myanmar", "Namibia",
        "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria", "North Korea", "North Macedonia", "Norway",
        "Oman", "Pakistan", "Palau", "Palestine", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland",
        "Portugal", "Qatar", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino",
        "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands",
        "Somalia", "South Africa", "South Korea", "South Sudan", "Spain", "Sri Lanka", "Sudan", "Suriname", "Sweden", "Switzerland",
        "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey",
        "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay", "Uzbekistan", "Vanuatu",
        "Vatican City", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"
    ];

    // Populate the dropdown with country names
    const selectCountry = document.getElementById('country');
    countries.forEach(country => {
        const option = document.createElement('option');
        option.value = country;
        option.textContent = country;
        selectCountry.appendChild(option);
    });
</script>

</body>
</html>