$(document).ready(function(){
  var cid;
  $( ".location_container .location_box" ).click(function() {
    $('.location_box').css('background-color','#dcddde');
    if(this.className == 'location_box box_all'){
      $('.box_all').css('background-color','#E63946 !important');
      cid = 0;
    } else if (this.className == 'location_box box_bby') {
      $('.box_bby').css('background-color','#E63946 !important');
      cid = 1;
    } else if (this.className == 'location_box box_sry') {
      $('.box_sry').css('background-color','#E63946 !important');
      cid = 2;
    } else if (this.className == 'location_box box_dt') {
      $('.box_dt').css('background-color','#E63946 !important');
      cid = 3;
    } else if (this.className == 'location_box box_nv') {
      $('.box_nv').css('background-color','#E63946 !important');
      cid = 4;
    }
    fetch_custom_orderhistroy_vendor(cid);
  });

  $(".date_listbox select").change(function(){
    if(!cid){
      cid = 0;
    }
    fetch_custom_orderhistroy_vendor(cid);
  });

  $(".status_listbox select").change(function(){
    if(!cid){
      cid = 0;
    }
    fetch_custom_orderhistroy_vendor(cid);
  });
});

$(document).ready(function(){
  $("#orderDate").datepicker({
    dateFormat: 'yy-mm-dd',
    onSelect: function( selectedDate ) {
      // $( "#orderDate" ).datepicker( 'option', {dateFormat: 'yyyy-mm-dd'} );
      search_Orderdate(selectedDate);
    }
  });
});

$(document).ready(function(){
  $("#confirmedDate").datepicker({
    dateFormat: 'yy-mm-dd',
    onSelect: function( selectedDate ) {
      // $( "#orderDate" ).datepicker( 'option', {dateFormat: 'yyyy-mm-dd'} );
      search_Confirmeddate(selectedDate);
    }
  });
});

$(document).ready(function(){
$("#mytable #checkall").click(function () {
        if ($("#mytable #checkall").is(':checked')) {
            $("#mytable input[type=checkbox]").each(function () {
                $(this).prop("checked", true);
            });

        } else {
            $("#mytable input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
        }
    });

    $("[data-toggle=tooltip]").tooltip();
});


$(document).ready(function(){
  $('#vendor_search_text').bind("enterKey",function(e){
      admin_search_vendor();
    });
    $('#vendor_search_text').keyup(function(e){
      if(e.keyCode == 13) {
        $(this).trigger("enterKey");
      }
  });
});

$(document).ready(function(){
  $('#admin-vendor-search-table-filter').bind("enterKey",function(e){
      ajax_vendor_search();
    });
    $('#admin-vendor-search-table-filter').keyup(function(e){
      if(e.keyCode == 13) {
        $(this).trigger("enterKey");
      }
  });
});

$(document).ready(function(){
  $('#vendoritem-table-filter').bind("enterKey",function(e){
      fetch_vendoritem_search_admin();
    });
    $('#vendoritem-table-filter').keyup(function(e){
      if(e.keyCode == 13) {
        $(this).trigger("enterKey");
      }
  });
});

$(document).ready(function(){
  $('#admin_search_item').bind("enterKey",function(e){
      ajax_search();
    });
    $('#admin_search_item').keyup(function(e){
      if(e.keyCode == 13) {
        $(this).trigger("enterKey");
      }
  });
});

$(document).ready(function(){
  $('#adj-table-filter').bind("enterKey",function(e){
      adj_search_item();
    });
    $('#adj-table-filter').keyup(function(e){
      if(e.keyCode == 13) {
        $(this).trigger("enterKey");
      }
  });
});

(function(){
    'use strict';
  var $ = jQuery;
  $.fn.extend({
    filterTable: function(){
      return this.each(function(){
        $(this).on('keyup', function(e){
          $('.filterTable_no_results').remove();
          var $this = $(this),
                        search = $this.val().toLowerCase(),
                        target = $this.attr('data-filters'),
                        $target = $(target),
                        $rows = $target.find('tbody tr');

          if(search == '') {
            $rows.show();
          } else {
            $rows.each(function(){
              var $this = $(this);
              $this.text().toLowerCase().indexOf(search) === -1 ? $this.hide() : $this.show();
            })
            // if($target.find('tbody tr:visible').size() === 0) {
            //   var col_count = $target.find('tr').first().find('td').size();
            //   var no_results = $('<tr class="filterTable_no_results"><td colspan="'+col_count+'">No results found</td></tr>')
            //   $target.find('tbody').append(no_results);
            // }
          }
        });
      });
    }
  });
  $('[data-action="filter"]').filterTable();
})(jQuery);

$(function(){
    // attach table filter plugin to inputs
  $('[data-action="filter"]').filterTable();

  $('#search').on('click', '.panel-heading span.filter', function(e){
    var $this = $(this),
      $panel = $this.parents('.panel');

    $panel.find('.panel-body').slideToggle();
    if($this.css('display') != 'none') {
      $panel.find('.panel-body input').focus();
    }
  });
  $('[data-toggle="tooltip"]').tooltip();
});

$(function(){
  $( "#deliveryDate" ).datepicker({
				onSelect: function( selectedDate ) {
					$( "#deliveryDate" ).datepicker( 'option', {dateFormat: 'yy-mm-dd'} );
				}
			});

  floatLabel(".floatLabel");
});


function send_delete_modal(row_num){
  $("#delete_order_no").html( tOrdNo );
  $('#delete').modal('show');
}
function send_data(num){
  var row_num = num.parentNode.parentNode.rowIndex - 1;
  $(".row_num_temp").val(row_num);
  load_data(row_num);
}
function save_data(num){
  var row_num = $(".row_num_temp").val();
  var inp = document.getElementsByName("order_memo[]");
  var text_area_memo = $('#textarea_memo').val();
  inp[row_num].value = text_area_memo;
  $('#memo_modal').modal('toggle');
}
function load_data(num){
  var inp = document.getElementsByName("order_memo[]");
  var text_value = inp[num].value;
  $('#textarea_memo').val(text_value);
}

function floatLabel(inputType){
  $(inputType).each(function(){
    var $this = $(this);
    // on focus add cladd active to label
    $this.focus(function(){
      $this.next().addClass("active");
    });
    //on blur check field and remove class if needed
    $this.blur(function(){
      if($this.val() === '' || $this.val() === 'blank'){
        $this.next().removeClass();
      }
    });
  });
}
