<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Barangay Leaders</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="main">Main</a></li>
            <li class="breadcrumb-item active">Barangay Leader</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div id="barangay_leaders">
      </div>
    </div>
  </section>
</div>

<!-- Modal Set Barangay Leader -->
<div class="modal fade" id="modal_set_barangay_leader" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
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
<div class="modal fade" id="modal_confirm_barangay_leader" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <span>Are you sure you want to select <span id="voter_name"></span> as barangay leader?</span>
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
