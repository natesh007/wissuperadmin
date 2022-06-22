<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<?php //echo $this->renderSection('content') 
	?>
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Add Organization</h1>
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
						<form class="form-horizontal" method="post" action="<?= base_url('admin/organizations/add_organization') ?>" style="width:100%" id="add_organization" method="post">
							<div class="form-group row">
								<div class="col-md-6 my-2">
									<label for="OrganizationType">Organization Name<strong class="help-block">*</strong></label>
									<input type="text" class="form-control" id="OrgName" name="OrgName" placehoder="Enter Organization Name ..." />
									<span id="name_error"></span>
								</div>
                                <div class="col-md-6">
									<label for="OrgType">Organization Type<strong class="help-block">*</strong></label>
									<select class="form-control" name="OrgType" required>
										<option disabled selected value>Select Organization Type</option>
										<?php foreach($organization_types as $organization_type){
											echo '<option value="' . $organization_type['TypeID'] . '">' . $organization_type['OrganizationType'] . '</option>' ;
										} ?>
									</select>
								</div>
                                
							</div>
							<div class="form-group row">
								<div class="col-md-6 my-2">
									<label for="Address">Address </label>
									<textarea class="form-control" id="Address" name="Address" placehoder="Enter Address ..." /></textarea>
									
								</div>
                                
								<div class="col-md-6 my-2">
									<label for="Langitude">Langitude </label>
									<input type="text" class="form-control" id="Langitude" name="Langitude" placehoder="Enter Langitude ..." />
									
								
								</div>
                                
							</div>
							<div class="form-group row">
								<div class="col-md-6 my-2">
									<label for="Latitude">Latitude</label>
									<input type="text" class="form-control" id="Latitude" name="Latitude" placehoder="Enter Latitude ..." />
									
								</div>
                                
                                
							</div>
							<div class="form-group text-center submit_cancel">
								<span><button type="submit" id="submit" name="submit" class="btn btn-success">Save</button></span>
								<span><a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin<?= session()->get('organization_page'); ?>" class="btn btn-primary">Cancel</a> </span>
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
	$("#add_organization").submit(function(event) {
		var OrgName = $('#OrgName').val();
        
       
        if(OrgName == '')
        {
            event.preventDefault();
            $('#name_error').css('color','red');
            $('#name_error').html('Please enter Organization Name');
        }
        else{
            $('#name_error').html();
        }
        
        
	});
</script>
</body>

</html>