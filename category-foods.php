<?php include('partial-front/menu.php'); ?>
<?php
    if(isset($_GET['category_id'])) {
        //Category id is set
        $category_id = $_GET['category_id'];
        //Get the category title based on category id
        $sql = "SELECT title FROM tbl_category WHERE id = $category_id";
        $res = mysqli_query($conn, $sql);
        //Get the value from database
        $row = mysqli_fetch_assoc($res);
        $category_title = $row['title'];

    }else
    {
        //Redirect to home page
        header('Location:' .SITEURL);
    }
?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
    <video class="bouncing-video" autoplay loop muted>
        <source src="images/16406-271607438.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

        <div class="container">

            <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
            <?php
                $sql2 = "SELECT * FROM tbl_food WHERE category_id = $category_id";
                $res2 = mysqli_query($conn, $sql2);
                //Get the value from database
                $count2 = mysqli_num_rows($res2);
                if($count2 > 0){
                    //Food is available
                    while($row2 = mysqli_fetch_assoc($res2)){
                        $id = $row2['id'];
                        $title = $row2['title'];
                        $price = $row2['price'];
                        $description = $row2['description'];
                        $image_name = $row2['image_name'];
                        ?>
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                    <?php
                                        if($image_name== ""){
                                            echo "<div class='error'>Image not Available</div>";
                                        }
                                        else
                                        {
                                            ?>
                                            <img src="<?php echo SITEURL;?>images/food/<?php echo $image_name; ?>" alt="Cookies" class="img-responsive img-curve">
                                            <?php

                                        }
                                    ?>
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price"><?php echo $price; ?> XAF</p>
                                <p class="food-detail">
                                <?php echo $description; ?>
                                </p>
                                <br>

                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>
                        <?php
                    }
                }
                else
                {
                    echo "<div class='error'>Food Not Available</div>";
                }
            ?>
            <div class="clearfix"></div>



        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partial-front/footer.php'); ?>