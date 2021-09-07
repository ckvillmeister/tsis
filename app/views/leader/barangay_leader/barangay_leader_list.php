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
    <table class="table table-sm table-bordered table-striped">
        <thead>
          <tr>
            <th width="20px">#</th>
            <th width="250px">Barangay Name</th>
            <th>Leader</th>
            <th width="180px">Control</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $ctr = 0;
            $leaders = $data['leaders'];
            foreach ($leaders as $key => $leader) {
              $record_info = (object) $leader;
          ?>
            <tr>
              <td><?php echo ++$ctr; ?></td>
              <td><?php echo $record_info->barangay_name; ?></td>
              <td><?php echo $record_info->fullname; ?></td>
              <td class="text-center">
                <?php 
                  if (trim($record_info->voter_id) == ''){
                ?>
                  <button class="btn btn-sm btn-primary" id="btn_set_leader" value="<?php echo $record_info->barangay_id; ?>"><icon class="fas fa-edit mr-2"></icon>Set Leader</button>
                <?php
                  }
                  else{
                ?>
                  <button class="btn btn-sm btn-warning" id="btn_edit_leader" value="<?php echo $record_info->barangay_id; ?>"><icon class="fas fa-edit mr-2"></icon>Edit Leader</button>
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