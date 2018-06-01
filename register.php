<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>HNIS</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="js/login_function.js"></script>
    <link rel="stylesheet" type="text/css" href="css/register.css?ver=1">
  </head>
  <body>
    <div class="body"></div>
  		<div class="grad"></div>
  		<div class="header">
  			<div>H-<span>NIS</span></div>
  		</div>
  		<br>
  		<div class="register">
  				<input type="email" placeholder="email" name="reg_user" class="reg_user"><br>
  				<input type="password" placeholder="password" name="reg_password" class="reg_password"><br>
          <input type="text" placeholder="company name" name="reg_companyname" class="reg_companyname"><br>
          <input type="text" placeholder="address" name="reg_address" class="reg_address"><br>
          <input type="text" placeholder="phone" name="reg_phone" class="reg_phone"><br>
          <input type="button" value="Submit" id="submit" onclick="ajax_register();">
  		</div>
  </body>
</html>
