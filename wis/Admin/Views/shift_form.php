		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark">Add Shift</h1>
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
								<form class="form-horizontal" method="post" action="<?= base_url('admin/shifts/add_shift') ?>" style="width:100%" id="add_shift" method="post">
									<div class="form-group row">
										<div class="col-md-6">
											<label for="ShiftName">Shift Name<strong class="help-block">*</strong></label>
											<input type="text" class="form-control" id="ShiftName" name="ShiftName" placehoder="Enter Shift Name" />
											<span id="name_error"></span>
										</div>
										<div class="col-md-6">
											<label for="ShiftDesc">Shift Desc</label>
											<input type="text" class="form-control" id="ShiftDesc" name="ShiftDesc" placehoder="Enter Shift Desc" />
											<span id="code_error"></span>
										</div>
										
									</div>
									<div class="form-group text-center">
										<button type="submit" id="submit" name="submit" class="btn btn-sm btn-success">Save</button>
										<a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin<?= session()->get('shift_page'); ?>" class="btn btn-sm btn-primary">Cancel</a>
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
		<input type="hidden" value="ShiftsTab" id="CurrentPage" />
		<?= view('Modules\Admin\Views\common\footer'); ?>
		<script>
			$("#add_shift").submit(function(event) {
				var ShiftName = $('#ShiftName').val();
				var ShiftDesc = $('#ShiftDesc').val();
				if(ShiftName == '')
				{
					event.preventDefault();
					$('#name_error').css('color','red');
					$('#name_error').html('Please enter Shift Type');
				}
				else{
					$('#name_error').html();
				}
				if(ShiftDesc == '')
				{
					event.preventDefault();
					$('#phne_error').css('color','red');
					$('#phne_error').html('Please enter Shift Code');
				}
				else{
					$('#phne_error').html();
				}
			});
		</script>
	</body>
</html>