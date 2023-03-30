<?php
include "../functions/func.php";
check_session($_SESSION['uname'], "index.php", "Authantication Failed");

$uname=$_SESSION['uname'];
$utype=$_SESSION['utype'];

require $_SERVER[ 'DOCUMENT_ROOT' ].'/quiz_forum/header.php'; 
?>
    <div class="container" style="margin:8% auto;width:900px;">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">Category</h3>
                </div> 
                 <div class="panel-body">
                     <a href="add-category.php" class="pull-right btn btn-success">Add New</a><br><br>
            <table class="table table-stripped">
                                <th>Category Name</th>
                                <th>Actions</th>
                            <?php
                            
                            include "../functions/db.php";

                            $sql = "SELECT * from category";
                            $run = mysqli_query($con, $sql);

                            while($row=mysqli_fetch_array($run))
                            {
                                extract($row);
                                echo "<tr>";
                                echo "<td>".$category."</td>";
                                echo '<td><a href="edit-category.php?cat_id='.$cat_id.'"><button class="btn btn-default">Edit</button> <a href="delete-category.php?cat_id='.$cat_id.'"><button class="btn btn-danger">Delete</button></a></td>';
                                echo "</tr>";
                            }
                           

                            ?>
                            </table>
                     </div>
                </div>

            </div>
            <script type="text/javascript">

           

            </script>
	</body>
</html>