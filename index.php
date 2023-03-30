<?php
require 'main.php'; die();
require 'header.php'; 
?>
<style>
	body{
		height: 100%;
	}
</style>
<div class="container" style="margin:5% auto;">
	<div class="col-sm-4 col-md-3">
		<h2><?php echo $language['site_name']; ?></h2>
		<p><?php if(!empty($globals['sitedesc'])){ echo $globals['sitedesc']; }else{ echo $language['site_desc']; }?></p>
	</div>
	<div class="col-sm-5 col-md-4 pull-right">
		<div class="row">
		<div id="resDiv"></div>
		</div>
		<div class="row">
			<form method="POST" name="regForm" id="regForm" class="form-signin" action="functions/register.php">
					<h3 class="text-center">Signup Here!</h3>
				<input type="text" name="fname" placeholder="First Name"class="form-control" required>
				<input type="text" name="lname" placeholder="Last Name"class="form-control" required>
				<select class="form-control" name="gender"required>
					<option>Gender</option>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select>
				<input type="text" placeholder="Username" name="username" class="form-control" required onkeyup='ajax_call("./functions/register.php","regForm","resDiv","checkUser")'>
				<input type="password" placeholder="Password" name="password" class="form-control" required>
				<input type="submit" value="Signup" class="btn btn-success usr-btn" style="width:100%;">
			</form>
		</div>
	</div>
<?php //require 'footer.php'; ?>