<?php

    include('../config/constants.php'); 

    //whether the id and image_name value are being passed or not

        if(isset($_GET['id']) AND isset($_GET['image_name']))
        {
            //get the value and delete
            $id = $_GET['id'];
            $image_name = $_GET['image_name'];

            //remove the physical image file if available
            if($image_name != "")
            {
                //image is available so remove it
                $path = "../images/category/".$image_name;
                //remove the image
                $remove = unlink($path);

                //if failed to remove image then add an error message and stop the process
                if($remove==false)
                {
                    //set the session message
                    $_SESSION['remove'] = "<div class='error'>Failed to remove Category Image.</div>";
                    //redirect to manage category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                    //stop the process
                    die();
                }
            }

            //delete data from db
            //sql query to delete data from db
            $sql = "DELETE FROM tbl_category WHERE id=$id";

            //execute query
            $res = mysqli_query($conn, $sql);

            //check whether the data is deleted from db or not
            if($res==true)
            {
                //set succes message and redirect 
                $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully</div>";
                //redirect to manage category
                header('location:'.SITEURL.'admin/manage-category.php');
            }
            else
            {
                //set failed message and redirect
                $_SESSION['delete'] = "<div class='error'>Category not Deleted </div>";
                //redirect to manage category
                header('location:'.SITEURL.'admin/manage-category.php');
            }

            //redirect to manage category page with message


        }
        else
        {
            //redirect to manage category page
            header('location:'.SITEURL.'admin/manage-category.php');
        }

?>