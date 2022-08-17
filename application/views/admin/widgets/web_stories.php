<?php
$webStoriesSection = "SELECT s.Sectionname , w.section_id FROM webstories_master AS w INNER JOIN sectionmaster AS s ON w.section_id = s.Section_id GROUP BY w.section_id ORDER BY s.Sectionname ASC";
if(!$this->memcached_library->get($webStoriesSection) && $this->memcached_library->get($webStoriesSection) == ''){
	$sectionList  = $this->db->query($webStoriesSection)->result();	
	$this->memcached_library->add($webStoriesSection,$sectionList);
}else{
	$sectionList = $this->memcached_library->get($webStoriesSection);
}
?>
<style>

.TopicBack{background-color: #09155e; padding: 3px 6px; border-radius: 5px;}
.accordion .panel-title::before, .ask-p::before, .topic::before{content: none;}

.webstories-section{width:100%;float:left;margin:2% 0 2%;}
.webstories-section h2{margin-right:10px; font-family: 'Roboto Condensed',sans-serif!important; text-transform: uppercase;}
.webstories-list{width:100%;float:left;}
.webstories-list-title{font-family: 'Roboto Condensed',sans-serif!important;font-weight: 500;text-transform: uppercase;float: left;   width: 100%;}
.webstories-list-title a{color: #09155e;width: auto;display: inline-block;font-weight: bold;}
.webstories-list-title a::after{content:'';width: 60%;display: block;border-bottom: 3px solid #201e1f; margin-top: 5px;}
.webstories-list ul{display: flex;width: 100%;}
.webstories-list ul li{transition: box-shadow .3s ease-out,transform .3s ease-out;overflow: hidden;    background: #fff;box-shadow: 0 0 8px 0 rgb(53 53 53 / 18%);border-radius: 6px;display: flex;flex-direction: column;margin-bottom: 25px;border: 1px solid transparent;position: relative;float: left;width: 225px;margin-left: 15px;}
.webstories-list ul li:nth-child(4n+1){margin-left: 0;}
.webstories-list ul li img{width: 223px;height: 297px;object-fit: cover;}
.webstories-list ul li p{font-size: 16px;padding: 10px 15px 10px;font-weight: 700;margin:0; font-family: 'Roboto Condensed',sans-serif!important; color: #000;}
.webstories-list ul li span{padding: 0px 15px 10px;display: block;color: #919090; font-family: 'Roboto Condensed',sans-serif!important;}
.webstories-icon{width: 30px !important;height: auto !important;position: absolute;top: 7px;right: 7px;}

@media only screen and (max-width: 768px){
	.webstories-list ul{display: block;width: 76%;float: left;padding: 0;margin: 0 12%;}
	.webstories-list ul li{width: 100%;margin-left: 0;}
	.webstories-list ul li:nth-child(4n+1){margin-left: 0;}
	.webstories-list ul li img{width:100%;}
	.webstories-list ul li p{font-size: 20px;}
	.webstories-list ul li span{font-size: 17px;}
}
</style>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="webstories-section">
		<h2 class="TopicBack topic" <?php if($this->input->get('id')==''){ echo ' style="background-color: black;"'; }?> > <a href="<?php echo current_url(); ?>" style="color:#fff;">ALL</a></h2>
		<?php
		foreach($sectionList as $section){
			echo '<h2 class="TopicBack topic" '.(($section->section_id==$this->input->get('id'))?' style="background-color: black;"' :'').'><a href="'.current_url().'?id='.$section->section_id.'" style="color:#fff;">'.$section->Sectionname.'</a></h2>';
		}
		?>
		</div>
		<hr style="width: 100%;float: left;margin-top: 0;border-top: 2px solid #201e1f;">
		<?php if($this->input->get('id')==''):?>
		<div class="webstories-list">
		<?php
		foreach($sectionList as $section){
			$getStories = "SELECT url, title, poster_image, modified_on FROM webstories_master WHERE section_id='".$section->section_id."' AND status=1 ORDER BY modified_on DESC LIMIT 3";
			if(!$this->memcached_library->get($getStories) && $this->memcached_library->get($getStories) == ''){
				$getStoriesList  = $this->db->query($getStories)->result();	
				$this->memcached_library->add($getStories,$getStoriesList);
			}else{
				$getStoriesList = $this->memcached_library->get($getStories);
			}
			echo '<h4 class="webstories-list-title"><a href="'.current_url().'?id='.$section->section_id.'">'.$section->Sectionname.'</a></h4>';
			echo '<ul>';
			foreach($getStoriesList as $stories){
				echo '<li>';
				echo '<a target="_BLANK" href="'.BASEURL.$stories->url.'">';
				echo '<img src="'.image_url.imagelibrary_image_path.'logo/nie_logo_600X300.jpg" data-src="'.image_url.'images/webstories/poster_image/'.$stories->poster_image.'">';
				echo '<p>'.$stories->title.'</p>';
				echo '<span>'.time_elapsed_string($stories->modified_on).'</span>';
				echo '<img class="webstories-icon" src="'.image_url.'images/webstories/webstories-icon.png">';
				echo '</a>';
				echo '</li>';
			}
			echo '</ul>';
		}
		?>
		</div>
		<?php else: ?>
		<div class="webstories-list">
		<?php
		$id = trim($this->input->get('id'));
		$getStories = "SELECT url, title, poster_image, modified_on FROM webstories_master WHERE section_id='".$id."' AND status=1 ORDER BY modified_on DESC LIMIT 0 ,6";
		if(!$this->memcached_library->get($getStories) && $this->memcached_library->get($getStories) == ''){
			$getStoriesList  = $this->db->query($getStories)->result();	
			$this->memcached_library->add($getStories,$getStoriesList);
		}else{
			$getStoriesList = $this->memcached_library->get($getStories);
		}
		$j=0;
		foreach($getStoriesList as $stories){
			if($j==0){
				echo '<ul>';
			}
			echo '<li>';
			echo '<a target="_BLANK" href="'.BASEURL.$stories->url.'">';
			echo '<img src="'.image_url.imagelibrary_image_path.'logo/nie_logo_600X300.jpg" data-src="'.image_url.'images/webstories/poster_image/'.$stories->poster_image.'">';
			echo '<p>'.$stories->title.'</p>';
			echo '<span>'.time_elapsed_string($stories->modified_on).'</span>';
			echo '<img class="webstories-icon" src="'.image_url.'images/webstories/webstories-icon.png">';
			echo '</a>';
			echo '</li>';
			if($j==2){
				echo '</ul>';
				$j=0;
			}else{
				$j++;
			}
		}
		if($j!=0){
			echo '</ul>';
		}
		?>
		<button id="load-more-list" style="font-family:Oswald_med;border: none;" class="btn btn-primary">LOAD MORE</button>
		</div>
		<input type="hidden" name="limitcount" value="0">
		<script type="text/javascript">
		$(document).ready(function(e){
			$('#load-more-list').on('click' , function(e){
				var countlist = parseInt($('input[name="limitcount"]').val());
				var sectionId = "<?php echo $id;?>";
				$.ajax({
					type :'post',
					cache : false,
					data :{'countList' : countlist , 'sectionId' : sectionId},
					url :'<?php echo BASEURL;?>/user/commonwidget/webstories',
					success : function(result){
						if(result!=''){
							 $(result).insertBefore("#load-more-list");
							 $('input[name="limitcount"]').val(countlist + 6);
						}else{
							alert('No more stories found in this section.');
						}
					},
					error : function(err , errmsg){
						console.log(err);
						console.log(errmsg);
					}
				});
			});
		});
		</script>
		<?php endif; ?>
	</div>
</div>