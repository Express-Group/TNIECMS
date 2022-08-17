<section class="blocks">
<div class="row">
	<div class="col-md-12 col-lg-12 col-xl-12 col-sm-12 col-12 margin-bottom-10">
		<div class="breadcrumbs">
			<a href="<?php echo base_url() ?> "><i class="fa fa-home" aria-hidden="true" style="color:#000;"></i></a>
			<?php if($data['isHome']==0): ?>
			<a><i class="fa fa-angle-right" aria-hidden="true"></i></a>
			<?php
			$sectionPaths =  explode('/' , $data['sectionDetails']['section_full_path']);
			$path = '';
			for($i=0;$i<count($sectionPaths);$i++){
				$path .= ($path=='') ? $sectionPaths[$i] : '/'.$sectionPaths[$i];
				foreach($data['menuDetails'] as $sections){
					if($path==$sections['section_full_path']){
						echo '<a '.(($sections['sid']==$data['sectionDetails']['sid'])? ' style="color:red;" ' : '').' href="'.base_url($sections['section_full_path']).'">'.$sections['section_name'].'</a>';
						if($i!=(count($sectionPaths)-1))
							echo '<a><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
					}
				}
			}
			?>
		<?php endif; ?>
		</div>
	</div>
</div>
</section>     