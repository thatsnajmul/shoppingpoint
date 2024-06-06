<?php include 'inc/header.php';?>
<?php
	$login = Session::get("custlogin");
	if ($login == false) {
		header("Location:login.php");
	}
?>
<style>
    .psuccess{
        width: 500px;
        min-height: 200px;
        text-align: center;
        border: 1px solid #ddd;
        margin: 0 auto;
        padding: 20px;
    }
    .psuccess h2{
        border-bottom: 1px solid #ddd;
        margin-bottom: 20px;
        padding-bottom: 10px;
    }
    .psuccess p{
        line-height: 25px;
        text-align: left;
        font-size: 18px;

    }
</style>
 <div class="main">
    <div class="content">
         <div class="section group">
            <div class="psuccess">
                <h2>Success</h2>
                <?php
                    $cmrId = Session::get("cmrId");
                    $amount = $ct->payableAmount($cmrId);
                    $sum = 0; 
                    if ($amount) {               
                        while ($result = $amount->fetch_assoc()) {
                            $price = $result['price'];
                            $sum = $sum+$price;
                        }
                    }
                ?>
                <p style="color:red;">Total Payable Amount(Including Vat) : $
                    <?php
                        $vat = $sum * 0.1;
                        $total = $sum+$vat;
                        echo $total;
                    ?>
                </p>
                <p>Thanks for Purchase. Receive Your Order Successfully. We Will contact as soon as possible with delivery details. Here is your order details.....<a href="orderdetails.php">Visit Here..</a></p>
            </div>
        </div>
 	</div>
	</div>
	<?php include 'inc/footer.php';?>