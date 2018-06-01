function ajax_register() {
  var reg_user = $('.reg_user').val();
  var reg_password = $('.reg_password').val();
  var reg_companyname = $('.reg_companyname').val();
  var reg_address = $('.reg_address').val();
  var reg_phone = $('.reg_phone').val();
  $.ajax({
          url:'includes/function.php?function=register_process',
          type:'POST',
          data:{
            reg_user : reg_user,
            reg_password : reg_password,
            reg_companyname : reg_companyname,
            reg_address : reg_address,
            reg_phone : reg_phone
          },
          success:function(data){
            if(data == 'success'){
              alert("Contact The Accounting Team to verify your account.");
              location.href = '?page=login';
            } else {
              alert("You have already signed up. To find out the password, Click the 'Forgot The Password'");
            }

          }
  });
}

function ajax_login() {
  var userId = $('.userId').val();
  var userPassword = $('.userPassword').val();

  // if ($('#remember').is(':checked')) {
	// 	var email = $('#userId').val();
	// 	Cookies.get('hnis_email', email, { expires: 14 });
	// 	Cookies.get('hnis_remember', true, { expires: 14 });
  // } else{
	// 	Cookies.get('hnis_email', null);
  //   Cookies.get('hnis_remember', null);
	// }

  $.ajax({
          url:'includes/function.php?function=login_process',
          type:'POST',
          data:{
            userId : userId,
            userPassword : userPassword
          },
          success:function(data){
            if(data == 'success'){
              location.href = '?page=frame';
            } else {
              alert("incorrect");
            }

          }
  });
}
function handle_login(e){
       if(e.keyCode === 13){
           e.preventDefault();
           ajax_login();
       }
}
