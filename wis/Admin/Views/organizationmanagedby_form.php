		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark">Add Organization Managed By</h1>
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
								<form class="form-horizontal" method="post" action="<?= base_url('admin/organizationmanagesby/add_organizationmanagedby') ?>" style="width:100%" id="add_organizationmanagedby" method="post">
									<div class="form-group row">
										<div class="col-md-6">
											<label for="OrgManaged">Managed By<strong class="help-block">*</strong></label>
											<input type="text" class="form-control" id="OrgManaged" name="OrgManaged" placehoder="Enter Managed By" />
											<span id="name_error"></span>
										</div>
										
									</div>
									<div class="form-group text-left">
										<button type="submit" id="submit" name="submit" class="btn btn-sm btn-success">Save</button>
										<a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin<?= session()->get('organizationmanagedby_page'); ?>" class="btn btn-sm btn-primary">Cancel</a>
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
		<input type="hidden" value="OrganizationmanagesbyTab" id="CurrentPage" />
		<?= view('Modules\Admin\Views\common\footer'); ?>
		<script>
			$("#add_organizationmanagedby").submit(function(event) {
				var OrgManaged = $('#OrgManaged').val();
				
				if(OrgManaged == '')
				{
					event.preventDefault();
					$('#name_error').css('color','red');
					$('#name_error').html('Please enter Managed By Type');
				}
				else{
					$('#name_error').html();
				}
				
			});
		</script>
	</body>
</html>