
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Shifts</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6 text-right add_user">
							<a href="<?= site_url('admin/shifts/add_shift') ?>" class="btn btn-sm btn-success btn-background">Add New Shift</a>
						</div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
				<?php if (session('msg')) : ?>
					<div class="alert alert-info alert-dismissible">
						<?= session('msg') ?>
						<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
					</div>
				<?php endif ?>
				<div class="row">
							<div class="col-md-3  head-title">
								<button onclick="delete_all('shifts', 'ShID', '', '')" name="delete_all[]" id="delete_all" class="btn btn-danger btn-xs"><span class="fa fa-trash"></span></button> Delete &nbsp;&nbsp;
								<button onclick="active_inactive_all('shifts',1,'ShID')" data-toggle="tooltip" title="Mark As Active" class="btn btn-xs btn-success" name="delete_all[]" id="active_all"><span class="fa fa-check"></span></button> Active &nbsp;&nbsp;
								<button onclick="active_inactive_all('shifts',0,'ShID')" data-toggle="tooltip" title="Mark As Inactive" class="btn btn-xs btn-warning" name="delete_all[]" id="inactive_all"><span class="fa fa-times"></span></button> Inactive
							</div>
							<div class="col-md-9">
								<div class="row">
									<div class="col-md-3">
										<div class="dropdown">
											<button type="button" class="btn btn-sm btn-primary dropdown-toggle form-control" data-toggle="dropdown">
												<?php
												if (session('shift_page') == '/shifts') {
													echo "All Shifts";
												} elseif (session('shift_page') == '/active_shifts') {
													echo "Active Shifts";
												} elseif (session('shift_page') == '/inactive_shifts') {
													echo "Inactive Shifts";
												}
												?>
											</button>
											<div class="dropdown-menu">
												<a class="dropdown-item" href="<?= base_url('admin/shifts') ?>">All Shifts</a>
												<a class="dropdown-item" href="<?= base_url('admin/active_shifts') ?>">Active Shifts</a>
												<a class="dropdown-item" href="<?= base_url('admin/inactive_shifts') ?>">Inactive Shifts</a>
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<select name="selectbox" id="selectbox" class="form-control">
											<option value="">Rows</option>
											<option value="10" <?php if (isset($_GET['nor'])) {
																	if ($_GET['nor'] == '10') {
																		echo 'selected';
																	}
																} ?>>10</option>
											<option value="20" <?php if (isset($_GET['nor'])) {
																	if ($_GET['nor'] == '20') {
																		echo 'selected';
																	}
																} ?>>20</option>
											<option value="30" <?php if (isset($_GET['nor'])) {
																	if ($_GET['nor'] == '30') {
																		echo 'selected';
																	}
																} ?>>30</option>
											<option value="40" <?php if (isset($_GET['nor'])) {
																	if ($_GET['nor'] == '40') {
																		echo 'selected';
																	}
																} ?>>40</option>
											<option value="50" <?php if (isset($_GET['nor'])) {
																	if ($_GET['nor'] == '50') {
																		echo 'selected';
																	}
																} ?>>50</option>
											<option value="100" <?php if (isset($_GET['nor'])) {
																	if ($_GET['nor'] == '100') {
																		echo 'selected';
																	}
																} ?>>100</option>
										</select>
									</div>
									<div class="col-md-7">
										<form class="form-horizontal" action="" method="post">
											<div class="row">
												<div class="col-md-6">
													<input type="text" class="form-control field" name="key_word" placeholder="Enter Key Word" id="key_word" value="<?php print $keyword; ?>">&nbsp;
												</div>
												<div class="col-md-2">
												&nbsp;<span id="searchbtn"><button type="submit" id="submit" name="submit" class="btn btn-sm btn-success field">search</button></span>
												</div>
												<div class="col-md-2">
                                                    <span id="searchbtn"><a href="<?= base_url('admin/shifts/') ?>" class="btn btn-sm  btn-info field">Clear</a></span>
                                                </div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						&nbsp;
						<table id="example1" class="table table-bordered table-striped ">
							<thead>
								<tr>
									<th width="70px"> All &nbsp;<input type="checkbox" id="select_all" class="select_all"></th>
									<th>Shifts Type</th>
                                    <th>Shift Code</th>
                                   
									<th width="110">Actions</th>
								</tr>
							</thead>
							<tbody id="Table">
								<?php
								if(!empty($shift)){
								foreach ($shift as $cnty) {
								?>
									<tr id="<?= $cnty['ShID']; ?>">
										<td>
											<input type="checkbox" name="" class="delete_checkbox" value="<?= $cnty['ShID']; ?>">
										</td>
										<td>
											<?= $cnty['ShType']; ?>
										</td>
										<td>
											<?= $cnty['ShCode']; ?>
										</td>
										
										<td>
											<?php if ($cnty['Status'] == 1) { ?>
												<button data-toggle="tooltip" title="Mark As Inactive" class="btn btn-xs btn-success inactive" onclick="activate_inactivate(<?= $cnty['ShID']; ?>,'shifts','ShID',0)"><span class="fa fa-check"></span></button>
											<?php } else { ?>
												&nbsp;<button data-toggle="tooltip" title="Mark As Active" class="btn btn-xs btn-warning " onclick="activate_inactivate(<?= $cnty['ShID']; ?>,'shifts','ShID',1)"><span class="fa fa-times"></span></button>
											<?php } ?>
											&nbsp;<a data-toggle="tooltip" href="<?= base_url('admin/shifts/edit_shift/' . $cnty['ShID']); ?>" title="Edit" class="btn btn-xs btn-primary"><span class="fa fa-pen"></span></a>
											&nbsp;<button data-toggle="tooltip" onclick="deletedata('<?= $cnty['ShID'] ?>','shifts','ShID', '', '')" title="Delete" class="btn btn-xs btn-danger"><span class="fa fa-trash"></span></button>
										</td>
									</tr>
									<?php
								} }else{
								?>
								<tr><td colspan="4">
								<?php echo "No Shifts Data found!";
							}
							?>
							</tbody>
						</table>
						<?php if(!empty($shift)){ if ($pagelinks) {
							print '<div class="row page">' . $pagelinks . '</div>';
						} } ?>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div><div style="clear:both"></div>
        <!-- /.content-wrapper -->
       

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
	<style>.pagination{margin-left:440px!important;width:100%!important}</style>
    <!-- jQuery -->
	<?= view('Modules\Admin\Views\common\footer'); ?>
    <!-- ./wrapper -->

    
    <script src="<?= base_url()?>/public/admin_assets/commonjs.js"></script>
	<script>
	
</script>
</body>

</html>