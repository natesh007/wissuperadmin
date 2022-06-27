		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark">Add Room</h1>
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
								<form class="form-horizontal" method="post" action="<?= base_url('admin/rooms/add_room') ?>" style="width:100%" id="add_room" method="post">
									<div class="form-group row">
										<div class="col-md-6">
											<label for="RoomName">Room Name<strong class="help-block">*</strong></label>
											<input type="text" class="form-control" id="RoomName" name="RoomName" placehoder="Enter room Name" />
											<span id="name_error"></span>
										</div>
										<div class="col-md-6">
											<label for="BID">Organization<strong class="help-block">*</strong></label>
											<select class="form-control" name="OrgID" id="OrgID" required>
												<option disabled selected value>Select Organization</option>
												<?php foreach($organizations as $organization){
													echo '<option value="' . $organization['OrgID'] . '">' . $organization['OrgName'] . '</option>' ;
												} ?>
											</select>
										</div>

										<div class="col-md-6">
											<label for="BID">Building<strong class="help-block">*</strong></label>
											<select name="BID" id="BID" class="form-control input-lg" required> 
												<option value="">Select Buildings</option>
											</select>
										</div>

										<div class="col-md-6">
											<label for="FID">Floor<strong class="help-block">*</strong></label>
											<select name="FID" id="FID" class="form-control input-lg" required> 
												<option value="">Select Floor</option>
											</select>
										</div>
										
										
									</div>
									
									<div class="form-group text-center">
										<button type="submit" id="submit" name="submit" class="btn btn-sm btn-success">Save</button>
										<a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin<?= session()->get('room_page'); ?>" class="btn btn-sm btn-primary">Cancel</a>
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
		<input type="hidden" value="RoomsTab" id="CurrentPage" />
		<?= view('Modules\Admin\Views\common\footer'); ?>
		<script>
			$("#add_room").submit(function(event) {
				var RoomName = $('#RoomName').val();    
				if(RoomName == '')
				{
					event.preventDefault();
					$('#name_error').css('color','red');
					$('#name_error').html('Please enter room Name');
				}
				else{
					$('#name_error').html();
				}      
			});
			$('#OrgID').change(function(){
				var OrgID = $('#OrgID').val();
				if(OrgID != ''){
					$.ajax({
						url: "<?= base_url(); ?>/admin/rooms/getbuildings",
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
			$('#BID').change(function(){
				var BID = $('#BID').val();
				if(BID != ''){
					$.ajax({
						url: "<?= base_url(); ?>/admin/rooms/getfloors",
						method:"POST",
						data:{BID:BID},
						dataType:"JSON",
						success:function(data)
						{
							var html = '<option value="">Select Floor</option>';
							for(var count = 0; count < data.length; count++)
							{
								html += '<option value="'+data[count].FID +'">'+data[count].FloorName+'</option>';
							}
							$('#FID').html(html);
						}
					});
				}else{
					$('#FID').val('');
				}
			});
		</script>
	</body>
</html>