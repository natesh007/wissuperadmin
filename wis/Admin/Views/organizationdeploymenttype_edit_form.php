		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark">Edit Organization Deployment Type</h1>
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
								<form class="form-horizontal" method="post" action="<?= base_url('admin/organizationdeploymenttypes/edit_organizationdeploymenttype/'.$organizationdeploymenttype['OrgDeploymentTypeID']) ?>" style="width:100%" id="edit_organizationdeploymenttype" method="post">
									<div class="form-group row">
										<div class="col-md-6">
											<label for="DeploymentType">Deployment Type<strong class="help-block">*</strong></label>
											<input type="text" class="form-control" id="DeploymentType" name="DeploymentType" placehoder="Enter Deployment Type"  value="<?= $organizationdeploymenttype['DeploymentType'];?>"/>
											<span id="name_error"></span>
										</div>
										
										
									</div>
									<div class="form-group text-left">
										<button type="submit" id="submit" name="submit" class="btn btn-sm btn-success">Update</button>
										<a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin<?= session()->get('organizationdeploymenttype_page'); ?>" class="btn btn-sm btn-primary">Cancel</a>
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
		<input type="hidden" value="OrganizationdeploymenttypeTab" id="CurrentPage" />
		<?= view('Modules\Admin\Views\common\footer'); ?>
		<script>
			$("#edit_organizationdeploymenttype").submit(function(event) {
				var DeploymentType = $('#DeploymentType').val();
				
				if(DeploymentType == '')
				{
					event.preventDefault();
					$('#name_error').css('color','red');
					$('#name_error').html('Please enter Deployment Type');
				}
				else{
					$('#name_error').html();
				}
			});
		</script>
	</body>
</html>