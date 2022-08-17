<!-- Content -->
<div class="content">
	<div class="page-header d-md-flex justify-content-between">
		<div>
            <h3>Arrange Section</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'section'); ?>">Section</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Arrange</li>
                </ol>
            </nav>
        </div>
		<div class="mt-2 mt-md-0">
			<div class="dropdown ml-2">
                <a href="<?php echo base_url(ADMINFOLDER.'section'); ?>" class="btn btn-danger">Back</a> 
            </div>
            <div class="dropdown ml-2">
                <button id="arrange_update" type="button" class="btn btn-primary">Save</button> 
            </div>
        </div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body text-center">
					<div class="dd" id="nestable1">
					<?php echo arrange_menu($sections); ?>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- ./ Content --> 