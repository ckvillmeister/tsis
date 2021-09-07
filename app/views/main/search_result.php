<!DOCTYPE html>
<html>

<head>
  <?php require 'app/views/components/header.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

<div class="wrapper">
  <?php require 'app/views/components/navbar.php'; ?>
  <?php require 'app/views/components/sidebar.php'; ?>
  
    <style>
    #btn_view_leaders, #btn_search_leader, #btn_search_member, #btn_submit, #btn_delete_ward {
      width:160px;
      border-radius: 10px;
    }
    </style>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Search Result</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo ROOT ?>main">Main</a></li>
                <li class="breadcrumb-item active">Search Result</li>
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

            <div class="row p-3 shadow-none mr-3 ml-3 mt-3 bg-light rounded">
            	<div class="col-sm-12">
            		<h5>Query Result: <?php echo count($data['search_result']); ?></h5>
            	</div>
            </div>

            <div class="row p-3 shadow-none m-3 bg-light rounded">

            <?php
            	$bgcolor = "";
            	$ctr = 1;
            	foreach ($data['search_result'] as $key => $supporter) {
            		if ($ctr == 1){
            			$bgcolor = "bg-info";
            			$ctr++;
            		}
            		elseif ($ctr == 2){
            			$bgcolor = "bg-warning";
            			$ctr++;
            		}
            		elseif ($ctr == 3){
            			$bgcolor = "bg-danger";
            			$ctr = 1;
            		}

                 $imgurl = ($supporter['imgurl']) ? ROOT.$supporter['imgurl'] : ROOT."public/image/avatar.png";
            ?>
    	          	<div class="col-sm-4">
    		          	<div class="card card-widget widget-user">
    			          	<div class="widget-user-header <?php echo $bgcolor; ?>">
    			          		<h6><?php echo $supporter['firstname'].' '.trim($supporter['middlename']).' '.$supporter['lastname'].' '.trim($supporter['suffix']); ?></h6>
    			          		<?php echo $supporter['rank'].' - '.$supporter['barangay'] ?>
    			          	</div>
    			          	<div class="widget-user-image">
    			          		<img class="img-circle elevation-2" src="<?php echo $imgurl; ?>">
    			          	</div>
                      <br>
    			          	<div class="card-footer">
    			          		<div class="row">
                          <div class="col-sm-4">
                            <a class="btn btn-sm btn-success" style="color:white; width: 100px" href="<?php echo ROOT ?>ward/view_ward?wardid=<?php echo $supporter['wardid']; ?>">View Ward</a>
                          </div>
    			          			<div class="col-sm-4 ml-1">
                            <?php if ($accessrole_model->check_access($role, 'viewsupporterprofile')): ?>
                              <a class="btn btn-sm btn-primary" style="color:white; width: 100px" href="<?php echo ROOT ?>voter/profile?voterid=<?php echo $supporter['voter_sys_id']; ?>">Profile
                              </a>
                            <?php endif; ?>
                          </div>
    			          		</div>
    			          	</div>
    		      		</div>
    		      	</div>
            <?php
            	}	
            ?>

            </div>

          </div>    
        </div>
      </section>
    </div>

    <?php require 'app/views/components/footer_banner.php'; ?>
</div>

<div class="modal fade" id="modal_message_box" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title"></h5>
      </div>
      <div class="modal-body">
        <h6 class="modal-body" id="modal_body"></h5>
      </div>
      <div class="modal-footer">
      
      </div>
    </div>
  </div>
</div>
</body>
<?php require 'app/views/components/footer.php'; ?>
</html>
