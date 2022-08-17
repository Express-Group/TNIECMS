					<!-- Footer -->
					<footer class="content-footer">
						<div>© 2020 Enpl - <a href="" target="_blank">Copyrights</a></div>
						<div>
						<nav class="nav">
							<a href="" class="nav-link">Licenses</a>
							<a href="#" class="nav-link">Change Log</a>
							<a href="#" class="nav-link">Get Help</a>
						</nav>
					</div>
					</footer>
					<!-- ./ Footer -->
				</div>
				<!-- ./ Content body -->
			</div>
			<!-- ./ Content wrapper -->
		</div>
		<!-- ./ Layout wrapper -->
		<script src="<?php echo ASSETURL; ?>js/bundle.js?v=<?php echo VERSION; ?>"></script>
		<script src="<?php echo ASSETURL; ?>js/daterangepicker.js?v=<?php echo VERSION; ?>"></script>
		<script src="<?php echo ASSETURL; ?>js/datatables.min.js?v=<?php echo VERSION; ?>"></script>
		<script src="<?php echo ASSETURL; ?>js/jquery.nestable.js?v=<?php echo VERSION; ?>"></script>
		<script src="<?php echo ASSETURL; ?>js/jquery-ui.js?v=<?php echo VERSION; ?>"></script>
		<script src="<?php echo ASSETURL; ?>js/prism.js?v=<?php echo VERSION; ?>"></script>
		<?php if($this->uri->segment(3)=='article' && ($this->uri->segment(4)=='add' || $this->uri->segment(4)=='edit')): ?>
		<script src="<?php echo ASSETURL; ?>js/bootstrap-tagsinput.js?v=<?php echo VERSION; ?>"></script>
		<script src="<?php echo ASSETURL; ?>ckeditor/ckeditor.js?v=<?php echo VERSION; ?>"></script>
		<script src="<?php echo ASSETURL; ?>js/article.js?v=<?php echo VERSION; ?>"></script>
		<?php endif; ?>
		<?php if($this->uri->segment(2)=='products' && ($this->uri->segment(3)=='add' || $this->uri->segment(3)=='edit')): ?>
		<script src="<?php echo ASSETURL; ?>js/bootstrap-tagsinput.js?v=<?php echo VERSION; ?>"></script>
		<script src="<?php echo ASSETURL; ?>ckeditor/ckeditor.js?v=<?php echo VERSION; ?>"></script>
		<script src="<?php echo ASSETURL; ?>js/product.js?v=<?php echo VERSION; ?>"></script>
		<?php endif; ?>
		<?php if($this->uri->segment(2)=='image_library' || $this->uri->segment(3)=='article' || $this->uri->segment(2)=='template'): ?>
		<script src="<?php echo ASSETURL; ?>js/dropzone.js?v=<?php echo VERSION; ?>"></script>
		<script src="<?php echo ASSETURL; ?>js/cropper.js?v=<?php echo VERSION; ?>"></script>
		<script>
		const image = document.getElementById('crop_image');
const cropper = new Cropper(image, {
  aspectRatio: 16 / 9,
  crop(event) {
    console.log(event.detail.x);
    console.log(event.detail.y);
    console.log(event.detail.width);
    console.log(event.detail.height);
    console.log(event.detail.rotate);
    console.log(event.detail.scaleX);
    console.log(event.detail.scaleY);
  },
});
		</script>
		<?php endif; ?>
		<script src="<?php echo ASSETURL; ?>js/app.min.js?v=<?php echo VERSION; ?>"></script>
		<?php if($this->uri->segment(2)=='template'): ?>
		<script src="<?php echo ASSETURL; ?>js/template_view.js?v=<?php echo VERSION; ?>"></script> 
		<?php endif; ?>
		<?php if($this->uri->segment(2)=='section' && $this->uri->segment(3)=='arrange'): ?>
		
		<script type="text/javascript">
			$( ".dd-list" ).sortable({revert: true});
			$( "ol, li" ).disableSelection();
			$('#arrange_update').on('click' , function(e){
				$temp = [];
				$('.dd').find('li').each(function(index){
					$temp.push($(this).data('id')+'-'+(index + 1));
				});
				alert($temp);
				if($temp.length > 0){
					$.ajax({
						type:'post',
						url :'<?php echo base_url(ADMINFOLDER."section/save_arranged") ?>',
						data:{'list' : $temp},
						success:function(result){
							alert(result);
							if(result==1){
								toastr.success('Section Arranged Successfully');
							}
						},
						error:function(err , errcode){
							console.log(err);
							console.log(errcode);
						}
					});
				}else{
					toastr.error('No Section Arranged');
				}
			});
		</script>
		<?php endif; ?>
		<script>
			$('#article_search').on('submit' , function(e){
				e.preventDefault();
				var error =false;
				toastr.remove();
				var search_by = $('select[name="search_by"]').val();
				var query = $('input[name="query"]').val().trim();
				if(search_by!=''){
					if(query==''){
						error =true;
						toastr.error('Please enter valid query');
					}
				}
				if(!error){
					window.location.href = BASEURL+ADMINFOLDER+'content/article?query='+query+'&search_by='+search_by+'&section='+$('select[name="section_name"]').val()+'&status='+$('select[name="status"]').val()+'&start='+$('#start_date').val()+'&end='+$('#end_date').val();
				}			
			});
			$('#article_search1').on('submit' , function(e){
				e.preventDefault();
				var error =false;
				toastr.remove();
				var search_by = $('select[name="search_by"]').val();
				var query = $('input[name="query"]').val().trim();
				if(search_by!=''){
					if(query==''){
						error =true;
						toastr.error('Please enter valid query');
					}
				}
				if(!error){
					window.location.href = BASEURL+ADMINFOLDER+'approval?query='+query+'&search_by='+search_by+'&section='+$('select[name="section_name"]').val()+'&status='+$('select[name="status"]').val()+'&start='+$('#start_date').val()+'&end='+$('#end_date').val();
				}			
			});
			$('#article_search2').on('submit' , function(e){
				e.preventDefault();
				var error =false;
				toastr.remove();
				var search_by = $('select[name="search_by"]').val();
				var query = $('input[name="query"]').val().trim();
				if(search_by!=''){
					if(query==''){
						error =true;
						toastr.error('Please enter valid query');
					}
				}
				if(!error){
					window.location.href = BASEURL+ADMINFOLDER+'approval/notes?query='+query+'&search_by='+search_by;
				}			
			});
			$('.order_by').on('click' , function(e){
				var type= $(this).attr('col');
				var order_by = ($(this).attr('type')=='DESC') ? 'ASC' : 'DESC';
				var search_by = $('select[name="search_by"]').val();
				var query = $('input[name="query"]').val().trim();
				window.location.href = BASEURL+ADMINFOLDER+'content/article?query='+query+'&search_by='+search_by+'&section='+$('select[name="section_name"]').val()+'&status='+$('select[name="status"]').val()+'&start='+$('#start_date').val()+'&end='+$('#end_date').val()+'&order_type='+type+'&order_by='+order_by;
			});
			$('#img_upload_1').on('click' , function(e){
				$("#image_upload").modal({backdrop: "static"});
			});
			$('#modal_close').on('click' , function(e){
				$("#image_upload").modal("toggle");
				location.reload();
			});
			Dropzone.autoDiscover = false;
			var dzimg = $("#image-upload-list").dropzone({
				url: "<?php echo base_url(ADMINFOLDER.'image_library/upload') ?>",
				acceptedFiles: ".png,.jpg,.gif,.jpeg",
				preventDuplicates: true,
				addRemoveLinks: true,
				maxFilesize: 2,
				removedfile: function(file){
					 if(file.created_id!='' && file.created_id!=undefined){
						$.ajax({
							type:'post',
							url: '<?php echo base_url(ADMINFOLDER."image_library/remove") ?>',
							data:{'id' : parseInt(file.created_id)},
							success:function(result){
								console.log(result);
								if(result==1){
									toastr.success('Removed successfully');
									file.previewElement.remove(); 
								}else{
									toastr.error('Something went wrong..please try again');
								}
							},
							error:function(err , errcode){
								console.log(err);
								console.log(errcode);
							}
						});
					 }else{
						file.previewElement.remove(); 
					 }
				 },
				 init: function ()  {
                    this.on("error", function (file, message) {
                        toastr.error(message);
                        this.removeFile(file);
                    });
					this.on("success", function(file, responseText) {
						if(responseText!='error'){
							file.created_id = responseText;
						}else{
							this.removeFile(file);
						}
					});
                }
				
				
			});
			function view_article(content_id){
				$('.aprrove-btn').hide();
				$('#preview_article').find('.modal-body').html('Please wait...');
				$('#preview_article').modal({backdrop: "static"});
				$.ajax({
					type:'post',
					url: '<?php echo base_url(ADMINFOLDER."approval/preview") ?>',
					data:{'id' : content_id},
					cache:false,
					beforeSend : function(){
						toastr.success('Please Wait.....');
					},
					success:function(result){
						//console.log(result);
						toastr.remove();
						$('#preview_article').find('.modal-body').html(result);
						$('#notes').val('');
						$('#article_id').val(content_id);
						$('.aprrove-btn').show();
					},
					error:function(err , errcode){
						console.log(err);
						console.log(errcode);
					}
				});
				
			}
			function approve_article(content_id){
				$('#notes').val('');
				$('#article_id').val(content_id);
				$('#approve_article').modal({backdrop: "static"});
			}
			function approve(){
				toastr.remove();
				var article_id = $('#article_id').val();
				var notes = $('#notes').val().trim();
				if(notes!='' && article_id!=''){
					$.ajax({
						type:'post',
						url: '<?php echo base_url(ADMINFOLDER."approval/approve") ?>',
						data:{'id' : article_id , 'notes' : notes},
						cache:false,
						beforeSend : function(){
							toastr.success('Please Wait.....');
						},
						success:function(result){
							toastr.remove();
							if(result==1){
								toastr.success("Article approved successfully");
								location.reload();
							}else{
								toastr.error("Something went wrong.please try again");
							}
						},
						error:function(err , errcode){
							console.log(err);
							console.log(errcode);
						}
					});
				}else{
					toastr.error("Please enter valid notes");
				}
			}
			function view_notes($content_id){
				var check = $('.btn-notes-'+$content_id).html();
				if(check=='<i class="ti-angle-down"></i>'){
					$('.btn-notes-'+$content_id).html('<i class="ti-angle-up"></i>');
					$.ajax({
						type:'post',
						url: '<?php echo base_url(ADMINFOLDER."approval/view_notes") ?>',
						data:{'id' : $content_id},
						cache:false,
						beforeSend : function(){
							$('.notes-view-'+$content_id).show();
							$('.notes-view-'+$content_id).find('td').html('<p><i class="fa fa-refresh fa-spin"></i> Please Wait.....</p>');
							toastr.success('Please Wait.....');
						},
						success:function(result){
							toastr.remove();
							$('.notes-view-'+$content_id).find('td').html(result);
							$('.layout-wrapper .content-wrapper .content-body .content').getNiceScroll().resize();
						},
						error:function(err , errcode){
							console.log(err);
							console.log(errcode);
						}
					});
				}else{
					$('.notes-view-'+$content_id).find('td').html('<p><i class="fa fa-refresh fa-spin"></i> Please Wait.....</p>');
					$('.notes-view-'+$content_id).hide();
					$('.btn-notes-'+$content_id).html('<i class="ti-angle-down"></i>');
					$('.layout-wrapper .content-wrapper .content-body .content').getNiceScroll().resize();
				}
				
				
			}
		</script>
	</body>
</html>  