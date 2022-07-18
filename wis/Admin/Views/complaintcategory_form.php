		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark">Add Complaint Category</h1>
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
								<form class="form-horizontal" method="post" action="<?= base_url('admin/complaintcategories/add_complaintcategory') ?>" style="width:100%" id="add_complaintcategory" enctype="multipart/form-data" >
									<div class="form-group row">
										<div class="col-md-6">
											<label for="complaintcategoryType">Category Name<strong class="help-block">*</strong></label>
											<input type="text" class="form-control" id="CategoryName" name="CategoryName" placehoder="Enter Category Name" />
											<span id="name_error"></span>
										</div>
										<div class="col-md-6">
											<label for="complaintcategoryType"> Category Icon<strong class="help-block">*</strong></label>
											<input type="file" class="form-control" id="CategoryIcon" name="CategoryIcon" placehoder="Enter Category Icon" />
											<span id="name_error"></span>
										</div>
										
									</div>
									<div class="form-group">
										<div class="col-md-6">
											<label for="OrgType">Organization<strong class="help-block">*</strong></label>
											<select class="selectpicker form-control" multiple data-live-search="true" name="OrgID[]">
											<option disabled selected value>Select Multiple Organizations</option>
													<?php foreach($organizations as $organization){
														echo '<option value="' . $organization['OrgID'] . '">' . $organization['OrgName'] . '</option>' ;
													} ?>
												
											</select>
										</div>
									</div>
									
									
									<div class="form-group text-center">
										<button type="submit" id="submit" name="submit" class="btn btn-sm btn-success">Save</button>
										<a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin<?= session()->get('complaintcategory_page'); ?>" class="btn btn-sm btn-primary">Cancel</a>
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
		<input type="hidden" value="ComplaintCategoriesTab" id="CurrentPage" />
		<?= view('Modules\Admin\Views\common\footer'); ?>
		<style>.bootstrap-select{background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da!important;height:auto}#OrgID-error{position: absolute;
    top: 40px;}</style>
		<script>
			$('#add_complaintcategory').validate({
				ignore: [],
				rules: {
					CategoryName: { required: true },
					CategoryIcon: { required: true },
					"OrgID[]": { required: true }
				},
				messages: {
					CategoryName: "Please enter Category Name",
					CategoryIcon: "Please select Category Icon",
					"OrgID[]": "Please enter Organization"
				},
				submitHandler: function(form) {
					return true;
				}
			});
			
		</script>
	</body>
</html>