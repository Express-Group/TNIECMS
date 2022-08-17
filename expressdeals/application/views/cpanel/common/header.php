<?php
$userdata = $this->session->userdata('userdata');
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $title ?></title>
		<link rel="shortcut icon" href="<?php echo ASSETURL; ?>images/favicon.ico" type="image/x-icon" />
		<link rel="stylesheet" href="<?php echo ASSETURL; ?>css/bundle.css?v=<?php echo VERSION; ?>" type="text/css">
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo ASSETURL; ?>css/daterangepicker.css?v=<?php echo VERSION; ?>" type="text/css">
		<link rel="stylesheet" href="<?php echo ASSETURL; ?>css/datatables.min.css?v=<?php echo VERSION; ?>" type="text/css">
		<link rel="stylesheet" href="<?php echo ASSETURL; ?>css/nestable.css?v=<?php echo VERSION; ?>" type="text/css">
		<link rel="stylesheet" href="<?php echo ASSETURL; ?>css/jquery-ui.css?v=<?php echo VERSION; ?>" type="text/css"> 
		<link rel="stylesheet" href="<?php echo ASSETURL; ?>css/prism.css?v=<?php echo VERSION; ?>" type="text/css">
		<?php if($this->uri->segment(3)=='article' && ($this->uri->segment(4)=='add' || $this->uri->segment(4)=='edit')): ?>
		<link rel="stylesheet" href="<?php echo ASSETURL; ?>css/bootstrap-tagsinput.css?v=<?php echo VERSION; ?>" type="text/css">
		<?php endif; ?>
		<?php if($this->uri->segment(2)=='image_library'): ?>
		<link rel="stylesheet" href="<?php echo ASSETURL; ?>css/dropzone.css?v=<?php echo VERSION; ?>" type="text/css">
		<link rel="stylesheet" href="<?php echo ASSETURL; ?>css/cropper.css?v=<?php echo VERSION; ?>" type="text/css">
		<?php endif; ?>
		<link rel="stylesheet" href="<?php echo ASSETURL; ?>css/app.min.css?v=<?php echo VERSION; ?>" type="text/css">
		<link rel="stylesheet" href="<?php echo ASSETURL; ?>css/custom.min.css?v=<?php echo VERSION; ?>" type="text/css">
		<script>var ADMINFOLDER = '<?php echo ADMINFOLDER; ?>';var BASEURL = '<?php echo base_url(); ?>';</script>
	</head>
	<body>
		<!-- Preloader -->
		<div class="preloader">
			<div class="preloader-icon"></div>
			<span>Loading...</span>
		</div>
		<!-- ./ Preloader -->
		<!-- Layout wrapper -->
		<div class="layout-wrapper">
			<!-- Header -->
			<div class="header d-print-none">
				<div class="header-container">
					<div class="header-left">
						<div class="navigation-toggler">
							<a href="#" data-action="navigation-toggler">
								<i data-feather="menu"></i>
							</a>
						</div>
						<div class="header-logo">
							<a href="<?php echo base_url(ADMINFOLDER.'home') ?>">
								<!--<img class="logo" src="<?php echo ASSETURL; ?>images/logo/logo.png" alt="logo">-->
								<h4 style="color: #fff !important;font-weight: 700;margin: 23px 0 0;text-transform: uppercase;line-height: 1.5;text-align: center;">ENPL affiliate <br> marketing</h4>
							</a>
						</div>
					</div>
					<div class="header-body">
						<div class="header-body-left">
							<ul class="navbar-nav">
								<li class="nav-item mr-3">
									<div class="header-search-form">
										<form>
											<div class="input-group">
												<div class="input-group-prepend">
													<button class="btn">
														<i data-feather="search"></i>
													</button>
												</div>
												<input type="text" class="form-control" placeholder="Search">
												<div class="input-group-append">
													<button class="btn header-search-close-btn">
														<i data-feather="x"></i>
													</button>
												</div>
											</div>
										</form>
									</div>
								</li>
							</ul>
						</div>
						<div class="header-body-right">
							<ul class="navbar-nav">
								<li class="nav-item dropdown d-none d-md-block">
									<a href="#" class="nav-link" title="Fullscreen" data-toggle="fullscreen">
										<i class="maximize" data-feather="maximize"></i>
										<i class="minimize" data-feather="minimize"></i>
									</a>
								</li>
								<li class="nav-item dropdown">
									<a href="#" class="nav-link" title="Settings" data-sidebar-target="#settings">
										<i data-feather="settings"></i>
									</a>
								</li>
								<li class="nav-item dropdown">
									<a href="#" class="nav-link dropdown-toggle" title="User menu" data-toggle="dropdown">
										<figure class="avatar avatar-sm">
											<img src="<?php echo ASSETURL; ?>images/man_avatar3.jpg"class="rounded-circle"
                                         alt="avatar">
										</figure>
										<span class="ml-2 d-sm-inline d-none"><?php echo ucwords($userdata['firstname'].' '.$userdata['lastname']); ?></span>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-big">
										<div class="text-center py-4">
											<figure class="avatar avatar-lg mb-3 border-0">
												<img src="<?php echo ASSETURL; ?>images/man_avatar3.jpg"
                                             class="rounded-circle" alt="image">
											</figure>
											<h5 class="text-center"><?php echo ucwords($userdata['firstname'].' '.$userdata['lastname']); ?></h5>
											<div class="mb-3 small text-center text-muted">@<?php echo $this->session->userdata('username'); ?></div>
											<a href="#" class="btn btn-outline-light btn-rounded">Manage Your Account</a>
										</div>
										<div class="list-group">
											<a href="profile.html" class="list-group-item">View Profile</a>
											<a href="<?php echo base_url(ADMINFOLDER.'logout'); ?>" class="list-group-item text-danger"
                                       >Sign Out!</a>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
					<ul class="navbar-nav ml-auto">
						<li class="nav-item header-toggler">
							<a href="#" class="nav-link">
								<i data-feather="arrow-down"></i>
							</a>
						</li>
					</ul>
			</div>
		</div>
		<!-- ./ Header -->
		<!-- Content wrapper -->
		<div class="content-wrapper">
			<!-- begin::navigation -->
			<div class="navigation">
				<div class="navigation-header">
					<span>Navigation</span>
					<a href="#"><i class="ti-close"></i></a>
				</div>
				<div class="navigation-menu-body">
					<ul>
						<?php
						$menus = get_menu();
						foreach($menus as $menu):
							if($menu->parent_id==null){
								echo '<li>';
								echo '<a class="'.(($menu->menu_link==$this->uri->segment(2) && $this->uri->segment(3)!='notes') ? 'active' : '').'" href="'.base_url(ADMINFOLDER.$menu->menu_link).'">'.$menu->menu_description.$menu->menu_name.'</span></a>';
								echo get_submenu($menu->mid , $menus);
								echo '</li>';
							}
						endforeach;
						?>
						
						<!--<li>
							<a href="">
								<span class="nav-link-icon"><i data-feather="shopping-cart"></i></span><span>E-commerce</span>
							</a>
							<ul>
								<li><a href="">Orders</a></li>
								<li><a href="">Orders</a></li>
								<li><a href="">Orders</a></li>
							</ul>
						</li>-->
					</ul>
				</div>
			</div>
			<!-- end::navigation -->
			<!-- Content body -->
				<div class="content-body">
