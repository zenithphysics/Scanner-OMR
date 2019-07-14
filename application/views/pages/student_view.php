<div class="row border-bottom white-bg page-heading">
  <div class="col-lg-10">
      <h2><?php echo @$breadcrumb['heading']; ?></h2>
      <ol class="breadcrumb">
          <?php
          if(isset($breadcrumb['route']))
          { 
              foreach ($breadcrumb['route'] as $route)
              {
                  if(is_array($route))
                  {
                      echo "<li><a href=".base_url($route['path']).">".$route['title']."</a></li>";
                  }
                  else
                  {
                      echo "<li class='active'><strong>".$route."</strong></li>";
                  }
              }
          }
          ?>
          </li>
      </ol>
  </div>
  <div class="col-lg-2">
  </div>
</div>
<div class="row wrapper wrapper-content animated fadeInRight">
  <div class="ibox-title">
    <a href="<?php echo base_url('student/add'); ?>"><button class="btn btn-success btn-outline"> <i class="fa fa-plus"></i> Add Student</button></a>
  </div>
  <div class="ibox-content">
    <div id="data_table" class="row">
      <table id="example" class="display responsive nowrap" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Student Name</th>
            <th>Roll No.</th>
            <th>Batch</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script src="<?php echo base_url("js/plugins/dataTables/jquery.dataTables.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/dataTables/dataTables.tableTools.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/datapicker/bootstrap-datepicker.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/fullcalendar/moment.min.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins/daterangepicker/daterangepicker.js"); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/buttons.dataTables.min.css'); ?>">
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/dataTables.buttons.min.js'); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/buttons.flash.min.js'); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/jszip.min.js'); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/pdfmake.min.js'); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/vfs_fonts.js'); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/buttons.html5.min.js'); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/buttons.print.min.js'); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo base_url("js/bootbox.min.js"); ?>"></script>
<script type="text/javascript">
$(document).ready(function() {
  oTable = $('#example').DataTable( {
    "ajax": "<?php echo base_url('student/get_show_data'); ?>",
    "dom": 'lBftip',
    "buttons": [
      'copy', 'csv', 'excel', 'pdf', 'print'
    ],
    "columns": [
      { "data": "name" },
      { "data": "roll_no" },
      { "data": "batch" },
      { "data": "description" },
      { "data": "Actions" }
    ]
  });
  $('.dt-buttons').css({'float':'right'});
});

function deletef(id,href)
{
  bootbox.confirm('Are you sure you want to delete?', function(result) {
    if(result == true)
    {
      $('body').prepend('<div id="Login_screen"><img src="'+base_url+'img/loader1.gif"></div>');
      $("#Login_screen").fadeIn('fast');
      $.ajax({
        url:href+'/'+id,
        method:'POST',
        datatype:'JSON',
        error: function(jqXHR, exception) {
          $("#Login_screen").fadeOut(2000);
          //Remove Loader
          if (jqXHR.status === 0) {
            alert('Not connect.\n Verify Network.');
          } else if (jqXHR.status == 404) {
            alert('Requested page not found. [404]');
          } else if (jqXHR.status == 500) {
            alert('Internal Server Error [500].');
          } else if (exception === 'parsererror') {
            alert('Requested JSON parse failed.');
          } else if (exception === 'timeout') {
            alert('Time out error.');
          } else if (exception === 'abort') {
            alert('Ajax request aborted.');
          } else {
            alert('Uncaught Error.\n' + jqXHR.responseText);
          }
        },
        success:function(response){
          $("#Login_screen").fadeOut(2000);
          response = JSON.parse(response);
          if(response === true)
          {
            swal({
              title: 'Done',
              text: 'Successfully Deleted.',
              type: "success"               
              },
              function(){
              oTable.ajax.reload();
            });
          }
          else
          {
            swal("Oops...", "Something went wrong!", "error");
          }
        }
      });
    }
  });
}
</script>