<?
// if(isset($_SESSION['hnisID'])){
//   header("Location: ?page=frame", true, 301); exit;
// }
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>HNIS</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="js/common_function.js?ver=3"></script>
  <link rel="stylesheet" type="text/css" href="css/login.css?ver=2">
  <script>
  $(document).ready(function(){
    $("#register").click(function(){
      location.href = "?page=login_registration";
    });
  });

  // $(document).ready(function() {
  // 	var remember = Cookies.get('hnis_remember');
  // 			 if (remember == 'true')
  // 			 {
  // 					 var email = Cookies.get('hnis_email');
  // 					 // autofill the fields
  // 					 $('#userId').val(email);
  // 					 $("#remember").prop("checked", true);
  // 			 }
  // });
  </script>
</head>
<body>
  <div class="body"></div>
		<div class="grad"></div>
		<div class="header">
			<div>H-<span>NIS</span></div>
		</div>
		<br>
		<div class="login">
      <form name="login_form" method="post" action="?page=login"  autocomplete="off">
				<input type="text" placeholder="username" name="userId" class="userId" id="userId" tabindex="1">
        <span class="input-group-addon">
        		<input type="checkbox" id="remember" name="remember" title="Remember Email Address" aria-label="...">
        </span><br>
				<input type="password" placeholder="password" name="userPassword" class="userPassword" onkeydown="handle(event,'login')"  tabindex="2"><br>
				<input type="button" value="Login" id="login" onclick="ajax_login()" tabindex="3">
        <input type="button" value="Register" id="register">
        <span class="error"></span>
      </form>
		</div>
</body>
</html>
