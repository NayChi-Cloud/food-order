<?php include('partials-front/menu.php'); ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
                //Display all the category that are active
                $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' ";
                
                //Execute the queery
                $res= mysqli_query($conn,$sql);
                
                //Count rows to check whether the category is avalible or not
                $count = mysqli_num_rows($res);
                
                if($count > 0){
                    while($row=mysqli_fetch_assoc($res))
                    {
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>

                        <a href="category-foods.html">
                            <div class="box-3 float-container">
                                <?php
                                    if($image_name==""){
                                        //Image Not Shown
                                        echo "<div class='error'>Image Not Found.</div>";
                                    
                                    }else
                                    {//Image Avaliable
                                        ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" 
                                        alt="Pizza" class="img-responsive img-curve">
                                        <?php
                                    }
                                    ?>
                              
                                <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                        </a>
                        <?php
                    }
                }
                else{
                    echo "<div class='error'>Category Not Added.</div>";
                }
                ?>
            

           
            

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <?php include ('partials-front/footer.php'); ?>

    