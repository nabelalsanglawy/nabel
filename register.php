<!DOCTYPE html>
<html>
<head>
    <title>Registration Page</title>
    <style>
        .container {
            margin-top: 50px;
        }
        .alert {
            margin-top: 20px;
        }

    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2>Register</h2>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $servername = "localhost";
                $username = "root";
                $password = "12345678";
                $dbname = "csc";

                $conn = mysqli_connect($servername, $username, $password, $dbname);

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $username = $_POST["username"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                $confirmPassword = $_POST["confirmPassword"];
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Validate input
                if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
                    echo "<div class='alert alert-danger'>All fields are required.</div>";
                } elseif ($password !== $confirmPassword) {
                    echo "<div class='alert alert-danger'>Passwords do not match.</div>";
                } else {
                    $sql = "INSERT INTO register (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";

                    if (mysqli_query($conn, $sql)) {
                        echo "<div class='alert alert-success'>Registration successful.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
                    }
                }

                mysqli_close($conn);
            }
            ?>
            <form method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
</div>
<!-- Include Bootstrap and other JS files -->
</body>
</html>









