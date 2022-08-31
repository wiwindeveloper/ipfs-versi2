// Call the dataTables jQuery plugin
$(document).ready(function () {
  $('#dataTable').DataTable({
    "searching": true,
    "order": [[0, "desc"]],
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
  });
});

$(document).ready(function () {
  $('#dataTable2').DataTable({
    "searching": true,
    "order": [[0, "desc"]],
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
  });
});

$(document).ready(function () {
  $('#tablenotorder').DataTable({
    "searching": true,
    "lengthMenu": [[-1, 10, 25, 50], ["All", 10, 25, 50]],
    "order": []
  });
});

$(document).ready(function () {
  $('#tabledetail').DataTable({
    "searching": true,
    "lengthMenu": [[-1, 10, 25, 50], ["All", 10, 25, 50]],
    "order": [[1, "asc"]],
  });
});

$(document).ready(function () {
  $('#tablenotorder2').DataTable({
    "searching": true,
    "lengthMenu": [[-1, 10, 25, 50], ["All", 10, 25, 50]],
    "order": []
  });
});

$(document).ready(function () {
  $('#tablenotorder3').DataTable({
    "searching": true,
    "lengthMenu": [[-1, 10, 25, 50], ["All", 10, 25, 50]],
    "order": []
  });
});

// multiple table in one page
$(document).ready(function () {
  $('table.display').DataTable({
    "searching": false,
    "order": [[0, "desc"]],
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
  });
});

// table with filter date
$(document).ready(function () {
  $.fn.dataTable.ext.search.push(
    function (settings, data, dataIndex) {
      if (settings.nTable.id !== 'table') {
        return true;
      }

      var min_date = document.getElementById("min").value;
      var min = new Date(min_date);
      var max_date = document.getElementById("max").value;
      var max = new Date(max_date);

      var startDate = new Date(data[0]);
      //window.confirm(startDate);
      if (!min_date && !max_date) {
        return true;
      }
      if (!min_date && startDate <= max) {
        return true;
      }
      if (!max_date && startDate >= min) {
        return true;
      }
      if (startDate <= max && startDate >= min) {
        return true;
      }
      return false;
    }
  );
  $('#table').DataTable({
    "lengthMenu": [[-1, 10, 25, 50], ["All", 10, 25, 50]],
    "order": [[1, "asc"]],
  });

  var table = $('#table').DataTable();
  // Event listener to the two range filtering inputs to redraw on input
  $('#min, #max').change(function () {
    table.draw();
  });
  $('#myInputTextField').keyup(function () {
    table.search($(this).val()).draw();
  })
});
