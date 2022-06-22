<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<?php //echo $this->renderSection('content') 
	?>
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Add Organization Type</h1>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Main row -->
			<div class="card">
				<div class="card-body">
					<div class="row">
						<form class="form-horizontal" method="post" action="<?= base_url('admin/organization_types/add_organization_type') ?>" style="width:100%" id="add_organization_type" method="post">
							<div class="form-group row">
								<div class="col-md-6 my-2">
									<label for="OrganizationType">Organization Type<strong class="help-block">*</strong></label>
									<input type="text" class="form-control" id="OrganizationType" name="OrganizationType" placehoder="Enter Organization Type ..." />
									<span id="name_error"></span>
								</div>
                                
                                
							</div>
							<div class="form-group text-center submit_cancel">
								<span><button type="submit" id="submit" name="submit" class="btn btn-success">Save</button></span>
								<span><a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin<?= session()->get('organization_type_page'); ?>" class="btn btn-primary">Cancel</a> </span>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /.row (main row) -->
		</div><!-- /.container-fluid -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<?= view('Modules\Admin\Views\common\footer'); ?>
    <!-- ./wrapper -->

    
    <script src="<?= base_url()?>/public/admin_assets/commonjs.js"></script>
<script>
	$("#add_organization_type").submit(function(event) {
		var OrganizationType = $('#OrganizationType').val();
        
       
        if(OrganizationType == '')
        {
            event.preventDefault();
            $('#name_error').css('color','red');
            $('#name_error').html('Please enter Organization Type');
        }
        else{
            $('#name_error').html();
        }
        
        
	});
</script>
</body>

</html>