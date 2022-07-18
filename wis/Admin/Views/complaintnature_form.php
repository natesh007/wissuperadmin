		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark">Add Complaint Nature</h1>
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
								<form class="form-horizontal" method="post" action="<?= base_url('admin/complaintnatures/add_complaintnature') ?>" style="width:100%" id="add_complaintnature" method="post">
									<div class="form-group row">
										<div class="col-md-6">
											<label for="ComplaintNature"> Nature Of  Complaint<strong class="help-block">*</strong></label>
											<input type="text" class="form-control" id="ComplaintNature" name="ComplaintNature" placehoder="Enter Complaint Nature" />
											<span id="name_error"></span>
										</div>
										<div class="col-md-6">
											<label for="CategoryName">Category <strong class="help-block">*</strong></label>
											<select class="form-control" name="ComCatID" required>
												<option disabled selected value>Select Category</option>
												<?php foreach($complaintcategories as $complaintcategory){
													echo '<option value="' . $complaintcategory['ComCatID'] . '">' . $complaintcategory['CategoryName'] . '</option>' ;
												} ?>
											</select>
										</div>
										
									</div>
									
									<div class="form-group text-center">
										<button type="submit" id="submit" name="submit" class="btn btn-sm btn-success">Save</button>
										<a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin<?= session()->get('complaintnature_page'); ?>" class="btn btn-sm btn-primary">Cancel</a>
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
		<input type="hidden" value="ComplaintNaturesTab" id="CurrentPage" />
		<?= view('Modules\Admin\Views\common\footer'); ?>
		<script>
			$('#add_complaintnature').validate({
				ignore: [],
				rules: {
					ComplaintNature: { required: true },
					ComCatID : { required: true }
				},
				messages: {
					ComplaintNature: "Please enter Complaint Nature",
					ComCatID : "Please select Complaint Category"
				},
				submitHandler: function(form) {
					return true;
				}
			});
		</script>
	</body>
</html>