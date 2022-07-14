		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark">Add Building</h1>
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
								<form class="form-horizontal" method="post" action="<?= base_url('admin/buildings/add_building') ?>" style="width:100%" id="add_building" method="post">
									<div class="form-group row">
										<div class="col-md-4">
											<label for="OrgID">Organization<strong class="help-block">*</strong></label>
											<select class="form-control" name="OrgID" id="OrgID" required>
												<option disabled selected value>Select Organization</option>
												<?php foreach($organizations as $organization){
													echo '<option value="' . $organization['OrgID'] . '">' . $organization['OrgName'] . '</option>' ;
												} ?>
											</select>
										</div>

										<div class="col-md-4">
                                            <label for="BrID">Branch</label>
                                            <select class="form-control" name="BrID" id="BrID">
                                                <option disabled selected value>Select Branch</option>
                                                
                                            </select>
                                        </div>
										<div class="col-md-4">
											<label for="BuildingName">Building Name<strong class="help-block">*</strong></label>
											<input type="text" class="form-control" id="BuildingName" name="BuildingName" placehoder="Enter building Name" />
											<span id="name_error"></span>
										</div>
									</div>
									

									<hr>
									<h4>Floor Info</h4>
									<div class="form-group row">
										<div class="col-md-4">
											<div id="inputFormRow">
											<div class="input-group mb-3">
												<input type="text" name="FloorName[]" class="form-control m-input" placeholder="Enter Floo rName" autocomplete="off">
												<div class="input-group-append">
												
												</div>
											</div>
											</div>
										</div>
										<div class="col-md-2">
											<button id="addRow" type="button" class="btn btn-sm btn-info">+ Add Floor</button>
										</div>
										
									</div>

									<div class="form-group row">
										<div class="col-md-4" >
										<div id="newRow"></div>
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
			$("#add_building").submit(function(event) {
				var BuildingName = $('#BuildingName').val();
				if(BuildingName == '')
				{
					event.preventDefault();
					$('#name_error').css('color','red');
					$('#name_error').html('Please enter building Name');
				}
				else{
					$('#name_error').html();
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
                        dataType:'json',
                        success:function(data)
                        {
                            var html = '<option value="">Select Branch</option>';
                            for(var count = 0; count < data.length; count++)
                            {
                                html += '<option value="'+data[count].BrID +'">'+data[count].BrName+'</option>';
                            }
                            //$('#BrID').html(data)
                            $('#BrID').html(html);
                        }
                    });
                }
                else
                {
                    $('#BrID').val('');
                }
            });

			// add row
			$("#addRow").click(function () {
				var html = '';
				html += '<div id="inputFormRow">';
				html += '<div class="input-group mb-12">';
				html += '<input type="text" name="FloorName[]" class="form-control m-input" placeholder="Enter FloorName" autocomplete="off">';
				html += '<div class="input-group-append">';
				html += '<button id="removeRow" type="button" class="btn btn-danger">X</button>';
				html += '</div>';
				html += '</div>';

				$('#newRow').append(html);
			});

			// remove row
			$(document).on('click', '#removeRow', function () {
				$(this).closest('#inputFormRow').remove();
			});
		
		</script>
	</body>
</html>