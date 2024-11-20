<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>
            Update Admin
        </h1>

        <br><br>

        <?php
            //Get the id of the selected Admin
            $id = $_GET["id"];
            
            
            //Create SQL Query to get the details
            $sql = "SELECT * FROM tbl_admin WHERE id = $id";
            $res = mysqli_query($conn, $sql);

            //Check Whether the query is executed successfully
            if($res==true)
            {
                //Check whether the data is available or not
                $count = mysqli_num_rows($res);

                //Check whether we have admin data or not
                if($count==1){
                    //Get the details
                    //echo "Admin Available";
                    $row= mysqli_fetch_assoc($res);
                    $full_name = $row['full_name'];
                    $username = $row['username'];

                }
                else{
                    //Redirect to Manage Admin Page
                    header('Location:' . SITEURL . 'admin/manage-admin.php');
                }
            }
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                    <tr>
                        <td>Full Name:</td>
                        <td><input type="text" name="full_name" value="<?php echo $full_name?>"></td>
                    </tr>
                    <tr>
                        <td>Username:</td>
                        <td>
                        <input type="text" name="username" value="<?php echo $username?>">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php  echo $id; ?>">
                            <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                        </td>
                    </tr>

            </table>
        </form>
    </div>
</div>
<?php 
//Check whether the submit button is clicked or not

if(isset($_POST["submit"])){
    //echo "Button clicked";
    //Get all the values from form to update
    $id = $_POST["id"];
    $full_name = $_POST["full_name"];
    $username = $_POST["username"];

    //Create a SQL Query to update admin

    $sql = "UPDATE tbl_admin SET
    full_name = '$full_name',
    username = '$username' 
    WHERE id = '$id'
    ";

    //Execute the SQL query
    $res = mysqli_query($conn, $sql);

    //Check Whether the query executed successfully or not
    if( $res == TRUE ){
        // your existing code...
        //Query Executed and Admin Updated
        $_SESSION['update'] = "<div class='success'> Admin Updated successfully</div>";
        header('Location:' . SITEURL . 'admin/manage-admin.php');
       


    }else{
        // your existing code...
        //Query Failed
        $_SESSION['update'] = "<div class='error'> Failed to delete Admin</div>";
        header('Location:' . SITEURL . 'admin/manage-admin.php');
        
    }

}
?>




<?php include('partials/footer.php')?>