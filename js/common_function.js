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

function ajax_search() {
  var main_vendor = $('#main_vendor').val();
  if(main_vendor == ''){
    alert('Set Vendor First');
    return;
  }
  show_loading_image();
  var search_item = $('#admin_search_item').val();
  $.ajax({
          url:'includes/function.php?function=ajax_search_item',
          type:'POST',
          data:{
            search_item : search_item
          },
          success:function(data){
            if(data == 'noitem'){
              alert("There Is No Item");
            } else if (data == 'toomanyitems') {
              alert("There are too many items. Please Type more Detail");
            } else{
              $("#admin_search_table tbody").html(data);
            }
            hide_loading_image();
          }
  });
}

function adj_search_item() {
  show_loading_image();
  var search_item = $('#adj-table-filter').val();
  $.ajax({
          url:'includes/function.php?function=adj_search_item',
          type:'POST',
          data:{
            search_item : search_item
          },
          success:function(data){
            if(data == 'noitem'){
              alert("There Is No Item");
            } else if (data == 'toomanyitems') {
              alert("There are too many items. Please Type more Detail");
            } else{
              $("#adjust_myitem_table tbody").html(data);
            }
            hide_loading_image();
          }
  });
}

function select_item(barcode,prodKname,prodName,prodUnit,prodsize,GalCode,ProdOwnCode) {
  $.ajax({
          url:'includes/function.php?function=ajax_add_item',
          type:'POST',
          data:{
            barcode : barcode,
            prodKname : prodKname,
            prodName : prodName,
            prodUnit : prodUnit,
            prodsize : prodsize
          },
          success:function(data){
              add_table_row(barcode,prodKname,prodName,prodUnit,prodsize,GalCode,ProdOwnCode);
          }
  });
}

function fetch_myitem(vendorId,where) {
  $.ajax({
          url:'includes/function.php?function=fetch_myitem',
          type:'POST',
          data:{
            vendorId : vendorId,
          },
          success:function(data){
            if(data !== 'noitem'){
              $('#'+where).html(data);
              // console.log(data);
            }
          }
  });
}

function fetch_vendoritem_admin(vendorId,where) {
  $.ajax({
          url:'includes/function.php?function=fetch_vendoritem_admin',
          type:'POST',
          data:{
            vendorId : vendorId,
          },
          success:function(data){
            if(data !== 'noitem'){
              $('#'+where).html(data);
              $('#admin_vendor_id').val(vendorId);
              // console.log(data);
            }
          }
  });
}

function fetch_submititem_vendor() {
  $.ajax({
          url:'includes/function.php?function=fetch_submititem_vendor',
          type:'POST',
          success:function(data){
            if(data !== 'novendor'){
              $("#admin-vendor-search-table tbody").html(data);
              // console.log(data);
            }
          }
  });
}

function fetch_myitem_inregister(){
  $.ajax({
          url:'includes/function.php?function=fetch_myitem_inregister',
          type:'POST',
          success:function(data){
            if(data !== 'noitem'){
              $("#myitem-register-table tbody").html(data);
              // console.log(data);
            }
          }
  });
}

function fetch_neworder_myitem() {
  show_loading_image();
  $.ajax({
          url:'includes/function.php?function=fetch_neworder_myitem',
          type:'POST',
          success:function(data){
            if(data !== 'noitem'){
              $("#neworder_myitem_tbody").html(data);
              // console.log(data);
            }
            hide_loading_image();
          }
  });
}

function fetch_myorder_itemlist(ordno) {
  show_loading_image();
  $.ajax({
          url:'includes/function.php?function=fetch_myorder_itemlist',
          type:'POST',
          data:{
            ordno : ordno
          },
          success:function(data){
            if(data !== 'noitem'){
              $("#neworder_item_tbody").html(data);
              // console.log(data);
            }
            hide_loading_image();
            var rowCount = document.getElementById('neworder_item_tbody').rows.length;
            document.getElementById("item_num").value = rowCount;
          }
  });
}

function fetch_adjust_itemlist(ordno) {
  show_loading_image();

  $.ajax({
          url:'includes/function.php?function=fetch_adjust_itemlist',
          type:'POST',
          data:{
            ordno : ordno
          },
          success:function(data){
            if(data !== 'noitem'){
              $("#adjust_item_tbody").html(data);
            }
            hide_loading_image();
            var rowCount = document.getElementById('adjust_item_tbody').rows.length;
            document.getElementById("item_num").value = rowCount;
          }
  });
}

function fetch_orderhistory_list() {
  show_loading_image();
  $.ajax({
          url:'includes/function.php?function=fetch_orderhistory_list',
          type:'POST',
          success:function(data){
            if(data !== 'noitem'){
              $("#order_history_list").html(data);
              // console.log(data);
            }// else{
            //   $("#order_history_list").html("NO DATA");
            // }
            hide_loading_image();
          }
  });
}

function fetch_received_list() {
  show_loading_image();
  $.ajax({
          url:'includes/function.php?function=fetch_received_list',
          type:'POST',
          success:function(data){
            if(data !== 'noitem'){
              $("#fetch_received_list").html(data);
              // console.log(data);
            }// else{
            //   $("#order_history_list").html("NO DATA");
            // }
            hide_loading_image();
          }
  });
}

function fetch_adjust_received_list() {
  show_loading_image();
  $.ajax({
          url:'includes/function.php?function=fetch_adjust_received_list',
          type:'POST',
          success:function(data){
            if(data !== 'noitem'){
              $("#fetch_adjust_received_list").html(data);
              // console.log(data);
            }// else{
            //   $("#order_history_list").html("NO DATA");
            // }
            hide_loading_image();
          }
  });
}


function add_table_row(barcode,prodKname,prodName,prodUnit,prodsize,GalCode,ProdOwnCode) {
  var table = document.getElementById("neworder_item_tbody");
  var item_num = parseInt($("input[name=item_num]").val());

  var new_item_num = 0;

  var barCodes = document.getElementsByName('order_barcode[]');
		//for(var i = 1; i <= item_num; i++) {
		for(var i = 0; i < barCodes.length; i++) {
			if(barcode == barCodes[i].value) {
				alert("이미 오더장에 추가된 상품입니다.");
        return;
			}
		}


  var row = table.insertRow(new_item_num);

  var cell0 = row.insertCell(0);
  var cell1 = row.insertCell(1);
  var cell2 = row.insertCell(2);
  var cell3 = row.insertCell(3);
  var cell4 = row.insertCell(4);
  var cell5 = row.insertCell(5);
  var cell6 = row.insertCell(6);
  var cell7 = row.insertCell(7);
  var cell8 = row.insertCell(8);
  var cell9 = row.insertCell(9);
  var cell10 = row.insertCell(10);

  cell0.style.textAlign = "left";
  cell0.style.verticalAlign = "middle";
  // cell0.innerHTML = VendorCode + "<input type='hidden' value='"+VendorCode+"' class='form-control neworder_myorder_inputtxt' name='order_vendor[]'>";

  cell1.style.textAlign = "left";
  cell1.style.verticalAlign = "middle";
  cell1.innerHTML = barcode + "<input type='hidden' value='"+barcode+"' class='form-control neworder_myorder_inputtxt' name='order_barcode[]'>" + "<input type='hidden' value='"+GalCode+"' class='form-control neworder_myorder_inputtxt' name='order_galcode[]'>" + "<input type='hidden' value='"+ProdOwnCode+"' class='form-control neworder_myorder_inputtxt' name='order_prodowncode[]'>";

  cell2.style.textAlign = "left";
  cell2.style.verticalAlign = "middle";
  cell2.innerHTML = prodName+"<br />" + prodKname + "<input type='hidden' value='"+prodName+"' class='form-control neworder_myorder_inputtxt' name='order_ename[]'>" + "<input type='hidden' value='"+prodKname+"' class='form-control neworder_myorder_inputtxt' name='order_kname[]'>";

  cell3.style.textAlign = "center";
  cell3.style.verticalAlign = "middle";
  cell3.innerHTML = prodsize + "<input type='hidden' value='"+prodsize+"' class='form-control neworder_myorder_inputtxt' name='order_size[]'>" + "<input type='hidden' value='"+prodUnit+"' class='form-control neworder_myorder_inputtxt' name='order_unit[]'>";

  cell4.style.textAlign = "center";
  cell4.style.verticalAlign = "middle";
  // cell4.innerHTML = VendorUnit + "<input type='hidden' value='"+VendorUnit+"' class='form-control neworder_myorder_inputtxt' name='order_size[]'>" + "<input type='hidden' value='"+prodUnit+"' class='form-control neworder_myorder_inputtxt' name='order_vunit[]'>";

  cell5.style.textAlign = "center";
  cell5.style.verticalAlign = "middle";
  // cell5.innerHTML = VendorContent + "<input type='hidden' value='"+VendorContent+"' class='form-control neworder_myorder_inputtxt' name='order_size[]'>" + "<input type='hidden' value='"+prodUnit+"' class='form-control neworder_myorder_inputtxt' name='order_vcontent[]'>";

  cell6.style.textAlign = "left";
  cell6.style.verticalAlign = "middle";
  cell6.innerHTML = "<input type='text' class='form-control neworder_myorder_inputtxt' onkeydown='return onlyNumber(event)' onblur='check_value(this.value, 6, this)' onfocus='this.select();' name='order_price[]' value='0'>";

  cell7.style.textAlign = "left";
  cell7.style.verticalAlign = "middle";
  cell7.innerHTML = "<input type='text' class='form-control neworder_myorder_inputtxt' onkeydown='return onlyNumber(event)' onblur='check_value(this.value, 7, this)' onfocus='this.select();' name='order_qty[]' value='0'>";

  cell8.style.textAlign = "right";
  cell8.style.verticalAlign = "middle";
  cell8.innerHTML = "0.00";

  cell9.style.textAlign = "center";
  cell9.style.verticalAlign = "middle";
  cell9.innerHTML = "<span onclick='send_data(this);' class='glyphicon glyphicon-list-alt' style='cursor:pointer;' data-id='this' data-toggle='modal' data-target='#memo_modal'></span><input type='hidden' class='form-control neworder_myorder_inputtxt' name='order_memo[]'>";

  cell10.style.textAlign = "left";
  cell10.style.verticalAlign = "middle";
  cell10.innerHTML = "<i class='flaticon-forbidden-mark' style='cursor:pointer;' onclick='javascript:delete_table_myorder_item(" + barcode + ',' + 'this' + ");'></i>";

  document.forms.order_sheet.item_num.value = item_num + 1;
  document.getElementById('neworder_save').style.display = "block";
}

function delete_table_item(barcode, row, status) {
	var table = document.getElementById("myitem-tbody");
  var deleterow = row.parentNode.parentNode.rowIndex;
	table.deleteRow(deleterow - 1);
  if(status == 'U'){
    update_item_inactive(barcode);
  } else if (status == 'D') {
    delete_db_item(barcode);
  }
}

function update_item_inactive(barcode){
  $.ajax({
          url:'includes/function.php?function=update_item_inactive',
          type:'POST',
          data:{
            barcode : barcode
          }
  });
}
function delete_db_item(barcode){
  $.ajax({
          url:'includes/function.php?function=delete_db_item',
          type:'POST',
          data:{
            barcode : barcode
          }
  });
}

function ajax_save_vendorcode(e, value, barcode){
  var charCode = e.which || e.keyCode;
  if (charCode == 9 || charCode == 13){
    $.ajax({
            url:'includes/function.php?function=ajax_save_vendorcode',
            type:'POST',
            data:{
              VendorCode : value,
              barcode : barcode
            },
            success:function(data){
                $("#tableforsearch").html(value);
            }
    });
  }
}

function ajax_save_vendorcontent(e, value, barcode){
  var charCode = e.which || e.keyCode;
  if (charCode == 9 || charCode == 13){
    $.ajax({
            url:'includes/function.php?function=ajax_save_vendorcontent',
            type:'POST',
            data:{
              VendorContent : value,
              barcode : barcode
            },
            success:function(data){
                $("#tableforsearch2").html(value);
            }
    });
  }
}

function add_table_myorder_row(VendorCode,barcode,prodKname,prodName,prodUnit,prodsize,VendorUnit,VendorContent,GalCode,ProdOwnCode) {
  var table = document.getElementById("neworder_item_tbody");
  var item_num = parseInt($("input[name=item_num]").val());

  var new_item_num = 0;

  var barCodes = document.getElementsByName('order_barcode[]');
		//for(var i = 1; i <= item_num; i++) {
		for(var i = 0; i < barCodes.length; i++) {
			if(barcode == barCodes[i].value) {
				alert("이미 오더장에 추가된 상품입니다.");
        return;
			}
		}


  var row = table.insertRow(new_item_num);

  var cell0 = row.insertCell(0);
  var cell1 = row.insertCell(1);
  var cell2 = row.insertCell(2);
  var cell3 = row.insertCell(3);
  var cell4 = row.insertCell(4);
  var cell5 = row.insertCell(5);
  var cell6 = row.insertCell(6);
  var cell7 = row.insertCell(7);
  var cell8 = row.insertCell(8);
  var cell9 = row.insertCell(9);
  var cell10 = row.insertCell(10);

  cell0.style.textAlign = "left";
  cell0.style.verticalAlign = "middle";
  cell0.innerHTML = VendorCode + "<input type='hidden' value='"+VendorCode+"' class='form-control neworder_myorder_inputtxt' name='order_vendor[]'>";

  cell1.style.textAlign = "left";
  cell1.style.verticalAlign = "middle";
  cell1.innerHTML = barcode + "<input type='hidden' value='"+barcode+"' class='form-control neworder_myorder_inputtxt' name='order_barcode[]'>" + "<input type='hidden' value='"+GalCode+"' class='form-control neworder_myorder_inputtxt' name='order_galcode[]'>" + "<input type='hidden' value='"+ProdOwnCode+"' class='form-control neworder_myorder_inputtxt' name='order_prodowncode[]'>";

  cell2.style.textAlign = "left";
  cell2.style.verticalAlign = "middle";
  cell2.innerHTML = prodName+"<br />" + prodKname + "<input type='hidden' value='"+prodName+"' class='form-control neworder_myorder_inputtxt' name='order_ename[]'>" + "<input type='hidden' value='"+prodKname+"' class='form-control neworder_myorder_inputtxt' name='order_kname[]'>";

  cell3.style.textAlign = "center";
  cell3.style.verticalAlign = "middle";
  cell3.innerHTML = prodsize + "<input type='hidden' value='"+prodsize+"' class='form-control neworder_myorder_inputtxt' name='order_size[]'>" + "<input type='hidden' value='"+prodUnit+"' class='form-control neworder_myorder_inputtxt' name='order_unit[]'>";

  cell4.style.textAlign = "center";
  cell4.style.verticalAlign = "middle";
  cell4.innerHTML = VendorUnit + "<input type='hidden' value='"+VendorUnit+"' class='form-control neworder_myorder_inputtxt' name='order_size[]'>" + "<input type='hidden' value='"+prodUnit+"' class='form-control neworder_myorder_inputtxt' name='order_vunit[]'>";

  cell5.style.textAlign = "center";
  cell5.style.verticalAlign = "middle";
  cell5.innerHTML = VendorContent + "<input type='hidden' value='"+VendorContent+"' class='form-control neworder_myorder_inputtxt' name='order_size[]'>" + "<input type='hidden' value='"+prodUnit+"' class='form-control neworder_myorder_inputtxt' name='order_vcontent[]'>";

  cell6.style.textAlign = "left";
  cell6.style.verticalAlign = "middle";
  cell6.innerHTML = "<input type='text' class='form-control neworder_myorder_inputtxt' onkeydown='return onlyNumber(event)' onblur='check_value(this.value, 6, this)' onfocus='this.select();' name='order_price[]' value='0'>";

  cell7.style.textAlign = "left";
  cell7.style.verticalAlign = "middle";
  cell7.innerHTML = "<input type='text' class='form-control neworder_myorder_inputtxt' onkeydown='return onlyNumber(event)' onblur='check_value(this.value, 7, this)' onfocus='this.select();' name='order_qty[]' value='0'>";

  cell8.style.textAlign = "right";
  cell8.style.verticalAlign = "middle";
  cell8.innerHTML = "0.00";

  cell9.style.textAlign = "center";
  cell9.style.verticalAlign = "middle";
  cell9.innerHTML = "<span onclick='send_data(this);' class='glyphicon glyphicon-list-alt' style='cursor:pointer;' data-id='this' data-toggle='modal' data-target='#memo_modal'></span><input type='hidden' class='form-control neworder_myorder_inputtxt' name='order_memo[]'>";

  cell10.style.textAlign = "left";
  cell10.style.verticalAlign = "middle";
  cell10.innerHTML = "<i class='flaticon-forbidden-mark' style='cursor:pointer;' onclick='javascript:delete_table_myorder_item(" + barcode + ',' + 'this' + ");'></i>";

  document.forms.order_sheet.item_num.value = item_num + 1;
  document.getElementById('neworder_save').style.display = "block";
}

function delete_table_myorder_item(barcode, row) {
	var table = document.getElementById("neworder_item_tbody");
  var item_num = parseInt($("input[name=item_num]").val());
  var deleterow = row.parentNode.parentNode.rowIndex;
	table.deleteRow(deleterow - 1);
  document.forms.order_sheet.item_num.value = item_num - 1;
}

function add_table_adjust_row(barcode,prodKname,prodName,prodUnit,prodsize,GalCode,ProdOwnCode) {
  var table = document.getElementById("adjust_item_tbody");
  var item_num = parseInt($("input[name=item_num]").val());

  var new_item_num = 0;

  var barCodes = document.getElementsByName('order_barcode[]');
		//for(var i = 1; i <= item_num; i++) {
		for(var i = 0; i < barCodes.length; i++) {
			if(barcode == barCodes[i].value) {
				alert("이미 오더장에 추가된 상품입니다.");
        return;
			}
		}


  var row = table.insertRow(new_item_num);

  var cell0 = row.insertCell(0);
  var cell1 = row.insertCell(1);
  var cell2 = row.insertCell(2);
  var cell3 = row.insertCell(3);
  var cell4 = row.insertCell(4);
  var cell5 = row.insertCell(5);

  cell0.style.textAlign = "left";
  cell0.style.verticalAlign = "middle";
  cell0.innerHTML = barcode + "<input type='hidden' value='"+barcode+"' class='form-control neworder_myorder_inputtxt' name='order_barcode[]'>" + "<input type='hidden' value='"+GalCode+"' class='form-control neworder_myorder_inputtxt' name='order_galcode[]'>" + "<input type='hidden' value='"+ProdOwnCode+"' class='form-control neworder_myorder_inputtxt' name='order_prodowncode[]'>";

  cell1.style.textAlign = "left";
  cell1.style.verticalAlign = "middle";
  cell1.innerHTML = prodName+"<br />" + prodKname + "<input type='hidden' value='"+prodName+"' class='form-control neworder_myorder_inputtxt' name='order_ename[]'>" + "<input type='hidden' value='"+prodKname+"' class='form-control neworder_myorder_inputtxt' name='order_kname[]'>";

  cell2.style.textAlign = "center";
  cell2.style.verticalAlign = "middle";
  cell2.innerHTML = prodsize + "<input type='hidden' value='"+prodsize+"' class='form-control neworder_myorder_inputtxt' name='order_size[]'>" + "<input type='hidden' value='"+prodUnit+"' class='form-control neworder_myorder_inputtxt' name='order_unit[]'>";

  cell3.style.textAlign = "left";
  cell3.style.verticalAlign = "middle";
  cell3.innerHTML = "<input type='text' class='form-control neworder_myorder_inputtxt' onkeydown='return onlyNumber(event)' name='order_qty[]' value='0'>";

  cell4.style.textAlign = "center";
  cell4.style.verticalAlign = "middle";
  cell4.innerHTML = "<span onclick='send_data(this);' class='glyphicon glyphicon-list-alt' style='cursor:pointer;' data-id='this' data-toggle='modal' data-target='#memo_modal'></span><input type='hidden' class='form-control neworder_myorder_inputtxt' name='order_memo[]'>";

  cell5.style.textAlign = "left";
  cell5.style.verticalAlign = "middle";
  cell5.innerHTML = "<i class='flaticon-forbidden-mark' style='cursor:pointer;' onclick='javascript:delete_table_myorder_item(" + barcode + ',' + 'this' + ");'></i>";

  document.forms.order_sheet.item_num.value = item_num + 1;
  document.getElementById('adjust_save').style.display = "block";
}

function check_value(str, cell, this_row_num) {
	var table = document.getElementById("neworder_item_tbody");
  var row_num = this_row_num.parentNode.parentNode.rowIndex - 1;

	if (str.length != 0 && str != 0) {
		table.rows[row_num].cells[cell].style.backgroundColor = "";
		if(cell == 6) {
			var price = parseFloat(document.getElementsByName('order_price[]')[row_num].value);
			document.getElementsByName('order_price[]')[row_num].value = price.toFixed(2);
		}
		if(cell == 7) {
			var qty = parseFloat(document.getElementsByName('order_qty[]')[row_num].value);
			document.getElementsByName('order_qty[]')[row_num].value = qty;
		}
	} else {
		if(cell == 6)	document.getElementsByName('order_price[]')[row_num].value = 0.00;
		if(cell == 7)	document.getElementsByName('order_qty[]')[row_num].value = 0;
		table.rows[row_num].cells[cell].style.backgroundColor = "red";
	}
  // console.log(row_num);
	calculate_sum(row_num);
  calculate_total_sum();
}

function calculate_sum(row_num) {
	var price = document.getElementsByName('order_price[]')[row_num].value;
	var qty = document.getElementsByName('order_qty[]')[row_num].value;
  var prev_row_num = row_num + 1;

	if(price && qty) {
    var table = document.getElementById("neworder_item_tbody");
		var sum = parseFloat(price * qty);
		table.rows[row_num].cells[8].innerHTML = sum.toFixed(2);
	}
}

function calculate_total_sum() {
  var trlength = $('#neworder_item_tbody tr').length;
  var sum = 0;
  var table = document.getElementById("neworder_item_tbody");
  for(var i=0; i<=trlength - 1; i++) {
      var subtotal = table.rows[i].cells[8].innerHTML;
      sum = sum + parseFloat(subtotal);
	}
	var span_num = document.getElementById("neworder_total_num");
  var total_sum = sum.toFixed(2);
	span_num.innerHTML = formatNumber(total_sum);

}
function formatNumber (num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
}


function newOrderPage_Redirect(tOrdNo, branch){
  window.location = "?page=frame&menu=neworderitem&branch=" + branch + "&order_no=" + tOrdNo
}

function adminOrderPage_Redirect(tOrdNo, branch){
  window.location = "?page=frame&menu=adminorderitem&branch=" + branch + "&order_no=" + tOrdNo
}
function adjustPage_Redirect(tOrdNo, branch){
  window.location = "?page=frame&menu=adjust&order_no=" + tOrdNo
}
function proceed_submit(mode) {
	var table = document.getElementById("neworder_item_tbody");
	var item_num = parseInt(document.forms.order_sheet.item_num.value);

	// var deliveryDate = document.getElementsByName("delivery_date")[0].value;
	// deliveryDate = deliveryDate.split("-");
	// var delYear = parseInt(deliveryDate[0]);
	// var delMonth = parseInt(deliveryDate[1])-1;
	// var delDay = parseInt(deliveryDate[2]);

	// var today = new Date();
	// deliveryDate = new Date();
	// deliveryDate.setFullYear(delYear, delMonth, delDay);

	// if(deliveryDate < today) {
	// 	if(mode == "modify" || mode == "delete") {
	// 		alert("배송날짜가 지나 수정/삭제할 수 없습니다.");
	// 	} else {
	// 		alert("배송날짜를 변경해주십시요");
	// 	}
	// 	return false;
	// }

	for(var i = 1; i <= item_num; i++) {
		if(table.rows[i-1].cells[6].style.backgroundColor == "red" || table.rows[i-1].cells[7].style.backgroundColor == "red") {
			alert("Put Price/Qty.");
			return false;
		}
    if(table.rows[i-1].cells[8].innerHTML < 0 && table.rows[i-1].cells[9].getElementsByTagName("input")[0].value == '') {
      alert("Plz Leave the memo since the price is below 0.");
			return false;
		}
	}

	if(mode == "add")		var answer = confirm("Would you like to add this item??");
	if(mode == "modify")	var answer = confirm("Would you like to modify this order?");
	if(mode == "delete")	var answer = confirm("Would you like to delete this order?");
  if(mode == "submit")	var answer = confirm("Would you like to submit this order?");
  if(mode == "update")	var answer = confirm("Would you like to send back this order to vendor?");
  if(mode == "confirm")	var answer = confirm("Would you like to confirm this order?");


	if(answer) {
		document.forms.order_sheet.mode.value = mode;
		document.forms.order_sheet.submit();
	} else {
		return false;
	}
}

function proceed_adjust_submit(mode) {
	var table = document.getElementById("adjust_item_tbody");
	var item_num = parseInt(document.forms.order_sheet.item_num.value);
  var ordno = $('#orderNum').val();
  var chk = 'adjust';
	// var deliveryDate = document.getElementsByName("delivery_date")[0].value;
	// deliveryDate = deliveryDate.split("-");
	// var delYear = parseInt(deliveryDate[0]);
	// var delMonth = parseInt(deliveryDate[1])-1;
	// var delDay = parseInt(deliveryDate[2]);

	// var today = new Date();
	// deliveryDate = new Date();
	// deliveryDate.setFullYear(delYear, delMonth, delDay);

	// if(deliveryDate < today) {
	// 	if(mode == "modify" || mode == "delete") {
	// 		alert("배송날짜가 지나 수정/삭제할 수 없습니다.");
	// 	} else {
	// 		alert("배송날짜를 변경해주십시요");
	// 	}
	// 	return false;
	// }

	for(var i = 1; i <= item_num; i++) {
		if(table.rows[i-1].cells[3].style.backgroundColor == "red") {
			alert("Put Price/Qty.");
			return false;
		}
	}

	if(mode == "add")		var answer = confirm("Would you like to add this item??");
	if(mode == "modify")	var answer = confirm("Would you like to modify this order?");
	if(mode == "delete")	var answer = confirm("Would you like to delete this order?");
  if(mode == "submit")	var answer = confirm("Would you like to submit this order?");
  if(mode == "update")	var answer = confirm("Would you like to send back this order to vendor?");
  if(mode == "confirm")	var answer = confirm("Would you like to confirm this order?");
  if(mode == "complete")	var answer = confirm("Would you like to complete this order?");
  if(mode == "complete" && answer){
    Update_order_balance(ordno,chk);
    return;
  }
	if(answer) {
		document.forms.order_sheet.mode.value = mode;
		document.forms.order_sheet.submit();
	} else {
		return false;
	}
}

function order_submit() {
  // show_loading_image();
  var order_no = $('#search_item').val();
  $.ajax({
          url:'includes/function.php?function=order_submit',
          type:'POST',
          data:{
            order_no : order_no
          },
          success:function(data){
            if(data == 'notright'){
              alert("You Can't Submit. This is not Your Order.");
            } else if (data == 'already') {
              alert("You already Submitted");
            } else{
              $("#search_result_table tbody").html(data);
            }
            // hide_loading_image();
          }
  });
}

function open_Orderdate_calendar(){
  $("#orderDate").datepicker("show");
}

function open_Orderdate_vendor_calendar(){
  $("#orderDate").datepicker("show");
}

function search_Orderdate(date){
  show_loading_image();
  $.ajax({
          url:'includes/function.php?function=search_Orderdate',
          type:'POST',
          data:{
            orderDate : date
          },
          success:function(data){
            if(data == 'noitem'){
              alert("There Is No Item");
            } else{
              $("#fetch_received_list").html(data);
            }
            hide_loading_image();
          }
  });
}

function search_ReceivedOrder(){
  var txt = $('#search_received_txt').val();
  show_loading_image();
  $.ajax({
          url:'includes/function.php?function=search_ReceivedOrder',
          type:'POST',
          data:{
            txt : txt
          },
          success:function(data){
            if(data == 'noitem'){
              alert("There Is No Item");
            } else{
              $("#fetch_received_list").html(data);
            }
            hide_loading_image();
          }
  });
}

function search_ConfirmedOrder(){
  var txt = $('#search_confirmed_txt').val();
  show_loading_image();
  $.ajax({
          url:'includes/function.php?function=search_ConfirmedOrder',
          type:'POST',
          data:{
            txt : txt
          },
          success:function(data){
            if(data == 'noitem'){
              alert("There Is No Item");
            } else{
              $("#fetch_adjust_received_list").html(data);
            }
            hide_loading_image();
          }
  });
}

function search_Confirmeddate(date){
  show_loading_image();
  $.ajax({
          url:'includes/function.php?function=search_Confirmeddate',
          type:'POST',
          data:{
            orderDate : date
          },
          success:function(data){
            if(data == 'noitem'){
              alert("There Is No Item");
            } else{
              $("#fetch_adjust_received_list").html(data);
            }
            hide_loading_image();
          }
  });
}

function open_confirmed_orderdate_calendar(){
  $("#confirmedDate").datepicker("show");
}

function Order_delete_chk(){
  var tOrdNo = $('#delete_order_no').html();
  show_loading_image();
  $.ajax({
          url:'includes/function.php?function=Order_delete_chk',
          type:'POST',
          data:{
            tOrdNo : tOrdNo
          },
          success:function(data){
            if(data == 'noauthorized'){
              alert('You cannot delete the record which you do not make');
            } else if (data == 'success') {
              alert('Success');
              window.location.reload();
            } else {
              alert('Contact IT department');
            }
            hide_loading_image();
          }
  });
}

function fetch_admin_itemlist(vendorid,ordno) {
  $.ajax({
          url:'includes/function.php?function=fetch_admin_itemlist',
          type:'POST',
          data:{
            ordno : ordno,
            vendorid : vendorid
          },
          success:function(data){
            if(data !== 'noitem'){
              $("#neworder_item_tbody").html(data);
              // console.log(data);
            }
            var rowCount = document.getElementById('neworder_item_tbody').rows.length;
            document.getElementById("item_num").value = rowCount;
          }
  });
}

function fetch_saved_list() {
  $.ajax({
          url:'includes/function.php?function=fetch_saved_list',
          type:'POST',
          success:function(data){
            if(data !== 'noitem'){
              $("#dashboard_saved_list").html(data);
              // console.log(data);
            }
          }
  });
}

function fetch_confirmed_list() {
  $.ajax({
          url:'includes/function.php?function=fetch_confirmed_list',
          type:'POST',
          success:function(data){
            if(data !== 'noitem'){
              $("#dashboard_confirmed_list").html(data);
              // console.log(data);
            }
          }
  });
}

function view_order(ordno)  {
	try{

    $.ajax({
            url:'includes/function.php?function=view_order',
            type:'POST',
            data:{
              ordno : ordno
            },
            success:function(data){
              if(data !== 'noitem'){
                var items_tmp = data.split('::'); // 전달 받은 데이타 파싱
        				var items_all_count = parseInt(items_tmp[0]);	// 전달된 데이타 갯수
        				var item_text = "";	// 화면에 표시할 변수 초기화
        				var n = "";
        				var line = "";
        				var table_header = "<table class='table table-bordered' style='table-layout:fixed;'>";
                table_header += "<tr><th>NAME</th><th style='width:63px;'>SIZE</th><th style='width:85px;'>QTY/PRICE</th><th style='width:85px;'>SUBTOTAL</th></tr>";
        				var table_footer = "</table>";
        				for(var i = 1; i < items_tmp.length; i++)
        				{
        					tmp = items_tmp[i].split(';');
                  item_text += "<tr><td rowspan='2'>"+tmp[5]+"<br />"+tmp[6]+"</td><td style='text-align:center;'>"+tmp[7]+"</td><td style='text-align:center;'>"+tmp[8]+"</td><td rowspan='2'  style='text-align:right;vertical-align:middle;padding-right:7px;'>$"+tmp[10]+"</td></tr>";
                  item_text += "<tr><td style='text-align:center;'>"+tmp[11]+"</td><td style='text-align:center;'>$"+tmp[9]+"</td></tr>"
        				}
                  item_text += "<tr><td colspan='3' style='text-align:right;'>Total:</td>";
                  item_text += "<td style='text-align:right;padding-right:7px;'>$"+tmp[2]+"</td></tr>";
                  item_text += "<input type='hidden' class='orderNo' value='"+tmp[0]+"'>";
                $("#orderItem_Detail").html(table_header+item_text+table_footer);
                // console.log(data);
              }
            }
    });
	} catch(e) {
		alert("Contact IT " + e.message);
	}
	return false;
}

function print_order_form(OrdNo) {
	var popupw;

	if(confirm("Want to print Order Sheet. \nProceed?"))
	{
		popupw = window.open("FormOrderSheet.php?OrdNo="+OrdNo,"_blank");

		try
		{
			popupw.focus();
			// window.open('about:blank','_self').close();
		}
		catch(e)
		{
			alert("Pop-up Blocker is enabled! Please add this site to your exception list.");
		}
	}
}

function get_number_vendorItem(){
    $.ajax({
            url:'includes/function.php?function=get_number_vendorItem',
            type:'POST',
            success:function(data){
                $(".box-item").html(data);
            }
    });
}

function get_number_Totalamount(){
    $.ajax({
            url:'includes/function.php?function=get_number_Totalamount',
            type:'POST',
            success:function(data){
                $(".box-total").html(data);
            }
    });
}

function get_number_balance(){
    $.ajax({
            url:'includes/function.php?function=get_number_balance',
            type:'POST',
            success:function(data){
                $(".box-balance").html(data);
            }
    });
}

function get_number_credit(){
    $.ajax({
            url:'includes/function.php?function=get_number_credit',
            type:'POST',
            success:function(data){
                $(".box-credit").html(data);
            }
    });
}

function register_item(){
  var reg_Ename = $( "input[name*='reg_Ename']" ).val();
  var reg_Kname = $( "input[name*='reg_Kname']" ).val();
  var reg_Size = $( "input[name*='reg_Size']" ).val();
  var reg_Upc = $( "input[name*='reg_Upc']" ).val();
  var reg_Itemcode = $( "input[name*='reg_Itemcode']" ).val();
  var reg_Vunit = $( "select[name*='reg_Vunit'] option:selected" ).val();
  var reg_Vcont = $( "input[name*='reg_Vcont']" ).val();
  var reg_Vtype = $( "select[name*='reg_Vtype'] option:selected" ).val();

  $.ajax({
          url:'includes/function.php?function=register_item',
          type:'POST',
          data:{
            reg_Ename : reg_Ename,
            reg_Kname : reg_Kname,
            reg_Size : reg_Size,
            reg_Upc : reg_Upc,
            reg_Itemcode : reg_Itemcode,
            reg_Vunit : reg_Vunit,
            reg_Vcont : reg_Vcont,
            reg_Vtype : reg_Vtype
          },
          success:function(data){
            if(data == 'already'){
              alert("You already have added this item. Please, Check the list.");
            } else if (data == 'success') {
              location.reload();
            } else {
              // alert(data);
              alert("Please Sign Out and Login again.")
            }
          }
  });
}

function register_vendor(){
  var ven_Name = $( "input[name*='ven_Name']" ).val();
  var ven_Phone = $( "input[name*='ven_Phone']" ).val();
  var ven_Fax = $( "input[name*='ven_Fax']" ).val();
  var ven_Email = $( "input[name*='ven_Email']" ).val();
  var ven_Address = $( "input[name*='ven_Address']" ).val();
  var ven_Useyn = $( "select[name*='ven_Useyn'] option:selected" ).val();

  if(ven_Name == ''){
    alert('Type the Company Name');
    return;
  }
  $.ajax({
          url:'includes/function.php?function=register_vendor',
          type:'POST',
          data:{
            ven_Name : ven_Name,
            ven_Phone : ven_Phone,
            ven_Fax : ven_Fax,
            ven_Email : ven_Email,
            ven_Address : ven_Address,
            ven_Useyn : ven_Useyn
          },
          success:function(data){
            if (data == 'success') {
              location.reload();
            } else {
              console.log(data);
              alert('Contact IT');
            }
          }
  });
}

function update_vendor(){
  var ven_ID = $( "input[name*='ven_ID']" ).val();
  var ven_Name = $( "input[name*='ven_Name']" ).val();
  var ven_Phone = $( "input[name*='ven_Phone']" ).val();
  var ven_Fax = $( "input[name*='ven_Fax']" ).val();
  var ven_Email = $( "input[name*='ven_Email']" ).val();
  var ven_Address = $( "input[name*='ven_Address']" ).val();
  var ven_Useyn = $( "select[name*='ven_Useyn'] option:selected" ).val();


  $.ajax({
          url:'includes/function.php?function=update_vendor',
          type:'POST',
          data:{
            ven_ID : ven_ID,
            ven_Name : ven_Name,
            ven_Phone : ven_Phone,
            ven_Fax : ven_Fax,
            ven_Email : ven_Email,
            ven_Address : ven_Address,
            ven_Useyn : ven_Useyn
          },
          success:function(data){
            if (data == 'success') {
              location.reload();
            } else {
              // alert(data);
              alert("Please Sign Out and Login again.")
            }
          }
  });
}

function fetch_vendor_list(){
  show_loading_image();
  $.ajax({
          url:'includes/function.php?function=fetch_vendor_list',
          type:'POST',
          success:function(data){
              $("#admin-vendor-list tbody").html(data);
              hide_loading_image();
          },
          error : function(){
            alert('Contact IT');
            hide_loading_image();
          }
  });
}

function fetch_vendor_detail(VendorID){
  $.ajax({
          url:'includes/function.php?function=fetch_vendor_detail',
          type:'POST',
          data:{
            VendorID : VendorID
          },
          dataType: 'json',
          success:function(data){
            $( "input[name*='ven_ID']" ).val(data["VendorID"]);
            $( "input[name*='ven_Name']" ).val(data["Name"]);
            $( "input[name*='ven_Phone']" ).val(data["Phone"]);
            $( "input[name*='ven_Fax']" ).val(data["Fax"]);
            $( "input[name*='ven_Email']" ).val(data["Email"]);
            $( "input[name*='ven_Address']" ).val(data["Address"]);
            $(".controls label").addClass('active');
            $(".vendorlist-update-btn").css('display','inline-block');
            $(".vendorlist-add-btn").css('display','none');
          },
          error : function(){
            alert('Contact IT');
          }
  });
}

function onlyNumber(event) {
	event = event || window.event;
	var keyID = (event.which) ? event.which : event.keyCode;
	if ( (keyID >= 48 && keyID <= 57) || (keyID >= 96 && keyID <= 105) || keyID == 8 || keyID == 46 || keyID == 37 || keyID == 39 || keyID == 189 || keyID == 190 || keyID == 110 || keyID == 9 || keyID == 45) {
		return;
	} else {
		return false;
	}
}

function select_status_listbox(v){
  if(v == 1){
    $('#orderhistory_status').html('SAVED ORDER');
    $('#orderhistory_status').css('color','#E63946');
  } else if (v == 2) {
    $('#orderhistory_status').html('UPDATED ORDER');
    $('#orderhistory_status').css('color','#7AC943');
  } else if (v == 3) {
    $('#orderhistory_status').html('SUBMITTED ORDER');
    $('#orderhistory_status').css('color','#7AC943');
  } else if (v == 4) {
    $('#orderhistory_status').html('CONFIRMED ORDER');
    $('#orderhistory_status').css('color','#3C91E6');
  } else if (v == 5) {
    $('#orderhistory_status').html('COMPLETED DELIVERY');
    $('#orderhistory_status').css('color','#a471db');
  } else if (v == 0){
    $('#orderhistory_status').html('');
    $('#orderhistory_status').css('');
  }
}
function show_loading_image() {
	document.getElementById('loader').style.display = "block";
}

function hide_loading_image() {
	document.getElementById('loader').style.display = "none";
}

function handle(e,func){
       if(e.keyCode === 13){
         if(func == 'login'){
           e.preventDefault();
           ajax_login();
         } else if (func == 'search_receivedorder') {
           e.preventDefault();
           search_ReceivedOrder();
         } else if (func == 'search_confirmedorder') {
           e.preventDefault();
           search_ConfirmedOrder();
         }
       }
}

function textchanged(number,val){

  var val = val.trim();
  var x = document.getElementsByName("chk[]");

  // if(val !== '0' || val !== ''){
  //   x[number].checked = true;
  // }
  // if(val == '' || val == "0"){
  //   x[number].checked = false;
  // }
  x[number].checked = true;

}

function myitem_save(){
  var itemarr = new Array();
  var vendorcode = document.getElementsByName("vendorcode[]");
  var vendorcontent = document.getElementsByName("vendorcontent[]");
  var vendorunit = document.getElementsByName("vendorunit[]");
  var vendortype = document.getElementsByName("vendortype[]");
  var barcode = document.getElementsByName("barcode[]");

  itemarr = getCheckedCheckboxesFor('chk[]');
  for (i = 0; i < itemarr.length; i++) {
    var ajax_barcode = barcode[itemarr[i]].value;
    var ajax_code = vendorcode[itemarr[i]].value;
    var ajax_unit = vendorunit[itemarr[i]].value;
    var ajax_content = vendorcontent[itemarr[i]].value;
    var ajax_type = vendortype[itemarr[i]].value;
    var row = itemarr[i];

    ajax_each_save_item(ajax_barcode, ajax_code, ajax_unit, ajax_content, ajax_type, row);
  }
}

function ajax_each_save_item(ajax_barcode, ajax_code, ajax_unit, ajax_content, ajax_type, row){
  var chk = document.getElementsByName("chk[]");
  $.ajax({
          url:'includes/function.php?function=ajax_each_save_item',
          type:'POST',
          data:{
            ajax_barcode : ajax_barcode,
            ajax_code : ajax_code,
            ajax_unit : ajax_unit,
            ajax_content : ajax_content,
            ajax_type : ajax_type
          },
          success:function(data){
            if(data == 'success'){
              chk[row].checked = false;
              location.reload();
            } else {
              alert('Contact IT');
            }
          }
  });
}

function getCheckedCheckboxesFor(checkboxName) {
    var checkboxes = document.querySelectorAll('input[name="' + checkboxName + '"]:checked'), values = [];
    Array.prototype.forEach.call(checkboxes, function(el) {
        values.push(el.value);
    });
    return values;
}

function search_galcode_prodowncode(this_row_num){
  $('#search_mfprod_div #Item_Detail').html('');
  var row_num = this_row_num.parentNode.parentNode.rowIndex - 1;
  var barcode = document.getElementsByName("barcode[]");
  $('#search_mfprod_row_num').val(row_num);
  $.ajax({
          url:'includes/function.php?function=search_galcode_prodowncode',
          type:'POST',
          data:{
            barcode : barcode[row_num].value
          },
          success:function(data){
            if(data == 'noitem'){
              alert("There Is No Item With This Barcode");
            } else{
              $('#search_mfprod_div #Item_Detail').html(data);
            }
          }
  });
}

function set_textbox(GalCode, ProdOwnCode){
  var row_num = $('#search_mfprod_row_num').val();
  var galcode = document.getElementsByName("galcode[]");
  var prodowncode = document.getElementsByName("prodowncode[]");
  galcode[row_num].value = GalCode;
  prodowncode[row_num].value = ProdOwnCode;
  $('#search_mfprod_div').modal('toggle');
}

function get_row_item(row_num, dataid){
  var vendorcode = document.getElementsByName("vendorcode[]");
  var barcode = document.getElementsByName("barcode[]");
  var vendorunit = document.getElementsByName("vendorunit[]");
  var vendorcontent = document.getElementsByName("vendorcontent[]");
  var vendortype = document.getElementsByName("vendortype[]");
  var galcode = document.getElementsByName("galcode[]");
  var prodowncode = document.getElementsByName("prodowncode[]");

  var vendorcode_value = vendorcode[row_num].value;
  var barcode_value = barcode[row_num].value;
  var vendorunit_value = vendorunit[row_num].value;;
  var vendorcontent_value = vendorcontent[row_num].value;
  var vendortype_value = vendortype[row_num].value;
  var galcode_value = galcode[row_num].value;
  var prodowncode_value = prodowncode[row_num].value;

  if(galcode_value == '' || prodowncode_value == ''){
    alert('Click Barcode and Choose the item that matches');
  } else {
    update_item_confirmed(vendorcode_value,barcode_value,vendorunit_value,vendorcontent_value,vendortype_value,galcode_value,prodowncode_value,dataid);
  }

}

function update_item_confirmed(vendorcode_value,barcode_value,vendorunit_value,vendorcontent_value,vendortype_value,galcode_value,prodowncode_value,dataid){
  var vendorId =  $('#admin_vendor_id').val();
  $.ajax({
          url:'includes/function.php?function=update_item_confirmed',
          type:'POST',
          data:{
            vendorid : vendorId,
            vendorcode:vendorcode_value,
            barcode:barcode_value,
            vendorunit:vendorunit_value,
            vendorcontent:vendorcontent_value,
            vendortype:vendortype_value,
            galcode:galcode_value,
            prodowncode:prodowncode_value
          },
          success:function(data){
            if(data == 'success'){
              remove_button_tr(dataid);
            } else{
              alert('Contact IT OR Close all the browser and Try again');
              console.log(data);
            }
          }
  });
}

function fetch_custom_orderhistroy_vendor(cid){
  var status =  $('.status_listbox select option:selected').val();
  var deliveryDate =  $('.date_listbox select option:selected').val();

  show_loading_image();
  $.ajax({
          url:'includes/function.php?function=fetch_custom_orderhistroy_vendor',
          type:'POST',
          data:{
            CID : cid,
            status:status,
            deliveryDate:deliveryDate
          },
          success:function(data){
            if(data == 'noitem'){
              $("#order_history_list").html('');
            } else {
              $("#order_history_list").html(data);
            }
            hide_loading_image();
          },
          error : function(){
            alert('Contact IT');
            hide_loading_image();
          }
  });
}


function remove_button_tr(dataid){
  var tr_dataid = $(dataid).closest('tr').attr('data-id');
  $('[data-id=' + tr_dataid + ']').removeClass('danger');
  $(dataid).hide();
}

function ajax_vendor_search() {
  var vendorTxt = $('#admin-vendor-search-table-filter').val();
  if(vendorTxt){
    show_loading_image();
    $.ajax({
            url:'includes/function.php?function=ajax_vendor_search',
            type:'POST',
            data:{
              vendorTxt : vendorTxt
            },
            success:function(data){
              if(data == 'noitem'){
                alert("There Is No Vendor");
              } else{
                $("#admin-vendor-search-table tbody").html(data);
              }
              hide_loading_image();
            },
            error : function(){
              alert('Contact IT');
              hide_loading_image();
            }
    });
  } else {
    alert("You need to Type something");
  }

}

function admin_search_vendor(){
  var vendorTxt = $('#vendor_search_text').val();
  if(vendorTxt){
    $.ajax({
            url:'includes/function.php?function=admin_search_vendor',
            type:'POST',
            data:{
              vendorTxt : vendorTxt
            },
            success:function(data){
              if(data == 'noitem'){
                alert("There Is No Vendor");
              } else{
                $('#search_vendor_modal').modal();

                $("#vendor-list-detail").html(data);
              }
            },
            error : function(){
              alert('Contact IT');
            }
    });
  } else {
    alert("You need to Type something");
  }
}

function select_vendor(VendorID, Name){
  $('#main_vendor').val(VendorID);
  $('#vendor_search_text').val(Name);
  $('#search_vendor_modal').modal('toggle');
}

function fetch_hnis_member() {
  $.ajax({
          url:'includes/function.php?function=fetch_hnis_member',
          type:'POST',
          success:function(data){
            if(data !== 'noitem'){
              $('#autho-table tbody').html(data);
              // console.log(data);
            }
          }
  });
}

function Update_order_balance(ordno, chk){
    $.ajax({
            url:'includes/function.php?function=Update_order_balance',
            type:'POST',
            data:{
              ordno : ordno,
              chk : chk
            },
            success:function(data){
              alert(data);
            },
            error : function(){
              alert('Contact IT');
            }
    });
}
