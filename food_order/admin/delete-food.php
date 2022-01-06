<?php
    include('../config/constants.php');
    
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //Process to delete
        //get the value and delete

        //1. get id and image name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];


        //2.remove the image if available
        //check whether the image is available or not and delete only of available
        if($image_name != "")
        {
            // it has image and need to remove from folder
            //get the image path
            $path = "../images/food/".$image_name;
            //remove the image
            $remove = unlink($path);

            //if failed to remove image then add an error message and stop the process
            if($remove==false)
            {
                //set the session message
                $_SESSION['upload'] = "<div class='error'>Failed to remove Food Image.</div>";
                //redirect to manage category page
                header('location:'.SITEURL.'admin/manage-food.php');
                //stop the process
                die();
            }
        }

        //3. delete food from database

        $sql ="DELETE FROM tbl_food WHERE id=$id";
        //execute query
        $res = mysqli_query($conn, $sql);


    //4. redirect to manage food with session message
        if($res==true)
            {
                //set succes message and redirect 
                $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully</div>";
                //redirect to manage category
                header('location:'.SITEURL.'admin/manage-food.php');
            }
            else
            {
                //set failed message and redirect
                $_SESSION['delete'] = "<div class='error'>Food not Deleted </div>";
                //redirect to manage category
                header('location:'.SITEURL.'admin/manage-food.php');
            }

    }
    else
   {
       //redirect to manage food page
       $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
       header('location:'.SITEURL.'admin/manage-food.php');
   } 
?>