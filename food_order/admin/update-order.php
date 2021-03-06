<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br><br>
            <?php

            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset ($_SESSION['update']);
            }

            ?>
                    <br><br>

        <?php
            //check whether id is set or not
            if(isset($_GET['id']))
            {
                //get the order details
                $id=$_GET['id'];

                //get all the details based on this id
                //query to get the order deails
                $sql = "SELECT * FROM tbl_order WHERE id=$id";
                //execute query
                $res = mysqli_query($conn, $sql);
                //count rows
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //details availablve
                    $row=mysqli_fetch_assoc($res);

                        $food = $row['food'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $status = $row['status'];
                        $costumer_name = $row['costumer_name'];
                        $costumer_contact = $row['costumer_contact'];
                        $costumer_email = $row['costumer_email'];
                        $costumer_address = $row['costumer_address'];


                }
                else
                {
                    //redirect to manage order page
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
            }
            else
            {
                //redirect to manage order page
                header('location:'.SITEURL.'admin/manage-order.php');
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">

                <tr>
                    <td>Food Name</td>
                    <td><b><?php echo $food; ?></b></td>
                </tr>

                <tr>
                    <td>Price</td>
                    <td><b> $ <?php echo $price; ?></b></td>
                </tr>

                <tr>
                    <td>Qty</td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status">
                            <option <?php if($status=="Ordered"){echo "selected";} ?> value="Ordered">Ordered</option>
                            <option <?php if($status=="On Delivery"){echo "selected";} ?> value="On Delivery">On Delivery</option>
                            <option <?php if($status=="Delivered"){echo "selected";} ?> value="Delivered">Delivered</option>
                            <option <?php if($status=="Cancelled"){echo "selected";} ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Costumer Name: </td>
                    <td>
                        <input type="text" name="costumer_name" value="<?php echo $costumer_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Costumer Contact: </td>
                    <td>
                        <input type="text" name="costumer_contact" value="<?php echo $costumer_contact; ?>">
                    </td>
                </tr>
                
                <tr>
                    <td>Costumer Email: </td>
                    <td>
                        <input type="text" name="costumer_email" value="<?php echo $costumer_email; ?>">
                    </td>
                </tr>
                
                <tr>
                    <td>Costumer Address: </td>
                    <td>
                        <textarea name="costumer_address" cols="30" rows="5"><?php echo $costumer_address; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>

        <?php
            //chech whether update button is clicked or not
            if(isset($_POST['submit']))
            {
                //get all the valzes from form
                    $id = $_POST['id'];
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];

                    $total = $price * $qty;

                    $status = $_POST['status'];

                    $costumer_name = $_POST['costumer_name'];
                    $costumer_contact = $_POST['costumer_contact'];
                    $costumer_email = $_POST['costumer_email'];
                    $costumer_address = $_POST['costumer_address'];
                    
                //update all the values

                $sql2 = "UPDATE tbl_order SET
                    qty = $qty,
                    total = $total,
                    status = '$status',
                    costumer_name = '$costumer_name',
                    costumer_contact = '$costumer_contact',
                    costumer_email = '$costumer_email',
                    costumer_address = '$costumer_address'
                    WHERE id=$id
                ";
                    //execute query

                $res2 = mysqli_query($conn, $sql2);

                //redirect
                if($res2==TRUE)
                    {
                        //query executed and order saved
                        $_SESSION['update'] = "<div class='success text-center'>Order updated</div>";
                        header('location:'.SITEURL.'admin/manage-order.php');
                    }
                    else
                    {
                        //failed to save order
                        $_SESSION['update'] = "<div class='error text-center'>Order not updated</div>";
                        header('location:'.SITEURL.'admin/manage-order.php');
                    }

            }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>