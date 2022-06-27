var baseURL = $("#BaseURL").val();

//Activate Or Inactive Record
function activate_inactivate(Id, tbl, col, status) {
  $.ajax({
    type: "POST",
    url: baseURL + "/admin/activate_inactivate",
    data: { table: tbl, Id: Id, column: col, status: status },
    async: false,
  }).done(function (data) {
    location.reload();
  });
}

//Delete Record
function deletedata(Id, tbl, col, img, thumb) {
  $.ajax({
    type: "POST",
    url: baseURL + "/admin/delete",
    data: { table: tbl, Id: Id, column: col, Image: img, Thumb: thumb},
    async: false,
  }).done(function (data) {
    location.reload();
  });
}

//Select All Records
$("#select_all").on("click", function () {
  if (this.checked) {
    $(".delete_checkbox").each(function () {
      this.checked = true;
    });
  } else {
    $(".delete_checkbox").each(function () {
      this.checked = false;
    });
  }
});

$(".delete_checkbox").on("click", function () {
  if ($(".delete_checkbox:checked").length == $(".delete_checkbox").length) {
    $("#select_all").prop("checked", true);
  } else {
    $("#select_all").prop("checked", false);
  }
});

//Active All Or Inactive All Records
function active_inactive_all(table, status, col) {
  var checkbox = $(".delete_checkbox:checked");
  if (checkbox.length > 0) {
    var checkbox_value = [];
    $(checkbox).each(function () {
      checkbox_value.push($(this).val());
    });
    $.ajax({
      url: baseURL + "/admin/active_inactive_all",
      method: "POST",
      data: {
        checkbox_value: checkbox_value,
        table: table,
        status: status,
        column: col,
      },
      success: function (value) {
        if (value == 1) {
          location.reload();
        }
      },
    });
  } else {
    alert("Select atleast one records");
  }
}

//Delete All Records
function delete_all(table, col, img, thumb) {
  var checkbox = $(".delete_checkbox:checked");
  if (checkbox.length > 0) {
    var checkbox_value = [];
    $(checkbox).each(function () {
      checkbox_value.push($(this).val());
    });
    $.ajax({
      url: baseURL + "/admin/delete_all",
      method: "POST",
      data: { checkbox_value: checkbox_value, table: table, column: col, Image: img, Thumb: thumb },
      success: function (value) {
        if (value == 1) {
          location.reload();
        }
      },
    });
  } else {
    alert("Select atleast one records");
  }
}
//No Of Rows Filter
$("#selectbox").change(function () {
  var urlsplit = window.location.href.split("?");
  location.href = urlsplit[0] + "?nor=" + $(this).val();
});