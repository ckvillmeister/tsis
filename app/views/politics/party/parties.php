<?php 
	foreach ($data['parties'] as $party){
?>
		<a class="btn btn-app col-sm-3 h-100" href="<?php echo ROOT; ?>politics/manage?id=<?php echo $party['id'] ?>">
        	<i style="font-size: 50pt" class="fas fa-users"></i> <br><h5><?php echo $party['name'] ?></h5>
      	</a>
<?php
	}
?>