<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">User Accounts</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="main">Main</a></li>
            <li class="breadcrumb-item active">User Accounts</li>
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
            <button class="btn btn-success" data-toggle="modal" data-target="#modal_user_account_form"><icon class="fas fa-plus">&nbsp;&nbsp;New Account</icon></button>
          </div>
        </div>

        <div class="row p-3 shadow-none ml-3 mr-3 mb-3 bg-light rounded">
          <div class="col-lg-12 align-self-center">
            <table class="table table-bordered table-striped display nowrap bg-white" id="table_user_account_list">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Username</th>
                  <th>Fullname</th>
                  <th>Role</th>
                  <th>Added By</th>
                  <th>Control</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
          </div>
        </div>

      </div>    
    </div>
  </section>
</div>

<div class="modal fade" id="modal_user_account_form" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title">User Account Information</h5>
      </div>
      <div class="modal-body">

        <legend><h6>Account Information</h6></legend>

        <div class="row mt-4">
          <div class="col-lg-2 align-self-center">
              Username:
          </div>
          <div class="col-lg-4">
              <input type="text" class="form-control" id="text_username">
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-lg-2 align-self-center">
              Password:
          </div>
          <div class="col-lg-4">
              <input type="password" class="form-control" id="text_password">
          </div>
          <div class="col-lg-2 align-self-center">
              Confirm Pass:
          </div>
          <div class="col-lg-4">
              <input type="password" class="form-control" id="text_cpassword">
          </div>
        </div>

        <hr>
        <legend><h6>User Information</h6></legend>

        <div class="row mt-4">
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
              Role:
          </div>
          <div class="col-lg-4">
              <select class="form-control" id="cbo_role">
                <option value="0"></option>
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