<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LOGIN - ENPL</title>
    <link rel="stylesheet" href="<?php echo ASSETURL; ?>css/bundle.css?v=<?php echo VERSION; ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo ASSETURL; ?>css/app.min.css?v=<?php echo VERSION; ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo ASSETURL; ?>css/custom.min.css?v=<?php echo VERSION; ?>" type="text/css">
</head>
<body class="form-membership">
	<!-- begin::preloader-->
	<div class="preloader">
		<div class="preloader-icon"></div>
	</div>
	<!-- end::preloader -->
	<div class="form-wrapper">
		<!-- logo -->
		<div id="logo">
			<img src="<?php echo ASSETURL; ?>images/logo/group-logo.jpg" alt="group logo">
		</div>
		<!-- ./ logo -->
		<h5>Sign in</h5>
		<!-- form -->
		<?php if($this->session->flashdata('message')==1 && $this->session->flashdata('message')!=''): ?>
		<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Alert!</strong> Invalid Credentials
		</div>
		<?php endif; ?>
		<?php if($this->session->flashdata('message')==2 && $this->session->flashdata('message')!=''): ?>
		<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Alert!</strong> Your Account is Inactive. Contact admin
		</div>
		<?php endif; ?>
		<form method="post" action="<?php echo base_url(ADMINFOLDER.'login'); ?>">
			<div class="form-group">
				<input type="text" name="username" class="form-control" placeholder="Username or email" value="<?php echo set_value('username'); ?>" autofocus>
				<?php echo form_error('username' ,'<p class="error" style="text-align:left;margin:0;">','</p>'); ?>
			</div>
			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="Password">
				<?php echo form_error('password' ,'<p class="error" style="text-align:left;margin:0;">','</p>'); ?>
			</div>
			<div class="form-group d-flex justify-content-between">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" checked="" id="customCheck1">
					<label class="custom-control-label" for="customCheck1">Remember me</label>
				</div>
				<a href="recovery-password.html">Reset password</a>
			</div>
			<button class="btn btn-primary btn-block">Sign in</button>
		</form>
		<!-- ./ form -->
	</div>
	<script src="<?php echo ASSETURL; ?>js/bundle.js?v=<?php echo VERSION; ?>"></script>
	<script src="<?php echo ASSETURL; ?>js/app.min.js?v=<?php echo VERSION; ?>"></script>
</body>
</html>
