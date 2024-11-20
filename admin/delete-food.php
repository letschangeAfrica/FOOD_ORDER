<?php 
    //Include Constants file
    include('../config/constants.php');
    //echo "Delete Ca"
    //Check whether the id and image_name value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name'])){
        //Get the value and Delete
        //echo "Get Value and Delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove the physical image file if available 
        if($image_name != ""){
            //image is Available. So remove it
            $path = "../images/food/".$image_name;
            //Remove te Image   
            $remove = unlink($path);

            //If Failed to Remove image then add an error message and stop the process

            if($remove==false){

                //Set the session Message
                $_SESSION['upload'] = "<div class='error'>Failed to Remove Image File</div>";
                //Redirect to Manage Category page

                header('Location:' . SITEURL . '/admin/manage-food.php');
                //Stop the process
                die();

            }
        }


        //Delete Data from the database
        //SQL Query to delete data from database
        $sql = "DELETE FROM tbl_food WHERE id = $id";

        //Execute SQL Query to delete
        $res = mysqli_query($conn, $sql);

        //Check Whether the data is delete from database or not
        if($res==true){
            //Set Success Message and redirect
            $_SESSION['delete'] = "<div class='success'>Food deleted Successfully</div>";
            //Redirect to manage category
            header('Location:' .SITEURL. '/admin/manage-food.php');

        }
        else{
            //Set Failure Message and redirect
            //Set Success Message and redirect
            $_SESSION['delete'] = "<div class='error'>Failed to delete Food</div>";
            //Redirect to manage category
            header('Location:' .SITEURL. '/admin/manage-food.php');
        }


        //Redirect to manage  Category Page with Message

    }
    else{
        //redirect to manage Food Page
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
        header('Location:' . SITEURL . 'admin/manage-food.php');

    }
?>