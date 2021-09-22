<style>
  table thead tr th{
    text-align: center;
  }
  .center_text{
    text-align: center;
  }

  #purok_leader_list{
    font-size: 10pt
  }

  .col-header {
    font-size: 10pt
  }
</style>
<div class="card">
  <div class="card-body">
    <table class="table table-sm table-bordered table-striped" id="purok_leader_list">
        <thead>
          <tr>
            <th class="col-header text-center" width="20px">#</th>
            <th class="col-header text-center" width="100px">Purok Number</th>
            <th class="col-header text-center" width="400px">Leader</th>
            <th class="col-header text-center" width="120px">Control</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $ctr=0;
            $purok=0;
            for($ctr=0; $ctr<7; $ctr++){
          ?>
            <tr>
              <td class="center_text"><?php echo ++$purok; ?></td>
              <td class="center_text"><?php echo $purok; ?></td>
              <td>
                <?php
                  $voter = 0;
                  $leaders = $data['leaders'];

                  foreach ($leaders as $key => $leader) {
                    $record_info = (object) $leader;
                    if ($purok == $record_info->purok){
                      $voter = $record_info->voter_id;
                      echo $record_info->fullname;
                    }
                  }
                ?>
              </td>
              <td class="text-center">
                <?php 
                  if ($voter == 0){
                ?>
                  <button class="btn btn-sm btn-primary" id="btn_set_leader" value="<?php echo $purok; ?>"><icon class="fas fa-edit mr-2"></icon>Set Leader</button>
                <?php
                  }
                  else{
                ?>
                  <button class="btn btn-sm btn-warning" id="btn_edit_leader" value="<?php echo $purok; ?>"><icon class="fas fa-edit mr-2"></icon>Edit Leader</button>
                <?php
                  }
                ?>
              </td>
            </tr>
          <?php
            }
          ?>
        </tbody>
      </table>
  </div>
</div>    