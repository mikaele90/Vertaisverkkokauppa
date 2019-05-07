<?php
// Include config file
require_once "database.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = $first_name = $last_name = $email = $telephone_number = $street_address = $zip_code = $city = $country = "";
$username_err = $password_err = $confirm_password_err = $first_name_err = $last_name_err = $email_err = $telephone_number_err = $street_address_err = $zip_code_err = $city_err = $country_err = "";
$city_strip = "";
function validate_phone_number($phone)
{
    $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
    $phone_to_check = str_replace("-", "", $filtered_phone_number);
    if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
        return false;
    } else {
        return true;
    }
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // Prepare a select statement

        $sql = "SELECT UserId FROM userDB WHERE UserName = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least six characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate first name
    if (empty(trim($_POST["first_name"]))) {
        $first_name_err = "Please confirm first name.";
    } elseif (strlen(trim($_POST["first_name"])) < 2) {
        $first_name_err = "First name must have at least two characters.";
    } else {
        $first_name = trim($_POST["first_name"]);
    }

    // Validate last name
    if (empty(trim($_POST["last_name"]))) {
        $last_name_err = "Please confirm last name.";
    } elseif (strlen(trim($_POST["last_name"])) < 2) {
        $last_name_err = "Last name must have at least two characters.";
    } else {
        $last_name = trim($_POST["last_name"]);
    }

    // Validate email address
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please confirm email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Your email is not valid";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate telephone number
    if (empty(trim($_POST["telephone_number"]))) {
        $telephone_number_err = "Please confirm telephone number.";
    } elseif (validate_phone_number(trim($_POST["telephone_number"])) == false) {
        $telephone_number_err = "Telephone number is not valid";
    } else {
        $telephone_number = trim($_POST["telephone_number"]);
    }

    // Validate street address
    if (empty(trim($_POST["street_address"]))) {
        $street_address_err = "Please confirm street address.";
    } elseif (strlen(trim($_POST["street_address"])) < 8) {
        $street_address_err = "Street address must have at least eight characters.";
    } else {
        $street_address = trim($_POST["street_address"]);
    }

    // Validate ZIP code
    if (empty(trim($_POST["zip_code"]))) {
        $zip_code_err = "Please confirm ZIP code.";
    } elseif (strlen(trim($_POST["zip_code"])) < 5) {
        $zip_code_err = "ZIP code must have at least five characters.";
    } else {
        $zip_code = trim($_POST["zip_code"]);
    }

    // Validate city
    if (empty(trim($_POST["city"]))) {
        $city_err = "Please confirm city name.";
    } elseif (strlen(trim($_POST["city"])) < 1) {
        $city_err = "City name must have at least one characters.";
    } else {
        $city = trim($_POST["city"]);
        $city = strip_tags($city);
    }


    // Validate country
    if (empty(trim($_POST["country"]))) {
        $country_err = "Please confirm country name.";
    } elseif (strlen(trim($_POST["country"])) < 1) {
        $country_err = "Country name must have at least one characters.";
    } else {
        $country = trim($_POST["country"]);
    }


    // Check input errors before inserting in database
    if (empty($username_err) &&
        empty($password_err) &&
        empty($confirm_password_err) &&
        empty($first_name_err) &&
        empty($last_name_err) &&
        empty($email_err) &&
        empty($telephone_number_err) &&
        empty($street_address_err) &&
        empty($zip_code_err) &&
        empty($city_err) &&
        empty($country_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO userDB (UserName, UserPassword, FirstName, LastName, Email, TelNum, StreetAddress, Zipcode, City, Country) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssssss",
                $param_username,
                $param_password,
                $param_first_name,
                $param_last_name,
                $param_email,
                $param_telephone_number,
                $param_street_address,
                $param_zip_code,
                $param_city,
                $param_country);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_email = $email;
            $param_telephone_number = $telephone_number;
            $param_street_address = $street_address;
            $param_zip_code = $zip_code;
            $param_city = $city;
            $param_country = $country;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: login.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <style type="text/css">
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 350px;
            padding: 20px;
            alignment: center
        }
    </style>
</head>
<body>

<?php require_once 'nav-bar.php' ?>

<div class="wrapper">
    <h2>Sign Up</h2>
    <p>Please fill this form to create an account.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control"
                   value="<?php echo $confirm_password; ?>">
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($first_name_err)) ? 'has-error' : ''; ?>">
            <label>First name</label>
            <input type="text" name="first_name" class="form-control" value="<?php echo $first_name; ?>">
            <span class="help-block"><?php echo $first_name_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($last_name_err)) ? 'has-error' : ''; ?>">
            <label>Last name</label>
            <input type="text" name="last_name" class="form-control" value="<?php echo $last_name; ?>">
            <span class="help-block"><?php echo $last_name_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <label>Email address</label>
            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
            <span class="help-block"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($telephone_number_err)) ? 'has-error' : ''; ?>">
            <label>Telephone number</label>
            <input type="text" name="telephone_number" class="form-control" value="<?php echo $telephone_number; ?>">
            <span class="help-block"><?php echo $telephone_number_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($street_address_err)) ? 'has-error' : ''; ?>">
            <label>Street address (it is at your own responsibility that the address is correct)</label>
            <input type="text" name="street_address" class="form-control" value="<?php echo $street_address; ?>">
            <span class="help-block"><?php echo $street_address_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($zip_code_err)) ? 'has-error' : ''; ?>">
            <label>ZIP code </label>
            <input type="text" name="zip_code" class="form-control" value="<?php echo $zip_code; ?>">
            <span class="help-block"><?php echo $zip_code_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($city_err)) ? 'has-error' : ''; ?>">
            <label>City </label>
            <input type="text" name="city" class="form-control" value="<?php echo $city; ?>">
            <span class="help-block"><?php echo $city_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($country_err)) ? 'has-error' : ''; ?>">
            <label>Country </label>
            <input type="text" name="country" class="form-control" value="<?php echo $country; ?>">
            <span class="help-block"><?php echo $country_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-default" value="Reset">
        </div>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </form>
</div>
</body>
</html>