		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark">Add Employee</h1>
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
							<?php if ($error!="") : ?>
								<div class="alert alert-danger" style="width:100%">
									<?= $error ?>
									
								</div>
							<?php endif ?>

							
								<form class="form-horizontal" method="post" action="<?= base_url('admin/employees/add_employee') ?>" style="width:100%" id="add_employee" method="post">
									<div class="form-group row">
										<div class="col-md-6">
											<label for="EmpName">Employee Name<strong class="help-block">*</strong></label>
											<input type="text" class="form-control" id="EmpName" value="<?php echo set_value('EmpName'); ?>" name="EmpName" placehoder="Enter employee Name" />
											<span id="name_error"></span>
										</div>
										<div class="col-md-6">
                                            <label for="BrID">Organization<strong class="help-block">*</strong></label>
                                            <select class="form-control OrgID" name="OrgID" id="OrgID">
                                                <option disabled selected value>Select Organization</option>
                                                <?php foreach($organizations as $organization){
                                                    echo '<option value="' . $organization['OrgID'] . '">' . $organization['OrgName'] . '</option>' ;
                                                } ?>
                                            </select>
                                        </div>
                                       
										
									</div>
									<div class="form-group row">
										<div class="col-md-6">
												<label for="BrID">Branch<strong class="help-block">*</strong></label>
												<select class="selectpicker form-control" multiple data-live-search="true" name="BrID[]" id="BrID">
													<!-- <option disabled selected value hidden>Select Multiple Branches</option> -->
													<?php /*foreach($branches as $branch){
														echo '<option value="' . $branch['BrID'] . '">' . $branch['BrName'] . '</option>' ;
													}*/ ?>
												</select>
										</div>
										<div class="col-md-6">
												<label for="ParentDept">Department<strong class="help-block">*</strong></label>
												<select name="ParentDept" id="ParentDept" class="form-control">
													<option disabled selected value>Select Department</option>
													<?php /*
												

													
													if (!empty($total_cats)) {
														foreach ($total_cats as $departments) { ?>
															<option value="<?= $departments['DeptID']; ?>" style="font-weight:800;background-color:#e9ebed;font-size:18px"><?= $departments['DeptName']; ?></option>
															<?php if (isset($departments['children'])) {
																for ($i = 0; $i <= count($departments['children']); $i++) {
																	if (isset($departments['children'][$i])) { ?>
																		<option value="<?= $departments['children'][$i]['DeptID']; ?>" style="font-weight:400;font-size:14px"> <?= $departments['children'][$i]['DeptName'] ?></option>
																		<?php if (isset($departments['children'][$i]['children'])) {
																			for ($j = 0; $j <= count($departments['children'][$i]['children']); $j++) {
																				if (isset($departments['children'][$i]['children'][$j])) { ?>
																					<option value="<?= $departments['children'][$i]['children'][$j]['DeptID']; ?>" style="background-color:#bcbfc2;font-size:12px"><?= $departments['children'][$i]['children'][$j]['DeptName']; ?></option>
													<?php  }
																			}
																		}
																	}
																}
															}
														}
													} ?>*/?>
												</select>
												<span id="caterror"></span>
										</div>
											
										
										
										
									</div>
									<div class="form-group row">
										<div class="col-md-6">
												<label for="BrID">Job Title<strong class="help-block">*</strong></label>
												<select class="form-control" name="JobTID" id="JobTID">
													<option disabled selected value>Select Job Title</option>
													<?php foreach($jobtitles as $jobtitle){
														echo '<option value="' . $jobtitle['JobTID'] . '">' . $jobtitle['JobTitle'] . '</option>' ;
													} ?>
												</select>
										</div>
										<div class="col-md-6">
											<label for="EmpName">Email ID<strong class="help-block">*</strong></label>
											<input type="text" value="<?php echo set_value('EmailID'); ?>" class="form-control" id="EmailID" name="EmailID" placehoder="Enter EmailID" />
											<span id="email_error"></span>
										</div>
									
										
									</div>
									<div class="form-group row">
										<div class="col-md-6">
											<label for="Langitude">Mobile <strong class="help-block">*</strong></label>
											<input type="text" class="form-control" id="Contact" name="Contact" placehoder="Enter Mobile Number" value="<?php echo set_value('Contact'); ?>" />
										</div>
										
										<div class="col-md-6">
											<label for="BrID">Gender</label>
											<select class="form-control" name="Gender" >
												<option disabled selected value>Select Gender</option>
												<option value="M">Male</option>
												<option value="F">Female</option>
											</select>
										</div>
										
										<?php /*<div class="col-md-6">
											<label for="BrID">Role<strong class="help-block">*</strong></label>
											<select class="form-control" name="RoleID" >
												<option disabled selected value="0">Select Role</option>
												<?php foreach($roles as $role){
													echo '<option value="' . $role['RoleID'] . '">' . $role['RoleName'] . '</option>' ;
												} ?>
											</select>
										</div>*/?>
										
									</div>
									<div class="form-group row">
										<div class="col-md-6">
											<label for="Langitude">Date Of Joining </label>
											<input type="text" class="form-control datepicker" id="DateOfJoining" name="DateOfJoining" placehoder="Enter Date Of Joining" value="<?php echo set_value('DateOfJoining'); ?>" />
										</div>
										<div class="col-md-6">
											<label for="Langitude">Job Type </label>
											<input type="text" class="form-control" id="JobType" name="JobType" placehoder="Enter JobType" value="<?php echo set_value('JobType'); ?>"/>
										</div>
										
										<?php /*<div class="col-md-6">
											<label for="Langitude">City </label>
											<input type="text" class="form-control" id="City" name="City" placehoder="Enter City" value="<?php echo set_value('City'); ?>"/>
										</div>*/?>
										
									</div>

									<div class="form-group row">
										<div class="col-md-6">
											<label for="Address">Address </label>
											<textarea class="form-control" id="Address" name="Address" placehoder="Enter Address"><?php echo set_value('Address'); ?></textarea>		
										</div>
									</div>
									
									<div class="form-group text-center">
										<button type="submit" id="submit" name="submit" class="btn btn-sm btn-success">Save</button>
										<a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin<?= session()->get('employee_page'); ?>" class="btn btn-sm btn-primary">Cancel</a>
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
		<input type="hidden" value="EmployeesTab" id="CurrentPage" />
		<?= view('Modules\Admin\Views\common\footer'); ?>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
		<style>.bootstrap-select{background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da!important;height:auto}</style>
		<script>
			$('.datepicker').datepicker({
				format: 'yyyy-mm-dd'
			});
			$('#add_employee').validate({
				rules: {
					EmpName: { required: true },
					OrgID: { required: true },
					JobTID: { required: true },
					BrID: { required: true },
					EmailID: { required: true,
								email: true},
					ParentDept: {required: true},
					Contact:  {required: true,
						number: true}	
				},
				messages: {
					EmpName: "Please enter Employee Name",
					EmailID: {
						required: "Please enter Email ID",
						EmailID: "Please enter valid Email ID"
					},
					ParentDept: "Please select Department",
					Contact: {
						required: "Please enter mobile number",
						number: "Please enter valid mobile number"
					},
					OrgID: "Please enter Organization",
					BrID: "Please enter Branch",
					JobTID: "Please enter Job Title",
				},
				submitHandler: function(form) {
					return true;
				}
			});
			$('.OrgID').change(function(){
				
                var OrgID = $('#OrgID').val();
                if(OrgID != '')
                {
                    $.ajax({
                        url: "<?= base_url(); ?>/admin/departments/getbranches",
                        method:"POST",
                        data:{OrgID:OrgID},
                        dataType:'JSON',
                        success:function(data)
                        {
                            var html = '';
                            for(var count = 0; count < data.length; count++)
                            {
                                html += '<option value="'+data[count].BrID +'">'+data[count].BrName+'</option>';
                            }
                            $('#BrID').html(html);
							$('#BrID').selectpicker("refresh");
                        }
                    });
                }
                else
                {
                    $('#BrID').val('');
                }
            });
			$('#OrgID').change(function(){
                var OrgID = $('#OrgID').val();
                if(OrgID != '')
                {
                    $.ajax({
                        url: "<?= base_url(); ?>/admin/jobtitles/getjobtitle",
                        method:"POST",
                        data:{OrgID:OrgID},
                        dataType:'json',
                        success:function(data)
                        {
                            var html = '<option value="">Select Job Title</option>';
                            for(var count = 0; count < data.length; count++)
                            {
                                html += '<option value="'+data[count].JobTID +'">'+data[count].JobTitle+'</option>';
                            }
                            //$('#ParentDept').html(data)
                            $('#JobTID').html(html);
                        }
                    });
                }
                else
                {
                    $('#JobTID').val('');
                }
            });

			$('#BrID').change(function(){

                var BrID = $('#BrID').val();
				
                if(BrID != '')
                {
                    $.ajax({
                        url: "<?= base_url(); ?>/admin/departments/getBrdepartments",
                        method:"POST",
                        data:{BrID:BrID},
                        dataType:'html',
                        success:function(data)
                        {
							$('#ParentDept').html(data);
                        }
                    });
                }
                else
                {
                    $('#ParentDept').val('');
                }
            });
		</script>
	</body>
</html>