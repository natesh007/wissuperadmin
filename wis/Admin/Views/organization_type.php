
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Organization Types</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6 text-right add_user">
							<a href="<?= site_url('admin/organization_types/add_organization_type') ?>" class="btn btn-sm btn-success btn-background">Add New Organization Type</a>
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
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-md-3 head-title">
									<button onclick="delete_all('organization_type', 'TypeID', '', '')" name="delete_all[]" id="delete_all" class="btn btn-danger btn-xs"><span class="fa fa-trash"></span></button> Delete &nbsp; &nbsp;
									<button onclick="active_inactive_all('organization_type',1,'TypeID')" data-toggle="tooltip" title="Mark As Active" class="btn btn-xs btn-success" name="delete_all[]" id="active_all"><span class="fa fa-check"></span></button> Active &nbsp; &nbsp;
									<button onclick="active_inactive_all('organization_type',0,'TypeID')" data-toggle="tooltip" title="Mark As Inactive" class="btn btn-xs btn-warning" name="delete_all[]" id="inactive_all"><span class="fa fa-times"></span></button> Inactive
								</div>
								<div class="col-md-9">
									<div class="row">
										<div class="col-md-3">
											<div class="dropdown">
												<button type="button" class="btn btn-sm btn-primary dropdown-toggle form-control" data-toggle="dropdown">
													<?php
													if (session('organization_type_page') == '/organization_types') {
														echo "All organization_types";
													} elseif (session('organization_type_page') == '/active_organization_types') {
														echo "Active organization_types";
													} elseif (session('organization_type_page') == '/inactive_organization_types') {
														echo "Inactive organization_types";
													}
													?>
												</button>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="<?= base_url('admin/organization_types') ?>">All Organization Types</a>
													<a class="dropdown-item" href="<?= base_url('admin/active_organization_types') ?>">Active Organization Types</a>
													<a class="dropdown-item" href="<?= base_url('admin/inactive_organization_types') ?>">Inactive Organization Types</a>
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
														<input type="text" class="form-control" name="key_word" placeholder="Enter Key Word" value="<?php print $keyword; ?>">
													</div>
													<div class="col-md-2">
													<button type="submit" id="submit" name="submit" class="btn btn-sm btn-success">search</button>
													</div>
													<div class="col-md-2">
														<a href="<?= base_url('admin/organization_types') ?>" class="btn btn-sm btn-info">Clear</a>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							&nbsp;
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th width="70px"> All &nbsp;<input type="checkbox" id="select_all" class="select_all"></th>
										<th>Organization Type</th>
										
									
										<th width="110">Actions</th>
									</tr>
								</thead>
								<tbody id="Table">
									<?php
									if(!empty($organization_type)){
									foreach ($organization_type as $cnty) {
									?>
										<tr id="<?= $cnty['TypeID']; ?>">
											<td>
												<input type="checkbox" name="" class="delete_checkbox" value="<?= $cnty['TypeID']; ?>">
											</td>
											<td>
												<?= $cnty['OrganizationType']; ?>
											</td>
											
											
											<td>
												<?php if ($cnty['Status'] == 1) { ?>
													<button data-toggle="tooltip" title="Mark As Inactive" class="btn btn-xs btn-success inactive" onclick="activate_inactivate(<?= $cnty['TypeID']; ?>,'organization_type','TypeID',0)"><span class="fa fa-check"></span></button>
												<?php } else { ?>
													&nbsp;<button data-toggle="tooltip" title="Mark As Active" class="btn btn-xs btn-warning " onclick="activate_inactivate(<?= $cnty['TypeID']; ?>,'organization_type','TypeID',1)"><span class="fa fa-times"></span></button>
												<?php } ?>
												&nbsp;<a data-toggle="tooltip" href="<?= base_url('admin/organization_types/edit_organization_type/' . $cnty['TypeID']); ?>" title="Edit" class="btn btn-xs btn-primary"><span class="fa fa-pen"></span></a>
												&nbsp;<button data-toggle="tooltip" onclick="deletedata('<?= $cnty['TypeID'] ?>','organization_type','TypeID', '', '')" title="Delete" class="btn btn-xs btn-danger"><span class="fa fa-trash"></span></button>
											</td>
										</tr>
										<?php
									} }else{
									?>
									<tr><td colspan="4">
									<?php echo "No Organization Types Data found!";
								}
								?>
								</tbody>
							</table>
							<?php if ($pagelinks) {
								print '<div class="row page">' . $pagelinks . '</div>';
							} ?>
						</div>
					</div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
       	<input type="hidden" value="OrganizationTypesTab" id="CurrentPage" />
		<?= view('Modules\Admin\Views\common\footer'); ?>
	</body>
</html>