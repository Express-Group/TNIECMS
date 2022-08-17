 <?php
 $FileName= $this->uri->segment(4).'.json';
 $path=FCPATH.'application/views/LIVENOW/';
 if(file_exists($path.$FileName)){
	 $File=file_get_contents($path.$FileName);
	 $File=array_reverse(json_decode($File,true));
 }
 ?>
<script type="text/javascript" src="<?php print HOMEURL ?>js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php print HOMEURL ?>js/w2ui-fields-1.0.min.js"></script>
<link href="<?php print HOMEURL ?>css/admin/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php print HOMEURL ?>css/admin/w2ui-fields-1.0.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>
.BodyHeadBg{position:absolute !important;margin-bottom:5%;margin-left: 7%;float: left;width: 87%;}
.posts{width: 100%;float: left;padding: 2%;background: #eeeeee70;}
.inner-post{float: left;width: 100%;background: #fff;padding: 1.5%;border-radius: 8px;border: 1px solid #eee;margin-bottom: 20px;position:relative;}
.post-title{margin: 0;float:left;width:100%;}
.post-title span{background: green;color: #fff;padding: 3px 10px 3px;margin-right: 9px;border-top-right-radius: 8px;    border-bottom-left-radius: 8px;display: inline-block;}
.inner-post hr{float: left;width: 100%;margin: 11px 0 4px;border-top: 1px solid #e7e7e7;}
.inner-post .edit{position: absolute;top: 0px;right: -5px;background: green;color: #fff;border-radius: 0;border-top-right-radius: 8px;}
.inner-post .delete{right: 33px;border-radius: 0;border-bottom-left-radius: 8px;border-right: 0px solid #fff;background: green;position: absolute;top: 0px;color: #fff;}
</style>
<div class="BodyHeadBg Overflow clear" style="margin-left:7%;">
	<div class="FloatLeft BreadCrumbsWrapper ">
		<div class="breadcrumbs">Dashboard &gt; Livenow Edit</div>
 		<h2>Livenow</h2>
	</div>
	<div class="container-fluid" style="margin-top:8%;">
	<div class="row-fluid">
		<div class="col-md-12">
			<div class="posts">
				<?php
				$Data=$File['details'];
				foreach($Data as $DataValue){
					echo '<div class="inner-post">';
					echo '<h4 class="post-title"><span>Title </span>'.$DataValue['title'].'</h4><hr>';
					echo '<div style="margin: 10px 0 0;font-size: 16px;line-height: 1.5;" class="post-title"><span style="margin-bottom: 10px;font-size: 18px;">Content </span>'.$DataValue['content'].'</div>';
					echo '<button class="btn edit"><i class="fa fa-pencil" aria-hidden="true"></i></button>';
					echo '<button class="btn delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
					echo '</div>';
				}
				?>
			</div>
		</div>
	</div>
</div>		             
</div>
 