<?php include 'inc/header.php';?>
<?php
	$login = Session::get("custlogin");
	if ($login == false) {
		header("Location:login.php");
	}
?>
<style>
    .payment{
        width: 500px;
        min-height: 200px;
        text-align: center;
        border: 1px solid #ddd;
        margin: 0 auto;
    }
    .payment h2{
        border-bottom: 1px solid #ddd;
        margin-bottom: 80px;
        padding-bottom: 10px;
    }
    .payment a{
        background: #ff0000;
        color: #fff;
        font-size: 25px;
        padding: 5px 30px;
        border-radius: 3px;
    }
    .back a{
        width: 160px;
        margin: 5px auto 0;
        padding: 7px 0px;
        font-size: 25px;
        text-align: center;
        display: block;
        background: #555;
        border: 1px solid #333;
        color: fff;
        border-radius: 3px;
    }
</style>
 <div class="main">
    <div class="content">
         <div class="section group">
            <div class="payment">
                <h2>Choose Your Payment Option</h2>
                <a href="paymetoffline.php">Offline Payment</a>
                <a href="paymentoffline.php">Online Payment</a>
            </div>
            <div class="back">
                <a href="cart.php">Previous</a>
            </div>
        </div>
 	</div>
	</div>
	<?php include 'inc/footer.php';?>