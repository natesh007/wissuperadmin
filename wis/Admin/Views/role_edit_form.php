		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark">Edit Role</h1>
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
								<form class="form-horizontal" method="post" id="edit_role" action="" style="width:100%">
									<input type="hidden" class="form-control" id="RoleID" name="RoleID" value="<?= $roles['RoleID']; ?>" />
									<div class="form-group row">
										<div class="col-md-6">
											<label for="RoleName">Role Name<strong class="help-block">*</strong></label>
											<input type="text" class="form-control" id="RoleName" name="RoleName" value="<?= $roles['RoleName']; ?>" placeholder="Enter Role Name">
											<span id="name_error"></span>
										</div>
										<div class="col-md-6">
											<label for="Priority">Priority</label>
											<input type="number" class="form-control" id="Priority" name="Priority" min="1" placeholder="Enter Priority" value="<?= $roles['Priority']; ?>">
										</div>
									</div>
									<div class="form-group text-center update_cancel">
										<button type="submit" id="submit" name="submit" class="btn btn-sm btn-success">Update</button>
										<a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin/roles" class="btn btn-sm btn-primary">Cancel</a>
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
			$("#edit_role").submit(function(event) {
				postUrl = '<?= base_url(); ?>/admin/common_edit_form_validation';
				dataToPost = {
					Name: $("#RoleName").val(),
					Table: 'roles',
					UniqueColoumn: 'RoleName',
					AutoIncColoumn: 'RoleID',
					AutoIncVal: $("#RoleID").val(),
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