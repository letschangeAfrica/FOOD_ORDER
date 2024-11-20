<?php

    //Include the constants.php file here
    include('../config/constants.php');

    $id = $_GET['id'];

    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    //Execute the query
    $res = mysqli_query($conn, $sql);

    //Check whether the query succeeded
    if($res==true){
        
        //Query Execution Success 
        //echo "Admin deleted";

        //Create a session variable to display message
        $_SESSION['delete'] = "<div class='success'>Admin deleted Successfully</div>";

        //Redirect to manage Admin Page
        header('location:'.SITEURL.'/admin/manage-admin.php');
    }
    else{
        //Query Failed
        //echo "Failed to delete admin";
        $_SESSION['delete'] = "<div class='error'>Failed to delete Admin. Try again Later.</div>";
        header('location:'.SITEURL.'/admin/manage-admin.php');
    }
?>