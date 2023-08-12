<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Welcome to the Home Page</h2>
    <hr>

    <h3>User Data</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>User Name</th>
            <th>Email</th>
        </tr>
        </thead>
        <tbody>
        <!-- Retrieve and display user data using PHP/MySQL -->
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "12345678";
        $dbname = "csc";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        else {

            $user_query = "SELECT  username , email FROM register";
            $user_result = mysqli_query($conn, $user_query);

            while ($user_row = mysqli_fetch_assoc($user_result)) {
                echo "<tr>";
                echo "<td>{$user_row['username']}</td>";
                echo "<td>{$user_row['email']}</td>";
                echo "</tr>";
            }
        }
        mysqli_close($conn);
        ?>
        </tbody>
    </table>

    <h3>Subject Information</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Subject</th>
            <th>Pass Mark</th>
            <th>Mark Obtained</th>
        </tr>
        </thead>
        <tbody>
        <!-- Retrieve and display subject-related information using PHP/MySQL -->
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "12345678";
        $dbname = "csc";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        else {

            $subject_query = "SELECT stName,subName,minimumMark FROM class ";
            $subject_result = mysqli_query($conn, $subject_query);

            while ($subject_row = mysqli_fetch_assoc($subject_result)) {
                echo "<tr>";
                echo "<td>{$subject_row['stName']}</td>";
                echo "<td>{$subject_row['subName']}</td>";
                echo "<td>{$subject_row['minimumMark']}</td>";
                echo "</tr>";
            }

            mysqli_close($conn);
        }
        ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
