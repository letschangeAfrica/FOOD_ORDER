<?php include('partials/menu.php'); ?>
    <div class="main-content">
        <div class="wrapper">
            <h1>
                Add Admin
            </h1>
            <br><br>

            <?php
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }
            ?>
            <form action="" method="POST">
                <table class="tbl-30">
                    <tr>
                        <td>Full Name:</td>
                        <td><input type="text" name="full_name" placeholder="Enter Your Name"></td>
                    </tr>
                    <tr>
                        <td>Username:</td>
                        <td>
                        <input type="text" name="username" placeholder="Your Username"> 
                        </td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td>
                        <input type="password" name="password" placeholder="Your Password"> 
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>
        </div>

    </div>

<?php include('partials/footer.php'); ?>
<?php
    //Process the value from and svae it in Database
    //Check whether the submit button is clicked or not
    if(isset($_POST['submit'])){
        // Button Clicked
        //echo "Button Clicked";

        //1. Get the data from form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //Password Encryption with MD5

        //2. SQL Query to save the data into database
        $sql = "INSERT INTO tbl_admin SET
            full_name = '$full_name',
            username = '$username',
            password = '$password'
        ";

        //3.Execute the query and saving data into the database 
        $res = mysqli_query($conn, $sql) or die();

        //4.Check whether the (query is executed) data is inserted or not and display appropriate error message
        if($res==TRUE) {
            //data inserted


            $_SESSION['add'] = "Admin Added Successfully";
            //Redirect Page to manage admin
            header("location:" . SITEURL . 'admin/manage-admin.php');
        }
        else{


            //Create a session variable to display message
            $_SESSION['add'] = "Failed to Add Admin";
            //Redirect Page to manage admin
            header("location:" . SITEURL . "admin/manage-admin.php");
        }
    }

?>