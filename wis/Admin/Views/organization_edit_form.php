		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark">Edit Organization </h1>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.container-fluid -->
			</div>
			<!-- /.content-header -->
			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
				<?php if ($error) : ?>
						<div class="alert alert-danger alert-dismissible">
							<?= $error ?>
							<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
						</div>
					<?php endif ?>
					<!-- Main row -->
					<div class="card">
						<div class="card-body">
							<div class="row">
								

								<form class="form-horizontal" method="post" action="<?= base_url('admin/organizations/edit_organization/'.$organization['OrgID']) ?>" style="width:100%" id="edit_organization" method="post" enctype="multipart/form-data" >
									<div class="form-group row">
										<div class="col-md-12">
											<h4>Organizational Admin</h4>
										</div>
									</div>
									<hr>
									<div class="form-group row">
										<div class="col-md-4">
											<label for="FirstName">First Name<strong class="help-block">*</strong></label>
											<input type="text" class="form-control" id="FirstName" name="FirstName" placeholder="Enter First Name" value="<?= $organization['FirstName'];?>"/> 
											<span id="name_error"></span>
										</div>

										<div class="col-md-4">
											<label for="MiddleName">Middle Name</label>
											<input type="text" class="form-control" id="MiddleName" name="MiddleName" placeholder="Enter Middle Name" value="<?= $organization['MiddleName'];?>"/> 
											<span id="name_error"></span>
										</div>

										<div class="col-md-4">
											<label for="LastName">Last Name<strong class="help-block">*</strong></label>
											<input type="text" class="form-control" id="LastName" name="LastName" placeholder="Enter Last Name" value="<?= $organization['LastName'];?>"/> 
											<span id="name_error"></span>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">
											<label for="OrganizationType">Organization Name<strong class="help-block">*</strong></label>
											<input type="text" class="form-control" id="OrgName" name="OrgName" placeholder="Enter Organization Name" value="<?= $organization['OrgName'];?>"/> 
											<span id="name_error"></span>
										</div>
										<div class="col-md-4">
											<label for="Designation">Designation<strong class="help-block">*</strong></label>
											<select class="selectpicker form-control" multiple data-live-search="true" name="Designation[]"> 
											<option disabled selected value>Select Multiple Designations</option>
												<?php foreach($organizationdesignations as $odg){
													echo '<option value="' . $odg['OrgDesignationID'] . '"';
													if(in_array($odg['OrgDesignationID'], $seldesignations)){
														echo ' selected';
													}
													echo '>' . $odg['Designation'] . '</option>' ;
												} ?>
												
											</select>
										</div>
										<div class="col-md-4">
											<label for="Department">Department<strong class="help-block">*</strong></label>
											<div class="Departmenterror">
											<select class="selectpicker form-control" multiple data-live-search="true" name="Department[]">
											<option disabled selected value>Select Multiple Departments</option>
												<?php foreach($organizationdepartments as $od){
													echo '<option value="' . $od['OrgDepartmentID'] . '"';
													if(in_array($od['OrgDepartmentID'], $seldepartments)){
														echo ' selected';
													}
													echo '>' . $od['Department'] . '</option>' ;
												} ?>
												
											</select>
											</div>
										</div>
										
									</div>
									<div class="form-group row">
										<div class="col-md-4">
											<label for="EmailID">Email ID<strong class="help-block">*</strong></label>
											<input type="email" class="form-control" id="EmailID" name="EmailID" placeholder="Enter EmailID"  value="<?= $organization['EmailID'];?>"/> 
											<span id="name_error"></span>
										</div>

										

										<div class="col-md-4">
											<label for="Phone">Phone<strong class="help-block">*</strong></label>
											<input type="text" class="form-control" id="Phone" name="Phone" placeholder="Enter Phone Number" value="<?= $organization['Contact'];?>"/> 
											<span id="name_error"></span>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-6">
											<label for="Phone">Complete Address</label>
											<textarea class="form-control" id="Address" name="Address"><?= $organization['Address'];?> </textarea>
											<span id="name_error"></span>
										</div>
										<div class="col-md-4">
											<label for="Logo"> Upload Logo<strong class="help-block">*</strong></label>
											<input type="file" class="form-control" id="Logo" name="Logo" placehoder="Upload Logo" />
											<span id="name_error"></span>

											<?php if($organization['Logo']){ ?>
												<input type="hidden" name="OldLogo" id="OldLogo" value="<?= $organization['Logo']; ?>" />
												<img src="<?= base_url($organization['Logo']); ?>" alt="image" class="FormImg" width="100"/>
											<?php } ?>
										</div>
										</div>
									</div>
									<br/>			
									<div class="form-group row">
										<div class="col-md-12">
											<h4>Organizational Configuration</h4>
										</div>
									</div>
									<hr>
									<div class="form-group row">
										<div class="col-md-4">
											<label for="ManagedBy"><strong>Managed By</strong><strong class="help-block">*</strong></label>
											<div class="ManagedByerror">
											<?php foreach($organizationmanagesby as $om){?>
												<div class="form-check">
												<input class="form-check-input" type="radio" name="ManagedBy" id="ManagedBy<?=$om['OrgManagedByID']?>" value="<?=$om['OrgManagedByID']?>" <?=($om['OrgManagedByID'] == $organization['ManagedBy']?'checked':'');?>>
												<label class="form-check-label" for="ManagedBy<?=$om['OrgManagedByID']?>">
													<?=$om['OrgManaged']?>
												</label>
												</div>
											<?php } ?>	
											</div>										
										</div>

										<div class="col-md-4">
											<label for="DeploymentType"><strong>Deployment Type</strong><strong class="help-block">*</strong></label>
											<div class="DeploymentTypeerror">
											<?php foreach($organizationdeploymenttypes as $od){?>
												<div class="form-check">
												<input class="form-check-input" type="radio" name="DeploymentType" id="DeploymentType<?=$od['OrgDeploymentTypeID']?>" value="<?=$od['OrgDeploymentTypeID']?>" <?=($od['OrgDeploymentTypeID'] == $organization['DeploymentType']?'checked':'');?>>
												<label class="form-check-label" for="DeploymentType<?=$od['OrgDeploymentTypeID']?>">
													<?=$od['DeploymentType']?>
												</label>
												</div>
											<?php } ?>	
											</div>										
										</div>

										<div class="col-md-4">
											<label for="Reporting"><strong>Reporting</strong><strong class="help-block">*</strong></label>
											<div class="Reportingerror">
											<?php foreach($organizationreportings as $or){?>
												<div class="form-check">
												<input class="form-check-input" type="radio" name="Reporting" id="Reporting<?=$or['OrgReportingID']?>" value="<?=$or['OrgReportingID']?>" <?=($or['OrgReportingID'] == $organization['Reporting']?'checked':'');?>>
												<label class="form-check-label" for="Reporting<?=$or['OrgReportingID']?>">
													<?=$or['Reporting']?>
												</label>
												</div>
											<?php } ?>	
											</div>										
										</div>
									</div>

									<div class="form-group row">
										<div class="col-md-4">
											<label for="OrgType"><strong>Organization Type</strong><strong class="help-block">*</strong></label>
											<div class="OrgTypeerror">
											<?php foreach($organization_types as $ot){?>
												<div class="form-check">
												<input class="form-check-input" type="radio" name="OrgType" id="OrgType<?=$ot['TypeID']?>" value="<?=$ot['TypeID']?>" onclick="orgtype(<?=$ot['TypeID']?>)" <?=($ot['TypeID'] == $organization['OrgType']?'checked':'');?>>
												<label class="form-check-label" for="OrgType<?=$ot['TypeID']?>">
													<?=$ot['OrganizationType']?>
												</label>
												</div>
											<?php } ?>
											</div>											
										</div>

										<div class="col-md-4">
											<label for="Site"><strong>Site</strong><strong class="help-block">*</strong></label>
											<div class="Siteerror">
											<?php foreach($organizationsites as $os){?>
												<div class="form-check">
												<input class="form-check-input" type="radio" name="Site" id="Site<?=$os['OrgSiteID']?>" value="<?=$os['OrgSiteID']?>" onclick="site(<?=$os['OrgSiteID']?>)" <?=($os['OrgSiteID'] == $organization['Site']?'checked':'');?>>
												<label class="form-check-label" for="Site<?=$os['OrgSiteID']?>">
													<?=$os['Site']?>
												</label>
												</div>
											<?php } ?>
											</div>											
										</div>

										<div class="col-md-4">
											<label for="SubClients"><strong>Sub Clients</strong></label>
											<?php /*php foreach($organization_types as $ot){?>
												<div class="form-check">
												<input class="form-check-input" type="radio" name="SubClients" id="SubClients<?=$ot['TypeID']?>" value="<?=$ot['TypeID']?>">
												<label class="form-check-label" for="SubClients<?=$ot['TypeID']?>">
													<?=$ot['OrganizationType']?>
												</label>
												</div>
											<?php } ?>	*/?>	
											<?php foreach($statuses as $s){?>
												<div class="form-check">
												<input class="form-check-input" type="radio" name="SubClients" id="SubClients<?=$s['StatusID']?>" value="<?=$s['StatusID']?>" <?=($s['StatusID'] == $organization['SubClients']?'checked':'');?>>
												<label class="form-check-label" for="SubClients<?=$s['StatusID']?>">
													<?=$s['StatusName']?>
												</label>
												</div>
											<?php } ?>		
											
										</div>
									</div>
									<div class="form-group row ClientLimitform" <?=($organization['ClientLimit']==0?'style="display:none"':'');?>>
										<div class="col-md-4">
										<input type="text" class="form-control" id="ClientLimit" name="ClientLimit" placeholder="Add limit on number clients" value="<?=($organization['ClientLimit']==0?'':$organization['ClientLimit']);?>"/> 
										</div>
									</div>

									<div class="form-group row SiteLimitform" <?=($organization['SiteLimit']==0?'style="display:none"':'');?>>
										<div class="form-group row col-md-12">
											<div class="col-md-4">
											<input type="text" class="form-control" id="SiteLimit" name="SiteLimit" placeholder="Add limit on number site" value="<?=($organization['SiteLimit']==0?'':$organization['SiteLimit']);?>"/> 
											</div>

											<div class="col-md-4">
											<input type="text" class="form-control" id="SiteLocations" name="SiteLocations" placeholder="Add limit on number of locaions per site" value="<?=($organization['SiteLocations']==0?'':$organization['SiteLocations']);?>"/> 
											</div>

											<div class="col-md-4">
											<input type="text" class="form-control" id="SiteEmps" name="SiteEmps" placeholder="Add limit on number of employees per location" value="<?=($organization['SiteEmps']==0?'':$organization['SiteEmps']);?>"/> 
											</div>
										</div>
									</div>
									<div class="form-group text-center">
										<button type="submit" id="submit" name="submit" class="btn btn-sm btn-success">Save</button>
										<a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin<?= session()->get('organization_page'); ?>" class="btn btn-sm btn-primary">Cancel</a>
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
		<input type="hidden" value="OrganizationsTab" id="CurrentPage" />
		<?= view('Modules\Admin\Views\common\footer'); ?>
		<style>
			.ClientLimitform{display:block;}
		.SiteLimitform{display:block;}
		
		.bootstrap-select{background-color: #fff;
    	background-clip: padding-box;
    	border: 1px solid #ced4da!important;height:auto}
		label:not(.form-check-label):not(.custom-file-label) {font-weight: 400;}
		</style>
		<script>
			

			$('#edit_organization').validate({
				ignore: [],
				rules: {
					FirstName: { required: true },
					LastName: { required: true },
					OrgName: { required: true },
					EmailID: { required: true },
					Password: { required: true },
					Phone: { required: true },
					ManagedBy: { required: true },
					Reporting: { required: true },
					DeploymentType: { required: true },
					OrgType: { required: true },
					Site: { required: true },
					"Designation[]": { required: true },
					"Department[]": { required: true },
				},
				messages: {
					FirstName: "Please enter First Name",
					LastName: "Please select Last Name",
					OrgName: "Please enter Organization Name",
					EmailID: "Please select EmailID",
					Password: "Please enter Password",
					Phone: "Please select Phone",
					ManagedBy: "Please enter Managed By",
					Reporting: "Please select Reporting",
					DeploymentType: "Please enter Deployment Type",
					OrgType: "Please select Organization Type",
					Site: "Please select Site",
					"Designation[]": "Please enter Designation",
					"Department[]": "Please enter Department",
				},

				errorPlacement: function (error, element) {
					if(element[0].name === "ManagedBy" || element[0].name === "Reporting" || element[0].name === "DeploymentType" || element[0].name === "OrgType" || element[0].name === "Site") {
						$(error).insertAfter("."+element[0].name+"error");
					}else {
						$(error[0]).insertAfter($(element[0]));
					}},

				submitHandler: function(form) {
					return true;
				}
			});

			function orgtype(a){
				if(a==2){
					$(".ClientLimitform").show();
				}else{
					$(".ClientLimitform").hide();
				}
			}

			function site(a){
				if(a==2){
					$(".SiteLimitform").show();
				}else{
					$(".SiteLimitform").hide();
				}
			}
		</script>
	</body>
</html>