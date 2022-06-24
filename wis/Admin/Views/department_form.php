<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<?php //echo $this->renderSection('content') 
	?>
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Add Department</h1>
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
                        <form method="post" action="" style="width:100%" enctype="multipart/form-data" id="add_cats">
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label for="DeptName">Department Name<strong class="help-block">*</strong></label>
                                    <input type="text" class="form-control" name="DeptName" onkeyup="myFunction()" id="DeptName" placeholder="Enter Department Name ..." />
                                    <span id="caterror"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="DeptURL">Department Url<strong class="help-block">*</strong></label>
                                    <input type="text" class="form-control" name="DeptURL" id="DeptURL" placeholder="Enter Department Url ..." />
                                    <span id="caturlerror"></span>
                                </div>
                            </div>
                            <div class="row form-group">
                            <div class="col-md-6">
                                    <label for="ParentDept">Parent Department</label>
                                    <select name="ParentDept" id="ParentDept" class="form-control">
                                        <option disabled selected value>Select Department</option>
                                        <option value="0">None</option>

                                        <?php
                                        if (!empty($total_cats)) {
                                            foreach ($total_cats as $departments) { ?>
                                                <option value="<?= $departments['DeptID']; ?>" style="font-weight:800;background-color:#e9ebed;font-size:18px"><?= $departments['DeptName']; ?></option>
                                                <?php if (isset($departments['children'])) {
                                                    for ($i = 0; $i <= count($departments['children']); $i++) {
                                                        if (isset($departments['children'][$i])) { ?>
                                                            <option value="<?= $departments['children'][$i]['DeptID']; ?>" style="font-weight:400;font-size:14px"> <?= $departments['children'][$i]['DeptName'] ?></option>
                                                            <?php if (isset($departments['children'][$i]['children'])) {
                                                                for ($j = 0; $j <= count($departments['children'][$i]['children']); $j++) {
                                                                    if (isset($departments['children'][$i]['children'][$j])) { ?>
                                                                        <option value="<?= $departments['children'][$i]['children'][$j]['DeptID']; ?>" style="background-color:#bcbfc2;font-size:12px"><?= $departments['children'][$i]['children'][$j]['DeptName']; ?></option>
                                        <?php  }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        } ?>
                                    </select>
                                    <span id="caterror"></span>
                                </div>
                                <div class="col-md-6">
									<label for="BrID">Branch</label>
									<select class="form-control" name="BrID" >
										<option disabled selected value>Select Branch</option>
										<?php foreach($branches as $branch){
											echo '<option value="' . $branch['BrID'] . '">' . $branch['BrName'] . '</option>' ;
										} ?>
									</select>
								</div>
                            </div>
                            
                            <div class="form-group text-center submit_cancel">
                                <span><button type="submit" id="submit" name="submit" class="btn btn-sm btn-success">Save</button></span>
                                <span><a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin<?= session()->get('departments_page'); ?>" class="btn btn-sm btn-primary">Cancel</a> </span>
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

    
<script src="<?= base_url()?>/public/admin_assets/commonjs.js"></script>
<script>
	

    function myFunction() {
        var x = document.getElementById("DeptName").value;
        var res = x.split(' ').join('-')
        document.getElementById("DeptURL").value = res;
    }
    $("#add_cats").submit(function(event) {
        postUrl = '<?= base_url(); ?>/admin/departments/departmentsajax';
        dataToPost = {
            DeptName: $("#DeptName").val(),
            DeptURL: $("#DeptURL").val(),
        };
        $.ajax({
            type: "POST",
            url: postUrl,
            data: dataToPost,
            async: false,
        }).done(function(data) {
            if (data.length != 0) {
                errors = data.split(",");
                for (i = 0; i < errors.length; i++) {
                    var errrorarray = errors[i].split('~');
                    if (errrorarray[0] == 'DeptName') {
                        if (errrorarray[1] != '') {
                            $('#caterror').html(errrorarray[1]);
                            $('#caterror').show();
                            $('#DeptName').focus();
                        } else {
                            $('#caterror').hide();
                        }
                    }
                    if (errrorarray[0] == 'DeptURL') {
                        if (errrorarray[1] != '') {
                            $('#caturlerror').html(errrorarray[1]);
                            $('#caturlerror').show();
                            $('#DeptURL').focus();
                        } else {
                            $('#caturlerror').hide();
                        }
                    }
                }
                event.preventDefault();
            } else {
                return true;
            }
        }).fail(function() {
            alert("Sorry. Server unavailable. ");
            event.preventDefault();
        });
    });
</script>
</body>
</html>