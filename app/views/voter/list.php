<div class="row p-3 shadow-none ml-3 mr-3 mb-3 bg-light rounded">
  <div class="col-lg-12 align-self-center">
    <table class="table table-sm table-bordered table-striped display nowrap bg-white" id="table_voter_list">
      <thead>
        <tr>
          <th>#</th>
          <th>First Name</th>
          <th>Middle Name</th>
          <th>Last Name</th>
          <th>Voter's Identification No.</th>
          <th>Voter's No.</th>
          <th>Precinct No.</th>
          <th>Cluster No.</th>
          <th>Purok</th>
          <th>Barangay</th>
          <th>Birthdate</th>
          <th>Gender</th>
          <th>Control</th>
        </tr>
      </thead>
      <tbody id="table_body">
      <?php
        $ctr = 0;
        $voters = $data['voters'];
        foreach ($voters as $key => $value) {
          $data = (object) $value;
      ?>
        <tr>
          <td><?php echo ++$ctr; ?></td>
          <td><?php echo $data->firstname.' '.$data->suffix; ?></td>
          <td><?php echo $data->middlename; ?></td>
          <td><?php echo $data->lastname; ?></td>
          <td><?php echo $data->vin; ?></td>
          <td><?php echo $data->votersno; ?></td>
          <td><?php echo $data->precinctno; ?></td>
          <td><?php echo $data->clusterno; ?></td>
          <td><?php echo $data->purokno; ?></td>
          <td><?php echo $data->barangay; ?></td>
          <td><?php echo $data->birthdate; ?></td>
          <td><?php echo $data->gender; ?></td>
          <td class="text-center">
            <a href="<?php echo ROOT.'voter/profile?voterid='.$data->id; ?>" class="btn btn-sm btn-warning" value="<?php echo $data->id; ?>"><icon class="fas fa-address-book"></icon></a>
            <!--<button class="btn btn-sm btn-danger" value="<?php echo $data->id; ?>"><icon class="fas fa-trash"></icon></button>-->
          </td>
        </tr>
      <?php   
        }
      ?>
      </tbody>
    </table>
  </div>
</div>

<script type="text/javascript">
  $('#table_voter_list').DataTable({
    "scrollX": true
  });
</script>
  
  
   