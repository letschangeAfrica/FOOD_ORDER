<?php include('partial-front/menu.php'); ?>
<!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <video autoplay loop muted>
            <source src="images/16406-271607438.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <div class="container">
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>
        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->
     <?php
            if(isset($_SESSION['order'])){
                echo $_SESSION['order'];  //Displaying Session Message
                unset($_SESSION['order']); //Removing Session Message
            }
        ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>
            <?php
                //Create Sql query to display categories from database
                $sql = "SELECT * FROM tbl_category WHERE active= 'Yes' AND featured= 'No' LIMIT 5";

                $res = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($res);

                if($count>0){
                    //Categories  available
                    while($row = mysqli_fetch_assoc($res))
                    {
                        //Get the values like title
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>

                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                                    <div class="box-3 float-container">
                                        <?php
                                        //Check whether image is available or not
                                            if($image_name==""){
                                                //Display Message
                                                echo "<div class='error'>Image not Available.</div>";
                                            }
                                            else{
                                                //Image Available
                                                ?>
                                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Quick Bites" class="img-responsive img-curve">
                                                <?php

                                            }
                                        ?>

                                        <h3 class="float-text text-white"><?php echo $title; ?></h3>
                                    </div>
                        </a>
                        <?php


                    }
                }
                else
                {
                    //Categories not available
                    echo "<div class='error'>Category not Added</div>";
                }

            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
            <?php
            //Getting food from database
            $sql2 = "SELECT * FROM tbl_food WHERE featured = 'Yes' LIMIT 6";
            $res2 = mysqli_query($conn, $sql2);
            $count2 = mysqli_num_rows($res2);
            if($count2> 0){
                while($row2 = mysqli_fetch_assoc($res2))
                {
                    $id = $row2["id"];
                    $title = $row2["title"];
                    $image_name = $row2["image_name"];
                    $price = $row2["price"];
                    $description = $row2["description"];
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
            else{
                echo "<div class='error'>Food not Available</div>";
            }
            ?>

            <div class="clearfix"></div>



        </div>

        <p class="text-center">
            <a href="foods.php">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->
     <?php include('partial-front/footer.php'); ?>