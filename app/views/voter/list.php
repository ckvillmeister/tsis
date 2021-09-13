<style>
  #table_voter_list{
    font-size: 10pt
  }

  .col-header {
    font-size: 10pt
  }

</style>

<div class="row p-3 shadow-none ml-3 mr-3 mb-3 bg-light rounded">
  <div class="col-lg-12 align-self-center">
    <table class="table table-sm table-bordered table-striped display bg-white" style="width: 100%" id="table_voter_list">
      <thead>
        <tr>
          <th class="text-center col-header">No</th>
          <th class="text-center col-header">First Name</th>
          <th class="text-center col-header">Middle Name</th>
          <th class="text-center col-header">Last Name</th>
          <th class="text-center col-header">Gender</th>
          <th class="text-center col-header">Barangay</th>
          <th class="text-center col-header">Purok</th>
          <th class="text-center col-header">Birthdate</th>
          <th class="text-center col-header">Voter's Identification No.</th>
          <th class="text-center col-header">Voter's No.</th>
          <th class="text-center col-header">Precinct No.</th>
          <th class="text-center col-header">Cluster No.</th>
          
          
          <th class="text-center col-header">Control</th>
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
          <td class="text-center"><?php echo ++$ctr; ?></td>
          <td><?php echo ($data->suffix) ? utf8_decode($data->firstname).' '.$data->suffix : utf8_decode($data->firstname); ?></td>
          <td><?php echo utf8_decode($data->middlename); ?></td>
          <td><?php echo utf8_decode($data->lastname); ?></td>
          <td><?php echo $data->gender; ?></td>
          <td><?php echo ucwords(strtolower($data->barangay)); ?></td>
          <td class="text-center"><?php echo $data->purokno; ?></td>
          <td><?php echo $data->birthdate; ?></td>
          <td><?php echo $data->vin; ?></td>
          <td class="text-center"><?php echo $data->votersno; ?></td>
          <td class="text-center"><?php echo $data->precinctno; ?></td>
          <td class="text-center"><?php echo $data->clusterno; ?></td>
          <td class="text-center">
            <a class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="View Voter Profile" href="<?php echo ROOT ?>voter/profile?voterid=<?php echo $data->id ?>"><icon class="fas fa-id-card-alt"></icon></a>
            <button class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Edit Voter's Information" value="<?php echo $data->id; ?>" id="edit"><icon class="fas fa-edit"></icon></button>
            <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete Voter's Record" value="<?php echo $data->id; ?>" id="delete"><icon class="fas fa-trash"></icon></button>
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
    "scrollX": true,
    "ordering": false,
    lengthMenu: [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
    styles: {
      tableHeader: {
        fontSize: 8
      }
    }
  });
</script>
  
  
   