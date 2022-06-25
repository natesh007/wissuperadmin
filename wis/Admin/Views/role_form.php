		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark">Add Role</h1>
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
								<form class="form-horizontal" method="post" action="" style="width:100%" id="add_roles" method="post">
									<div class="form-group row">
										<div class="col-md-6">
											<label for="RoleName">Role Name<strong class="help-block">*</strong></label>
											<input type="text" class="form-control" id="RoleName" name="RoleName" placehoder="Enter Role Name" />
											<span id="name_error"></span>
										</div>
										<div class="col-md-6">
											<label for="Priority">Priority</label>
											<input type="number" class="form-control" min="1" id="Priority" name="Priority" placehoder="Enter Priority" />
										</div>
									</div>
									<div class="form-group text-center">
										<button type="submit" id="submit" name="submit" class="btn btn-sm btn-success">Save</button>
										<a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin/roles" class="btn  btn-sm btn-primary">Cancel</a>
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
		<input type="hidden" value="RolesTab" id="CurrentPage" />
		<?= view('Modules\Admin\Views\common\footer'); ?>
		<script>
			$("#add_roles").submit(function(event) {
				postUrl = '<?= base_url(); ?>/admin/common_form_validation';
				dataToPost = {
					Name: $("#RoleName").val(),
					Table: 'roles',
					UniqueColoumn: 'RoleName',
					ColoumnName: 'Role Name'
				};
				$.ajax({
					type: "POST",
					url: postUrl,
					data: dataToPost,
					async: false,
				}).done(function(data) {
					if (data.length != 0) {
						errors = data.split(",");
						for (i = 0; i < errors.length; i++) {
							var errrorarray = errors[i].split('~');
							if (errrorarray[0] == 'Name') {
								if (errrorarray[1] != '') {
									$('#name_error').html(errrorarray[1]);
									$('#RoleName').focus();
								} else {
									$('#name_error').html('');
								}
							}
						}
						event.preventDefault();
					} else {
						return true;
					}
				}).fail(function() {
					alert("Sorry. Server unavailable. ");
					event.preventDefault();
				});
			});
		</script>
	</body>
</html>