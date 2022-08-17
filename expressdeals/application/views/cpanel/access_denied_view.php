<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $title ?></title>
	<link rel="stylesheet" href="<?php echo ASSETURL; ?>css/bundle.css?v=<?php echo VERSION; ?>" type="text/css">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo ASSETURL; ?>css/prism.css?v=<?php echo VERSION; ?>" type="text/css">
	<link rel="stylesheet" href="<?php echo ASSETURL; ?>css/app.min.css?v=<?php echo VERSION; ?>" type="text/css">
	<link rel="stylesheet" href="<?php echo ASSETURL; ?>css/custom.min.css?v=<?php echo VERSION; ?>" type="text/css">
</head>
<body class="error-page">
<div>
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <img class="img-fluid" src="<?php echo ASSETURL; ?>images/404.svg" alt="...">
            <h3>Page : <?php echo urldecode($menuname); ?></h3>
            <p class="text-muted">You don't have permission to accesss this page.</p>
            <a href="<?php echo base_url(ADMINFOLDER.'home') ?>" class="btn btn-primary">Home Page</a>
        </div>
    </div>
</div>
<script src="<?php echo ASSETURL; ?>js/bundle.js?v=<?php echo VERSION; ?>"></script>
<script src="<?php echo ASSETURL; ?>js/daterangepicker.js?v=<?php echo VERSION; ?>"></script>
<script src="<?php echo ASSETURL; ?>js/datatables.min.js?v=<?php echo VERSION; ?>"></script>
<script src="<?php echo ASSETURL; ?>js/prism.js?v=<?php echo VERSION; ?>"></script>
<script src="<?php echo ASSETURL; ?>js/app.min.js?v=<?php echo VERSION; ?>"></script>
</body>
</html>
 