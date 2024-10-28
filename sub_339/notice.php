<?php
set_time_limit(0);

if (isset($_GET['page'])) {
  $page = preg_replace('/\D/', '', $_GET['page']);
  $page = (int)$page;
} else {
  $page = 1;
}

$per_page = 5;
$start_from = ($page - 1) * $per_page;

?>
<?php
include_once 'inc/header.php';
include_once 'inc/navbar.php';
include_once 'inc/sidebar.php';

if (isset($_POST['submit'])) {

  if (class_exists('MdImranHosenClass')) {
    $obj = new MdImranHosenClass();

    if (method_exists($obj, 'addNotices')) {
      $msgc = $obj->addNotices($_POST, $_FILES);
    }
  }
}

?>

<div class="modal fade" id="noticeViewModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fas fa-edit"></i> Notice Details </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"> &times; </span>
        </button>
      </div>
      <div class="modal-body">
        <div id="notice_details"></div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal"> Close </button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="noticeEditModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fas fa-edit"></i> Notice Edit </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="notice_from_update" action="" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="modal-body">
          <div id="notice_update_msg"></div>
          <div id="notice_from"></div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"> Close </button>
          <button type="submit" class="btn btn-primary"> Update </button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
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
  <!-- Main content -->
  <section class="content">
    <div class="row"> <!-- justify-content-end -->
      <div class="col-lg-12">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title"> <i class="fas fa-plus"></i> Add Notice </h3>
            <?php if (isset($msgc)) {
              echo $msgc;
            } ?>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group row">
                    <label for="notice_title" class="col-sm-2 col-form-label"> Title <span class="text-red">*</span> </label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="notice_title" id="notice_title" placeholder="Notice Title">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="notice_body" class="col-sm-2 col-form-label"> Text </label>
                    <div class="col-sm-10">
                      <textarea class="form-control notice_body" placeholder="Place some text here" rows="15" name="notice_body" id="notice_body" style="min-height: 400px;"> </textarea>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group row">
                    <label for="notice_cat" class="col-sm-2 col-form-label"> Category <span class="text-red">*</span> </label>
                    <div class="col-sm-10">
                      <select class="form-control" name="notice_cat" id="notice_cat" onchange="return noticeCategory();">
                        <option style="display: none;" value=""> Select Notice Category </option>
                        <option value="1"> Public </option>
                        <option value="2"> Only Department </option>
                        <option value="3"> Only Hall </option>
                      </select>
                    </div>
                  </div>
                  <div id="college_type" style="display: none;">
                    <div class="form-group row">
                      <label for="subject_id" class="col-sm-2 col-form-label">Department</label>
                      <div class="col-sm-10">
                        <select class="form-control" name="SUBJECTS_ID2" id="SUBJECTS_ID2">
                          <option style="display: none;" value="0"> Select Department</option>

                          <?php if (class_exists('MdImranHosenClass')) {
                            $obj = new MdImranHosenClass();
                            if (method_exists($obj, 'getAllSubList')) {
                              $gct = $obj->getAllSubList();
                              if ($gct) {
                                $college_cat_pro = '';
                                while ($cprows = $gct->fetch_assoc()) {
                                  $SUBJECTS_ID   = $cprows['SUBJECTS_ID'];
                                  $SUBJECTS_TITLE_EN = $cprows['SUBJECTS_TITLE_EN'];
                                  $college_cat_pro .= '<option value="' . $SUBJECTS_ID . '">' . $SUBJECTS_TITLE_EN . '</option>';
                                }
                                echo $college_cat_pro;
                              }
                            }
                          } ?>

                        </select>
                      </div>
                    </div>
                  </div>
                  <div id="college_type" style="display: none;">
                    <div class="form-group row">
                      <label for="hall_id" class="col-sm-2 col-form-label">Department</label>
                      <div class="col-sm-10">
                        <select class="form-control" name="SUBJECTS_ID" id="SUBJECTS_ID" onchange="return noticeCategory();">
                          <option value="0"> All </option>
                          <?php if (class_exists('MdImranHosenClass')) {
                            $obj = new MdImranHosenClass();
                            if (method_exists($obj, 'getAllSubList')) {
                              $gct = $obj->getAllSubList();
                              if ($gct) {
                                $college_cat_pro = '';
                                while ($cprows = $gct->fetch_assoc()) {
                                  $SUBJECTS_ID   = $cprows['SUBJECTS_ID'];
                                  $SUBJECTS_TITLE_EN = $cprows['SUBJECTS_TITLE_EN'];
                                  $college_cat_pro .= '<option value="' . $SUBJECTS_ID . '">' . $SUBJECTS_TITLE_EN . '</option>';
                                }
                                echo $college_cat_pro;
                              }
                            }
                          } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="college_email" class="col-sm-2 col-form-label"> Date <span class="text-red">*</span> </label>
                    <div class="col-sm-10">
                      <input type="date" class="form-control" name="create_date" id="create_date">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="notice_doc" class="col-sm-2 col-form-label"> Document </label>
                    <div class="col-sm-10">
                      <div class="btn btn-default btn-file">
                        <i class="fas fa-paperclip"></i> Attachment
                        <input type="file" name="notice_doc" id="notice_doc" accept="image/png, image/jpg, application/pdf, application/doc, application/docx">
                        <small class="text-red"> (.png,.jpg,.jpeg,.pdf,.doc,.docx) </small>
                      </div>
                      <p class="help-block"> Max. 15MB </p>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="college_email" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                      <input type="submit" class="form-control btn btn-success" name="submit" value="Add">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-default float-right"> Cancel </button>
            </div>
            <!-- /.card-footer -->
          </form>
        </div>
        <!-- /.card -->
      </div>
    </div>

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
      <form target="_blank" action="notice_search.php" method="get">
        <div class="row">

          <!--	  <div class="col-sm-4">
			  <input type="text" class="form-group form-control" name="search_exam_name" id="search_exam_name" value="<?php echo $search_exam_name; ?>">
		  </div>-->
          <div class="col-sm-4" style="margin-left:20px">
            <select class="form-group form-control" id="SUBJECTS_ID" name="SUBJECTS_ID">
              <option value="0" style="display: none;cursor: pointer;"> Select Program </option>
              <?php
              if (class_exists('MdImranHosenClass')) {
                $objn = new MdImranHosenClass();

                if (method_exists($objn, "getDepartmentData")) {
                  $gpdex = $objn->getDepartmentData();
                  if ($gpdex) {
                    $goutput_ex = '';
                    while ($grds = $gpdex->fetch_assoc()) {

                      $department_idex = $grds['SUBJECTS_ID'];
                      $department_name_ex = $grds['SUBJECTS_TITLE_EN'];

                      $selected_p = '';
                      if (!empty($department_id_es) || ($department_id_es != 0)) {

                        if ($department_idex == $department_id_es) {

                          $selected_p = ' selected ';
                        }
                      }

                      $goutput_ex .= '<option ' . $selected_p . ' value="' . $department_idex . '">' . $department_name_ex . '</option>';
                    }
                    echo $goutput_ex;
                  }
                }
              } ?>
            </select>
          </div>

          <div class="form-row">
            <div class="col">
              <input type="text" class="form-control" placeholder="search" id="search" name="search">
            </div>
          </div>


          <div class="col-sm-2">
            <button type="submit" name="search_exam" class="btn btn-primary"> Search </button>
          </div>
        </div>
      </form>
      <div class="card-body p-0"><br>
        <div id="notice_del_smg"></div>
        <div id="notice_mqid"></div>
        <table class="table table-bordered table-striped projects">
          <thead>
            <tr class="text-center">
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
              if (method_exists($obj, 'getNotice')) {
                $data = $obj->getNotice($start_from, $per_page);
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
                      $file_url = "../notices/" . $id . "/" . $notice_doc;
                    }


            ?>
                    <!--<button type="button" class="btn btn-outline-warning" name="button"><i class="fas fa-chart-line"></i></button> -->
                    <tr>
                      <td><?php echo $id; ?></td>
                      <td><?php echo $notice_title; ?></td>
                      <td><?php if ($notice_cat == 1) {
                            echo "Public";
                          } else if ($notice_cat == 2) {
                            echo "Only Department";
                          } ?></td>
                      <td>
                        <?php if (!empty($notice_doc)) { ?>
                          <a href="<?php echo $file_url; ?>" class="btn btn-outline-success" download=""><i class="fa fa-download"></i> Download </a>
                        <?php } ?>
                      </td>
                      <td style="text-align:center;"> <input type="checkbox" <?php if ($mrquee == 1) {
                                                                                echo 'checked';
                                                                              } ?> class="onclick_marquee" data-mqdata="<?php echo $mrquee; ?>" data-mqid="<?php echo $id; ?>" style="padding:15px;" value=""></td>
                      <td class="project-actions text-right">
                        <a class="btn btn-info btn-sm notice_view_onclick" href="javascript:void(0)" data-vid="<?php echo $id; ?>" data-toggle="modal" data-target="#noticeViewModal">
                          <i class="fas fa-eye"></i> View </a>
                        <a class="btn btn-primary btn-sm notice_edit_onclick" href="javascript:void(0)" data-nid="<?php echo $id; ?>" data-toggle="modal" data-target="#noticeEditModal">
                          <i class="fas fa-edit"></i> Edit </a>
                        <a class="btn btn-danger btn-sm notice_delete_onclick" href="javascript:void(0)" data-did="<?php echo $id; ?>"> <i class="far fa-trash-alt"></i> Delete </a>
                      </td>
                    </tr>
            <?php }
                }
              }
            } ?>
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
      <!-- /.card-body -->
      <div class="card-footer clearfix">
        <nav aria-label="Contacts Page Navigation">
          <ul class="pagination pagination-md m-0 float-right">
            <?php
            // Start Pagination Make by Md Imran Hosen
            if (class_exists('MdImranHosenClass')) {
              $neObj = new MdImranHosenClass();
              if (method_exists($neObj, 'noticePaginations')) {
                $total_page = $neObj->noticePaginations($per_page);

                if ($total_page > 1) {

                  $pagination = '';

                  if ($page > 1) {
                    $pagination .= '<li class="page-item"><a class="page-link" href="notice.php?page=' . ($page - 1) . '"><span class="icon fa fa-angle-left"></span></a></li>';
                  }

                  /*for ($pagin = 1; $pagin <= $total_page; $pagin++) {

                if ($page == $pagin) {
                    $active_pagin = ' class="page-item active"';
                  } elseif( $page == '') {
                    $active_pagin = ' class="page-item active"';
                  } else{
                   $active_pagin = ' class="page-item"';
                 }

                  $pagination .= '<li '.$active_pagin.'><a class="page-link"  href="notice.php?page='.$pagin.'">'.$pagin.'</a></li>';

                 }*/


                  // Start Pagination Short by Md Imran Hosen

                  if ($total_page >= 10) {

                    for ($pagin = $page; $pagin <= $page + 3; $pagin++) {

                      if ($page == $pagin) {
                        $active_pagin = ' class="page-item active"';
                      } elseif ($page == '') {
                        $active_pagin = ' class="page-item active"';
                      } else {
                        $active_pagin = ' class="page-item"';
                      }

                      if ($page < $total_page - 3) {
                        $pagination .= '<li ' . $active_pagin . '><a class="page-link"  href="notice.php?page=' . $pagin . '">' . $pagin . '</a></li>';
                      }
                    }

                    $pagination .= '<li class="page-item">....</li>';

                    for ($pagin = $total_page - 2; $pagin <= $total_page; $pagin++) {

                      $pagination .= '<li ' . $active_pagin . '><a class="page-link"  href="notice.php?page=' . $pagin . '">' . $pagin . '</a></li>';
                    }
                  } else {

                    for ($pagin = 1; $pagin <= $total_page; $pagin++) {

                      if ($page == $pagin) {
                        $active_pagin = ' class="page-item active"';
                      } elseif ($page == '') {
                        $active_pagin = ' class="page-item active"';
                      } else {
                        $active_pagin = ' class="page-item"';
                      }
                      $pagination .= '<li ' . $active_pagin . '><a class="page-link"  href="notice.php?page=' . $pagin . '">' . $pagin . '</a></li>';
                    }
                  }

                  // End Pagination Short by Md Imran Hosen

                  if ($page < $total_page) {
                    $pagination .= '<li class="page-item"><a class="page-link" href="notice.php?page=' . ($page + 1) . '"><span class="icon fa fa-angle-right"></span></a></li>';
                  }
                  echo $pagination;
                }
              }
            }
            // End Pagination Make by Md Imran Hosen
            ?>
          </ul>
        </nav>
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

      $.ajax({
        url: "ajax/notice.php?notice_id=" + notice_id + "&edata=98",
        success: function(edit_data) {
          $('#notice_from').html(edit_data);

          $('#notice_from_update').on('submit', function(e) {
            var notice_id_up = $('#notice_id_up').val();
            var notice_title_up = $('#notice_title_up').val();
            var notice_body_up = $('#notice_body_up').val();
            var notice_cat_up = $('#notice_cat_up').val();
            var SUBJECTS_ID3 = $('#SUBJECTS_ID3').val();
            var create_date_up = $('#create_date_up').val();
            var college_program_id_up = $('#college_program_id_up').val();
            var notice_doc_up = $('#notice_doc_up').prop('files')[0];

            if (notice_title_up == '' || notice_id_up == '' || (notice_cat_up == '' || notice_cat_up == 0) || create_date_up == '') {

              $('#err_notice_title_up').addClass('has-error');
              $('#err_notice_cat_up').addClass('has-error');
              $('#err_create_date_up').addClass('has-error');
              $('#err_err_notice_title_up_msg').html("<div class='text-red'> Title is Required! </div>");
              $('#err_notice_cat_up_msg').html("<div class='text-red'> Category is Required!</div>");
              $('#err_create_date_up_msg').html("<div class='text-red'> Category is Required!</div>");
              return false;
            } else {

              var form_data = new FormData();

              form_data.append('SUBJECTS_ID3', SUBJECTS_ID3);
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
                type: "post",
                url: "ajax/notice.php",
                data: form_data,
                processData: false,
                cache: false,
                contentType: false,
                success: function(upedata) {
                  $('#notice_update_msg').html(upedata);
                }
              });
              return false;
            }

          });

          $(function() {
            $('#notice_body_up').summernote();
          });

        }
      });

    });

    $('.notice_view_onclick').on('click', function() {
      var vid = $(this).data('vid');
      $.ajax({
        url: "ajax/notice.php?noticev_id=" + vid + "&vdata=98",
        success: function(notice_data) {
          $('#notice_details').html(notice_data);
        }
      });
    });

    $('.onclick_marquee').on('click', function() {
      var mqid = $(this).data('mqid');
      var mqdata = $(this).data('mqdata');
      // alert(mqdata);
      $.ajax({
        url: "ajax/notice.php?notice_mqid=" + mqid + "&mqdata=" + mqdata + "&mqiddata=98",
        success: function(notice_mqiddata) {
          $('#notice_mqid').html(notice_mqiddata);
        }
      });
    });

    // Delete
    $('.notice_delete_onclick').click(function() {

      // Delete id
      var deleteid = $(this).data('did');

      if (confirm('Do you really want to delete record? ')) {
        $.ajax({
          url: "ajax/notice.php?did=" + deleteid + "&ddata=98",
          success: function(notice_del) {
            $('#notice_del_smg').html(notice_del);
          }
        });
      }

    });



  });

  function noticeCategory() {
    var notice_cat = $('#notice_cat').val();
    if (notice_cat == 2) {
      $('#college_type').css('display', 'block');
    } else {
      $('#college_type').css('display', 'none');
    }
  }

  function noticeCategoryUp() {
    var notice_cat_up = $('#notice_cat_up').val();
    if (notice_cat_up == 2) {
      $('#college_type_up').css('display', 'block');
    } else {
      $('#college_type_up').css('display', 'none');
    }
  }

  $(function() {
    $('#notice_body').summernote({
      height: 150, //set editable area's height
      codemirror: { // codemirror options
        theme: 'monokai'
      }
    });
  });
</script>