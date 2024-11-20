<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br>
        <br>
        <?php
            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>
                        Title:
                    </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Food">
                    </td>
                </tr>
                <tr>
                    <td>
                        Description:
                    </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td><input type="number" name="price"></td>
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
                        Category:
                    </td>
                    <td>
                        <select name="category">
                            <?php
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                $res = mysqli_query($conn, $sql);
                                $count = mysqli_num_rows($res);
                                //if count is greater than zero, we have categories ilse we donot have categories
                                if ($count > 0) {
                                    //we have categories
                                    while($row=mysqli_fetch_assoc($res)) {
                                        //Get the details of categories
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>

                                        <option value="<?php echo $id;  ?>"><?php echo $title; ?></option>
                                        <?php
                                    }
                                }
                                else{
                                    //We do not have category
                                    ?>
                                    <option value="0">No Category Found</option>
                                    <?php
                                }
                            ?>
                        </select>
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
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <?php
            //Check whether the button is clicked or not
            if(isset($_POST['submit'])){
                //Add the food in databsae
                //echo "Clicked";

                //Get the data from form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                //Check whether radion button for featured and active are checked or not
                if(isset($_POST['featured'])){
                    $featured = $_POST['featured'];

                }
                else
                {
                    $featured = "No";
                }
                if(isset($_POST['active'])){
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No"; //Setting Default Values
                }
                //Upload the image if selected

                //Check whether the select image is clicked or not and upload the image if the image is selected
                if(isset($_FILES['image']['name'])){
                    //Upload the image
                    //To upload image we need image name, source path and destination path

                    $image_name = $_FILES['image']['name'];

                    //Upload the Image only if image is selected
                    if($image_name !=""){

                        //Auto Rename our Image
                        //Get the extension of our image(jg, png, gif, etc) e.g. "food.jpg"
                        $image_info = explode('.', $image_name);
                        $ext = end($image_info);

                        //Rename the image
                        $image_name = "Food_Name_".rand(0000, 9999).'.'.$ext;


                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/food/".$image_name;

                        //Finally upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //Check whether the image is uploaded
                        //And if the image is not uploaded then we will stop the process and redirect with error message
                        if($upload==false){
                            //Set message
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";

                            //Redirect to add Category Page
                            header('location:'. SITEURL .'/admin/add-food.php');

                            //Stop the Process
                            die();
                        }
                    }
                }
                else{
                    $image_name = ""; //Setting default values as blank
                }
                //Insert into Database
                //Create a SQL Query to Save or Add food
                //For numerical valueswe do not need to pass values inside quotes '' But for string values it is compulsory to add quotes ''
                $sql2 = "INSERT INTO tbl_food SET
                title='$title',
                description='$description',
                price='$price',
                image_name='$image_name',
                category_id = $category,
                featured='$featured',
                active='$active'
                ";
                //Execute the query
                $res2 = mysqli_query($conn, $sql2);
                //Check whether data inserted or not
                //Redirect with message to Manage Food page
                if($res2 == true){
                    //Data inserted Successfully
                    $_SESSION['add'] = "<div class='success'>Food Added Successfully</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //Failed
                    $_SESSION['add'] = "<div class='error'>Failed to Add Food</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
            }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>