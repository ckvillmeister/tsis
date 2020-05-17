<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Ward List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="main">Main</a></li>
            <li class="breadcrumb-item active">Ward List</li>
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
            <button class="btn btn-primary" id="btn_view_ward_list"><icon class="fas fa-thumbs-up">&nbsp;&nbsp;&nbsp;Submit</icon></button>
          </div>
          <div class="col-lg-2">
            <div class="float-right">
              <button class="btn btn-primary" id="btn_print"><icon class="fas fa-print">&nbsp;&nbsp;&nbsp;Print</icon></button>
            </div>
          </div>
        </div>

        <div id="report">
        </div>

      </div>    
    </div>
  </section>
</div>
