<?php
  require './core/auth.php';
  require './core/library.php';
  $app = new Library();
  
  //get all tags
  $notifications = $app->get_notifications();
  
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Ιστορικό Ενημερώσεων</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php include './common/sidebar.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php include './common/topbar.php'; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Ιστορικό ανακοιώνσεων</h1>
            <!-- <a href="notification_student.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-tag fa-sm text-white-50"></i> Νέα ανακοίνωση</a> -->
          </div>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Πίνακας ανακοιώνσεων</h6>
            </div>
            <div class="card-body">
              <?php 
                
                if (count($notifications) == []) 
                {
                    echo "no notifications";
                }
                else
                {
             ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                      <th>Ημερομινία</th>
                      <th>Μαθητής</th>
                      <th>Μάθημα</th>
                      <th>Ετικέτα</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Ημερομινία</th>
                      <th>Μαθητής</th>
                      <th>Μάθημα</th>
                      <th>Ετικέτα</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  <?php
                  foreach ($notifications as $row) 
                  {  
                  ?>      
                    <tr>
                    <!-- not_id	not_date	not_tag_id	not_lesson_id	not_student_id -->
                        <td><?php echo $row->not_date; ?></td>
                        <td><?php echo $app->get_student($row->not_student_id)->stu_name; ?></td>
                        <td>
                          <?php 
                            if ($row->not_lesson_id == -1)
                            {
                              echo "";
                            }
                            else
                            {
                              echo $app->get_lesson($row->not_lesson_id)->le_name;
                            }
                             
                          ?>
                        </td>
                        <td>
                        <?php 
                          if($row->not_tag_id == -1)
                          {
                            echo "";
                          }
                          else
                          {
                            echo $app->get_tag($row->not_tag_id)->tag_name; 
                          }
                         
                        ?>
                        </td>
                    </tr>
                  <?php } ?>      
                    
                  </tbody>
                </table>
              </div>
             <?php
                
                }
              ?> 
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php include './common/footer.php';  ?> 
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  

  <!-- Logout Modal-->
  <?php include './common/logout_modal.php';  ?> 

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
