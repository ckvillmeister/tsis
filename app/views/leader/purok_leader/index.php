<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Purok Leaders</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="main">Main</a></li>
            <li class="breadcrumb-item active">Purok Leader</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="row p-3 shadow-none m-3 bg-light rounded">
          <div class="col-lg-2 align-self-center" style="vertical-align: middle;">
            Barangay
          </div>
          <div class="col-lg-3">
            <select class="form-control" id="cbo_barangay">
              <option value="0"></option>
                <?php 
                  $barangay = (object) $data['barangay'];
                  foreach ($barangay as $key => $value) {
                    $data = (object) $value;
                ?>
                <option value="<?php echo $data->id; ?>"><?php echo $data->name; ?></option>
                <?php
                  }
                ?>
            </select>
          </div>
          <div class="col-lg-5">
            <button class="btn btn-primary" id="btn_submit"><icon class="fas fa-thumbs-up">&nbsp;&nbsp;&nbsp;Submit</icon></button>
          </div>
        </div>

        <div id="purok_leaders">
        </div>

      </div>    
    </div>
  </section>
</div>

<!-- Modal Set Barangay Leader -->
<div class="modal fade" id="modal_set_purok_leader" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title">Select Barangay Leader</h5>
      </div>
      <div class="modal-body">
        <div id="voters_list">

        </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<!-- Modal Confirm Barangay Leader -->
<div class="modal fade" id="modal_confirm_purok_leader" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <span>Are you sure you want to select <span id="voter_name"></span> as purok leader?</span>
      </div>
      <div class="modal-footer">
        <div class="float-right">
          <button class="btn btn-primary" id="btn_yes" style="width:120px">Yes</button>&nbsp;&nbsp;
          <button class="btn btn-secondary" id="btn_no" style="width:120px">No</button>
        </div>
      </div>
    </div>
  </div>
</div>