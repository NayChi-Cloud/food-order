<?php include('partials-front/menu.php'); ?>
    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
    


            <h2>Foods on Your Search <a href="#" 
            class="text-white"></a></h2>
</div>
        </section>
  <!-- Food Search Section End-->

  <!-- food menu Section start-->
<section class = "food-menu"> 
    <div class ="container">
        <h2 class = "text-center">Food Menu</h2>
  <?php
                        $search = $_POST['search'];

                //SQL query to get food based on search keyword
                $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

                $res = mysqli_query($conn,$sql);

                $count = mysqli_num_rows($res);

                if($count >0){
                    while($row=mysqli_fetch_assoc($res)){
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                        ?>
                    
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                            <?php 
                            //check if image is avaliable or not
                                if($image_name == ""){
                                    echo "<div class='error'>Image Not Avaliable.</div>";

                                }else{
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                    <?php
                                }
                                ?>
                   

                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">$<?php echo $price; ?></p>
                                <p class="food-detail">
                                    <?php echo $description; ?>
                                </p>
                                <br>

                                <a href="#" class="btn btn-primary">Order Now</a>
                            </div>

                        <?php
                    }

                }else{
                    echo "<div class='error'>Food Not Found.</div>";
                }
                ?>
        
            <div class="clearfix"></div>

            </div>

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>