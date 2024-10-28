<?php
set_time_limit(0);

if (isset($_GET['page'])) {
  $page = preg_replace('/\D/', '', $_GET['page']);
  $page = (int)$page;
} else{ $page = 1; }

$per_page = 5;
$start_from = ($page - 1) * $per_page;
$SUBJECTS_ID=$_GET['SUBJECTS_ID'];

?>
<?php
include_once 'inc/header.php';
include_once 'inc/navbar.php';
include_once 'inc/sidebar.php';

if (isset($_POST['submit'])) {

   if (class_exists('MdImranHosenClass')) {
        $obj = new MdImranHosenClass();

       

  }
}

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark"> Notic </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home"></i> Home </a></li>
                <li class="breadcrumb-item active"> Notice </li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
    <!-- /.content-header -->
    <section class="content">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
		<br>
		 
        <div class="card-body p-0"><br>
          <div id="notice_del_smg"></div>
          <div id="notice_mqid"></div>
          <table class="table table-bordered table-striped projects">
              <thead>
                  <tr  class="text-center">
                      <th> ID </th>
                      <th> Notice Title </th>
                      <th> Notice Cat </th>
                      <th> Document </th>
                      <th> Marquee </th>
                      <th width="15%"> Action </th>
                  </tr>
              </thead>
              <tbody>
               <?php
                   if (class_exists('MdImranHosenClass')) {
                     $obj = new MdImranHosenClass();
                     if (method_exists($obj, 'getNotice2')) {
                      $data = $obj->getNotice2($SUBJECTS_ID);
                      if ($data) {
                      $i = 0;
                      $file_url = '';
                      while ($rows = $data->fetch_assoc()) {
                      $i++;
                      $id = $rows['id'];
                      $notice_title = $rows['notice_title'];
                      $notice_doc = $rows['notice_doc'];
                      $notice_body = $rows['notice_body'];
                      $notice_cat = $rows['notice_cat'];
                      $mrquee = $rows['mrquee'];
                      $notice_status  = $rows['notice_status'];

                      if (!empty($notice_doc)) {
                        $file_url = "../notices/".$id."/".$notice_doc;
                      }


                  ?>
                  <!--<button type="button" class="btn btn-outline-warning" name="button"><i class="fas fa-chart-line"></i></button> -->
                  <tr>
                      <td><?php echo $id; ?></td>
                      <td><?php echo $notice_title; ?></td>
                      <td><?php if ($notice_cat == 1) { echo "Public"; } else if($notice_cat == 2) { echo "Only Department"; } ?></td>
                      <td>
                        <?php if (!empty($notice_doc)) { ?>
                        <a href="<?php echo $file_url; ?>" class="btn btn-outline-success" download=""><i class="fa fa-download"></i> Download </a>
                        <?php } ?>
                      </td>
                      <td style="text-align:center;"> <input type="checkbox" <?php if ($mrquee == 1) { echo 'checked';  } ?> class="onclick_marquee" data-mqdata="<?php echo $mrquee; ?>" data-mqid="<?php echo $id; ?>" style="padding:15px;" value=""></td>
                      <td class="project-actions text-right">
                          <a class="btn btn-info btn-sm notice_view_onclick" href="javascript:void(0)" data-vid="<?php echo $id; ?>" data-toggle="modal" data-target="#noticeViewModal">
                              <i class="fas fa-eye"></i>  View </a>
                          <a class="btn btn-primary btn-sm notice_edit_onclick" href="javascript:void(0)" data-nid="<?php echo $id; ?>" data-toggle="modal" data-target="#noticeEditModal">
                              <i class="fas fa-edit"></i>  Edit </a>
                          <a class="btn btn-danger btn-sm notice_delete_onclick" href="javascript:void(0)" data-did="<?php echo $id; ?>"> <i class="far fa-trash-alt"></i>  Delete </a>
                      </td>
                  </tr>
               <?php } } } } ?>
              </tbody>
              <tfoot>
              <tr class="text-center">
                      <th> ID. </th>
                      <th> Notice Title </th>
                      <th> Notice Cat </th>
                      <th> Document </th>
                      <th> Marquee </th>
                      <th> Action </th>
               </tr>
              </tfoot>
          </table>
        </div>
       
      </div>
      </div>
      <!-- /.card -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include_once 'inc/footer.php'; ?>
<script type="text/javascript">
  $(document).ready(function() {
    $('.notice_edit_onclick').on('click', function() {
      var notice_id = $(this).data('nid');
       //alert(college_id);

      $.ajax({url:"ajax/notice.php?notice_id="+notice_id+"&edata=98" ,success:function(edit_data){
       $('#notice_from').html(edit_data);

       $('#notice_from_update').on('submit', function(e) {
          var notice_id_up    = $('#notice_id_up').val();
          var notice_title_up = $('#notice_title_up').val();
          var notice_body_up  = $('#notice_body_up').val();
          var notice_cat_up   = $('#notice_cat_up').val();
          var create_date_up  = $('#create_date_up').val();
          var college_program_id_up = $('#college_program_id_up').val();
          var notice_doc_up   = $('#notice_doc_up').prop('files')[0];

          if (notice_title_up == '' || notice_id_up == '' || ( notice_cat_up == '' || notice_cat_up == 0 ) || create_date_up == '') {

            $('#err_notice_title_up').addClass('has-error');
            $('#err_notice_cat_up').addClass('has-error');
            $('#err_create_date_up').addClass('has-error');
            $('#err_err_notice_title_up_msg').html("<div class='text-red'> Title is Required! </div>");
            $('#err_notice_cat_up_msg').html("<div class='text-red'> Category is Required!</div>");
            $('#err_create_date_up_msg').html("<div class='text-red'> Category is Required!</div>");
            return false;
          } else{

            var form_data = new FormData();

            form_data.append('notice_id_up', notice_id_up);
            form_data.append('notice_title_up', notice_title_up);
            form_data.append('notice_body_up', notice_body_up);
            form_data.append('notice_cat_up', notice_cat_up);
            form_data.append('create_date_up', create_date_up);
            form_data.append('college_program_id_up', college_program_id_up);
            form_data.append('notice_doc_up', notice_doc_up);
            form_data.append('updata', 99);

             e.preventDefault();
             $.ajax({
                   type:"post",
                   url:"ajax/notice.php",
                   data: form_data,
                   processData: false,
                   cache: false,
                   contentType: false,
                   success:function(upedata) {
                    $('#notice_update_msg').html(upedata);
                   }
             });
             return false;
          }

       });

     $(function () {
        $('#notice_body_up').summernote();
      });

      }});

    });

     $('.notice_view_onclick').on('click', function() {
          var vid = $(this).data('vid');
          $.ajax({url:"ajax/notice.php?noticev_id="+vid+"&vdata=98", success:function(notice_data){
           $('#notice_details').html(notice_data);
           }
          });
        });

        $('.onclick_marquee').on('click', function() {
             var mqid = $(this).data('mqid');
             var mqdata = $(this).data('mqdata');
            // alert(mqdata);
             $.ajax({url:"ajax/notice.php?notice_mqid="+mqid+"&mqdata="+mqdata+"&mqiddata=98", success:function(notice_mqiddata){
              $('#notice_mqid').html(notice_mqiddata);
              }
             });
           });

     // Delete
      $('.notice_delete_onclick').click(function() {

        // Delete id
        var deleteid = $(this).data('did');

         if(confirm('Do you really want to delete record? '))
           {
              $.ajax({url:"ajax/notice.php?did="+deleteid+"&ddata=98", success:function(notice_del) {
                    $('#notice_del_smg').html(notice_del);
                 }
               });
           }

      });

     

  });

 function noticeCategory() {
      var notice_cat = $('#notice_cat').val();
      if (notice_cat == 2) {
        $('#college_type').css('display','block');
      } else{
        $('#college_type').css('display','none');
      }  
 }

  function noticeCategoryUp() {
      var notice_cat_up = $('#notice_cat_up').val();
      if (notice_cat_up == 2) {
        $('#college_type_up').css('display','block');
      } else{
        $('#college_type_up').css('display','none');
      }  
 }
 
  $(function () {
    $('#notice_body').summernote({
      height: 150,   //set editable area's height
      codemirror: { // codemirror options
        theme: 'monokai'
      }
    });
  });
</script>