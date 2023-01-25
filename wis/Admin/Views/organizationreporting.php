
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"> Organization Reporting</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6 text-right add_user">
							<a href="<?= site_url('admin/organizationreporting/add_organizationreporting') ?>" class="btn btn-sm btn-success btn-background">Add New Organization Reporting</a>
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
								<div class="col-md-3  head-title">
									<button onclick="delete_all('organizationreporting', 'OrgReportingID', '', '')" name="delete_all[]" id="delete_all" class="btn btn-danger btn-xs"><span class="fa fa-trash"></span></button> Delete &nbsp;&nbsp;
									<button onclick="active_inactive_all('organizationreporting',1,'OrgReportingID')" data-toggle="tooltip" title="Mark As Active" class="btn btn-xs btn-success" name="delete_all[]" id="active_all"><span class="fa fa-check"></span></button> Active &nbsp;&nbsp;
									<button onclick="active_inactive_all('organizationreporting',0,'OrgReportingID')" data-toggle="tooltip" title="Mark As Inactive" class="btn btn-xs btn-warning" name="delete_all[]" id="inactive_all"><span class="fa fa-times"></span></button> Inactive
								</div>
								<div class="col-md-9">
									<div class="row">
										<div class="col-md-3">
											<div class="dropdown">
												<button type="button" class="btn btn-sm btn-primary dropdown-toggle form-control" data-toggle="dropdown">
													<?php
													if (session('organizationreporting_page') == '/organizationreporting') {
														echo "All Organization Reportings";
													} elseif (session('organizationreporting_page') == '/organizationreporting/1') {
														echo "Active Organization Reportings";
													} elseif (session('organizationreporting_page') == '/organizationreporting/0') {
														echo "Inactive Organization Reportings";
													}
													?>
												</button>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="<?= base_url('admin/organizationreporting') ?>">All Organization Reportings</a>
													<a class="dropdown-item" href="<?= base_url('admin/organizationreporting/1') ?>">Active Organization Reportings</a>
													<a class="dropdown-item" href="<?= base_url('admin/organizationreporting/0') ?>">Inactive Organization Reportings</a>
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
														<a href="<?= base_url('admin/organizationreporting') ?>" class="btn btn-sm btn-info">Clear</a>
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
										<th>Reporting</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody id="Table">
									<?php
									if(!empty($organizationreporting)){
									foreach ($organizationreporting as $cnty) {
									?>
										<tr id="<?= $cnty['OrgReportingID']; ?>">
											<td>
												<input type="checkbox" name="" class="delete_checkbox" value="<?= $cnty['OrgReportingID']; ?>">
											</td>
											<td>
												<?= $cnty['Reporting']; ?>
											</td>
											
											
											<td>
												<?php if ($cnty['Status'] == 1) { ?>
													<button data-toggle="tooltip" title="Mark As Inactive" class="btn btn-xs btn-success inactive" onclick="activate_inactivate(<?= $cnty['OrgReportingID']; ?>,'organizationreporting','OrgReportingID',0)"><span class="fa fa-check"></span></button>
												<?php } else { ?>
													&nbsp;<button data-toggle="tooltip" title="Mark As Active" class="btn btn-xs btn-warning " onclick="activate_inactivate(<?= $cnty['OrgReportingID']; ?>,'organizationreporting','OrgReportingID',1)"><span class="fa fa-times"></span></button>
												<?php } ?>
												&nbsp;<a data-toggle="tooltip" href="<?= base_url('admin/organizationreporting/edit_organizationreporting/' . $cnty['OrgReportingID']); ?>" title="Edit" class="btn btn-xs btn-primary"><span class="fa fa-pen"></span></a>
												&nbsp;<button data-toggle="tooltip" onclick="deletedata('<?= $cnty['OrgReportingID'] ?>','organizationreporting','OrgReportingID', '', '')" title="Delete" class="btn btn-xs btn-danger"><span class="fa fa-trash"></span></button>
											</td>
										</tr>
										<?php
									} }else{
									?>
									<tr><td colspan="4">
									<?php echo "No Organization Reporting Data found!";
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
		<input type="hidden" value="OrganizationReportingTab" id="CurrentPage" />
		<?= view('Modules\Admin\Views\common\footer'); ?>
	</body>
</html>