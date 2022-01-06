<?php include('partials/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Manage Order</h1>
            
            </br></br></br>
             <?php

            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset ($_SESSION['update']);
            }

            ?>

                        </br></br></br>


            <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Food</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Costumer Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
                <?php
                //get all the orders from database
                $sql = "SELECT * FROM tbl_order ORDER BY id DESC";
                //execute query
                $res = mysqli_query($conn, $sql);
                //count rows
                $count = mysqli_num_rows($res);

                $sn = 1; //create a serial number and set its inital value as 1

                if($count>0)
                {
                    //order available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //get all the order details
                        $id = $row['id'];
                        $food = $row['food'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $total = $row['total'];
                        $order_date = $row['order_date'];
                        $status = $row['status'];
                        $costumer_name = $row['costumer_name'];
                        $costumer_contact = $row['costumer_contact'];
                        $costumer_email = $row['costumer_email'];
                        $costumer_address = $row['costumer_address'];

                        ?>
                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo $food; ?></td>
                                <td><?php echo $price; ?></td>
                                <td><?php echo $qty; ?></td>
                                <td><?php echo $total; ?></td>
                                <td><?php echo $order_date; ?></td>
                                <td><?php echo $status; ?></td>
                                <td><?php echo $costumer_name; ?></td>
                                <td><?php echo $costumer_contact; ?></td>
                                <td><?php echo $costumer_email; ?></td>
                                <td><?php echo $costumer_address; ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update Order</a>
                                </td>
                            </tr>
                        <?php
                    }
                }
                else
                {
                    echo "<tr><td colspan='12' class='error'>Orders not available </td></tr>";
                }
                ?>
              
            </table>
        </div>
    </div>

<?php include('partials/footer.php'); ?>