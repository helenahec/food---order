     <?php 

          //incude constants.php file here
          include('../config/constants.php');
          //1.get the id of admin to be deleted
          $id = $_GET['id'];

          //2.create sql query to delete admin

          $sql = "DELETE FROM tbl_admin WHERE id=$id";

          //execute the query
          $res = mysqli_query($conn, $sql);

          //check whether the query executed successfully or nor
          if($res==TRUE)
          {
               //Session to display message
               $_SESSION['delete'] = "<div class='success'> Admin deleted successfully.</div>";
               //Redirect page to manage admin
               header("location:".SITEURL.'admin/manage-admin.php');
          }
          else
          {
          $_SESSION['delete'] ="<div class='error'> Failed</div>";
          //Redirect page to manage admin
          header("location:".SITEURL.'admin/manage-admin.php');
          }
          //3. redirect to manage admin page with maessage

     ?>
