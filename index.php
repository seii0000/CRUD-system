<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="float-start">To-Do List</h2>
                        <a href="create.php" class="btn btn-success float-end">Add New Task</a>
                    </div>
                    <?php
                    session_start();
                    // Include config file
                    require_once "dbconfig.php";

                    // Check existence of success message
                    if(isset($_SESSION['success_message'])){
                        echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
                        unset($_SESSION['success_message']);
                    }

                    //Check existence of success update message 
                    if(isset($_SESSION['success_update_message'])){
                        echo '<div class="alert alert-success">' . $_SESSION['success_update_message'] . '</div>';
                        unset($_SESSION['success_update_message']);
                    }


                    // Attempt select query execution
                    $sql = "SELECT * FROM tasks";
                    if($result = $conn->query($sql)){
                        if($result->num_rows > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>ID</th>";
                                        echo "<th>Title</th>";
                                        echo "<th>Description</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch_assoc()){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['title'] . "</td>";
                                        echo "<td>" . $row['description'] . "</td>";
                                        echo "<td>
                                            <a href='update.php?id=" . $row['id'] . "' class='btn btn-primary'>Update</a>
                                            <a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger'>Delete</a>
                                        </td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                            echo "</table>";
                            // Free result set
                            $result->free();
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close connection
                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
