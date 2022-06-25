		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark">Edit Organization </h1>
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
								<form class="form-horizontal" method="post" action="<?= base_url('admin/organizations/edit_organization/'.$organization['OrgID']) ?>" style="width:100%" id="edit_organization" method="post">
									
									<div class="form-group row">
										<div class="col-md-6">
											<label for="OrganizationType">Organization Name<strong class="help-block">*</strong></label>
											<input type="text" class="form-control" id="OrgName" name="OrgName" placehoder="Enter Organization Name" value="<?= $organization['OrgName'];?>"/> 
											<span id="name_error"></span>
										</div>
										<div class="col-md-6">
											<label for="OrgType">Organization Type<strong class="help-block">*</strong></label>
											<select class="form-control" name="OrgType" required>
												<option disabled selected value>Select Organization Type</option>
								
												<?php foreach($organization_types as $organization_type){
														echo '<option value="' . $organization_type['TypeID'] . '"';
														if($organization_type['TypeID'] == $organization['OrgType']){
															echo ' selected';
														}
														echo '>' . $organization_type['OrganizationType'] . '</option>' ;
													} ?>
											</select>
										</div>
										
									</div>
									<div class="form-group row">
										<div class="col-md-6">
											<label for="Address">Address </label>
											<textarea class="form-control" id="Address" name="Address" placehoder="Enter Address" /><?= $organization['Address'];?></textarea>
											
										</div>
										
										<div class="col-md-6">
											<label for="Langitude">Langitude </label>
											<input type="text" class="form-control" id="Langitude" name="Langitude" placehoder="Enter Langitude" value="<?= $organization['Langitude'];?>"/>
											
										
										</div>
										
									</div>
									<div class="form-group row">
										<div class="col-md-6">
											<label for="Latitude">Latitude</label>
											<input type="text" class="form-control" id="Latitude" name="Latitude" placehoder="Enter Latitude"  value="<?= $organization['Latitude'];?>"/>
											
										</div>
										
										
									</div>
									<div class="form-group text-center">
										<button type="submit" id="submit" name="submit" class="btn btn-sm btn-success">Update</button>
										<a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin<?= session()->get('organization_page'); ?>" class="btn btn-sm btn-primary">Cancel</a>
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
		<input type="hidden" value="OrganizationsTab" id="CurrentPage" />
		<?= view('Modules\Admin\Views\common\footer'); ?>
		<script>
			$("#edit_organization").submit(function(event) {
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