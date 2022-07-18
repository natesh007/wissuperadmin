		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark">Edit Block </h1>
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
								<form class="form-horizontal" method="post" action="<?= base_url('admin/blocks/edit_block/'.$block['BKID']) ?>" style="width:100%" id="edit_block" method="post">
									
									<div class="form-group row">
										<div class="col-md-6">
											<label for="blockType">Block Name<strong class="help-block">*</strong></label>
											<input type="text" class="form-control" id="BlockName" name="BlockName" placehoder="Enter block Name" value="<?= $block['BlockName'];?>"/> 
											<span id="name_error"></span>
										</div>
										<div class="col-md-6">
											<label for="OrgType">Organization<strong class="help-block">*</strong></label>
											<select class="form-control" name="OrgID"  id="OrgID" required>
												
												<option disabled selected value>Select Organization</option>
								
												<?php foreach($organizations as $organization){
														echo '<option value="' . $organization['OrgID'] . '"';
														if($organization['OrgID'] == $block['OrgID']){
															echo ' selected';
														}
														echo '>' . $organization['OrgName'] . '</option>' ;
													} ?>
											</select>
										</div>

										<div class="col-md-6">
											<label for="OrgType">Building<strong class="help-block">*</strong></label>
											<select class="form-control" name="BID" id="BID" required>
												
												<option disabled selected value>Select Building</option>
								
												<?php foreach($buildings as $building){
														echo '<option value="' . $building['BID'] . '"';
														if($building['BID'] == $block['BID']){
															echo ' selected';
														}
														echo '>' . $building['BuildingName'] . '</option>' ;
													} ?>
											</select>
										</div>
										
									</div>
									
									<div class="form-group text-center">
										<button type="submit" id="submit" name="submit" class="btn btn-sm btn-success">Update</button>
										<a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin<?= session()->get('block_page'); ?>" class="btn btn-sm btn-primary">Cancel</a>
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
		<input type="hidden" value="BlocksTab" id="CurrentPage" />
		<?= view('Modules\Admin\Views\common\footer'); ?>
		<script>
			$("#edit_block").submit(function(event) {
				var BlockName = $('#BlockName').val();
				if(BlockName == '')
				{
					event.preventDefault();
					$('#name_error').css('color','red');
					$('#name_error').html('Please enter block name');
				}
				else{
					$('#name_error').html();
				}
			});

			$('#OrgID').change(function(){
				var OrgID = $('#OrgID').val();
				if(OrgID != ''){
					$.ajax({
						url: "<?= base_url(); ?>/admin/blocks/getbuildings",
						method:"POST",
						data:{OrgID:OrgID},
						dataType:"JSON",
						success:function(data)
						{
							var html = '<option value="">Select Buildings</option>';
							for(var count = 0; count < data.length; count++)
							{
								html += '<option value="'+data[count].BID +'">'+data[count].BuildingName+'</option>';
							}
							$('#BID').html(html);
						}
					});
				}else{
					$('#BID').val('');
				}
			});
		</script>
	</body>
</html>