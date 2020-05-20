<style>
  table thead tr th{
    text-align: center;
  }
  .center_text{
    text-align: center;
  }
</style>
<div class="card">
  <div class="card-body">
    <table class="table table-bordered">
        <thead>
          <tr>
            <th width="20px">#</th>
            <th width="100px">Purok Number</th>
            <th width="400px">Leader</th>
            <th width="120px">Control</th>
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
              <td>
                <?php 
                  if ($voter == 0){
                ?>
                  <button class="btn btn-primary" id="btn_set_leader" value="<?php echo $purok; ?>"><icon class="fas fa-edit"></icon>&nbsp;Set Leader</button>
                <?php
                  }
                  else{
                ?>
                  <button class="btn btn-warning" id="btn_edit_leader" value="<?php echo $purok; ?>"><icon class="fas fa-edit""></icon>&nbsp;Edit Leader</button>
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