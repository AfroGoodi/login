<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>

<?php
	if(!empty($_POST["save"])) {
	    $conn = mysqli_connect("localhost","root","", "registration");
		$itemCount = count($_POST["item_name"]);
		$itemValues=0;
		$query = "INSERT INTO item (item_name,item_price) VALUES ";
		$queryValue = "";
		for($i=0;$i<$itemCount;$i++) {
			if(!empty($_POST["item_name"][$i]) || !empty($_POST["item_price"][$i])) {
				$itemValues++;
				if($queryValue!="") {
					$queryValue .= ",";
				}
				$queryValue .= "('" . $_POST["item_name"][$i] . "', '" . $_POST["item_price"][$i] . "')";
			}
		}
		$sql = $query.$queryValue;
		if($itemValues!=0) {
		    $result = mysqli_query($conn, $sql);
			if(!empty($result)) $message = "Added Successfully.";
		}
	}
?>



<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">


	<LINK href="style1.css" rel="stylesheet" type="text/css" />
	
</head>
<body>

<div class="header">
	<h2>Home Page</h2>
</div>
<div class="content">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
    	<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
		
    	<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?>
</div>



		<FORM name="frmProduct" method="post" action="">
		<DIV id="outer">
		<DIV id="header">
		<DIV class="float-left">&nbsp;</DIV>
		<DIV class="float-left col-heading">Item Name</DIV>
		<DIV class="float-left col-heading">Item Price</DIV>
		</DIV>
		<DIV id="product">
		<?php require_once("input.php") ?>
		</DIV>
		<DIV class="btn-action float-clear">
		<span class="success"><?php if(isset($message)) { echo $message; }?></span>
		</DIV>
		<DIV class="footer">
		<input type="submit" name="save" value="Save" />
		</DIV>
		</DIV>
		</form>




</body>
</html>