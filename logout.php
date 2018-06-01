<?php
	unset($_SESSION['hnisID']);
  unset($_SESSION['hnisVendorID']);
  unset($_SESSION['hnisCompanyName']);
  unset($_SESSION['hnisLevel']);
	session_destroy();
?>
	

	<script type="text/javascript">
			location.href="?page=logout";
	</script>
