<?php
    $list = $data['list'];
    $year = $data['year'];
?>

<script type="module">
  import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-analytics.js";
  import { getDatabase, ref, get, set } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-database.js";

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

  const list = JSON.parse(`<?= json_encode($list) ?>`);
  const year = "<?= $year ?>";
  const baseRef = ref(db, `tsis/voterslist/${year}`);

  list.forEach(record => {
    const id = record.id;
    const recordRef = ref(db, `tsis/voterslist/${year}/${id}`);

    get(recordRef).then(snapshot => {
      if (snapshot.exists()) {
        console.log(`Record with ID ${id} already exists.`);
      } else {
        set(recordRef, record)
          .catch(err => console.error(`Error uploading ID ${id}:`, err));
      }
    }).catch(err => {
      console.error(`Error checking ID ${id}:`, err);
    });
  });
</script>

