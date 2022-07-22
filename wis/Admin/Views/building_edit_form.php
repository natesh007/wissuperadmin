		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark">Edit Building </h1>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.container-fluid -->
			</div>
			<!-- /.content-header -->
			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<!-- Main row -->
					<div class="row">
						<form class="form-horizontal" method="post" action="<?= base_url('admin/buildings/edit_building/'.$building['BID']) ?>" style="width:100%" id="edit_building" method="post">
							<div class="card">
								<div class="card-body">		
									<div class="form-group row">
										<div class="col-md-4">
											<label for="OrgID">Organization<strong class="help-block">*</strong></label>
											<select class="form-control" name="OrgID" id="OrgID" required>
												<option disabled selected value>Select Organization</option>
												<?php foreach($organizations as $organization){
														echo '<option value="' . $organization['OrgID'] . '"';
														if($organization['OrgID'] == $building['OrgID']){
															echo ' selected';
														}
														echo '>' . $organization['OrgName'] . '</option>' ;
													} ?>
											</select>
										</div>
										<div class="col-md-4">
											<label for="BrID">Branch</label>
											<select class="form-control" name="BrID" id="BrID">
												<option disabled selected value>Select Branch</option>
												<option disabled selected value hidden>Select Branch</option>
												<?php foreach($branches as $branch){
													echo '<option value="' . $branch['BrID'] . '"';
													if($branch['BrID'] == $building['BrID']){
														echo ' selected';
													}
													echo '>' . $branch['BrName'] . '</option>' ;
												
												} ?>
											</select>
										</div>
										<div class="col-md-4">
											<label for="BuildingName">Building Name<strong class="help-block">*</strong></label>
											<input type="text" class="form-control" id="BuildingName" name="BuildingName" placehoder="Enter building Name" value="<?= $building['BuildingName']; ?>"/>
											<span id="name_error"></span>
										</div>
									</div>
								</div>
							</div>
							<h4>Blocks & Floors & Rooms Info</h4>
							<?php if(!empty(@$building['blocks'])){ 
								$i = 1;
								foreach($building['blocks'] as $block){ ?>
									<div class="TotalBlock">
										<div class="form-group row">
											<div class="col-md-4">
												<label for="BlockName">Block Name<strong class="help-block">*</strong></label>
												<input type="text" name="BlockName[<?= ($i == 1) ? $i : ''; ?>]" class="form-control" placeholder="Enter Block Name" autocomplete="off" value="<?= $block['BlockName']; ?>">
											</div>
										</div>
										<div class="card">
											<div class="card-body">
												<?php if(!empty(@$block['floors'])){ 
													$j = 1;
													foreach($block['floors'] as $floor){ ?>
														<div class="MainFloor<?= $i ?> <?php if($j > 1) echo 'FloorBlk'; ?>">
															<div class="form-group row">
																<div class="col-md-4">
																	<label for="FloorName">Floor Name<strong class="help-block">*</strong></label>
																	<input type="text" name="FloorName[<?= $i ?>][<?= ($j == 1) ? $j : ''; ?>]" class="form-control" placeholder="Enter Floor Name" autocomplete="off" value="<?= $floor['FloorName']; ?>">
																</div>
															</div>
															<?php if(!empty(@$floor['rooms'])){ ?>
																<label for="RoomName">Room Name<strong class="help-block">*</strong></label>
																<div class="row">
																 	<?php $k = 1; 
																	foreach($floor['rooms'] as $room){ ?>
																		<div class="col-md-3 mb-2 MainRoom_<?= $i ?>_<?= $j ?> <?php if($k > 1) echo 'RoomBlk'; ?>">
																			<input type="text" name="RoomName[<?= $i ?>][<?= $j ?>][<?= ($k == 1) ? $k : ''; ?>]" class="form-control" placeholder="Enter Room Name" autocomplete="off" value="<?= $room['RoomName']; ?>"/>
																			<?php if($k > 1){ ?>
																				<button type="button" class="btn btn-sm btn-danger" style="float: right; margin-top: -38px; height: calc(2.25rem + 2px);" onclick="removerelatedrecords(<?= $room['RID']; ?>, 'room')"><span class="fa fa-minus"></span></button>
																			<?php } ?>
																		</div>
																	<?php $k++; } ?>
																	<div class="col-md-2 my-auto">
																		<button type="button" class="btn btn-sm btn-success" onclick="AddMoreRooms(<?= $i ?>, <?= $j ?>)"><span class="fa fa-plus"></span> Add Room</button>
																	</div>
																</div>
															<?php }else{ ?>
																<label for="RoomName">Room Name<strong class="help-block">*</strong></label>
																<div class="row">
																	<div class="col-md-3 mb-2 MainRoom_<?= $i ?>_<?= $j ?>">
																		<input type="text" name="RoomName[<?= $i ?>][<?= $j ?>][1]" class="form-control" placeholder="Enter Room Name" autocomplete="off"/>
																	</div>
																	<div class="col-md-2 my-auto">
																		<button type="button" class="btn btn-sm btn-success" onclick="AddMoreRooms(<?= $i ?>, <?= $j ?>)"><span class="fa fa-plus"></span> Add Room</button>
																	</div>
																</div>
															<?php } if($j > 1){ ?>
																<div class="col-md-12 text-right"><button type="button" class="btn btn-sm btn-danger" onclick="removerelatedrecords(<?= $floor['FID']; ?>, 'floor')"><span class="fa fa-minus"></span> Remove Floor</button></div>
															<?php } ?>
															<hr>
														</div>
													<?php $j++; } ?>
													<div class="col-md-12 text-right">
														<button type="button" class="btn btn-sm btn-success" id="AddMoreFloorsBtn<?= $i ?>" onclick="AddMoreFloors(<?= $i ?>, <?= $j ?>)"><span class="fa fa-plus"></span> Add Floor</button>
													</div>
												<?php }else{ ?>
													<div class="MainFloor<?= $i ?>">
														<div class="form-group row">
															<div class="col-md-4">
																<label for="FloorName">Floor Name<strong class="help-block">*</strong></label>
																<input type="text" name="FloorName[<?= $i ?>][1]" class="form-control" placeholder="Enter Floor Name" autocomplete="off">
															</div>
														</div>
														<label for="RoomName">Room Name<strong class="help-block">*</strong></label>
														<div class="row">
															<div class="col-md-3 mb-2 MainRoom_<?= $i ?>_1">
																<input type="text" name="RoomName[<?= $i ?>][1][1]" class="form-control" placeholder="Enter Room Name" autocomplete="off"/>
															</div>
															<div class="col-md-2 my-auto">
																<button type="button" class="btn btn-sm btn-success" onclick="AddMoreRooms(<?= $i ?>, 1)"><span class="fa fa-plus"></span> Add Room</button>
															</div>
														</div>
														<hr>
													</div>
													<div class="col-md-12 text-right">
														<button type="button" class="btn btn-sm btn-success" id="AddMoreFloorsBtn<?= $i ?>" onclick="AddMoreFloors(<?= $i ?>, <?= $j ?>)"><span class="fa fa-plus"></span> Add Floor</button>
													</div>
												<?php } ?>
											</div>
										</div>
										<?php if($i > 1){ ?>
											<div class="col-md-12 text-right"><button type="button" class="btn btn-sm btn-danger" onclick="removerelatedrecords(<?= $block['BKID']; ?>, 'block')"><span class="fa fa-minus"></span> Remove Block</button></div>
										<?php } ?>
										<hr>
									</div>
								<?php $i++; } ?>
								<div class="col-md-12 text-right">
									<button type="button" class="btn btn-sm btn-success" id="AddMoreBlocksBtn" onclick="AddMoreBlocks(<?= $i ?>)"><span class="fa fa-plus"></span> Add Block</button>
									&nbsp;
								</div>
							<?php } ?>
							<div class="form-group text-center">
								<button type="submit" id="submit" name="submit" class="btn btn-sm btn-success">Save</button>
								<a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin<?= session()->get('building_page'); ?>" class="btn btn-sm btn-primary">Cancel</a>
							</div>
						</form>
					</div><!-- /.row (main row) -->
				</div><!-- /.container-fluid -->
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->
		<input type="hidden" value="BuildingsTab" id="CurrentPage" />
		<?= view('Modules\Admin\Views\common\footer'); ?>
		<script>
			$('#OrgID').change(function(){
				if($('#OrgID').val() != ''){
					$.ajax({
						url: "<?= base_url(); ?>/admin/departments/getbranches",
						method:"POST",
						data:{OrgID:$('#OrgID').val()},
						dataType:'json',
						success:function(data){
							var html = '<option value="">Select Branch</option>';
							for(var count = 0; count < data.length; count++){
								html += '<option value="'+data[count].BrID +'">'+data[count].BrName+'</option>';
							}
							$('#BrID').html(html);
						}
					});
				}else{
					$('#BrID').val('');
				}
			});

			// Add More Rooms
			function AddMoreRooms(num1, num2){
				$('<div class="col-md-3 mb-2 MainRoom_'+num1+'_'+num2+' RoomBlk"><input type="text" name="RoomName['+num1+']['+num2+'][]" class="form-control" placeholder="Enter Room Name" autocomplete="off"/><button type="button" class="btn btn-sm btn-danger RemoveRoomBtn" style="float: right; margin-top: -38px; height: calc(2.25rem + 2px);"><span class="fa fa-minus"></span></button></div>').insertAfter($('.MainRoom_'+num1+'_'+num2).last());
			}
			// Add More Floors
			function AddMoreFloors(num1, num2){
				$('<div class="MainFloor'+num1+' FloorBlk"><div class="form-group row"><div class="col-md-4"><label for="FloorName">Floor Name</label><input type="text" name="FloorName['+num1+'][]" class="form-control" placeholder="Enter Floor Name" autocomplete="off"></div></div><label for="RoomName">Room Name</label><div class="row"><div class="col-md-3 mb-2 MainRoom_'+num1+'_'+num2+'"><input type="text" name="RoomName['+num1+']['+num2+'][1]" class="form-control" placeholder="Enter Room Name" autocomplete="off"/></div><div class="col-md-2 my-auto"><button type="button" class="btn btn-sm btn-success" onclick="AddMoreRooms('+num1+', '+num2+')"><span class="fa fa-plus"></span> Add Room</button></div></div><div class="col-md-12 text-right"><button type="button" class="btn btn-sm btn-danger RemoveFloorBtn"><span class="fa fa-minus"></span> Remove Floor</button></div><hr></div>').insertAfter($('.MainFloor'+num1).last());
				$("#AddMoreFloorsBtn"+num1).attr("onclick", "AddMoreFloors("+num1+", "+(num2+1)+")");
			}
			// Add More Blocks
			function AddMoreBlocks(num){
				$('<div class="TotalBlock"><div class="form-group row"><div class="col-md-4"><label for="BlockName">Block Name</label><input type="text" name="BlockName[]" class="form-control" placeholder="Enter Block Name" autocomplete="off"></div></div><div class="card"><div class="card-body"><div class="MainFloor'+num+'"><div class="form-group row"><div class="col-md-4"><label for="FloorName">Floor Name</label><input type="text" name="FloorName['+num+'][1]" class="form-control" placeholder="Enter Floor Name" autocomplete="off"></div></div><label for="RoomName">Room Name</label><div class="row"><div class="col-md-3 mb-2 MainRoom_'+num+'_1 d-flex"><input type="text" name="RoomName['+num+'][1][1]" class="form-control" placeholder="Enter Room Name" autocomplete="off"/></div><div class="col-md-2 my-auto"><button type="button" class="btn btn-sm btn-success" onclick="AddMoreRooms('+num+', 1)"><span class="fa fa-plus"></span> Add Room</button></div></div><hr></div><div class="col-md-12 text-right"><button type="button" class="btn btn-sm btn-success" id="AddMoreFloorsBtn'+num+'" onclick="AddMoreFloors('+num+', 2)"><span class="fa fa-plus"></span> Add Floor</button></div></div></div><div class="col-md-12 text-right"><button type="button" class="btn btn-sm btn-danger RemoveBlockBtn"><span class="fa fa-minus"></span> Remove Block</button></div><hr></div>').insertAfter($('.TotalBlock').last());
				$("#AddMoreBlocksBtn").attr("onclick", "AddMoreBlocks("+(num+1)+")");
			}
			// Remove Rooms
			$(document).on('click', '.RemoveRoomBtn', function () {	
				$(this).closest('div.RoomBlk').remove();
			});
			// Remove Floors
			$(document).on('click', '.RemoveFloorBtn', function () {	
				$(this).closest('div.FloorBlk').remove();
			});
			// Remove Blocks
			$(document).on('click', '.RemoveBlockBtn', function () {	
				$(this).closest('div.TotalBlock').remove();
			});

			$('#edit_building').validate({
				ignore: [],
				rules: {
					OrgID: { required: true },
					BrID: { required: true },
					BuildingName: { required: true },
					"BlockName[1]": { required: true },
					"FloorName[1][1]": { required: true },
					"RoomName[1][1][1]": { required: true},
				},
				messages: {
					OrgID: "Please select Organization",
					BrID: "Please select Branch",
					BuildingName:"Please enter Building Name",
					"BlockName[1]": "Please enter Block Name",
					"FloorName[1][1]": "Please enter Floor Name",
					"RoomName[1][1][1]": "Please enter Room Name",
				},
				submitHandler: function(form) {
					return true;
				}
			});
			function removerelatedrecords(ID, Table){
				$.post("<?= base_url() ?>/admin/buildings/removerelatedrecords", {ID: ID, Table: Table}, function(data, status){
					if(data == 1)
						window.location.href = window.location.href;
				});
			}
		</script>
	</body>
</html>