		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark">Edit City </h1>
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
								<form class="form-horizontal" method="post" action="<?= base_url('admin/cities/edit_city/'.$city['CityID']) ?>" style="width:100%" id="edit_city" method="post">
									
									<div class="form-group row">
										<div class="col-md-6">
											<label for="cityType">City Name<strong class="help-block">*</strong></label>
											<input type="text" class="form-control" id="CityName" name="CityName" placehoder="Enter city Name" value="<?= $city['CityName'];?>"/> 
											<span id="name_error"></span>
										</div>
										<div class="col-md-6">
											<label for="Langitude">Langitude </label>
											<input type="text" class="form-control" id="Langitude" name="Langitude" placehoder="Enter Langitude" value="<?= $city['Langitude'];?>"/>
											
										
										</div>
										
									</div>
									<div class="form-group row">
									<div class="col-md-6">
											<label for="Latitude">Latitude</label>
											<input type="text" class="form-control" id="Latitude" name="Latitude" placehoder="Enter Latitude"  value="<?= $city['Latitude'];?>"/>
											
										</div>
										
										
										
										
									</div>
									
									<div class="form-group text-center">
										<button type="submit" id="submit" name="submit" class="btn btn-sm btn-success">Update</button>
										<a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin<?= session()->get('city_page'); ?>" class="btn btn-sm btn-primary">Cancel</a>
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
		<input type="hidden" value="CitiesTab" id="CurrentPage" />
		<?= view('Modules\Admin\Views\common\footer'); ?>
		<script>
			$("#edit_city").submit(function(event) {
				var CityName = $('#CityName').val();
				if(CityName == '')
				{
					event.preventDefault();
					$('#name_error').css('color','red');
					$('#name_error').html('Please enter city name');
				}
				else{
					$('#name_error').html();
				}
			});
		</script>
	</body>
</html>