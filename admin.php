<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <!-- Include Bootstrap and other CSS/JS files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>
<div class="container mt-4">
    <h2>Admin Panel</h2>

    <?php
    // Include database connection

    $servername = "localhost";
    $username = "root";
    $password = "12345678";
    $dbname = "csc";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }






    // Handle delete action
    if (isset($_GET["delete_id"])) {
        $delete_id = $_GET["delete_id"];
        $delete_query = "DELETE FROM register WHERE id = $delete_id";

        if (mysqli_query($conn, $delete_query)) {
            echo "<div class='alert alert-success'>User deleted successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error deleting user: " . mysqli_error($conn) . "</div>";
        }
    }

    // Handle edit action
    if (isset($_POST["edit_id"])) {
        $edit_id = $_POST["edit_id"];
        $new_username = $_POST["new_username"];
        $new_email = $_POST["new_email"];

        $update_query = "UPDATE register SET username = '$new_username', email = '$new_email' WHERE id = $edit_id";

        if (mysqli_query($conn, $update_query)) {
            echo "<div class='alert alert-success'>User updated successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error updating user: " . mysqli_error($conn) . "</div>";
        }
    }



    // Handle add subject action
    if (isset($_POST["add_stName"]) && isset($_POST["add_subName"]) && isset($_POST["add_minimumMark"])) {
        $add_stName = $_POST["add_stName"];
        $add_subName = $_POST["add_subName"];
        $add_minimumMark = $_POST["add_minimumMark"];

        $add_querysub = "INSERT INTO class (stName, subName, minimumMark) VALUES ('$add_stName', '$add_subName', '$add_minimumMark')";

        if (mysqli_query($conn, $add_querysub)) {
            echo "<div class='alert alert-success'>subject added successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error adding subject: " . mysqli_error($conn) . "</div>";
        }
    }






    // Handle add user action
    if (isset($_POST["add_username"]) && isset($_POST["add_email"]) && isset($_POST["add_password"])) {
        $add_username = $_POST["add_username"];
        $add_email = $_POST["add_email"];
        $add_password = password_hash($_POST["add_password"], PASSWORD_DEFAULT);

        $add_query = "INSERT INTO register (username, email, password) VALUES ('$add_username', '$add_email', '$add_password')";

        if (mysqli_query($conn, $add_query)) {
            echo "<div class='alert alert-success'>User added successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error adding user: " . mysqli_error($conn) . "</div>";
        }
    }



/* assign $query ="SELECT stName
                FROM class
                    WHERE subName != 'math' OR subName IS NULL
                        ";




    $result1 =$conn->query($query);

    if ($result1->num_rows > 0) {
        while ($row = $result1->fetch_assoc()) {
            echo "stName: " . $row["stName"] . "<br>";
        }
    } else {
        echo "No students found.";
    }

*/




    // mark
$sql = "SELECT stName FROM class WHERE subName = 'english' ";
    $result = $conn->query($sql);

    $studentNames = array();
    while ($row = $result->fetch_assoc()) {
        $studentNames[] = $row["stName"];
    }

    echo json_encode($studentNames);





    // Fetch user data from database
    $fetch_query = "SELECT id, username, email FROM register";
    $result = mysqli_query($conn, $fetch_query);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table'>";
        echo "<thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Actions</th></tr></thead><tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["username"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>";
            echo "<a href='admin.php?delete_id=" . $row["id"] . "' class='btn btn-danger btn-sm mr-2'>Delete</a>";
            echo "<button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#editModal" . $row["id"] . "'>Edit</button>";
            echo "</td>";
            echo "</tr>";

            // Edit modal for each user
            echo "<div class='modal fade' id='editModal" . $row["id"] . "' tabindex='-1' role='dialog' aria-labelledby='editModalLabel' aria-hidden='true'>";
            echo "<div class='modal-dialog' role='document'>";
            echo "<div class='modal-content'>";
            echo "<div class='modal-header'>";
            echo "<h5 class='modal-title' id='editModalLabel'>Edit User</h5>";
            echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
            echo "<span aria-hidden='true'>&times;</span>";
            echo "</button>";
            echo "</div>";
            echo "<div class='modal-body'>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='edit_id' value='" . $row["id"] . "'>";
            echo "<div class='form-group'>";
            echo "<label for='new_username'>New Username</label>";
            echo "<input type='text' class='form-control' id='new_username' name='new_username' value='" . $row["username"] . "'>";
            echo "</div>";
            echo "<div class='form-group'>";
            echo "<label for='new_email'>New Email</label>";
            echo "<input type='email' class='form-control' id='new_email' name='new_email' value='" . $row["email"] . "'>";
            echo "</div>";
            echo "<button type='submit' class='btn btn-primary'>Save Changes</button>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }

        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-info'>No users found.</div>";

    }








    mysqli_close($conn);
    ?>


    <hr>





    <hr>












    <!-- add user-->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
        Add new user
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <h3>Add New User</h3>
                    <form method="post">
                        <div class="form-group">
                            <label for="add_username">Username</label>
                            <input type="text" class="form-control" id="add_username" name="add_username" required>
                        </div>
                        <div class="form-group">
                            <label for="add_email">Email</label>
                            <input type="email" class="form-control" id="add_email" name="add_email" required>
                        </div>
                        <div class="form-group">
                            <label for="add_password">Password</label>
                            <input type="password" class="form-control" id="add_password" name="add_password" required>
                        </div>
                        <button type="submit" class="btn btn-success">Add User</button>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>





    <!-- Add subject -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Add New Subject
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <h3>Add New subject</h3>
                <form method="post">
                    <div class="form-group">
                        <label for="add_stName">stName</label>
                        <input type="text" class="form-control" id="add_stName" name="add_stName" required>
                    </div>
                    <div class="form-group">
                        <label for="add_subName">subName</label>
                        <input type="text" class="form-control" id="add_subName" name="add_subName" required>
                    </div>
                    <div class="form-group">
                        <label for="add_minimumMark">minimumMark</label>
                        <input type="text" class="form-control" id="add_minimumMark" name="add_minimumMark" required>
                    </div>
                    <button type="submit" class="btn btn-success">Add subject</button>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>






    <!DOCTYPE html>
    <html>
    <head>
        <title>Subject Assignment</title>
        <!-- Include Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
    <button id="assignButton" class="btn btn-primary" data-toggle="modal" data-target="#assignmentModal">
        Assign Subject
    </button>

    <!-- Modal Popup -->
    <div class="modal fade" id="assignmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select a Subject and a Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="assignmentForm">
                        <div class="form-group">
                            <label for="subjectList">Select a Subject:</label>
                            <select class="sub" >

                                <?php while($row1 = mysqli_fetch_array($result)):;?>

                                    <option value="<?php echo $row1[0];?>"><?php echo $row1[1];?></option>

                                <?php endwhile;?>

                            </select>


                        </div>
                        <div class="form-group">
                            <label for="studentList">Select a Student:</label>
                            <select class="form-control" id="studentList" name="student">
                                <!-- Options will be populated using JavaScript -->
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Assign</button>
                    </form>
                    <div id="result"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#assignButton').click(function() {
                // Populate subject and student dropdowns using AJAX
                $.ajax({
                    url: 'get_options.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var subjectOptions = '';
                        var studentOptions = '';

                        // Populate subject options
                        data.subjects.forEach(function(subject) {
                            subjectOptions += '<option value="' + subject.id + '">' + subject.name + '</option>';
                        });
                        $('#subjectList').html(subjectOptions);

                        // Populate student options
                        data.students.forEach(function(student) {
                            studentOptions += '<option value="' + student.id + '">' + student.name + '</option>';
                        });
                        $('#studentList').html(studentOptions);
                    }
                });
            });

            // Handle form submission
            $('#assignmentForm').submit(function(event) {
                event.preventDefault();

                var selectedSubject = $('#subjectList').val();
                var selectedStudent = $('#studentList').val();

                // Perform assignment using AJAX
                $.ajax({
                    url: 'process_assignment.php',
                    method: 'POST',
                    data: { subject: selectedSubject, student: selectedStudent },
                    success: function(result) {
                        $('#result').html(result);
                    }
                });
            });
        });
    </script>
    </body>
    </html>










    <!DOCTYPE html>
    <html>
    <head>
        <title>Subject Assignment</title>
        <!-- Include Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
    <button id="assignButton" class="btn btn-primary" data-toggle="modal" data-target="#assignmentModal">
        mark
    </button>

    <!-- Modal Popup -->
    <div class="modal fade" id="assignmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select a Subject and a Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="assignmentForm">
                        <div class="form-group">
                            <label for="subjectList">Select a Subject:</label>
                            <select class="sub" >


                            </select>


                        </div>
                        <div class="form-group">
                            <label for="studentList">Select a Student:</label>
                            <select class="form-control" id="studentList" name="student">
                                <!-- Options will be populated using JavaScript -->
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Assign</button>
                    </form>
                    <div id="result"></div>
                </div>
            </div>
        </div>
    </div>



</body>
    </html>


















</div>




<!-- Include Bootstrap and other JS files -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
