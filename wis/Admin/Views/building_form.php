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
            <div class="row">
                <form class="form-horizontal" method="post" action="<?= base_url('admin/buildings/add_building') ?>" style="width:100%" id="add_building" method="post">
                    <div class="card">
                        <div class="card-body">		
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="OrgID">Organization<strong class="help-block">*</strong></label>
                                    <select class="form-control" name="OrgID" id="OrgID">
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4>Floors & Rooms Info</h4>
                    <div class="card MainFloor">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="FloorName">Floor Name<strong class="help-block">*</strong></label>
                                    <input type="text" name="FloorName[1]" class="form-control" placeholder="Enter Floor Name" autocomplete="off">
                                </div>
                            </div>
                            <label for="RoomName">Room Name<strong class="help-block">*</strong></label>
                            <div class="row">
                                <div class="col-md-3 mb-2 MainRoom1">
                                    <input type="text" name="RoomName[1][1]" class="form-control" placeholder="Enter Room Name" autocomplete="off"/>
                                </div>
                                <div class="col-md-2 my-auto">
                                    <button type="button" class="btn btn-sm btn-success" onclick="AddMoreRooms(1)"><span class="fa fa-plus"></span> Add Room</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-sm btn-success" onclick="AddMoreFloors(2)"><span class="fa fa-plus"></span> Add Floor</button>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" id="submit" name="submit" class="btn btn-sm btn-success">Save</button>
                        <a data-toggle="tooltip" title="Cancel" href="<?= base_url(); ?>/admin<?= session()->get('building_page'); ?>" class="btn btn-sm btn-primary">Cancel</a>
                    </div>
                </form>
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
    // Add More Floors
    function AddMoreFloors(num){
        $('<div class="card MainFloor FloorBlk"><div class="card-body"><div class="form-group row"><div class="col-md-4"><label for="FloorName">Floor Name<strong class="help-block">*</strong></label><input type="text" name="FloorName[]" class="form-control" placeholder="Enter Floor Name" autocomplete="off"></div></div><label for="RoomName">Room Name<strong class="help-block">*</strong></label><div class="row"><div class="col-md-3 mb-2 MainRoom'+num+'"><input type="text" name="RoomName['+num+'][1]" class="form-control" placeholder="Enter Room Name" autocomplete="off"/></div><div class="col-md-2 my-auto"><button type="button" class="btn btn-sm btn-success" onclick="AddMoreRooms('+num+')"><span class="fa fa-plus"></span> Add Room</button></div></div><hr><div class="col-md-12 text-right"><button type="button" class="btn btn-sm btn-danger RemoveFloorBtn"><span class="fa fa-minus"></span> Remove Floor</button></div></div></div>').insertAfter($('.MainFloor').last());
    }
    // Add More Rooms
    function AddMoreRooms(num){
        $('<div class="col-md-3 mb-2 MainRoom'+num+' RoomBlk"><input type="text" name="RoomName['+num+'][]" class="form-control" placeholder="Enter Room Name" autocomplete="off"/><button type="button" class="btn btn-sm btn-danger RemoveRoomBtn" style="float: right; margin-top: -38px; height: calc(2.25rem + 2px);"><span class="fa fa-minus"></span></button></div>').insertAfter($('.MainRoom'+num).last());
    }
    // Remove Floors
    $(document).on('click', '.RemoveFloorBtn', function () {	
        $(this).closest('div.FloorBlk').remove();
    });
    // Remove Rooms
    $(document).on('click', '.RemoveRoomBtn', function () {	
        $(this).closest('div.RoomBlk').remove();
    });
    $('#add_building').validate({
            ignore: [],
            rules: {
                OrgID: { required: true },
                BrID: { required: true },
                BuildingName: { required: true },
                "FloorName[1][1]": { required: true },
                "RoomName[1][1][1]": { required: true},
            },
            messages: {
                OrgID: "Please select Organization",
                BrID: "Please select Branch",
                BuildingName:"Please enter Building Name",
                "FloorName[1][1]": "Please enter Floor Name",
                "RoomName[1][1][1]": "Please enter Room Name",
            },
            submitHandler: function(form) {
                return true;
            }
        });
</script>
</body>
</html>