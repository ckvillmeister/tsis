<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Voters List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="main">Main</a></li>
            <li class="breadcrumb-item active">Voter</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card">

        <div class="row p-3 shadow-none m-3 bg-light rounded">
          <div class="col-lg-12 align-self-center">
            <button class="btn btn-success" data-toggle="modal" data-target="#modal_voters_form"><icon class="fas fa-plus">&nbsp;&nbsp;New Voter</icon></button>
          </div>
        </div>
      
        <div class="overlay-wrapper">
        
        </div>
        
        <div id="voters_list">
        </div>
        
      </div>    
    </div>
  </section>
</div>

<div class="modal fade" id="modal_voters_form" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title">Voter's Information</h5>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-lg-2 align-self-center">
              VIN:
          </div>
          <div class="col-lg-4">
              <input type="text" class="form-control" id="text_vin">
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-lg-2 align-self-center">
              First Name:
          </div>
          <div class="col-lg-4">
              <input type="text" class="form-control" id="text_firstname">
          </div>
          <div class="col-lg-2 align-self-center">
              Middle Name:
          </div>
          <div class="col-lg-4">
              <input type="text" class="form-control" id="text_middlename">
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-lg-2 align-self-center">
              Last Name:
          </div>
          <div class="col-lg-4">
              <input type="text" class="form-control" id="text_lastname">
          </div>
          <div class="col-lg-2 align-self-center">
              Suffix:
          </div>
          <div class="col-lg-4">
              <select class="form-control" id="cbo_suffix">
                <option value="0"></option>
              </select>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-lg-2 align-self-center">
              Precint Number:
          </div>
          <div class="col-lg-4">
              <input type="text" class="form-control" id="text_precinctnumber">
          </div>
          <div class="col-lg-2 align-self-center">
              Cluster Number:
          </div>
          <div class="col-lg-4">
              <input type="text" class="form-control" id="text_clusternumber">
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-lg-2 align-self-center">
              Purok Number:
          </div>
          <div class="col-lg-4">
              <input type="text" class="form-control" id="text_puroknumber">
          </div>
          <div class="col-lg-2 align-self-center">
              Barangay:
          </div>
          <div class="col-lg-4">
              <select class="form-control" id="cbo_barangay">
                <option value="0"></option>
              </select>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-lg-2 align-self-center">
              Birthdate:
          </div>
          <div class="col-lg-4">
              <input type="date" class="form-control" id="text_birthdate">
          </div>
          <div class="col-lg-2 align-self-center">
              Gender:
          </div>
          <div class="col-lg-4">
              <select class="form-control" id="cbo_gender">
                <option value="0"></option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
          </div>
        </div>

        <div class="row mt-3 mr-0 ml-0 p-2 bg-light rounded">
          <div class="col-lg-8">
            <span id="message"></span>
          </div>
          <div class="col-lg-4">
            <div class="float-right">
              <button class="btn btn-success"><icon class="fas fa-thumbs-up">&nbsp;&nbsp;Submit</icon></button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>