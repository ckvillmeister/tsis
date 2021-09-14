<!DOCTYPE html>
<html>

<head>
  <?php require 'app/views/components/header.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

<div class="wrapper">
  <?php require 'app/views/components/navbar.php'; ?>
  <?php require 'app/views/components/sidebar.php'; ?>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Summary</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>main">Main</a></li>
                <li class="breadcrumb-item active">Summary</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="card">

            <div class="overlay-wrapper">
            
            </div>

            <div id="report">
              <br>
              <div class="header text-center">
                  <h3>Summary <span class="year"><?php echo ($data['year']) ? $data['year'] : ''; ?><span></h3>
                </div>
                <div class="row shadow-none m-3 rounded">
                  <div class="col-lg-12 align-self-center">
                    <table class="table table-sm table-bordered table-striped display nowrap bg-white" id="tbl_result" style="width:100%">
                      <thead>
                        <tr>
                          <td class="text-center">No.</td>
                          <td class="text-center">Barangay</td>
                          <td class="text-center">Ward Leaders</td>
                          <td class="text-center">Ward Members</td>
                          <td class="text-center">Total Supporters</td>
                          <td class="text-center">Total Voters</td>
                          <td class="text-center">60% of Total Voters</td>
                          <td class="text-center">Difference <br> (60% Voters - Total Supporters)</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $total_leaders = 0;
                          $total_members = 0;
                          $total_supporters = 0;
                          $total_voters = 0;
                          $total_voters_60 = 0;
                          $total_difference = 0;

                          $ctr = 1;
                          $prev_post = "";
                          foreach ($data['summary'] as $key => $sum) {
                            $total_leaders += $sum['leaders'];
                            $total_members += $sum['members'];
                            $total_supporters += ($sum['leaders'] + $sum['members']);
                            $total_voters += $sum['voters'];
                            $total_voters_60 += round($sum['voters'] * .60, 0);
                            $total_difference += (round($sum['voters'] * .60, 0) - ($sum['leaders'] + $sum['members']));
                        ?>
                        <tr>
                          <td class="text-center"><?php echo $ctr++; ?></td>
                          <td class="text-center"><?php echo $sum['barangay']; ?></td>
                          <td class="text-center"><?php echo $sum['leaders']; ?></td>
                          <td class='text-center data'><?php echo $sum['members']; ?></td>
                          <td class='text-center data'><?php echo $sum['leaders'] + $sum['members']; ?></td>
                          <td class='text-center data'><?php echo $sum['voters']; ?></td>
                          <td class='text-center data'><?php echo round($sum['voters'] * .60, 0); ?></td>
                          <td class='text-center data'><?php echo round($sum['voters'] * .60, 0) - ($sum['leaders'] + $sum['members']); ?></td>
                        </tr>
                        <?php
                          }
                        ?>
                        <tr>
                          <td class="text-center"></td>
                          <td class="text-center">Total</td>
                          <td class="text-center"><strong><?php echo $total_leaders ?></strong></td>
                          <td class="text-center"><strong><?php echo $total_members ?></strong></td>
                          <td class="text-center"><strong><?php echo $total_supporters ?></strong></td>
                          <td class="text-center"><strong><?php echo $total_voters ?></strong></td>
                          <td class="text-center"><strong><?php echo $total_voters_60 ?></strong></td>
                          <td class="text-center"><strong></strong></td>
                        </tr>

                      </tbody>
                    </table>
                  </div>
                </div>
            </div>

          </div>    
        </div>
      </section>
    </div>

  <?php require 'app/views/components/footer_banner.php'; ?>
</div>

<div class="modal fade" id="modal_message_box" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title"></h5>
      </div>
      <div class="modal-body">
        <h6 class="modal-body" id="modal_body"></h5>
      </div>
      <div class="modal-footer">
      
      </div>
    </div>
  </div>
</div>
</body>
<?php require 'app/views/components/footer.php'; ?>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/js/jquery.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/js/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/js/jszip.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/js/pdfmake.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/js/vfs_fonts.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/js/buttons.print.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/js/buttons.colVis.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {

    /*
      B - Buttons
      l - length changing input control
      f - filtering input
      r - processing display element
      t - The table
      i - Table information summary
      p - pagination control
    */
    var table = $('#tbl_result').DataTable({
      "dom": 'Brt',
      "initComplete": function() {
        $("#tbl_result").show();
      },
      "buttons": ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis'],
      "scrollX": true,
      "ordering": false,
      paging: false
    });
    table.buttons().container().appendTo('#reminders_wrapper .col-md-6:eq(0)');
  });
</script>
</html>
