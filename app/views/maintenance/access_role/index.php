<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Access Roles</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="main">Main</a></li>
            <li class="breadcrumb-item active">Access Role</li>
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
            <button class="btn btn-success" data-toggle="modal" data-target="#modal_role_form"><icon class="fas fa-plus">&nbsp;&nbsp;New Role</icon></button>
          </div>
        </div>

        <div class="row p-3 shadow-none ml-3 mr-3 mb-3 bg-light rounded">
          <div class="col-lg-12 align-self-center">
            <table class="table table-bordered table-striped display nowrap bg-white" id="table_access_role_list">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Role Name</th>
                  <th>Description</th>
                  <th>Added By</th>
                  <th>Status</th>
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

<div class="modal fade" id="modal_role_form" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title">Access Role Information</h5>
      </div>
      <div class="modal-body">

        <div class="row mt-3">
          <div class="col-lg-3 align-self-center">
              Role Name:
          </div>
          <div class="col-lg-9">
              <input type="text" class="form-control" id="text_rolename">
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-lg-3 align-self-center">
              Description:
          </div>
          <div class="col-lg-9">
              <input type="text" class="form-control" id="text_description">
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