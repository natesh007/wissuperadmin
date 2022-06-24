<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<?php //echo $this->renderSection('content') 
	?>
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Edit Branch </h1>
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
						<form class="form-horizontal" method="post" action="<?= base_url('admin/branches/edit_branch/'.$branch['BrID']) ?>" style="width:100%" id="edit_branch" method="post">
							
							<div class="form-group row">
								<div class="col-md-6 my-2">
									<label for="branchType">Branch Name<strong class="help-block">*</strong></label>
									<input type="text" class="form-control" id="BrName" name="BrName" placehoder="Enter Branch Name ..." value="<?= $branch['BrName'];?>"/> 
									<span id="name_error"></span>
								</div>
                                <div class="col-md-6">
									<label for="OrgType">Organization<strong class="help-block">*</strong></label>
									<select class="form-control" name="OrgID" required>
										<option disabled selected value>Select Organization</option>
						
										<?php foreach($organizations as $organization){
												echo '<option value="' . $organization['OrgID'] . '"';
												if($organization['OrgID'] == $branch['OrgID']){
													echo ' selected';
												}
												echo '>' . $organization['OrgName'] . '</option>' ;
											} ?>
									</select>
								</div>
                                
							</div>
							<div class="form-group row">
								<div class="col-md-6 my-2">
									<label for="Address">Address </label>
									<textarea class="form-control" id="Address" name="Address" placehoder="Enter Address ..." /><?= $branch['Address'];?></textarea>
									
								</div>
                                
								<div class="col-md-6 my-2">
									<label for="Langitude">Langitude </label>
									<input type="text" class="form-control" id="BrLangitude" name="BrLangitude" placehoder="Enter Langitude ..." value="<?= $branch['BrLangitude'];?>"/>
									
								
								</div>
                                
							</div>
							<div class="form-group row">
								<div class="col-md-6 my-2">
									<label for="Latitude">Latitude</label>
									<input type="text" class="form-control" id="BrLatitude" name="BrLatitude" placehoder="Enter Latitude ..."  value="<?= $branch['BrLatitude'];?>"/>
									
								</div>
                                
                                
							</div>
							<div class="form-group text-center submit_cancel">
								<span><button type="submit" id="submit" name="submit" class="btn btn-sm btn-success">Update</button></span>
								<span><a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin<?= session()->get('branch_page'); ?>" class="btn btn-sm btn-primary">Cancel</a> </span>
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

</div>
<!-- ./wrapper -->

<?= view('Modules\Admin\Views\common\footer'); ?>
    <!-- ./wrapper -->
	<style>.form-group{margin-bottom: 0px!important;}</style>
    
<script src="<?= base_url()?>/public/admin_assets/commonjs.js"></script>

<script>
	$("#edit_branch").submit(function(event) {
		var BrName = $('#BrName').val();
      
       
        if(BrName == '')
        {
            event.preventDefault();
            $('#name_error').css('color','red');
            $('#name_error').html('Please enter branch name');
        }
        else{
            $('#name_error').html();
        }
        
	});
</script>
</body>

</html>