		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark">Edit Department</h1>
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
								<form class="form-horizontal" method="post" action="" style="width:100%" enctype="multipart/form-data" id="edit_cats">
									<input type="hidden" class="form-control" id="DeptID" name="DeptID" value="<?= $cat['DeptID']; ?>">
									<div class="form-group row">
										<div class="col-md-6">
											<label for="DeptName">Department Name<strong class="help-block">*</strong></label>
											<input type="text" class="form-control" value="<?= $cat['DeptName'] ?>" onkeyup="myFunction()" name="DeptName" id="DeptName" placeholder="Enter Department Name ..." />
											<span id="caterror"></span>
										</div>
										<div class="col-md-6">
											<label for="Priority">Parent Department</label>
											<select name="ParentDept" id="ParentDept" class="form-control">
												<option disabled selected value>Select Department</option>
												<option value="0">None</option>
												<?php if(!empty($total_cats)){
													foreach ($total_cats as $departments) { ?>
													<option value="<?= $departments['DeptID']; ?>" style="font-weight:800;background-color:#e9ebed;font-size:18px" <?php if ($cat['ParentDept'] != '') {
																																																					if ($cat['ParentDept'] == $departments['DeptID']) {
																																																						echo 'selected';
																																																					}
																																										} ?>><?= $departments['DeptName']; ?></option>
													<?php if (isset($departments['children'])) {
														for ($i = 0; $i <= count($departments['children']); $i++) {
															if (isset($departments['children'][$i])) { ?>
																<option value="<?= $departments['children'][$i]['DeptID']; ?>" style="font-weight:400;font-size:14px" <?php if ($cat['ParentDept'] != '') {
																																												if ($cat['ParentDept'] == $departments['children'][$i]['DeptID']) {
																																													echo 'selected';
																																												}
																																											} ?>> <?= $departments['children'][$i]['DeptName'] ?></option>
																<?php if (isset($departments['children'][$i]['children'])) {
																	for ($j = 0; $j <= count($departments['children'][$i]['children']); $j++) {
																		if (isset($departments['children'][$i]['children'][$j])) { ?>
																			<option value="<?= $departments['children'][$i]['children'][$j]['DeptID']; ?>" style="background-color:#bcbfc2;font-size:12px" <?php if ($cat['ParentDept'] != '') {
																																																					if ($cat['ParentDept'] == $departments['children'][$i]['children'][$j]['DeptID']) {
																																																						echo 'selected';
																																																					}
																																																				} ?>><?= $departments['children'][$i]['children'][$j]['DeptName']; ?></option>
												<?php  }
																	}
																}
															}
														}
													}
												} } ?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-6">
											<label for="BrID">Organization</label>
											<select class="form-control" name="OrgID" id="OrgID">
												<option disabled selected value hidden>Select Organization</option>
												<?php foreach($organizations as $organization){
													echo '<option value="' . $organization['OrgID'] . '"';
													if($organization['OrgID'] == $cat['OrgID']){
														echo ' selected';
													}
													echo '>' . $organization['OrgName'] . '</option>' ;
												
												} ?>
											</select>
										</div>
										<div class="col-md-6">
											<label for="OrgType">Branch<strong class="help-block">*</strong></label>
											<select class="form-control" name="BrID" id="BrID">
												<option disabled selected value hidden>Select Branch</option>
												<?php foreach($branches as $branch){
													echo '<option value="' . $branch['BrID'] . '"';
													if($branch['BrID'] == $cat['BrID']){
														echo ' selected';
													}
													echo '>' . $branch['BrName'] . '</option>' ;
												
												} ?>
												
											</select>
										</div>
										
														<?php foreach($branches as $branch){
																echo '<option value="' . $branch['BrID'] . '"';
																if($branch['BrID'] == $cat['BrID']){
																	echo ' selected';
																}
																echo '>' . $branch['BrName'] . '</option>' ;
															} ?>
													</select>
												</div>
												
											</div>
											<div class="form-group row">
												<?PHP /*<div class="col-md-6">
													<label for="bannerimage">Banner Image</label>
													<small class="text-info text-bold">(Suggested Pixel Resolution:1000 X 400, Size should be below 2MB)</small>
													<input type="file" name="BannerImage" class="form-control" id="BannerImage" />
													<input type="hidden" name="HiddenImage" id="HiddenImage" value="<?= $cat['BannerImage']; ?>" />
													<span id="imgerr" style="color:red"></span>
													<br />
													<img src="<?= base_url() . '/' . $cat['BannerImage']; ?>" alt="Banner image" class="img-thumbnail" width="200" height="200" />
												</div>*/?>
											
											</div>
											<div class="text-center form-group">
												<span><button type="submit" id="submit" name="submit" class="btn btn-sm btn-success subcanbtn">Update</button></span>
												<span><a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin<?= session()->get('departments_page'); ?>" class="btn btn-sm btn-primary subcanbtn">Cancel</a> </span>
											</div>
										</form>
									</div>
									
									<div class="text-center form-group">
										<span><button type="submit" id="submit" name="submit" class="btn btn-sm btn-success subcanbtn">Update</button></span>
										<span><a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin<?= session()->get('departments_page'); ?>" class="btn btn-sm btn-primary subcanbtn">Cancel</a> </span>
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
        <input type="hidden" value="DepartmentsTab" id="CurrentPage" />
		<?= view('Modules\Admin\Views\common\footer'); ?>
		<script>
			$('#edit_cats').validate({
				rules: {
					DeptName: { required: true },
					ParentDept: { required: true},
					OrgID: {required: true},
					BrID:  {required: true}
				},
				messages: {
					DeptName: "Please enter Department Name",
					ParentDept: {
						required: "Please select Parent Department"
					},
					OrgID: "Please select Organization",
					BrID: {
						required: "Please select Branch"
					}
				},
				submitHandler: function(form) {
					return true;
				}
			});
			$('#OrgID').change(function(){
				var OrgID = $('#OrgID').val();
				if(OrgID != '')
				{
					$.ajax({
						url: "<?= base_url(); ?>/admin/departments/getbranches",
						method:"POST",
						data:{OrgID:OrgID},
						dataType:"JSON",
						success:function(data)
						{
							var html = '<option value="">Select Branch</option>';
							for(var count = 0; count < data.length; count++)
							{
								html += '<option value="'+data[count].BrID +'">'+data[count].BrName+'</option>';
							}

							$('#BrID').html(html);
						}
					});
				}
				else
				{
					$('#BrID').val('');
				}
			});
		</script>
	</body>
</html>