<?php include('partials/menu.php'); ?>

<?php

    //check whether id is set or not
    if(isset($_GET['id']))
    {
        //get all the details
        $id = $_GET['id'];

        //sql query to get the selected food
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

        //execute the query
        $res2 = mysqli_query($conn, $sql2);

        //get tge value based on query executed
        $row2 = mysqli_fetch_assoc($res2);

        //get the individual values of selected food
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
              
    }
    else
    {
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        </br></br>

         <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title ?>">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" value="<?php echo $description; ?>"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php 
                            if($current_image !=  "")
                            {
                                //display the image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                                <?php
                            }
                            else
                            {
                                //display message
                                echo "<div class='error'>Image not Added.</div>";                          
                            }
                        ?>          
                    </td>
                </tr>

                <tr>
                    <td>Select New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php 
                                //query to get active categories
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                //execute the query
                                $res = mysqli_query($conn, $sql);

                                $count = mysqli_num_rows($res);

                                //check whether category available or not
                                if($count>0)
                                {
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        $category_title = $row['title'];
                                        $category_id = $row['id'];
                                        
                                        ?>
                                        <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?>
                                        <?php
                                       
                                    }
                                }
                                else
                                {
                                    echo "<option value='0'>Not available</option>";
                                }
                            ?>
                            
                            <option value="0">Test Category</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes

                        <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes

                        <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php

            if(isset($_POST['submit']))
            {
                //1. Get all the values from our form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2. updating new image if selected
                //check whether the image is selected or not
                if(isset($_FILES['image']['name']))
                {
                    //get the image details
                    $image_name = $_FILES['image']['name'];

                    //check whether the image is available or not
                    if($image_name != "")
                    {
                        //image available
                        //A.upload the new image
                        //auto rename our image
                        //get the extension of our image (jpg, png, gif, etc) e.g. "special.food1.jpg"
                            $ext = end(explode('.', $image_name));

                            //rename the image
                            $image_name = "Food-Name-".rand(0000, 9999).'.'.$ext; //e.g. Food_Category_734.jpg

                            $src_path = $_FILES['image']['tmp_name'];
                            $dest_path = "../images/food/".$image_name;

                            //upload the image
                            $upload = move_uploaded_file($src_path, $dest_path);

                            //check whether the image is uploaded or not
                            //and if image is not uploaded then we will stop the process and redirect with error message
                            if($upload==false)
                            {
                                //set message
                                $_SESSION['upload'] = "<div class='error'>Failed to upload Image. </div>";
                                //redirect to add category page
                                header('location:'.SITEURL.'admin/manage-food.php');
                                //stop process
                                die();
                            }

                        //B. remove the current image if available
                        if($current_image!="")
                        {
                            $remove_path = "../images/food/".$current_image;

                            $remove = unlink($remove_path);
    
                            //check whether the image is removed or not
                            //if failed to remove then display message and stop the process
                            if($remove==false)
                            {
                                //failed to remove the image
                                $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image.</div>";
                                header('location:'.SITEURL.'admin/manage-food.php');
                                die();//stop the process
                            }
                        }
                        
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }

                //3. update the database
                $sql3 = "UPDATE tbl_food SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = '$category',
                featured = '$featured',
                active = '$active'
                WHERE id=$id
                ";

                //execute query
                $res3 = mysqli_query($conn, $sql3);

                //4. redirect to manage category with message
                //check whether executed or not
                if($res3==true)
                {
                    //category updated
                    $_SESSION['update'] = "<div class='success'>Food updated sucessfully</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //failed to update category
                    $_SESSION['update'] = "<div class='error'>Failed to update Food</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

            }
        ?>

    </div>
</div>
<?php include('partials/footer.php'); ?>