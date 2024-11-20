<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>
            Change Password
            <br><br>

        <?php
            //Get the id of the selected Admin
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
            }
        ?>

            <form action="" method="POST">
            <table class="tbl-30">
                    <tr>
                        <td>Current Password: </td>
                        <td><input type="password" name="current_password" placeholder="Current Password"></td>
                    </tr>
                    <tr>
                        <td>New Password: </td>
                        <td>
                        <input type="password" name="new_password" placeholder="New Password">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Confirm Password: </td>
                        <td>
                            <input type="password" name="confirm_password" placeholder="Confirm Password">
                        </td>
                    </tr>
                    <tr>
                    <td colspan="2">
                            <input type="hidden" name="id" value="<?php  echo $id; ?>">
                            <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                        </td>
                    </tr>

            </table>
            </form>
        </h1>
    </div>
</div>
<?php
    if(isset($_POST['submit'])){

        //echo "Clicked";

        //Get data from Form
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        //Check Whether the user with current ID and current Password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE id =$id AND password = '$current_password'";

        //Execute the query
        $res = mysqli_query($conn, $sql);

        if ($res == true){
            // Check whther data is available or not
            $count = mysqli_num_rows($res);
            if($count == 1){
                // User exists and Password Can be changed
                //echo "User Found";
                //Checked whether the new password and confirm password match

                if($new_password == $confirm_password){
                    //Update the password
                    //echo "Password matches";
                    $sql2 = "UPDATE tbl_admin SET 
                    password = '$new_password'
                    WHERE id = $id

                    ";
                    //Execute the query
                    $res2 = mysqli_query($conn, $sql2);

                    //Check whether the query is exceuted or not
                    if($res2 == true){
                        //Display Success Message
                        //Redirect to the Manage Admin Page with Success Message
                        //User does not exists and Set Message amd redirect

                        $_SESSION['change-pwd'] = "<div class='success'>Password changed successfully</div>";
                        header('Location:' . SITEURL . 'admin/manage-admin.php');

                    }
                    else{
                        //Display Error Message
                        //Redirect to the Manage Admin Page with Error Message
                        //User does not exists and Set Message amd redirect

                        $_SESSION['change-pwd'] = "<div class='error'>Failed to change Password</div>";
                        header('Location:' . SITEURL . 'admin/manage-admin.php');
                        exit();
                    }
                }
                else{
                    //Redirect to the Manage Admin Page with Error Message

                    //User does not exists and Set Message amd redirect

                    $_SESSION['pwd-not-match'] = "<div class='error'>Password did not match</div>";
                    header('Location:' . SITEURL . 'admin/manage-admin.php');
        

                }
            }
            else{
                //User does not exists and Set Message amd redirect

                $_SESSION['user-not-found'] = "<div class='error'>User Not Found</div>";
                header('Location:' . SITEURL . 'admin/manage-admin.php');
            }
        }


    }
?>



<?php include('partials/footer.php')?>