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
					<div class="card">
						<div class="card-body">
							<div class="row">
								<?php /*<form class="form-horizontal" method="post" action="<?= base_url('admin/buildings/edit_building/'.$building['BID']) ?>" style="width:100%" id="edit_building" method="post">
									
									<div class="form-group row">
										<div class="col-md-6">
											<label for="buildingType">building Name<strong class="help-block">*</strong></label>
											<input type="text" class="form-control" id="BuildingName" name="BuildingName" placehoder="Enter building Name" value="<?= $building['BuildingName'];?>"/> 
											<span id="name_error"></span>
										</div>
										<div class="col-md-6">
											<label for="OrgType">Organization<strong class="help-block">*</strong></label>
											<select class="form-control" name="OrgID" required>
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
										
									</div>
									
									<div class="form-group text-center">
										<button type="submit" id="submit" name="submit" class="btn btn-sm btn-success">Update</button>
										<a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin<?= session()->get('building_page'); ?>" class="btn btn-sm btn-primary">Cancel</a>
									</div>
								</form>*/?>

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
											<input type="text" class="form-control" id="BuildingName" name="BuildingName" placehoder="Enter building Name" value="<?=$building['BuildingName']?>"/>
											<span id="name_error"></span>
										</div>
									</div>
								</div>
							</div>
							<h4>Floors & Rooms Info</h4>
							<div class="card">
								<div class="card-body">
                                    <?php if(!empty($floors)){
                                        $i=0;
                                        foreach($floors  as $floor){
                                            ?>
                                            <div class="MainFloor">
                                                <div class="form-group row">
                                                    <div class="col-md-4">
                                                        <input type="text" name="FloorName[<?=$i?>]" class="form-control" placeholder="Enter Floor Name" autocomplete="off" value="<?=$floor['FloorName']?>">
                                                    </div>
                                                </div>
												
                                                <div class="row">
													<?php 
													if(!empty($rooms[$floor['FID']])){
													$j=0;
													foreach($rooms[$floor['FID']]  as $room){ 
													?>
													
                                                    <div class="col-md-3 mb-2 MainRoom<?=$i?> d-flex RoomeBlk">
                                                        <input type="text" name="RoomName[<?=$i?>][]" value="<?=$room['RoomName']?>" class="form-control RoomName" placeholder="Enter Room Name" autocomplete="off"  style="width: 90%;"/>
														<button type="button" class="btn btn-sm btn-danger RemoveRoom"><span class="fa fa-minus"></span></button>
                                                    </div>
													<?php 
													$j++;
													 } } ?>
                                                    <div class="col-md-1 my-auto">
                                                        <button type="button" class="btn btn-sm btn-success" onclick="AddMoreRooms(<?=$i?>)"><span class="fa fa-plus"></span> Add Room</button>
                                                    </div>
                                                </div>
												<div class="col-md-12 text-right">
													<button type="button" class="btn btn-sm btn-danger RemoveFloor"><span class="fa fa-minus"></span> Remove Floor</button>
                                                <hr>
                                            </div>
											
                                            <?php
                                        $i++;}
                                    }
                                    ?>
									
									<div class="col-md-12 text-right">
										<button type="button" class="btn btn-sm btn-success" id="AddMoreFloorsBtn" onclick="AddMoreFloors(<?=$i++?>)"><span class="fa fa-plus"></span> Add Floor</button>
										&nbsp;
									</div>
								</div>
							</div>
							<div class="form-group text-center">
								<button type="submit" id="submit" name="submit" class="btn btn-sm btn-success">Save</button>
								<a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin<?= session()->get('building_page'); ?>" class="btn btn-sm btn-primary">Cancel</a>
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
		<input type="hidden" value="BuildingsTab" id="CurrentPage" />
		<?= view('Modules\Admin\Views\common\footer'); ?>
		<script>
			$("#edit_building").submit(function(event) {
				var BuildingName = $('#BuildingName').val();
				if(BuildingName == '')
				{
					event.preventDefault();
					$('#name_error').css('color','red');
					$('#name_error').html('Please enter building name');
				}
				else{
					$('#name_error').html();
				}
			});

            function AddMoreRooms(num){
				//alert("asdas");
				$('<div class="col-md-3 mb-2 MainRoom'+num+' d-flex RoomeBlk"><input type="text" name="RoomName['+num+'][]" class="form-control RoomName" placeholder="Enter Room Name" autocomplete="off" style="width: 90%;"/><button type="button" class="btn btn-sm btn-danger RemoveRoom"><span class="fa fa-minus"></span></button></div>').insertAfter($('.MainRoom'+num+'').last());
			}
			// Add More Floors
			function AddMoreFloors(num){
				$('<div class="MainFloor"><div class="form-group row"><div class="col-md-4"><input type="text" name="FloorName['+num+']" class="form-control" placeholder="Enter Floor Name" autocomplete="off"></div></div><div class="row"><div class="col-md-3 mb-2 MainRoom'+num+'"><input type="text" name="RoomName['+num+'][]" class="form-control" placeholder="Enter Room Name" autocomplete="off"/></div><div class="col-md-1 my-auto"><button type="button" class="btn btn-sm btn-success" onclick="AddMoreRooms('+num+')"><span class="fa fa-plus"></span> Add Room</button></div></div><div class="col-md-12 text-right"><button type="button" class="btn btn-sm btn-danger RemoveFloor"><span class="fa fa-minus"></span> Remove Floor</button></div><hr></div>').insertAfter($('.MainFloor').last());
				$("#AddMoreFloorsBtn").attr("onclick", "AddMoreFloors("+(num+1)+")");
			}
			// remove row
			$(document).on('click', '.RemoveRoom', function () {	
				$(this).closest('div.RoomeBlk').remove();
			});
			$(document).on('click', '.RemoveFloor', function () {	
				$(this).closest('div.MainFloor').remove();
			});

		</script>
	</body>
</html>