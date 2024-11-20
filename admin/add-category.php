<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>
        <?php
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }
                if(isset($_SESSION['upload'])){
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }
        ?>
        <br>

        <!-- Add Category Form Starts -->

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>
                        Title:
                    </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>
                <tr>
                    <td>
                        Select Image:
                    </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>
                        Featured:
                    </td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>
                        Active:
                    </td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
         <!-- Add Category Form Ends -->

         <?php
         //Check whethe the submit button is clicked or not

         if(isset($_POST['submit'])){
            //echo "Clicked";

            //Get value from the category form
            $title = $_POST['title'];

            //Check if the button is selected or not
            if(isset($_POST['featured'])){
                //Get the value from the category form
                $featured = $_POST['featured'];

            }
            else
            {
                //Set the default value
                $featured = "No";
            }

            if(isset($_POST['active'])){
                //Get the value from the category form
                $active = $_POST['active'];

            }
            else
            {
                //Set the default value
                $active = "No";
            }

            //Check whether the image is selected or not
                //print_r($_FILES['image']);
                //die(); //Break the code here
                if(isset($_FILES['image']['name'])){
                    //Upload the image
                    //To upload image we need image name, source path and destination path

                    $image_name = $_FILES['image']['name'];

                    //Upload the Image only if image is selected
                    if($image_name !=""){

                        //Auto Rename our Image
                        //Get the extension of our image(jg, png, gif, etc) e.g. "food.jpg"
                        $image_info =explode('.', $image_name);
                        $ext = end($image_info);

                        //Rename the image
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext;
                        

                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/category/".$image_name;

                        //Finally upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //Check whether the image is uploaded
                        //And if the image is not uploaded then we will stop the process and redirect with error message
                        if($upload==false){
                            //Set message
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";

                            //Redirect to add Category Page
                            header('location:'. SITEURL .'/admin/add-category.php');

                            //Stop the Process
                            die();
                        }
                    }
                }
                else
                {
                    //Don't upload the image
                    $image_name = "";
                }

            // Create SQL Query to insert category into Database
            $sql = "INSERT INTO tbl_category SET
                title='$title',
                image_name='$image_name',
                featured='$featured',
                active='$active'
                ";


            //Execute SQL Query and save in Database
            $res = mysqli_query($conn, $sql);

            //Check whether the query is executed or not and data added or not
            if($res == True){
                // Query executed and category added
                $_SESSION['add'] = "<div class='success'>Category Added Successfully</div>";
                //Redirect to manage category page
                header('location:'. SITEURL .'/admin/manage-category.php');
            }
            else{ 
                 //Failed to add Category
                 $_SESSION['add'] = "<div class='error'>Failed to Add Category</div>";
                //Redirect to manage category page
                header('location:'. SITEURL .'/admin/add-category.php');

            }

         }
         ?>

    </div>
</div>






<?php include('partials/footer.php'); ?>