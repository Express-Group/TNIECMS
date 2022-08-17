<?php
$section_img_path ='';
$width ='';
$height ='';
$index = '';
$follow = '';
$canonical = ($data['isHome']==1) ? base_url() : base_url($sectionDetails['section_full_path']);
$title = ($data['isArticle']==1) ? strip_tags($articleDetails['title']) : strip_tags($sectionDetails['meta_title']);
$metaTitle = ($data['isArticle']==1) ? strip_tags($articleDetails['meta_title']) : strip_tags($sectionDetails['meta_title']);
$metaDescription = ($data['isArticle']==1) ? strip_tags($articleDetails['meta_description']) : strip_tags($sectionDetails['meta_description']);
$metaKeywords = ($data['isArticle']==1) ? trim($articleDetails['tags']) : trim($sectionDetails['meta_keywords']);
if($data['isArticle']==1){
	$width = 450;
	$height = 298;
	$imageDetails['status'] = 0;
	if($articleDetails['image_path']!=''){
		$imageDetails = hasImage($articleDetails['image_path']);
	}
	if($imageDetails['status']==1){
		$section_img_path = ASSETURL.IMAGE_PATH. str_replace('original/' ,'medium/' , $articleDetails['image_path']);
	}else{
		$section_img_path = ASSETURL.'images/logo/medium.jpg';
	}
	$canonical = base_url($articleDetails['url']);
}
if($data['isHome']==1 || ($data['isHome']==0 && $data['isArticle']==0)){
	$width = 600;
	$height = 300;
	if($sectionDetails['image']!=''){
		$section_img_path = ASSETURL.'images/section/'.$sectionDetails['image'];
	}else{
		$section_img_path = ASSETURL.'images/logo/medium.jpg';
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $title; ?> | TNIE</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="title" content="<?php echo $metaTitle; ?>" />
	<meta name="description" content="<?php echo $metaDescription;?>">
	<meta name="keywords" content="<?php echo $metaKeywords;?>">
	<meta name="news_keywords" content="<?php echo $sectionDetails['meta_keywords'];?>">
	<link rel="canonical" href="<?php echo $canonical;?>" />
	<meta property="fb:pages" content="" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="<?php echo $title;?>"/>
	<meta property="og:image" content="<?php echo $section_img_path;?>"/>
	<meta property="og:image:width" content="<?php echo $width; ?>"/>
    <meta property="og:image:height" content="<?php echo $height; ?>"/>
	<meta property="og:site_name" content="The New Indian Express"/>
	<meta property="og:description" content="<?php echo $metaDescription;?>"/>
	<meta name="twitter:card" content="summary_large_image" /> 
	<meta name="twitter:creator" content="NewIndianXpress" />
	<meta name="twitter:site" content="@newindianexpress.com" />
	<meta name="twitter:title" content="<?php echo $title;?>" />
	<meta name="twitter:description" content="<?php echo $metaDescription;?>" />
	<meta name="twitter:image" content="<?php echo $section_img_path;?>" />
	<meta name="robots" content="<?php echo $index;?>, <?php echo $follow;?>">
	<link rel="stylesheet" href="<?php echo MAINASSETURL;?>css/bootstrap.min.css?v=<?php echo MAIN_VERSION;?>">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo MAINASSETURL;?>css/style.css?v=<?php echo MAIN_VERSION;?>">
	<script type="text/javascript" rel="stylesheet" href="<?php echo MAINASSETURL;?>js/jquery-3.5.1.min.js?v=<?php echo MAIN_VERSION;?>"></script>
	<script type="text/javascript" rel="stylesheet" href="<?php echo MAINASSETURL;?>js/bootstrap.min.js?v=<?php echo MAIN_VERSION;?>"></script>
	<script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
  <script>
    window.googletag = window.googletag || {cmd: []};
    googletag.cmd.push(function() {
      googletag
          .defineSlot(
              '/3167926/NIE_STG_DFP_300x250', [300, 250], 'div-gpt-ad-1588064667642-0')
          .addService(googletag.pubads());
      googletag.enableServices();
    });
  </script>
</head>
<body>
<?php echo $html; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script>
<script type="text/javascript">
$(function() {
        $('.lazy-loaded').Lazy();
    });
</script>
</body>
</html>