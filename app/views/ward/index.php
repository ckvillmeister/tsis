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
        border-radius: 5px;
      }

      #table_member_list{
        font-size: 10pt
      }

      .col-header {
        font-size: 10pt
      }
    </style>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Manage Supporters</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>main">Main</a></li>
                <li class="breadcrumb-item active">Manage Supporters</li>
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

            <div class="row shadow-none p-3">
              
                <div class="col-sm-6">
                    <a href="<?php echo ROOT; ?>ward/regular" class="btn btn-primary form-control" style="height: 180px"><i class="fas fa-users" style="font-size: 100pt"></i><br>Regular Voters</a>
                </div>
                <div class="col-sm-6">
                <a href="<?php echo ROOT; ?>ward/sk" class="btn btn-secondary form-control" style="height: 180px"><i class="fas fa-user-friends" style="font-size: 100pt"></i><br>Sangguniang Kabataan Voters</a>
                </div>
                <div class="col-sm-6">
                <a href="<?php echo ROOT; ?>ward/special" class="btn btn-info form-control mt-3" style="height: 180px"><i class="fas fa-user-secret" style="font-size: 100pt"></i><br>Special Ops</a>
                </div>
                <div class="col-sm-3">
                <button class="btn btn-success form-control mt-3" id="upload-leaders" style="height: 180px"><i class="fas fa-user-tie" style="font-size: 70pt"></i><br>Upload Leaders List to Cloud</button>
                </div>
                <div class="col-sm-3">
                <button class="btn btn-warning form-control mt-3" id="upload-members" style="height: 180px"><i class="fas fa-users" style="font-size: 70pt"></i><br>Upload Members List to Cloud</button>
                </div>
            </div>

          </div>    
        </div>
      </section>
    </div>

  <?php require 'app/views/components/footer_banner.php'; ?>
</div>

</body>
<?php require 'app/views/components/footer.php'; ?>
<script type="module">
  import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-analytics.js";
  import { getDatabase, ref, get, set, remove } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-database.js";

  const firebaseConfig = {
    apiKey: "AIzaSyBbvtZeC07sZWvVsIvF78nMcy4Lvtt8PbU",
    authDomain: "tsis-4b084.firebaseapp.com",
    databaseURL: "https://tsis-4b084-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "tsis-4b084",
    storageBucket: "tsis-4b084.appspot.com",
    messagingSenderId: "703707119922",
    appId: "1:703707119922:web:1ef29666317342b0a2972b",
    measurementId: "G-PZ44WFJQEZ"
  };

  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);
  const db = getDatabase(app);

  $('#upload-leaders').on('click', function(){
    Swal.fire({
			title: "Confirm",
			text: "Are you sure you want to upload the list of ward leaders to the cloud?",
			icon: "question",
			showCancelButton: true,	
			showConfirmButton: true,	
			confirmButtonColor: "#17a2b8"
		}).then((res) => {
			if (res.value) {

        $.ajax({
          url: 'ward/uploadLeadersList',
          method: 'POST',
          dataType: 'JSON',
          success: function(result) {
            const year = result['year'];
            const list = result['list'];
            const baseRef = ref(db, `tsis/leaderslist/${year}`);

            $('.overlay-wrapper').html('<div class="overlay">' +
                        '<i class="fas fa-3x fa-sync-alt fa-spin"></i>' +
                        '<div class="text-bold pt-2">Loading...</div>' +
                            '</div>');

            get(baseRef).then(snapshot => {
              const deletions = [];
              const insertions = [];

              if (snapshot.exists()) {
                const existingRecords = snapshot.val();
                const existingIds = Object.keys(existingRecords);
                const newIds = list.map(item => item.voterid.toString());

                const idsToDelete = existingIds.filter(id => !newIds.includes(id));

                idsToDelete.forEach(id => {
                  const deleteRef = ref(db, `tsis/leaderslist/${year}/${id}`);
                  deletions.push(remove(deleteRef));
                });
              }

              list.forEach(record => {
                const voterid = record.voterid;
                const recordRef = ref(db, `tsis/leaderslist/${year}/${voterid}`);
                insertions.push(set(recordRef, record));
              });

              return Promise.all([...deletions, ...insertions]);

            }).then(() => {
              $('.overlay-wrapper').html('');
            }).catch(err => {
              console.error("Error syncing data:", err);
              $('.overlay-wrapper').html('<div class="text-danger">Failed to sync records.</div>');
            });

            
          },
          error: function(obj, err, ex){
            Swal.fire({
              title: "Error",
              text: err + ": " + obj.status + " " + ex,
              icon: "error",
            });
          }
        })
        //End Ajax

			}
		});
  });

  $('#upload-members').on('click', function(){
    Swal.fire({
			title: "Confirm",
			text: "Are you sure you want to upload the list of ward members to the cloud?",
			icon: "question",
			showCancelButton: true,	
			showConfirmButton: true,	
			confirmButtonColor: "#17a2b8"
		}).then((res) => {
			if (res.value) {

        $.ajax({
          url: 'ward/uploadMembersList',
          method: 'POST',
          dataType: 'JSON',
          success: function(result) {
            const year = result['year'];
            const list = result['list'];
            const baseRef = ref(db, `tsis/memberslist/${year}`);

            $('.overlay-wrapper').html('<div class="overlay">' +
                        '<i class="fas fa-3x fa-sync-alt fa-spin"></i>' +
                        '<div class="text-bold pt-2">Loading...</div>' +
                            '</div>');

            get(baseRef).then(snapshot => {
              const deletions = [];
              const insertions = [];

              // STEP 1: Get existing wardids from Firebase and compare
              if (snapshot.exists()) {
                const existingData = snapshot.val(); // e.g., { 7619: { voterid1: {...}, voterid2: {...} }, ... }
                const existingWardIds = Object.keys(existingData);

                // Get wardids from current list
                const currentWardIds = [...new Set(list.map(item => item.wardid.toString()))];

                // Delete entire wardid branches not found in the current list
                const wardIdsToDelete = existingWardIds.filter(id => !currentWardIds.includes(id));
                wardIdsToDelete.forEach(wardid => {
                  const wardRef = ref(db, `tsis/memberslist/${year}/${wardid}`);
                  deletions.push(remove(wardRef));
                });
              }

              // STEP 2: Group voter records by wardid
              const grouped = {};
              list.forEach(record => {
                const wardid = record.wardid.toString();
                const voterid = record.voterid.toString();
                if (!grouped[wardid]) grouped[wardid] = {};
                grouped[wardid][voterid] = record;
              });

              // STEP 3: Set each voter under its ward
              for (const wardid in grouped) {
                for (const voterid in grouped[wardid]) {
                  const recordRef = ref(db, `tsis/memberslist/${year}/${wardid}/${voterid}`);
                  insertions.push(set(recordRef, grouped[wardid][voterid]));
                }
              }

              // STEP 4: Wait for all operations
              return Promise.all([...deletions, ...insertions]);

            }).then(() => {
              $('.overlay-wrapper').html('');
            }).catch(err => {
              $('.overlay-wrapper').html('<div class="text-danger">Failed to sync members.</div>');
            });


            
          },
          error: function(obj, err, ex){
            Swal.fire({
              title: "Error",
              text: err + ": " + obj.status + " " + ex,
              icon: "error",
            });
          }
        })
        //End Ajax

			}
		});
  });

</script>
</html>
