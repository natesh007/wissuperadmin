		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark">Add Building</h1>
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
								<form class="form-horizontal" method="post" action="<?= base_url('admin/buildings/add_building') ?>" style="width:100%" id="add_building" method="post">
									<div class="form-group row">
										<div class="col-md-6 my-2">
											<label for="BuildingName">Building Name<strong class="help-block">*</strong></label>
											<input type="text" class="form-control" id="BuildingName" name="BuildingName" placehoder="Enter building Name" />
											<span id="name_error"></span>
										</div>
										<div class="col-md-6 my-2">
											<label for="OrgID">Organization<strong class="help-block">*</strong></label>
											<select class="form-control" name="OrgID" required>
												<option disabled selected value>Select Organization</option>
												<?php foreach($organizations as $organization){
													echo '<option value="' . $organization['OrgID'] . '">' . $organization['OrgName'] . '</option>' ;
												} ?>
											</select>
										</div>
										
									</div>
									
									<div class="form-group text-center">
										<span><button type="submit" id="submit" name="submit" class="btn btn-sm  btn-success">Save</button></span>
										<span><a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin<?= session()->get('building_page'); ?>" class="btn btn-sm  btn-primary">Cancel</a> </span>
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
		<input type="hidden" value="BuildingsTab" id="CurrentPage" />
		<?= view('Modules\Admin\Views\common\footer'); ?>
		<script>
			$("#add_building").submit(function(event) {
				var BuildingName = $('#BuildingName').val();
				if(BuildingName == '')
				{
					event.preventDefault();
					$('#name_error').css('color','red');
					$('#name_error').html('Please enter building Name');
				}
				else{
					$('#name_error').html();
				}
			});
		</script>
	</body>
</html>