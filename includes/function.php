<?
  include_once('include_db.php');
  include_once('db_bby.php');
  // include_once('db_sry.php');
  include_once('db_dt.php');

  include_once('common_class.php');
  session_start();
  function login_process($id, $pw){
    global $conn_hannam;

    $id = addslashes($id);
    $pw = addslashes($pw);

    $query = "SELECT * FROM hnis_member WHERE hnisID = '$id' and hnisPW = '$pw' and hnisVendorID != 'NULL' ";
  	$query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $row_num = sqlsrv_num_rows($query_result);

    if($row_num > 0){
      $row = sqlsrv_fetch_array($query_result);
      $_SESSION['hnisID'] = $id;
      $_SESSION['hnisVendorID'] = $row['hnisVendorID'];
      $_SESSION['hnisCompanyName'] = $row['hnisCompanyName'];
      $_SESSION['hnisLevel'] = $row['hnisLevel'];
      $_SESSION['hnisAdminYN'] = $row['hnisAdminYN'];
      $loginTime = date("Y-m-d H:i:s");
      $update_query = "UPDATE hnis_member SET hnisLoginDate = '$loginTime' WHERE hnisID = '$id' AND hnisPW = '$pw'";
  		sqlsrv_query($conn_hannam, $update_query);
      echo "success";
    } else {
      echo "failed";
    }
  }

  function register_process($id, $pw, $c_name, $address, $phone){
    global $conn_hannam;

    $id = addslashes($id);
    $pw = addslashes($pw);
    $c_name = addslashes($c_name);
    $address = addslashes($address);
    $phone = addslashes($phone);

    $query = "SELECT * FROM hnis_member WHERE hnisID = '$id'";
    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $row_num = sqlsrv_num_rows($query_result);

    if($row_num > 0){
      echo "failed";
    } else {
      $insert_query = "INSERT INTO hnis_member (hnisID, hnisPW, hnisPhone, hnisAddress, hnisCompanyName) VALUES ('$id', '$pw', '$phone', '$address', '$c_name')";
      sqlsrv_query($conn_hannam, $insert_query);
      echo "success";
    }
  }

  function ajax_search_item($searchtxt){
    global $conn_bby;
    // global $conn_sry;
    global $conn_dt;

    $context = "";

    // $searchtxt = addslashes($searchtxt);
    // $searchtxt = str_replace(" ", "", $searchtxt);
    // $searchtxt = iconv("utf-8","euc-kr",$searchtxt);
    $searchtxt = dconv_addslash($searchtxt);
    $AdminCompany = $_SESSION['hnisCompanyName'];
    $query = "SELECT prodId, prodName, prodKname, prodUnit, prodsize, GalCode, ProdOwnCode ".
             "FROM mfProd ".
             "WHERE (replace(prodKname,' ','')  LIKE '%$searchtxt%' OR replace(prodName,' ','')  LIKE '%$searchtxt%' OR prodId LIKE '%$searchtxt%') AND useYN = 'Y' ".
             "ORDER BY prodName ASC";
    // $query_result = sqlsrv_query($conn_bby, $query, array(), array("scrollable" => 'keyset'));

    if ($AdminCompany == 'BBY') {
      $query_result = sqlsrv_query($conn_bby, $query, array(), array("scrollable" => 'keyset'));
    } elseif ($AdminCompany == 'SRY') {
      $query_result = sqlsrv_query($conn_sry, $query, array(), array("scrollable" => 'keyset'));
    } elseif ($AdminCompany == 'DT') {
      $query_result = sqlsrv_query($conn_dt, $query, array(), array("scrollable" => 'keyset'));
    } elseif ($AdminCompany == 'NV') {
      $query_result = sqlsrv_query($conn_nv, $query, array(), array("scrollable" => 'keyset'));
    }



    $row_num = sqlsrv_num_rows($query_result);

    if($row_num == 0){
      echo "noitem";
    } else {
      if ($row_num > 300) {
        echo "toomanyitems";
    } else {
        $i = 0;
        while ($row = sqlsrv_fetch_array($query_result)) {
          $i++;
					if ($i % 2 == 0)	$doc_field_name = "info";
					else					$doc_field_name = "active";

          $barcode = Br_iconv($row['prodId']);
          $prodName = Br_iconv($row['prodName']);
          $prodName2 = addslashes($prodName);
          $prodKname = Br_iconv($row['prodKname']);
          $prodKname2 = addslashes($prodKname);
          $prodUnit = Br_iconv($row['prodUnit']);
          $prodUnit2 = addslashes($prodUnit);
          $prodsize = Br_iconv($row['prodsize']);
          $prodsize2 = addslashes($prodsize);

          $GalCode = Br_iconv($row['GalCode']);
          $GalCode = addslashes($GalCode);
          $ProdOwnCode = Br_iconv($row['ProdOwnCode']);
          $ProdOwnCode = addslashes($ProdOwnCode);

          // $context .= $barcode."::".$prodName."::".$prodKname."::".$prodUnit."::".$prodsize;
          //
          $context .= '<tr class="" style="cursor:pointer;" onclick="javascript:select_item(\''.$barcode.'\',\''.$prodKname2.'\',\''.$prodName2.'\',\''.$prodUnit2.'\',\''.$prodsize2.'\',\''.$GalCode.'\',\''.$ProdOwnCode.'\');">
                        <td>
                          '.$barcode.'
                        </td>
                        <td>
                          '.$prodKname.'<br  />
                          '.$prodName.'
                        </td>
                        <td>
                          '.$prodUnit.'
                        </td>
                        <td>
                          '.$prodsize.'
                        </td>
                       </tr>';
        }
        echo $context;
      }
    }
  }

  function adj_search_item($searchtxt){
    global $conn_bby;
    // global $conn_sry;
    global $conn_dt;

    $context = "";

    // $searchtxt = addslashes($searchtxt);
    // $searchtxt = str_replace(" ", "", $searchtxt);
    // $searchtxt = iconv("utf-8","euc-kr",$searchtxt);
    $searchtxt = dconv_addslash($searchtxt);
    $AdminCompany = $_SESSION['hnisCompanyName'];
    $query = "SELECT prodId, prodName, prodKname, prodUnit, prodsize, GalCode, ProdOwnCode, prodBal ".
             "FROM mfProd ".
             "WHERE (replace(prodKname,' ','')  LIKE '%$searchtxt%' OR replace(prodName,' ','')  LIKE '%$searchtxt%' OR prodId LIKE '%$searchtxt%') AND useYN = 'Y' ".
             "ORDER BY prodName ASC";
    // $query_result = sqlsrv_query($conn_bby, $query, array(), array("scrollable" => 'keyset'));

    if ($AdminCompany == 'BBY') {
      $query_result = sqlsrv_query($conn_bby, $query, array(), array("scrollable" => 'keyset'));
    } elseif ($AdminCompany == 'SRY') {
      $query_result = sqlsrv_query($conn_sry, $query, array(), array("scrollable" => 'keyset'));
    } elseif ($AdminCompany == 'DT') {
      $query_result = sqlsrv_query($conn_dt, $query, array(), array("scrollable" => 'keyset'));
    } elseif ($AdminCompany == 'NV') {
      $query_result = sqlsrv_query($conn_nv, $query, array(), array("scrollable" => 'keyset'));
    }



    $row_num = sqlsrv_num_rows($query_result);

    if($row_num == 0){
      echo "noitem";
    } else {
      if ($row_num > 300) {
        echo "toomanyitems";
    } else {
        $i = 0;
        while ($row = sqlsrv_fetch_array($query_result)) {
          $i++;
					if ($i % 2 == 0)	$doc_field_name = "info";
					else					$doc_field_name = "active";

          $barcode = Br_iconv($row['prodId']);
          $prodName = Br_iconv($row['prodName']);
          $prodName2 = addslashes($prodName);
          $prodKname = Br_iconv($row['prodKname']);
          $prodKname2 = addslashes($prodKname);
          $prodUnit = Br_iconv($row['prodUnit']);
          $prodUnit2 = addslashes($prodUnit);
          $prodsize = Br_iconv($row['prodsize']);
          $prodsize2 = addslashes($prodsize);

          $prodbalance = Br_iconv($row['prodBal']);

          $GalCode = Br_iconv($row['GalCode']);
          $GalCode = addslashes($GalCode);
          $ProdOwnCode = Br_iconv($row['ProdOwnCode']);
          $ProdOwnCode = addslashes($ProdOwnCode);

          // $context .= $barcode."::".$prodName."::".$prodKname."::".$prodUnit."::".$prodsize;
          //
          $context .= '<tr class="" style="cursor:pointer;" onclick="javascript:add_table_adjust_row(\''.$barcode.'\',\''.$prodKname2.'\',\''.$prodName2.'\',\''.$prodUnit2.'\',\''.$prodsize2.'\',\''.$GalCode.'\',\''.$ProdOwnCode.'\');">
                        <td>
                          '.$barcode.'
                        </td>
                        <td>
                          '.$prodKname.'<br  />
                          '.$prodName.'
                        </td>
                        <td>
                          '.$prodUnit.'<br  />
                          '.$prodsize.'
                        </td>
                        <td>
                          '.$prodbalance.'
                        </td>
                       </tr>';
        }
        echo $context;
      }
    }
  }

  function search_galcode_prodowncode($barcode){
    global $conn_bby;
    $barcode = str_replace(" ", "", $barcode);
    $query = "SELECT prodId, prodName, prodKname, prodUnit, prodsize, GalCode, ProdOwnCode ".
             "FROM mfProd ".
             "WHERE prodId = '$barcode' AND useYN = 'Y' ".
             "ORDER BY prodName ASC";
    $query_result = sqlsrv_query($conn_bby, $query, array(), array("scrollable" => 'keyset'));
    $row_num = sqlsrv_num_rows($query_result);
    $context = '<table class="table table-hover table-mfprod">';
    $context .= '<thead><tr><th>Barcode</th><th>Name</th><th>Unit</th><th>Size</th><th>Set</th></tr></thead><tbody>';
    if($row_num == 0){
      echo "noitem";
    } else {
        $i = 0;
        while ($row = sqlsrv_fetch_array($query_result)) {
          $i++;

          $barcode = Br_iconv($row['prodId']);
          $prodName = Br_iconv($row['prodName']);
          $prodName2 = addslashes($prodName);
          $prodKname = Br_iconv($row['prodKname']);
          $prodKname2 = addslashes($prodKname);
          $prodUnit = Br_iconv($row['prodUnit']);
          $prodUnit2 = addslashes($prodUnit);
          $prodsize = Br_iconv($row['prodsize']);
          $prodsize2 = addslashes($prodsize);
          $GalCode = $row['GalCode'];
          $ProdOwnCode = $row['ProdOwnCode'];
          // $context .= $barcode."::".$prodName."::".$prodKname."::".$prodUnit."::".$prodsize;
          //
          $context .= '<tr style="cursor:pointer;">
                        <td>
                          '.$barcode.'
                        </td>
                        <td>
                          '.$prodKname.'<br  />
                          '.$prodName.'
                        </td>
                        <td>
                          '.$prodUnit.'
                        </td>
                        <td>
                          '.$prodsize.'
                        </td>
                        <td>
                          <span class="glyphicon glyphicon-book" onclick="javascript:set_textbox(\''.$GalCode.'\',\''.$ProdOwnCode.'\');">
                          </span>
                        </td>
                       </tr>';
        }
        $context .= '</tbody></table>';
        echo $context;
      }
  }

  function ajax_add_item($barcode,$prodKname,$prodName,$prodUnit,$prodsize){
    global $conn_hannam;

    $prodKname = addslashes($prodKname);
    $prodName = addslashes($prodName);
    $prodUnit = addslashes($prodUnit);
    $prodsize = addslashes($prodsize);

    $prodKname = Br_dconv($prodKname);
    $prodName = Br_dconv($prodName);
    $prodUnit = Br_dconv($prodUnit);
    $prodsize = Br_dconv($prodsize);

    $vendorId = $_SESSION['hnisVendorID'];
    $search_query = "SELECT Barcode FROM Hnis_Vendor_Item WHERE Barcode = '$barcode' AND VendorID = '$vendorId'";
    $search_query_result = sqlsrv_query($conn_hannam, $search_query, array(), array("scrollable" => 'keyset'));
    $search_num_row = sqlsrv_num_rows($search_query_result);
    if ($search_num_row > 0) {
      echo "already";
    } else {
      $add_query = "INSERT INTO Hnis_Vendor_Item(VendorID, Barcode, ProdEname, ProdKname, ProdSize, ProdUnit) ".
                   "VALUES('$vendorId','$barcode','$prodName','$prodKname','$prodsize','$prodUnit')";
      sqlsrv_query($conn_hannam, $add_query);


      echo "success";
    }
  }

  function delete_db_item($barcode){
    global $conn_hannam;

    $vendorId = $_SESSION['hnisVendorID'];
    $delete_query = "DELETE FROM Hnis_Vendor_Item WHERE Barcode = '$barcode' AND VendorID = '$vendorId'";
    $delete_query_result = sqlsrv_query($conn_hannam, $delete_query);
  }

  function update_item_inactive($barcode){
    global $conn_hannam;

    $vendorId = $_SESSION['hnisVendorID'];
    $update_query = "UPDATE Hnis_Vendor_Item SET chkYN = 'I' WHERE Barcode = '$barcode' AND VendorID = '$vendorId'";
    $update_query_result = sqlsrv_query($conn_hannam, $update_query);
  }

  function update_item_confirmed($vendorid,$vendorcode,$barcode,$vendorunit,$vendorcontent,$vendortype,$galcode,$prodowncode){
    global $conn_hannam;
    $vendorcode = dconv_addslash($vendorcode);
    $barcode = dconv_addslash($barcode);
    $vendorunit = dconv_addslash($vendorunit);
    $vendorcontent = dconv_addslash($vendorcontent);
    $vendortype = dconv_addslash($vendortype);
    $galcode = dconv_addslash($galcode);
    $prodowncode = dconv_addslash($prodowncode);
    $registerDate = date("Y-m-d h:i:sa");
    $update_query = "UPDATE Hnis_Vendor_Item SET chkYN = 'Y', VendorCode = '$vendorcode', VendorUnit = '$vendorunit', VendorContent = '$vendorcontent', VendorType = '$vendortype', GalCode = '$galcode', ProdOwnCode = '$prodowncode', registerDate = '$registerDate' WHERE Barcode = '$barcode' AND VendorID = '$vendorid'";
    $update_query_result = sqlsrv_query($conn_hannam, $update_query);
    echo 'success';
  }

  function ajax_each_save_item($ajax_barcode, $ajax_code, $ajax_unit, $ajax_content, $ajax_type){
    global $conn_hannam;

    $vendorId = $_SESSION['hnisVendorID'];
    $update_query = "UPDATE Hnis_Vendor_Item SET VendorCode = '$ajax_code', VendorUnit = '$ajax_unit', VendorContent = '$ajax_content', VendorType = '$ajax_type', chkYN = 'S' WHERE Barcode = '$ajax_barcode' AND VendorID = '$vendorId'";
    $update_query_result = sqlsrv_query($conn_hannam, $update_query);
    echo 'success';

  }

  function fetch_myitem($vendorId){
    global $conn_hannam;
    $adminChk = $_SESSION['hnisAdminYN'];
    $context = '';
    $query = "SELECT * FROM Hnis_Vendor_Item WHERE VendorID = '$vendorId' ORDER BY chkYN desc";
    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    $i = 0;
    $table_status = "U";
    if($num_row == 0){
      echo "noitem";
    } else {
      while($row = sqlsrv_fetch_array($query_result)){

        $chkYN = $row['chkYN'];
        $chkYN = str_replace(' ', '', $chkYN);

        if($chkYN == 'Y'){
          $tr_class = '';
        } elseif ($chkYN == 'I') {
          $tr_class = 'info';
        } else {
          $tr_class = 'danger';
        }
        $VendorCode = Br_iconv($row['VendorCode']);
        $VendorUnit = Br_iconv($row['VendorUnit']);
        $VendorContent = Br_iconv($row['VendorContent']);
        $VendorType = Br_iconv($row['VendorType']);
        $Barcode = Br_iconv($row['Barcode']);
        $ProdEname = Br_iconv($row['ProdEname']);
        $ProdKname = Br_iconv($row['ProdKname']);
        $ProdSize = Br_iconv($row['ProdSize']);
        $VendorSize = Br_iconv($row['VendorSize']);


        $box_selected = '';
        $ea_selected = '';
        $pk_selected = '';
        $lb_selected = '';

        $ref_selected = '';
        $fro_selected = '';
        $dry_selected = '';
        $etc_selected = '';



        if($VendorUnit == 'BOX'){
          $box_selected = 'selected';
        } elseif ($VendorUnit == 'EA') {
          $ea_selected = 'selected';
        } elseif ($VendorUnit == 'PK') {
          $pk_selected = 'selected';
        } elseif ($VendorUnit == 'LB') {
          $lb_selected = 'selected';
        }

        if($VendorType == 'Refri'){
          $ref_selected = 'selected';
        } elseif ($VendorType == 'Frozen') {
          $fro_selected = 'selected';
        } elseif ($VendorType == 'Dry') {
          $dry_selected = 'selected';
        } elseif ($VendorType == 'etc') {
          $etc_selected = 'selected';
        }



        $context .= '<tr class="'.$tr_class.'">
                      <td>
                        <input type="text" name="vendorcode[]" class="form-control" style="" value="'.$VendorCode.'" onchange=textchanged("' .$i. '",this.value)>
                        <span style="display:none;">
                          '.$VendorCode.'
                        </span>
                      </td>
                      <td>
                        <input type="hidden" name="barcode[]" class="form-control" style="" value="'.$Barcode.'">
                        '.$Barcode.'
                      </td>
                      <td>
                        '.$ProdKname.'<br />
                        '.$ProdEname.'
                      </td>
                      <td>
                        '.$VendorSize.'
                      </td>
                      <td>
                        <select class="form-control" name="vendorunit[]" onchange=textchanged("' .$i. '",this.value)>
                          <option value="BOX" '.$box_selected.'>BOX</option>
                          <option value="EA" '.$ea_selected.'>EA</option>
                          <option value="PK" '.$pk_selected.'>PK</option>
                          <option value="LB" '.$lb_selected.'>LB</option>
                        </select>
                      </td>
                      <td>
                        <input type="text" name="vendorcontent[]" class="form-control" value="'.$VendorContent.'" onchange=textchanged("' .$i. '",this.value)>
                        <span style="display:none;">
                          '.$VendorContent.'
                        </span>
                      </td>
                      <td>
                        <select class="form-control" name="vendortype[]" onchange=textchanged("' .$i. '",this.value)>
                          <option value="Refri" '.$ref_selected.'>Refri</option>
                          <option value="Frozen" '.$fro_selected.'>Frozen</option>
                          <option value="Dry" '.$dry_selected.'>Dry</option>
                          <option value="etc" '.$etc_selected.'>etc</option>
                        </select>
                      </td>
                      <td>
                        <input type="checkbox" name="chk[]" value="'.$i.'" />
                      </td>
                      <td>
                        <i class="flaticon-forbidden-mark" onclick="javascript:delete_table_item(\''.$Barcode.'\', this, \''.$table_status.'\');"></i>
                      </td>
                     </tr>';
           $i++;
      }
      echo $context;
    }
  }

  function fetch_vendoritem_admin($vendorId){
    global $conn_hannam;
    $adminChk = $_SESSION['hnisAdminYN'];

    $query = "SELECT * FROM Hnis_Vendor_Item WHERE VendorID = '$vendorId' AND chkYN != 'I' ORDER BY chkYN asc";
    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    $i = 0;
    $table_status = "U";
    if($num_row == 0){
      echo "noitem";
    } else {
      while($row = sqlsrv_fetch_array($query_result)){

        $chkYN = $row['chkYN'];
        $chkYN = str_replace(' ', '', $chkYN);

        if($chkYN == 'Y'){
          $tr_class = '';
        } elseif ($chkYN == 'I') {
          $tr_class = 'info';
        } else {
          $tr_class = 'danger';
        }
        $VendorCode = Br_iconv($row['VendorCode']);
        $VendorUnit = Br_iconv($row['VendorUnit']);
        $VendorContent = Br_iconv($row['VendorContent']);
        $VendorType = Br_iconv($row['VendorType']);
        $Barcode = Br_iconv($row['Barcode']);
        $ProdEname = Br_iconv($row['ProdEname']);
        $ProdKname = Br_iconv($row['ProdKname']);
        $ProdSize = Br_iconv($row['ProdSize']);
        $VendorSize = Br_iconv($row['VendorSize']);

        $box_selected = '';
        $ea_selected = '';
        $pk_selected = '';
        $lb_selected = '';

        $ref_selected = '';
        $fro_selected = '';
        $dry_selected = '';
        $etc_selected = '';



        if($VendorUnit == 'BOX'){
          $box_selected = 'selected';
        } elseif ($VendorUnit == 'EA') {
          $ea_selected = 'selected';
        } elseif ($VendorUnit == 'PK') {
          $pk_selected = 'selected';
        } elseif ($VendorUnit == 'LB') {
          $lb_selected = 'selected';
        }

        if($VendorType == 'Refri'){
          $ref_selected = 'selected';
        } elseif ($VendorType == 'Frozen') {
          $fro_selected = 'selected';
        } elseif ($VendorType == 'Dry') {
          $dry_selected = 'selected';
        } elseif ($VendorType == 'etc') {
          $etc_selected = 'selected';
        }
        $tr_class_for_css = 'table-item-'.$i;
          // if($chkYN == 'Y'){
          //   $xtag = '';
          // } else {
          //   $xtag = '<span class="glyphicon glyphicon-ok vtag'.$i.'" onclick="javascript:get_row_item(\''.$i.'\', this);"></span>';
          // }
          $xtag = '<span class="glyphicon glyphicon-ok vtag'.$i.'" onclick="javascript:get_row_item(\''.$i.'\', this);"></span>';

        $context .= '<tr class="'.$tr_class.'" data-id="'.$tr_class_for_css.'">
                      <td>
                        <input type="text" name="vendorcode[]" class="form-control" style="" value="'.$VendorCode.'">
                        <span style="display:none;">
                          '.$VendorCode.'
                        </span>
                      </td>
                      <td>
                        <input type="hidden" name="barcode[]" class="form-control" style="" value="'.$Barcode.'">
                        <span style="cursor:pointer;" data-title="View" data-toggle="modal" data-target="#search_mfprod_div" onclick="search_galcode_prodowncode(this)">
                          '.$Barcode.'
                        </span>
                      </td>
                      <td>
                        '.$ProdKname.'<br />
                        '.$ProdEname.'
                        <input type="hidden" name="galcode[]" class="form-control" value="">
                        <input type="hidden" name="prodowncode[]" class="form-control" value="">
                      </td>
                      <td>
                        '.$VendorSize.'
                      </td>
                      <td>
                        <select class="form-control" name="vendorunit[]">
                          <option value="BOX" '.$box_selected.'>BOX</option>
                          <option value="EA" '.$ea_selected.'>EA</option>
                          <option value="PK" '.$pk_selected.'>PK</option>
                          <option value="LB" '.$lb_selected.'>LB</option>
                        </select>
                      </td>
                      <td>
                        <input type="text" name="vendorcontent[]" class="form-control" value="'.$VendorContent.'">
                        <span style="display:none;">
                          '.$VendorContent.'
                        </span>
                      </td>
                      <td>
                        <select class="form-control" name="vendortype[]">
                          <option value="Refri" '.$ref_selected.'>Refri</option>
                          <option value="Frozen" '.$fro_selected.'>Frozen</option>
                          <option value="Dry" '.$dry_selected.'>Dry</option>
                          <option value="etc" '.$etc_selected.'>etc</option>
                        </select>
                      </td>
                      <td>
                        <input type="checkbox" name="chk[]" value="'.$i.'" />
                      </td>
                      <td>
                        '.$xtag.'
                      </td>
                     </tr>';
           $i++;
      }
      echo $context;
    }
  }

  function fetch_submititem_vendor(){
    global $conn_hannam;
    $query = "SELECT v.VendorID, m.hnisCompanyName, count(v.VendorID) as items FROM Hnis_Vendor_Item as v LEFT JOIN hnis_member as m on m.hnisVendorID = v.VendorID WHERE v.chkYN = 'S' GROUP BY VendorID, m.hnisCompanyName";
    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    $i = 0;
    $where = "'vendoritem-table-tbody'";
    if($num_row == 0){
      echo "novendor";
    } else {
      while($row = sqlsrv_fetch_array($query_result)){
        $VendorID = $row['VendorID'];
        $CompanyName = $row['hnisCompanyName'];
        $num_items = $row['items'];
        $CompanyName = iconv_stripslash($CompanyName);

        $context .= '<tr style="cursor:pointer;" onclick="fetch_vendoritem_admin('.$VendorID.','.$where.')">
                      <td width="45%">
                        '.$CompanyName.'
                      </td>
                      <td width="25%">
                        '.$num_items.'
                      </td>
                      <td>
                        '.$VendorID.'
                      </td>
                     </tr>';
           $i++;
      }
      echo $context;
    }
  }

  function fetch_vendor_list(){
    global $conn_hannam;
    $query = "SELECT * FROM Hnis_Vendor_List ORDER BY VendorID ASC";
    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    $i = 0;
    // $where = "'vendoritem-table-tbody'";
    if($num_row == 0){
      echo "novendor";
    } else {
      while($row = sqlsrv_fetch_array($query_result)){
        $VendorID = $row['VendorID'];
        $CompanyName = $row['Name'];
        $CompanyName = iconv_stripslash($CompanyName);
        $Phone = iconv_stripslash($row['Phone']);

        $context .= '<tr style="cursor:pointer;" onclick="fetch_vendor_detail('.$VendorID.')">
                      <td>
                        '.$VendorID.'
                      </td>
                      <td>
                        '.$CompanyName.'
                      </td>
                      <td>
                        '.$Phone.'
                      </td>
                     </tr>';
           $i++;
      }
      echo $context;
    }
  }

  function update_vendor($VendorID,$VendorName,$VendorPhone,$VendorFax,$VendorEmail,$VendorAddress,$VendorUseyn){
    global $conn_hannam;

    $VendorID = dconv_addslash($VendorID);
    $VendorName = dconv_addslash($VendorName);
    $VendorPhone = dconv_addslash($VendorPhone);
    $VendorFax = dconv_addslash($VendorFax);
    $VendorEmail = dconv_addslash($VendorEmail);
    $VendorAddress = dconv_addslash($VendorAddress);
    $VendorUseyn = dconv_addslash($VendorUseyn);
    $today = date("Y-m-d");
    $query = "UPDATE Hnis_Vendor_List SET Name = '$VendorName', Phone = '$VendorPhone', Fax = '$VendorFax', Address = '$VendorAddress', email = '$VendorEmail', useYN = '$VendorUseyn', regDate = '$today' WHERE VendorID = '$VendorID'";
    $query_result = sqlsrv_query($conn_hannam, $query);
    echo 'success';
  }

  function register_vendor($VendorName,$VendorPhone,$VendorFax,$VendorEmail,$VendorAddress,$VendorUseyn){
    global $conn_hannam;


    $VendorName = dconv_addslash($VendorName);
    $VendorPhone = dconv_addslash($VendorPhone);
    $VendorFax = dconv_addslash($VendorFax);
    $VendorEmail = dconv_addslash($VendorEmail);
    $VendorAddress = dconv_addslash($VendorAddress);
    $VendorUseyn = dconv_addslash($VendorUseyn);
    $select_query = "SELECT VendorID FROM Hnis_Vendor_List ORDER BY VendorID DESC";
    $select_query_result = sqlsrv_query($conn_hannam, $select_query);
    $row = sqlsrv_fetch_array($select_query_result);
    $VendorID = $row['VendorID'] + 1;

    $today = date("Y-m-d");
    $insert_query = "INSERT INTO Hnis_Vendor_List (VendorID ,Name ,Phone ,Fax ,Address ,email ,useYN ,regDate) VALUES";
    $insert_query .= " ('$VendorID','$VendorName','$VendorPhone','$VendorFax','$VendorAddress','$VendorEmail','$VendorUseyn','$today')";
    $insert_query_result = sqlsrv_query($conn_hannam, $insert_query);
    echo 'success';
  }

  function fetch_vendor_detail($VendorID){
    global $conn_hannam;
    $query = "SELECT * FROM Hnis_Vendor_List WHERE VendorID = '$VendorID'";
    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    $i = 0;
    // $where = "'vendoritem-table-tbody'";
    if($num_row == 0){
      echo "novendor";
    } else {
        $row = sqlsrv_fetch_array($query_result);
        $VendorID = $row['VendorID'];
        $CompanyName = $row['Name'];
        $CompanyName = iconv_stripslash($CompanyName);
        $Phone = iconv_stripslash($row['Phone']);
        $Fax = $row['Fax'];
        $address = $row['Address'];
        $email = $row['email'];
        $useYN = $row['useYN'];

        $data['VendorID'] = $VendorID;
        $data['Name'] = $CompanyName;
        $data['Phone'] = $Phone;
        $data['Fax'] = $Fax;
        $data['Email'] = $email;
        $data['useYN'] = $useYN;
        $data['Address'] = $address;
        $data = json_encode($data);
        print_r($data);
    }
  }


  // function fetch_myitem2($vendorid){
  //   global $conn_hannam;
  //   $query = "SELECT * FROM Hnis_Vendor_Item WHERE VendorID = '$vendorid' ORDER BY chkYN desc";
  //   $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
  //   $num_row = sqlsrv_num_rows($query_result);
  //   $i = 1;
  //   $table_status = "U";
  //   if($num_row == 0){
  //     echo "noitem";
  //   } else {
  //     while($row = sqlsrv_fetch_array($query_result)){
  //       if ($i % 2 == 0)	$doc_field_name = "info";
  //       else					$doc_field_name = "active";
  //       $chkYN = $row['chkYN'];
  //       $chkYN = str_replace(' ', '', $chkYN);
  //
  //       if($chkYN == 'Y'){
  //         $tr_class = '';
  //       } else {
  //         $tr_class = 'danger';
  //       }
  //       $VendorCode = Br_iconv($row['VendorCode']);
  //       $VendorUnit = Br_iconv($row['VendorUnit']);
  //       $VendorContent = Br_iconv($row['VendorContent']);
  //       $VendorType = Br_iconv($row['VendorType']);
  //       $Barcode = Br_iconv($row['Barcode']);
  //       $ProdEname = Br_iconv($row['ProdEname']);
  //       $ProdKname = Br_iconv($row['ProdKname']);
  //       $ProdSize = Br_iconv($row['ProdSize']);
  //
  //       $box_selected = '';
  //       $ea_selected = '';
  //       $pk_selected = '';
  //       $lb_selected = '';
  //
  //       $ref_selected = '';
  //       $fro_selected = '';
  //       $dry_selected = '';
  //       $etc_selected = '';
  //
  //
  //
  //       if($VendorUnit == 'BOX'){
  //         $box_selected = 'selected';
  //       } elseif ($VendorUnit == 'EA') {
  //         $ea_selected = 'selected';
  //       } elseif ($VendorUnit == 'PK') {
  //         $pk_selected = 'selected';
  //       } elseif ($VendorUnit == 'LB') {
  //         $lb_selected = 'selected';
  //       }
  //
  //       if($VendorType == 'Refri'){
  //         $ref_selected = 'selected';
  //       } elseif ($VendorType == 'Frozen') {
  //         $fro_selected = 'selected';
  //       } elseif ($VendorType == 'Dry') {
  //         $dry_selected = 'selected';
  //       } elseif ($VendorType == 'etc') {
  //         $etc_selected = 'selected';
  //       }
  //
  //       $context .= '<tr class="'.$tr_class.'">
  //                     <td>
  //                       <input type="text" class="form-control" style="width:87px;height:21px;" value="'.$VendorCode.'" onkeydown="return ajax_save_vendorcode(event, this.value, \''.$Barcode.'\')">
  //                       <span style="display:none;">
  //                         '.$VendorCode.'
  //                       </span>
  //                     </td>
  //                     <td>
  //                       '.$Barcode.'
  //                     </td>
  //                     <td>
  //                       '.$ProdKname.'<br />
  //                       '.$ProdEname.'
  //                     </td>
  //                     <td>
  //                       '.$ProdSize.'
  //                     </td>
  //                     <td>
  //                       <select class="form-control">
  //                         <option value="BOX" '.$box_selected.'>BOX</option>
  //                         <option value="EA" '.$ea_selected.'>EA</option>
  //                         <option value="PK" '.$pk_selected.'>PK</option>
  //                         <option value="LB" '.$lb_selected.'>LB</option>
  //                       </select>
  //                     </td>
  //                     <td>
  //                       <input type="text" class="form-control" style="" value="'.$VendorContent.'" onkeydown="return ajax_save_vendorcontent(event, this.value, \''.$Barcode.'\')">
  //                       <span style="display:none;">
  //                         '.$VendorContent.'
  //                       </span>
  //                     </td>
  //                     <td>
  //                       <select class="form-control">
  //                         <option value="Refri" '.$ref_selected.'>Refri</option>
  //                         <option value="Frozen" '.$fro_selected.'>Frozen</option>
  //                         <option value="Dry" '.$dry_selected.'>Dry</option>
  //                         <option value="etc" '.$etc_selected.'>etc</option>
  //                       </select>
  //                     </td>
  //                     <td>
  //                       <input type="checkbox" name="chk[]" />
  //                     </td>
  //                     <td>
  //                       <i class="flaticon-forbidden-mark" onclick="javascript:delete_table_item(\''.$Barcode.'\', this, \''.$table_status.'\');"></i>
  //                     </td>
  //                    </tr>';
  //          $i++;
  //     }
  //     echo $context;
  //   }
  // }

  function fetch_myitem_inregister(){
    global $conn_hannam;
    $vendorid = $_SESSION['hnisVendorID'];
    $query = "SELECT * FROM Hnis_Vendor_Item WHERE VendorID = '$vendorid'";
    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    $i = 1;
    if($num_row == 0){
      echo "noitem";
    } else {
      while($row = sqlsrv_fetch_array($query_result)){
        // if ($i % 2 == 0)	$doc_field_name = "info";
        // else					$doc_field_name = "active";

        $VendorCode = Br_iconv($row['VendorCode']);
        $VendorUnit = Br_iconv($row['VendorUnit']);
        $VendorContent = Br_iconv($row['VendorContent']);
        $VendorType = Br_iconv($row['VendorType']);
        $Barcode = Br_iconv($row['Barcode']);
        $ProdEname = Br_iconv($row['ProdEname']);
        $ProdKname = Br_iconv($row['ProdKname']);
        $ProdSize = Br_iconv($row['ProdSize']);

        $chkYN = $row['chkYN'];
        $chkYN = str_replace(' ', '', $chkYN);

        if($chkYN == 'Y'){
          $tr_class = '';
        } else {
          $tr_class = 'danger';
        }

        $context .= '<tr class = "'.$tr_class.'">
                      <td>
                        <span>
                          '.$VendorCode.'
                        </span>
                      </td>
                      <td>
                        '.$Barcode.'
                      </td>
                      <td>
                        '.$ProdKname.'<br />
                        '.$ProdEname.'
                      </td>
                      <td>
                        '.$ProdSize.'
                      </td>
                      <td>
                        '.$VendorUnit.'
                      </td>
                      <td>
                        <span>
                          '.$VendorContent.'
                        </span>
                      </td>
                      <td>
                        '.$VendorType.'
                      </td>
                     </tr>';
           $i++;
      }
      echo $context;
    }
  }

  function fetch_neworder_myitem($vendorid){
    global $conn_hannam;
    $query = "SELECT VendorCode, Barcode, ProdEname, ProdKname, ProdSize, ProdUnit, VendorUnit, VendorContent, VendorSize, GalCode, ProdOwnCode FROM Hnis_Vendor_Item WHERE VendorID = '$vendorid' and chkYN = 'Y'";
    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    $i = 1;
    if($num_row == 0){
      echo "noitem";
    } else {
      while($row = sqlsrv_fetch_array($query_result)){
        if ($i % 2 == 0)	$doc_field_name = "info";
        else					$doc_field_name = "active";

        $VendorCode = Br_iconv($row['VendorCode']);
        $VendorCode2 = addslashes($VendorCode);

        $Barcode = Br_iconv($row['Barcode']);
        $Barcode2 = addslashes($Barcode);

        $ProdEname = Br_iconv($row['ProdEname']);
        $ProdEname2 = addslashes($ProdEname);

        $ProdKname = Br_iconv($row['ProdKname']);
        $ProdKname2 = addslashes($ProdKname);

        $ProdSize = Br_iconv($row['ProdSize']);
        $ProdSize2 = addslashes($ProdSize);

        $ProdUnit = Br_iconv($row['ProdUnit']);
        $ProdUnit2 = addslashes($ProdUnit);

        $VendorUnit = Br_iconv($row['VendorUnit']);
        $VendorUnit2 = addslashes($VendorUnit);

        $VendorSize = Br_iconv($row['VendorSize']);
        $VendorSize2 = addslashes($VendorSize);

        $VendorContent = Br_iconv($row['VendorContent']);
        $VendorContent2 = addslashes($VendorContent);

        $GalCode = $row['GalCode'];
        $ProdOwnCode = $row['ProdOwnCode'];


        $prodBalance = get_prodBalance($Barcode);
        // <span href="#" data-toggle="neworderitem_myitem" title="'.$VendorUnit.'">'.$ProdSize.'</span><br />

        $context .= '<tr class="neworder_search_tr" style="cursor:pointer;"  onclick="javascript:add_table_myorder_row(\''.$VendorCode2.'\',\''.$Barcode2.'\',\''.$ProdKname2.'\',\''.$ProdEname2.'\',\''.$ProdUnit2.'\',\''.$ProdSize2.'\',\''.$VendorUnit2.'\',\''.$VendorContent2.'\',\''.$GalCode.'\',\''.$ProdOwnCode.'\');">
                      <td>
                        '.$VendorCode.'
                      </td>
                      <td class="hidden-xs">
                        '.$Barcode.'
                      </td>
                      <td>
                        <span href="#" data-toggle="neworderitem_myitem" title="'.$ProdKname.'">'.$ProdEname.'</span><br  />
                        <span href="#" data-toggle="neworderitem_myitem" title="'.$ProdEname.'">'.$ProdKname.'</span>
                      </td>
                      <td class="hidden-lg">
                        '.$VendorUnit2.'<br />'.$VendorSize2.'
                      </td>
                      <td class="hidden-lg">
                        '.$prodBalance.'
                      </td>
                     </tr>';
           $i++;
      }
      echo $context;
    }
  }

  function ajax_save_vendorcode($VendorCode, $barcode){
    global $conn_hannam;

    $VendorCode = Br_dconv($VendorCode);
    $vendorId = $_SESSION['hnisVendorID'];
    $save_query = "UPDATE Hnis_Vendor_Item SET VendorCode = '$VendorCode' ".
                  "WHERE Barcode = '$barcode' AND VendorID = '$vendorId'";
    $save_query_result = sqlsrv_query($conn_hannam, $save_query);
  }

  function ajax_save_vendorcontent($VendorContent, $barcode){
    global $conn_hannam;

    $VendorContent = Br_dconv($VendorContent);
    $vendorId = $_SESSION['hnisVendorID'];
    $save_query = "UPDATE Hnis_Vendor_Item SET VendorContent = '$VendorContent' ".
                  "WHERE Barcode = '$barcode' AND VendorID = '$vendorId'";
    $save_query_result = sqlsrv_query($conn_hannam, $save_query);
  }

  function fetch_myorder_itemlist($vendorid,$ordno){
    global $conn_hannam;
    $query = "SELECT t.VendorCode, t.tProd, t.tQty, t.tOUPrice, t.tAmt, t.ProdEname, t.ProdKname, t.tSize, t.tPunit, t.tMemo, h.VendorUnit, h.VendorContent, h.VendorSize, t.tGalcode, t.tProdOwnCode FROM
trOrderDetail as t LEFT JOIN Hnis_Vendor_Item as h on h.Barcode = t.tProd AND t.tCust = h.VendorID WHERE t.tCust = '$vendorid' and t.tOrdNo = '$ordno' ORDER BY t.tID DESC";
    // echo $query;
    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    $i = 1;
    if($num_row == 0){
      echo "noitem";
    } else {
      while($row = sqlsrv_fetch_array($query_result)){
        if ($i % 2 == 0)	$doc_field_name = "info";
        else					$doc_field_name = "active";
        $VendorCode = Br_iconv($row['VendorCode']);
        $Barcode = Br_iconv($row['tProd']);
        $tQty = $row['tQty'];
        $tOUPrice = $row['tOUPrice'];
        $tAmt = $row['tAmt'];
        $tAmt = number_format($tAmt,2);
        $GalCode = $row['tGalcode'];
        $ProdOwnCode = $row['tProdOwnCode'];

        $ProdEname = Br_iconv($row['ProdEname']);
        $ProdKname = Br_iconv($row['ProdKname']);
        $ProdSize = Br_iconv($row['VendorSize']);
        $ProdUnit = Br_iconv($row['tPunit']);
        $tMemo = Br_iconv($row['tMemo']);

        $vUnit = Br_iconv($row['VendorUnit']);
        $vCont = Br_iconv($row['VendorContent']);

        $context .= '<tr class="neworder_search_tr" style="cursor:pointer;">
                      <td>
                        '.$VendorCode.'
                        <input type="hidden" value="'.$VendorCode.'" class="form-control neworder_myorder_inputtxt" name="order_vendor[]">
                      </td>
                      <td>
                        '.$Barcode.'
                        <input type="hidden" value="'.$Barcode.'" class="form-control neworder_myorder_inputtxt" name="order_barcode[]">
                        <input type="hidden" value="'.$GalCode.'" class="form-control neworder_myorder_inputtxt" name="order_galcode[]">
                        <input type="hidden" value="'.$ProdOwnCode.'" class="form-control neworder_myorder_inputtxt" name="order_prodowncode[]">
                      </td>
                      <td>
                        <span href="#" data-toggle="neworderitem_myitem" title="'.$ProdKname.'">'.$ProdEname.'<input type="hidden" value="'.$ProdEname.'" class="form-control neworder_myorder_inputtxt" name="order_ename[]"><input type="hidden" value="'.$ProdKname.'" class="form-control neworder_myorder_inputtxt" name="order_kname[]">
                      </td>
                      <td style="text-align:center;">
                       '.$ProdSize.'
                        <input type="hidden" value="'.$ProdSize.'" class="form-control neworder_myorder_inputtxt" name="order_size[]"><input type="hidden" value="'.$ProdUnit.'" class="form-control neworder_myorder_inputtxt" name="order_unit[]">
                      </td>
                      <td style="text-align:center;">
                        '.$vUnit.'
                      </td>
                      <td style="text-align:center;">
                        '.$vCont.'
                      </td>
                      <td>
                        <input type="text" class="form-control neworder_myorder_inputtxt" onkeydown="return onlyNumber(event)" onblur="check_value(this.value, 4, this)" name="order_price[]" value="'.$tOUPrice.'">
                      </td>
                      <td>
                        <input type="text" class="form-control neworder_myorder_inputtxt" onkeydown="return onlyNumber(event)" onblur="check_value(this.value, 5, this)" name="order_qty[]" value="'.$tQty.'">
                      </td>
                      <td style="text-align:right;">
                        '.$tAmt.'
                      </td>
                      <td align="center">
                        <span onclick="send_data(this);" class="glyphicon glyphicon-list-alt" style="cursor:pointer;" data-id="this" data-toggle="modal" data-target="#memo_modal"></span><input type="hidden" class="form-control neworder_myorder_inputtxt" name="order_memo[]" value="'.$tMemo.'">
                      </td>
                      <td>
                        <i class="flaticon-forbidden-mark" style="cursor:pointer;" onclick="javascript:delete_table_myorder_item('.$Barcode.', this);"></i>
                      </td>
                     </tr>';
           $i++;
      }
      // <span onclick='send_data(this);' class='glyphicon glyphicon-list-alt' style='cursor:pointer;' data-id='this' data-toggle='modal' data-target='#memo_modal'></span><input type='hidden' class='form-control neworder_myorder_inputtxt' name='order_memo[]'>
      echo $context;
    }
  }

  function fetch_adjust_itemlist($ordno){
    global $conn_hannam;
    $query = "SELECT * FROM trAdjustDetail WHERE tAdjNo = '$ordno' ORDER BY tID DESC";
    // echo $query;
    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    $i = 1;
    if($num_row == 0){
      echo "noitem";
    } else {
      while($row = sqlsrv_fetch_array($query_result)){
        if ($i % 2 == 0)	$doc_field_name = "info";
        else					$doc_field_name = "active";
        $Barcode = Br_iconv($row['tProd']);
        $tQty = $row['tQty'];
        $ProdEname = Br_iconv($row['ProdEname']);
        $ProdKname = Br_iconv($row['ProdKname']);
        $ProdSize = Br_iconv($row['tSize']);
        $ProdUnit = Br_iconv($row['tPunit']);
        $tMemo = Br_iconv($row['Memo']);

        $context .= '<tr>
        <td>
        '.$Barcode.'
        </td>
        <td>
        '.$ProdEname.'<br />
        '.$ProdKname.'
        </td>
        <td>
        '.$ProdSize.'
        </td>
        <td>
          <input type="text" class="form-control neworder_myorder_inputtxt" name="order_qty[]" value="'.$tQty.'" readonly>
        </td>
        <td>
          <span onclick="send_data(this);" class="glyphicon glyphicon-list-alt" style="cursor:pointer;" data-id="this" data-toggle="modal" data-target="#memo_modal">
          </span>
          <input type="hidden" class="form-control neworder_myorder_inputtxt" name="order_memo[]" value="'.$tMemo.'">
        </td>
        <td>

        </td>
        </tr>';


        $i++;
      }
      // <span onclick='send_data(this);' class='glyphicon glyphicon-list-alt' style='cursor:pointer;' data-id='this' data-toggle='modal' data-target='#memo_modal'></span><input type='hidden' class='form-control neworder_myorder_inputtxt' name='order_memo[]'>
      echo $context;
    }
  }

  function fetch_saved_list($vendorid){
    global $conn_hannam;
    $query = "SELECT TOP 8 *, CONVERT(char(10), tDate, 126) AS oDate, CONVERT(char(10), tDeliveryDate, 126) AS tDeliveryDate FROM trOrderMaster WHERE tCust = '$vendorid' and tStatus < 3 ORDER BY oDate desc";
    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    $i = 1;
    if($num_row == 0){
      echo "noitem";
    } else {
      while($row = sqlsrv_fetch_array($query_result)){
        $CID = $row['CID'];
        if($CID == '1'){
          $branch = 'bby';
        } elseif($CID == '2'){
          $branch = 'sry';
        } else{
          $branch = 'dt';
        }
        $tOrdNo = $row['tOrdNo'];
        $tDate = $row['oDate'];
        $tAMT = $row['tAMT'];
        $tMemo = $row['tMemo'];
        $tDeliveryDate = $row['tDeliveryDate'];
        $tStatus = $row['tStatus'];
        if($tStatus == 2){
          $highlight_class = 'red_text';
          $icon = 'glyphicon-repeat';
          $btn_css = 'btn-danger';
        } else {
          $highlight_class = 'default_text';
          $icon = 'glyphicon-pencil';
          $btn_css = 'btn-default';
        }
        $context .= '<tr class = '.$highlight_class.'>
                      <td>
                        '.$tDate.'
                      </td>
                      <td>
                        '.$tDeliveryDate.'
                      </td>
                      <td>
                        '.strtoupper($branch).'
                      </td>
                      <td>
                        $'.number_format($tAMT, 2).'
                      </td>
                      <td>
                        <p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn '.$btn_css.' btn-xs"  onclick="newOrderPage_Redirect(\''.$tOrdNo.'\', \''.$branch.'\')"><span style="top:2px;" class="glyphicon '.$icon.'"></span></button></p>
                      </td>
                     </tr>';
            $i++;
      }
      echo $context;
    }
  }

  function fetch_confirmed_list($vendorid){
    global $conn_hannam;
    $query = "SELECT TOP 8 *, CONVERT(char(10), tDate, 126) AS oDate, CONVERT(char(10), tDeliveryDate, 126) AS tDeliveryDate FROM trOrderMaster WHERE tCust = '$vendorid' and tStatus = '4' ORDER BY oDate desc";
    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    $i = 1;
    if($num_row == 0){
      echo "noitem";
    } else {
      while($row = sqlsrv_fetch_array($query_result)){
        $CID = $row['CID'];
        if($CID == '1'){
          $branch = 'BBY';
        } elseif($CID == '2'){
          $branch = 'SRY';
        } else{
          $branch = 'DT';
        }
        $tOrdNo = $row['tOrdNo'];
        $tDate = $row['oDate'];
        $tAMT = $row['tAMT'];
        $tMemo = $row['tMemo'];
        $tDeliveryDate = $row['tDeliveryDate'];
        $tStatus = $row['tStatus'];
        $context .= '<tr>
                      <td>
                        '.$tDate.'
                      </td>
                      <td>
                        '.$tDeliveryDate.'
                      </td>
                      <td>
                        '.$branch.'
                      </td>
                      <td>
                        $'.number_format($tAMT, 2).'
                      </td>
                      <td>
                        <p data-placement="top" data-toggle="tooltip" title="View"><button class="btn btn-default btn-xs" data-title="View" data-toggle="modal" data-target="#view_complete" onclick="view_order('.$tOrdNo.')" ><span class="glyphicon glyphicon-search"></span></button></p>
                      </td>
                     </tr>';
            $i++;
      }
      echo $context;
    }
  }

  function fetch_orderhistory_list($vendorid){
    global $conn_hannam;
    $today = date("Y-m-d");
    // $query = "SELECT *, CONVERT(char(10), tDate, 126) AS oDate, CONVERT(char(10), tDeliveryDate, 126) AS tDeliveryDate FROM trOrderMaster WHERE tCust = '$vendorid' and tStatus < '2' ORDER BY oDate desc";
    $query = "SELECT *, CONVERT(char(10), tDate, 126) AS oDate, CONVERT(char(10), tDeliveryDate, 126) AS tDeliveryDate FROM trOrderMaster WHERE tCust = '$vendorid' AND tDeliveryDate = '$today' ORDER BY tStatus desc, oDate";
    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    $i = 1;
    if($num_row == 0){
      echo 'noitem';
    } else {
      while($row = sqlsrv_fetch_array($query_result)){
        if ($i % 2 == 0)	$doc_field_name = "info";
        else					$doc_field_name = "active";

        $CID = $row['CID'];
        if($CID == '1'){
          $branch = 'bby';
          $Company = "HANNAM SUPERMARKET BURNABY";
        } elseif($CID == '2'){
          $branch = 'sry';
          $Company = "HANNAM SUPERMARKET SURREY";
        } else{
          $branch = 'dt';
          $Company = "HANNAM SUPERMARKET DOWNTOWN";
        }
        $tOrdNo = $row['tOrdNo'];
        $tDate = $row['oDate'];
        $tAMT = $row['tAMT'];
        $tMemo = $row['tMemo'];
        $tDeliveryDate = $row['tDeliveryDate'];
        $tStatus = $row['tStatus'];
        $tStatus_text = get_tStatus_text($tStatus);
        if($tStatus < 3){
          $icon_text =  '<p style="margin:0 10px 10px;" data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-default btn-xs" onclick="newOrderPage_Redirect(\''.$tOrdNo.'\', \''.$branch.'\')" ><span class="glyphicon glyphicon-pencil"></span></button></p>';
        } else{
          $icon_text =  '<p style="margin:0 10px 10px;" data-placement="top" data-toggle="tooltip" title="View"><button class="btn btn-default btn-xs" data-title="View" data-toggle="modal" data-target="#view_complete" onclick="view_order('.$tOrdNo.')" ><span class="glyphicon glyphicon-search"></span></button></p>';
        }
        $context .= '<tr class="orderhistory_list_tr" style="cursor:pointer;">
                      <td>
                        '.$tOrdNo.'
                        <input type="hidden" value="'.$tOrdNo.'" class="form-control">
                      </td>
                      <td>
                        '.$tDate.'
                        <input type="hidden" value="'.$tDate.'" class="form-control">
                      </td>
                      <td>
                        '.$tDeliveryDate.'
                        <input type="hidden" value="'.$tDeliveryDate.'" class="form-control">
                      </td>
                      <td>
                        '.$Company.'
                      </td>
                      <td>
                        '.$tStatus_text.'
                      </td>
                      <td>
                        $'.number_format($tAMT, 2).'
                      </td>
                      <td>
                        '.$icon_text.'
                      </td>
                     </tr>';
           $i++;
      }
      echo $context;
    }
  }

  function fetch_received_list($adminCompany){
    global $conn_hannam;
    $adminCompany = get_Company_CID($adminCompany);
    $query = "SELECT *, CONVERT(char(10), tDate, 126) AS oDate, CONVERT(char(10), tDeliveryDate, 126) AS tDeliveryDate FROM trOrderMaster WHERE CID = '$adminCompany' AND tStatus > 2 ORDER BY oDate desc";
    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    $i = 1;
    if($num_row == 0){
      echo "noitem";
    } else {
      while($row = sqlsrv_fetch_array($query_result)){
        if ($i % 2 == 0)	$doc_field_name = "info";
        else					$doc_field_name = "active";

        $CID = $row['CID'];
        if($CID == '1'){
          $branch = 'bby';
          $Company = "HANNAM SUPERMARKET BURNABY";
        } elseif($CID == '2'){
          $branch = 'sry';
          $Company = "HANNAM SUPERMARKET SURREY";
        } else{
          $branch = 'dt';
          $Company = "HANNAM SUPERMARKET DOWNTOWN";
        }
        $tOrdNo = $row['tOrdNo'];
        $tDate = $row['oDate'];
        $tAMT = $row['tAMT'];
        $tMemo = $row['tMemo'];
        $tDeliveryDate = $row['tDeliveryDate'];
        $tStatus = $row['tStatus'];
        $tStatus_text = get_tStatus_text($tStatus);
        $tCust = $row['tCust'];
        $tCust = get_company_name($tCust);
        $context .= '<tr class="orderhistory_list_tr" style="cursor:pointer;">
                      <td>
                        '.$tOrdNo.'
                        <input type="hidden" value="'.$tOrdNo.'" class="form-control">
                      </td>
                      <td>
                        '.$tDate.'
                        <input type="hidden" value="'.$tDate.'" class="form-control">
                      </td>
                      <td>
                        '.$tDeliveryDate.'
                        <input type="hidden" value="'.$tDeliveryDate.'" class="form-control">
                      </td>
                      <td>
                        '.$tCust.'
                      </td>
                      <td>
                        '.$tStatus_text.'
                      </td>
                      <td>
                        $'.number_format($tAMT, 2).'
                      </td>
                      <td>
                        <p style="margin:0 10px 10px;" data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-default btn-xs" onclick="adminOrderPage_Redirect(\''.$tOrdNo.'\', \''.$branch.'\')" ><span class="glyphicon glyphicon-search"></span></button></p>
                      </td>
                     </tr>';
           $i++;
           // $later = '<td>
           //   <p style="margin:0 10px 10px;" data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-default btn-xs" data-title="Delete" data-toggle="modal" onclick="send_delete_modal('.$tOrdNo.');"><span class="glyphicon glyphicon-trash"></span></button></p>
           // </td>';
      }
      echo $context;
    }
  }

  function fetch_adjust_received_list($adminCompany){
    global $conn_hannam;
    $adminCompany = get_Company_CID($adminCompany);
    $query = "SELECT *, CONVERT(char(10), tDate, 126) AS oDate FROM trAdjustMaster WHERE CID = '$adminCompany' AND tStatus > 1 ORDER BY oDate desc";
    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    $i = 1;
    if($num_row == 0){
      echo "noitem";
    } else {
      while($row = sqlsrv_fetch_array($query_result)){
        // if ($i % 2 == 0)	$doc_field_name = "info";
        // else					$doc_field_name = "active";

        $CID = $row['CID'];
        if($CID == '1'){
          $branch = 'bby';
          $Company = "HANNAM SUPERMARKET BURNABY";
        } elseif($CID == '2'){
          $branch = 'sry';
          $Company = "HANNAM SUPERMARKET SURREY";
        } elseif($CID == '3'){
          $branch = 'dt';
          $Company = "HANNAM SUPERMARKET DOWNTOWN";
        }
        $tOrdNo = $row['tAdjNo'];
        $tDate = $row['oDate'];
        $tStatus = $row['tStatus'];
        $tStatus_text = get_tStatus_text($tStatus);
        $context .= '<tr class="orderhistory_list_tr" style="cursor:pointer;">
                      <td>
                        '.$tOrdNo.'
                        <input type="hidden" value="'.$tOrdNo.'" class="form-control">
                      </td>
                      <td>
                        '.$tDate.'
                        <input type="hidden" value="'.$tDate.'" class="form-control">
                      </td>
                      <td>
                        '.$Company.'
                      </td>
                      <td>
                        '.$tStatus_text.'
                      </td>
                      <td>
                        <p style="margin:0 10px 10px;" data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-default btn-xs" onclick="adjustPage_Redirect(\''.$tOrdNo.'\', \''.$branch.'\')" ><span class="glyphicon glyphicon-search"></span></button></p>
                      </td>
                     </tr>';
           $i++;
      }
      echo $context;
    }
  }

  function get_company_name($tCust){
    global $conn_hannam;
    $query = "SELECT hnisCompanyName FROM hnis_member WHERE hnisVendorID = '$tCust'";
    $query_result = sqlsrv_query($conn_hannam, $query);
    $row = sqlsrv_fetch_array($query_result);
    return $row['hnisCompanyName'];
  }

  function fetch_search_by_date($orderDate){
    global $conn_hannam;
    $query = "SELECT *, CONVERT(char(10), tDate, 126) AS oDate, CONVERT(char(10), tDeliveryDate, 126) AS tDeliveryDate FROM trOrderMaster WHERE tDate = '$orderDate' AND tStatus = '2' ORDER BY oDate desc";
    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    $i = 1;
    if($num_row == 0){
      echo 'noitem';
    } else {
      while($row = sqlsrv_fetch_array($query_result)){
        if ($i % 2 == 0)	$doc_field_name = "info";
        else					$doc_field_name = "active";

        $CID = $row['CID'];
        if($CID == '1'){
          $branch = 'bby';
          $Company = "HANNAM SUPERMARKET BURNABY";
        } elseif($CID == '2'){
          $branch = 'sry';
          $Company = "HANNAM SUPERMARKET SURREY";
        } else{
          $branch = 'dt';
          $Company = "HANNAM SUPERMARKET DOWNTOWN";
        }
        $tOrdNo = $row['tOrdNo'];
        $tDate = $row['oDate'];
        $tAMT = $row['tAMT'];
        $tMemo = $row['tMemo'];
        $tDeliveryDate = $row['tDeliveryDate'];
        $tStatus = $row['tStatus'];
        $tCust = $row['tCust'];
        $tCust = get_company_name($tCust);
        $context .= '<tr class="'.$doc_field_name.' orderhistory_list_tr" style="cursor:pointer;">
                      <td>
                        '.$tOrdNo.'
                        <input type="hidden" value="'.$tOrdNo.'" class="form-control">
                      </td>
                      <td>
                        '.$tDate.'
                        <input type="hidden" value="'.$tDate.'" class="form-control">
                      </td>
                      <td>
                        '.$tCust.'
                      </td>
                      <td>
                        $'.number_format($tAMT, 2).'
                      </td>
                      <td>
                        <p style="margin:0 10px 10px;" data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" onclick="adminOrderPage_Redirect(\''.$tOrdNo.'\', \''.$branch.'\')" ><span class="glyphicon glyphicon-pencil"></span></button></p>
                      </td>
                      <td>
                        <p style="margin:0 10px 10px;" data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" onclick="send_delete_modal('.$tOrdNo.');"><span class="glyphicon glyphicon-trash"></span></button></p>
                      </td>
                     </tr>';
           $i++;
      }
      echo $context;
    }
  }

  function fetch_search_by_Confirmeddate($orderDate){
    global $conn_hannam;
    $query = "SELECT *, CONVERT(char(10), tDate, 126) AS oDate ";
    $query .= "FROM trAdjustMaster ";
    $query .= "WHERE tStatus > 2 ";
    $query .= "AND tDate = '$orderDate'";
    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    $i = 1;
    if($num_row == 0){
      echo "noitem";
    } else {
      while($row = sqlsrv_fetch_array($query_result)){
        if ($i % 2 == 0)	$doc_field_name = "info";
        else					$doc_field_name = "active";

        $CID = $row['CID'];
        if($CID == '1'){
          $branch = 'bby';
          $Company = "HANNAM SUPERMARKET BURNABY";
        } elseif($CID == '2'){
          $branch = 'sry';
          $Company = "HANNAM SUPERMARKET SURREY";
        } else{
          $branch = 'dt';
          $Company = "HANNAM SUPERMARKET DOWNTOWN";
        }
        $tOrdNo = $row['tAdjNo'];
        $tDate = $row['oDate'];
        $tStatus = $row['tStatus'];
        $tStatus_text = get_tStatus_text($tStatus);
        $context .= '<tr class="orderhistory_list_tr" style="cursor:pointer;">
                      <td>
                        '.$tOrdNo.'
                        <input type="hidden" value="'.$tOrdNo.'" class="form-control">
                      </td>
                      <td>
                        '.$tDate.'
                        <input type="hidden" value="'.$tDate.'" class="form-control">
                      </td>
                      <td>
                        '.$Company.'
                      </td>
                      <td>
                        '.$tStatus_text.'
                      </td>
                      <td>
                        <p style="margin:0 10px 10px;" data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-default btn-xs" onclick="adjustPage_Redirect(\''.$tOrdNo.'\', \''.$branch.'\')" ><span class="glyphicon glyphicon-search"></span></button></p>
                      </td>
                     </tr>';
           $i++;
      }
      echo $context;
    }
  }


  function search_ReceivedOrder($txt){
    global $conn_hannam;

    $txt = addslashes($txt);
    $txt = str_replace(" ", "", $txt);
    $txt = Br_dconv($txt);

    $query = "SELECT CONVERT(char(10), t.tDate, 126) AS oDate, ";
    $query .= "CID, tOrdNo, tAMT, t.tStatus, tCust, h.hnisCompanyName, ";
    $query .= "CONVERT(char(10), t.tDeliveryDate, 126) AS tDeliveryDate ";
    $query .= "FROM trOrderMaster as t ";
    $query .= "LEFT JOIN hnis_member as h on h.hnisVendorID = t.tCust ";
    $query .= "WHERE t.tStatus > 2 ";
    $query .= "AND (replace(h.hnisCompanyName,' ','')  LIKE '%$txt%' OR replace(tOrdNo,' ','')  LIKE '%$txt%' OR tAmt LIKE '%$txt%') ";
    $query .= "ORDER BY oDate desc";

    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    $i = 1;
    if($num_row == 0){
      echo 'noitem';
    } else {
      while($row = sqlsrv_fetch_array($query_result)){
        if ($i % 2 == 0)	$doc_field_name = "info";
        else					$doc_field_name = "active";

        $CID = $row['CID'];
        if($CID == '1'){
          $branch = 'bby';
          $Company = "HANNAM SUPERMARKET BURNABY";
        } elseif($CID == '2'){
          $branch = 'sry';
          $Company = "HANNAM SUPERMARKET SURREY";
        } elseif($CID == '3'){
          $branch = 'dt';
          $Company = "HANNAM SUPERMARKET DOWNTOWN";
        } elseif($CID == '4'){
          $branch = 'nv';
          $Company = "HANNAM SUPERMARKET N/V";
        }
        $tOrdNo = $row['tOrdNo'];
        $tDate = $row['oDate'];
        $tAMT = $row['tAMT'];
        $tMemo = $row['tMemo'];
        $tDeliveryDate = $row['tDeliveryDate'];
        $tStatus = $row['tStatus'];
        $tStatus_text = get_tStatus_text($tStatus);
        $tCust = $row['tCust'];
        $tCust = get_company_name($tCust);
        $context .= '<tr class="'.$doc_field_name.' orderhistory_list_tr" style="cursor:pointer;">
                      <td>
                        '.$tOrdNo.'
                        <input type="hidden" value="'.$tOrdNo.'" class="form-control">
                      </td>
                      <td>
                        '.$tDate.'
                        <input type="hidden" value="'.$tDate.'" class="form-control">
                      </td>
                      <td>
                        '.$tDeliveryDate.'
                        <input type="hidden" value="'.$tDeliveryDate.'" class="form-control">
                      </td>
                      <td>
                        '.$tCust.'
                      </td>
                      <td>
                        '.$tStatus_text.'
                      </td>
                      <td>
                        $'.number_format($tAMT, 2).'
                      </td>
                      <td>
                        <p style="margin:0 10px 10px;" data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-default btn-xs" onclick="adminOrderPage_Redirect(\''.$tOrdNo.'\', \''.$branch.'\')" ><span class="glyphicon glyphicon-search"></span></button></p>
                      </td>
                     </tr>';
           $i++;
      }
      echo $context;
    }
  }

  function search_ConfirmedOrder($txt){
    global $conn_hannam;

    $txt = addslashes($txt);
    $txt = str_replace(" ", "", $txt);
    $txt = Br_dconv($txt);

    $query = "SELECT *, CONVERT(char(10), tDate, 126) AS oDate ";
    $query .= "FROM trAdjustMaster ";
    $query .= "WHERE tStatus > 2 ";
    $query .= "AND replace(tAdjNo,' ','') LIKE '%$txt%' ";
    $query .= "ORDER BY oDate desc";

    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    $i = 1;
    if($num_row == 0){
      echo "noitem";
    } else {
      while($row = sqlsrv_fetch_array($query_result)){
        if ($i % 2 == 0)	$doc_field_name = "info";
        else					$doc_field_name = "active";

        $CID = $row['CID'];
        if($CID == '1'){
          $branch = 'bby';
          $Company = "HANNAM SUPERMARKET BURNABY";
        } elseif($CID == '2'){
          $branch = 'sry';
          $Company = "HANNAM SUPERMARKET SURREY";
        } elseif($CID == '3'){
          $branch = 'dt';
          $Company = "HANNAM SUPERMARKET DOWNTOWN";
        } elseif($CID == '4'){
          $branch = 'nv';
          $Company = "HANNAM SUPERMARKET N/V";
        }
        $tOrdNo = $row['tAdjNo'];
        $tDate = $row['oDate'];
        $tStatus = $row['tStatus'];
        $tStatus_text = get_tStatus_text($tStatus);
        $context .= '<tr class="orderhistory_list_tr" style="cursor:pointer;">
                      <td>
                        '.$tOrdNo.'
                        <input type="hidden" value="'.$tOrdNo.'" class="form-control">
                      </td>
                      <td>
                        '.$tDate.'
                        <input type="hidden" value="'.$tDate.'" class="form-control">
                      </td>
                      <td>
                        '.$Company.'
                      </td>
                      <td>
                        '.$tStatus_text.'
                      </td>
                      <td>
                        <p style="margin:0 10px 10px;" data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-default btn-xs" onclick="adjustPage_Redirect(\''.$tOrdNo.'\', \''.$branch.'\')" ><span class="glyphicon glyphicon-search"></span></button></p>
                      </td>
                     </tr>';
           $i++;
      }
      echo $context;
    }
  }

  function register_item($reg_Ename,$reg_Kname,$reg_Size,$reg_Upc,$reg_Itemcode,$reg_Vunit,$reg_Vcont,$reg_Vtype){
    global $conn_hannam;

    $reg_Ename = dconv_addslash($reg_Ename);
    $reg_Kname = dconv_addslash($reg_Kname);
    $reg_Size = dconv_addslash($reg_Size);
    $reg_Upc = dconv_addslash($reg_Upc);
    $reg_Itemcode = dconv_addslash($reg_Itemcode);
    $reg_Vunit = dconv_addslash($reg_Vunit);
    $reg_Vcont = dconv_addslash($reg_Vcont);
    $reg_Vtype = dconv_addslash($reg_Vtype);
    $reg_date = date("Y-m-d h:i:sa");

    // echo $reg_Ename."||".$reg_Kname."||".$reg_Size."||".$reg_Upc."||".$reg_Itemcode."||".$reg_Vunit."||".$reg_Vcont."||".$reg_Vtype;
    $vendorId = $_SESSION['hnisVendorID'];

    $search_query = "SELECT Barcode FROM Hnis_Vendor_Item WHERE Barcode = '$reg_Upc' AND VendorID = '$vendorId'";
    $search_query_result = sqlsrv_query($conn_hannam, $search_query, array(), array("scrollable" => 'keyset'));
    $search_num_row = sqlsrv_num_rows($search_query_result);
    if ($search_num_row > 0) {
      echo "already";
    } else {
      $add_query = "INSERT INTO Hnis_Vendor_Item(VendorID, Barcode, ProdEname, ProdKname, VendorSize, VendorCode, VendorUnit, VendorContent, VendorType, chkYN, registerDate) ".
                   "VALUES('$vendorId','$reg_Upc','$reg_Ename','$reg_Kname','$reg_Size','$reg_Itemcode','$reg_Vunit','$reg_Vcont','$reg_Vtype','S','$reg_date')";
      sqlsrv_query($conn_hannam, $add_query);
      echo "success";
    }
  }

  function Order_delete_chk($tOrdNo){
    global $conn_hannam;
    $hnislevel = $_SESSION['hnisLevel'];

    if($hnislevel < 2){
      $chk_query = "SELECT tCust FROM trOrderMaster WHERE tOrdNo = '$tOrdNo' AND tCust = '$tCust'";
      $chk_query_result = sqlsrv_query($conn_hannam, $chk_query, array(), array("scrollable" => 'keyset'));
      $chk_num_row = sqlsrv_num_rows($chk_query_result);
      if($chk_num_row == 0){
        echo "noauthorized";
      } else {
        Order_master_detail_delete($tOrdNo);
        echo "success";
      }
    } else {
      Order_master_detail_delete($tOrdNo);
      echo "success";
    }
    //if lv < 2 then check if this is record from you. if lv == 2 or high then just delete
  }

  function Order_master_detail_delete($tOrdNo){
    global $conn_hannam;
    $master_query = "DELETE FROM trOrderMaster WHERE tOrdNo = '$tOrdNo'";
    $detail_query = "DELETE FROM trOrderDetail WHERE tOrdNo = '$tOrdNo'";
    sqlsrv_query($conn_hannam, $master_query);
    sqlsrv_query($conn_hannam, $detail_query);
  }

  function Update_order_balance($tOrdNo, $chk){
    global $conn_hannam;
    global $conn_bby;
    global $conn_sry;
    global $conn_dt;

    $CID = get_CID_Order($tOrdNo);

    if($CID = '1')  {
      global $conn_bby;
    } elseif ($CID = '2') {
      global $conn_sry;
    } elseif ($CID = '3') {
      global $conn_dt;
    } elseif ($CID = '4') {
      global $conn_nv;
    }
    if($chk == 'adjust'){
      $fetch_query = "SELECT CID,tID,tProd,tQty FROM trAdjustDetail WHERE tAdjNo = '$tOrdNo'";
    } else {
      $fetch_query = "SELECT CID,tID,tProd,tQty FROM trOrderDetail WHERE tOrdNo = '$tOrdNo'";
    }
    // echo $fetch_query;
    $fetch_query_result = sqlsrv_query($conn_hannam, $fetch_query);
    while($row = sqlsrv_fetch_array($fetch_query_result)){
      $tProd = $row['tProd'];
      $tQty = $row['tQty'];
      $update_query = "UPDATE mfProd SET prodBal = prodBal + $tQty WHERE prodId = '$tProd'";
      echo $update_query."<br />";
      // sqlsrv_query($conn_bby, $update_query);
    }
    echo 'success';
  }

  function Update_status_order($tOrdNo){
    global $conn_hannam;
    $update_master_query = "UPDATE trOrderMaster SET tStatus = '3' WHERE tOrdNo = '$tOrdNo'";
    sqlsrv_query($conn_hannam, $update_master_query);
    echo "success";
  }

  function get_CID_Order($tOrdNo){
    global $conn_hannam;
    $query = "SELECT CID FROM trOrderMaster WHERE tOrdNo = '$tOrdNo'";
    $query_result = sqlsrv_query($conn_hannam, $query);
    $row = sqlsrv_fetch_array($query_result);
    return $row['CID'];
  }

  function view_order($ordno, $vendorid){
    global $conn_hannam;

    $item_detail_query = "SELECT m.tOrdNo, t.tPunit, CONVERT(char(10), m.tDate, 126) as tDate, m.tAMT, CONVERT(char(10), m.tDeliveryDate, 126) as tDeliveryDate, m.CID, t.ProdKname, t.ProdEname, t.tSize, t.tQty, t.tOUPrice, t.tAmt FROM trOrderDetail t LEFT JOIN trOrderMaster m on m.tOrdNo = t.tOrdNo";
		$item_detail_query .= " WHERE m.tOrdNo = '$ordno' and m.tCust = '$vendorid'";
		$item_query_result = sqlsrv_query($conn_hannam, $item_detail_query, array(), array("scrollable" => 'keyset'));
    $item_detail_num = sqlsrv_num_rows($item_query_result);
    if($item_detail_num == 0){
      echo $item_detail_query;
    } else {
      while($row = sqlsrv_fetch_array($item_query_result)) {
        $tOrdNo = $row['tOrdNo'];
        $tDate = $row['tDate'];
        $tAMT = $row['tAMT'];
        $tAMT = number_format($tAMT, 2);
        $tDeliveryDate = $row['tDeliveryDate'];
        $CID = $row['CID'];
        $kname = Br_iconv($row['ProdKname']);
        $ename = $row['ProdEname'];
        $tSize = $row['tSize'];
        $tQty = $row['tQty'];
        $tOUPrice = $row['tOUPrice'];
        $tOUPrice = number_format($tOUPrice, 2);
        $tAmt = $row['tAmt'];
        $tAmt = number_format($tAmt, 2);
        $tPunit = $row['tPunit'];
  			echo "::".$tOrdNo.";".$tDate.";".$tAMT.";".$tDeliveryDate.";".$CID.";".$kname.";".$ename.";".$tSize.";".$tQty.";".$tOUPrice.";".$tAmt.";".$tPunit;
  		}
    }
  }

  function get_number_vendorItem(){
    global $conn_hannam;
    $vendorId = $_SESSION['hnisVendorID'];
    $query = "SELECT Barcode FROM Hnis_Vendor_Item WHERE VendorID = '$vendorId'";
    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    echo $num_row;
  }

  function get_number_Totalamount(){
    global $conn_hannam;
    $vendorId = $_SESSION['hnisVendorID'];
    $query = "SELECT sum(tAMT) as total FROM trOrderMaster WHERE tCust = '$vendorId' and tStatus = '5'";
    $query_result = sqlsrv_query($conn_hannam, $query);
    $row = sqlsrv_fetch_array($query_result);
    $total = number_format($row['total'], 2);

    echo "$".$total;
  }

  function get_prodBalance($tProd){
    global $conn_bby;

    $query = "SELECT prodBal FROM mfProd WHERE prodId = '$tProd'";
    $query_result = sqlsrv_query($conn_bby, $query);
    $row = sqlsrv_fetch_array($query_result);
    $balance = $row['prodBal'];

    return $balance;
  }

  function fetch_custom_orderhistroy_vendor($CID,$status,$deliveryDate) {
    global $conn_hannam;
    $vendorid = $_SESSION['hnisVendorID'];
    $today = date("Y-m-d");

    if($CID == 0){
      $where_CID = "";
    } else {
      $where_CID = " AND CID = '$CID'";
    }

    if($status == 0){
      $where_status = "";
    } else {
      $where_status = " AND tStatus = '$status'";
    }

    if($deliveryDate == '1'){
      $where_tDelDate = " AND tDeliveryDate > '$today'";
    } elseif ($deliveryDate == '7') {
      $oneWeekAgo = strtotime ( '-1 week' , strtotime ($today));
      $oneWeekAgo = date("Y-m-d" , $oneWeekAgo);
      $where_tDelDate = " AND tDeliveryDate BETWEEN '$oneWeekAgo' AND '$today'";
    } elseif ($deliveryDate == '30') {
      $oneMonthAgo = strtotime ( '-1 month' , strtotime ($today));
      $oneMonthAgo = date("Y-m-d" , $oneMonthAgo);
      $where_tDelDate = " AND tDeliveryDate BETWEEN '$oneMonthAgo' AND '$today'";
    } elseif ($deliveryDate == '90') {
      $threeMonthAgo = strtotime ( '-1 month' , strtotime ($today));
      $threeMonthAgo = date("Y-m-d" , $threeMonthAgo);
      $where_tDelDate = " AND tDeliveryDate BETWEEN '$threeMonthAgo' AND '$today'";
    }


    $query = "SELECT *, CONVERT(char(10), tDate, 126) AS oDate, CONVERT(char(10), tDeliveryDate, 126) AS DeliveryDate FROM trOrderMaster ";
    $query .= "WHERE tCust = '$vendorid'$where_CID$where_status$where_tDelDate ";
    $query .= "ORDER BY DeliveryDate desc";
    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    $i = 1;
    if($num_row == 0){
      echo 'noitem';
    } else {
      while($row = sqlsrv_fetch_array($query_result)){
        if ($i % 2 == 0)	$doc_field_name = "info";
        else					$doc_field_name = "active";

        $CID = $row['CID'];
        if($CID == '1'){
          $branch = 'bby';
          $Company = "HANNAM SUPERMARKET BURNABY";
        } elseif($CID == '2'){
          $branch = 'sry';
          $Company = "HANNAM SUPERMARKET SURREY";
        } else{
          $branch = 'dt';
          $Company = "HANNAM SUPERMARKET DOWNTOWN";
        }
        $tOrdNo = $row['tOrdNo'];
        $tDate = $row['oDate'];
        $tAMT = $row['tAMT'];
        $tMemo = $row['tMemo'];
        $tDeliveryDate = $row['DeliveryDate'];
        $tStatus = $row['tStatus'];
        $tStatus_text = get_tStatus_text($tStatus);
        if($tStatus < 3){
          $icon_text =  '<p style="margin:0 10px 10px;" data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-default btn-xs" onclick="newOrderPage_Redirect(\''.$tOrdNo.'\', \''.$branch.'\')" ><span class="glyphicon glyphicon-pencil"></span></button></p>';
        } else{
          $icon_text =  '<p style="margin:0 10px 10px;" data-placement="top" data-toggle="tooltip" title="View"><button class="btn btn-default btn-xs" data-title="View" data-toggle="modal" data-target="#view_complete" onclick="view_order('.$tOrdNo.')" ><span class="glyphicon glyphicon-search"></span></button></p>';
        }
        $context .= '<tr class="orderhistory_list_tr" style="cursor:pointer;">
                      <td>
                        '.$tOrdNo.'
                        <input type="hidden" value="'.$tOrdNo.'" class="form-control">
                      </td>
                      <td>
                        '.$tDate.'
                        <input type="hidden" value="'.$tDate.'" class="form-control">
                      </td>
                      <td>
                        '.$tDeliveryDate.'
                        <input type="hidden" value="'.$tDeliveryDate.'" class="form-control">
                      </td>
                      <td>
                        '.$Company.'
                      </td>
                      <td>
                        '.$tStatus_text.'
                      </td>
                      <td>
                        $'.number_format($tAMT, 2).'
                      </td>
                      <td>
                        '.$icon_text.'
                      </td>
                     </tr>';
           $i++;
      }
      echo $context;
    }
  }

  function ajax_vendor_search($vendorTxt){
    global $conn_hannam;
    $vendorTxt = dconv_addslash($vendorTxt);
    $query = "SELECT v.VendorID, m.hnisCompanyName, count(v.VendorID) as items FROM Hnis_Vendor_Item as v LEFT JOIN hnis_member as m on m.hnisVendorID = v.VendorID ";
    $query .= "WHERE (replace(v.VendorID,' ','')  LIKE '%$vendorTxt%' OR replace(m.hnisCompanyName,' ','') LIKE '%$vendorTxt%') ";
    $query .= "GROUP BY VendorID, m.hnisCompanyName";
    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    $i = 0;
    $where = "'vendoritem-table-tbody'";
    if($num_row == 0){
      echo 'noitem';
    } else {
      while($row = sqlsrv_fetch_array($query_result)){
        $VendorID = $row['VendorID'];
        $CompanyName = $row['hnisCompanyName'];
        $num_items = $row['items'];
        $CompanyName = iconv_stripslash($CompanyName);

        $context .= '<tr style="cursor:pointer;" onclick="fetch_vendoritem_admin('.$VendorID.','.$where.')">
                      <td width="45%">
                        '.$CompanyName.'
                      </td>
                      <td width="25%">
                        '.$num_items.'
                      </td>
                      <td>
                        '.$VendorID.'
                      </td>
                     </tr>';
           $i++;
      }
      echo $context;
    }
  }

  function admin_search_vendor($vendorTxt){
    global $conn_hannam;
    $vendorTxt = dconv_addslash($vendorTxt);
    $query = "SELECT VendorID, Name, Phone FROM Hnis_Vendor_List ";
    $query .= "WHERE (replace(VendorID,' ','')  LIKE '%$vendorTxt%' OR replace(Name,' ','') LIKE '%$vendorTxt%') OR replace(Phone,' ','') LIKE '%$vendorTxt%' ";
    $query .= "ORDER BY VendorID ASC ";
    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    $i = 0;
    if($num_row == 0){
      echo 'noitem';
    } else {
      $context = '<table class="table table-hover">';
      $context .= '<thead><tr><th>VendorID</th><th>Company Name</th><th>Phone</th></tr></thead><tbody>';
      while($row = sqlsrv_fetch_array($query_result)){
        $VendorID = $row['VendorID'];
        $CompanyName = $row['Name'];
        $phone = $row['Phone'];
        $CompanyName = iconv_stripslash($CompanyName);
        $CompanyName_send = "'$CompanyName'";
        $context .= '<tr style="cursor:pointer;" onclick="select_vendor('.$VendorID.','.$CompanyName_send.')">
                      <td>
                        '.$VendorID.'
                      </td>
                      <td>
                        '.$CompanyName.'
                      </td>
                      <td>
                        '.$phone.'
                      </td>
                     </tr>';
           $i++;
      }
      $context .= '</tbody></table>';
      echo $context;
    }
  }

  function fetch_hnis_member(){
    global $conn_hannam;
    $query = "SELECT * FROM hnis_member WHERE hnisAdminYN is NULL Order by hnisVendorID ASC";
    $query_result = sqlsrv_query($conn_hannam, $query, array(), array("scrollable" => 'keyset'));
    $num_row = sqlsrv_num_rows($query_result);
    $i = 0;
    if($num_row == 0){
      echo 'noitem';
    } else {
      while($row = sqlsrv_fetch_array($query_result)){
        $hnisID = $row['hnisID'];
        $CompanyName = $row['hnisCompanyName'];
        $CompanyName = iconv_stripslash($CompanyName);
        $phone = $row['hnisPhone'];
        $hnisVendorID = $row['hnisVendorID'];
        $hnisAddress = $row['hnisAddress'];
        $hnisAddress = iconv_stripslash($hnisAddress);

        if($hnisVendorID == ''){
          $class_name = 'danger';
        } else {
          $class_name = '';
        }

        $context .= '<tr class="'.$class_name.'">
                      <td>
                        '.$hnisID.'
                      </td>
                      <td>
                        '.$phone.'
                      </td>
                      <td>
                        '.$hnisAddress.'
                      </td>
                      <td>
                        '.$CompanyName.'
                      </td>
                      <td>
                        <input type="text" class="form-control vendorID'.$i.'" value="'.$hnisVendorID.'">
                      </td>
                      <td>
                        <button class="btn btn-default">UPDATE</button>
                      </td>
                     </tr>';
           $i++;
      }
      echo $context;
    }
  }

  $function = ($_GET['function']) ? $_GET['function'] : $_POST['function'];

  switch ($function) {
    case 'login_process':
      $LoginId = $_POST['userId'];
      $LoginPw = $_POST['userPassword'];
      login_process($LoginId, $LoginPw);
    break;

    case 'register_process':
      $reg_user = $_POST['reg_user'];
      $reg_password = $_POST['reg_password'];
      $reg_companyname = $_POST['reg_companyname'];
      $reg_address = $_POST['reg_address'];
      $reg_phone = $_POST['reg_phone'];
      register_process($reg_user, $reg_password, $reg_companyname, $reg_address, $reg_phone);
    break;

    case 'ajax_search_item':
      $searchtxt = $_POST['search_item'];
      ajax_search_item($searchtxt);
    break;

    case 'adj_search_item':
      $searchtxt = $_POST['search_item'];
      adj_search_item($searchtxt);
    break;

    case 'ajax_add_item':
      $barcode = $_POST['barcode'];
      $prodKname = $_POST['prodKname'];
      $prodName = $_POST['prodName'];
      $prodUnit = $_POST['prodUnit'];
      $prodsize = $_POST['prodsize'];
      ajax_add_item($barcode,$prodKname,$prodName,$prodUnit,$prodsize);
    break;

    case 'fetch_myitem':
      $vendorId = $_POST['vendorId'];
      fetch_myitem($vendorId);
    break;

    case 'fetch_submititem_vendor':
      fetch_submititem_vendor();
    break;

    case 'delete_db_item':
      $barcode = $_POST['barcode'];
      delete_db_item($barcode);
    break;

    case 'update_item_inactive':
      $barcode = $_POST['barcode'];
      update_item_inactive($barcode);
    break;

    case 'ajax_save_vendorcode':
      $VendorCode = $_POST['VendorCode'];
      $barcode = $_POST['barcode'];
      ajax_save_vendorcode($VendorCode, $barcode);
    break;

    case 'ajax_save_vendorcontent':
      $VendorContent = $_POST['VendorContent'];
      $barcode = $_POST['barcode'];
      ajax_save_vendorcontent($VendorContent, $barcode);
    break;

    case 'fetch_neworder_myitem':
      $vendorid = $_SESSION['hnisVendorID'];
      fetch_neworder_myitem($vendorid);
    break;

    case 'fetch_myorder_itemlist':
      $vendorid = $_SESSION['hnisVendorID'];
      $ordno = $_POST['ordno'];
      fetch_myorder_itemlist($vendorid,$ordno);
    break;

    case 'fetch_admin_itemlist':
      $vendorid = $_POST['vendorid'];
      $ordno = $_POST['ordno'];
      fetch_myorder_itemlist($vendorid,$ordno);
    break;

    case 'fetch_orderhistory_list':
      $vendorid = $_SESSION['hnisVendorID'];
      fetch_orderhistory_list($vendorid);
    break;

    case 'fetch_saved_list':
      $vendorid = $_SESSION['hnisVendorID'];
      fetch_saved_list($vendorid);
    break;

    case 'fetch_confirmed_list':
      $vendorid = $_SESSION['hnisVendorID'];
      fetch_confirmed_list($vendorid);
    break;

    case 'fetch_received_list':
      $adminCompany = $_SESSION['hnisCompanyName'];
      fetch_received_list($adminCompany);
    break;

    case 'fetch_adjust_received_list':
      $adminCompany = $_SESSION['hnisCompanyName'];
      fetch_adjust_received_list($adminCompany);
    break;

    case 'search_Orderdate':
      $orderDate = $_POST['orderDate'];
      fetch_search_by_date($orderDate);
    break;

    case 'search_Confirmeddate':
      $orderDate = $_POST['orderDate'];
      fetch_search_by_Confirmeddate($orderDate);
    break;

    case 'search_ReceivedOrder':
      $txt = $_POST['txt'];
      search_ReceivedOrder($txt);
    break;

    case 'search_ConfirmedOrder':
      $txt = $_POST['txt'];
      search_ConfirmedOrder($txt);
    break;

    case 'fetch_myitem_inregister':
      fetch_myitem_inregister();
    break;

    case 'Order_delete_chk':
      $tOrdNo = $_POST['tOrdNo'];
      Order_delete_chk($tOrdNo);
    break;

    case 'view_order':
      $ordno = $_POST['ordno'];
      $vendorid = $_SESSION['hnisVendorID'];
      view_order($ordno,$vendorid);
    break;

    case 'get_number_vendorItem':
      get_number_vendorItem();
    break;

    case 'get_number_Totalamount':
      get_number_Totalamount();
    break;

    case 'get_number_balance':
      get_number_balance();
    break;

    case 'get_number_credit':
      get_number_credit();
    break;

    case 'register_item':
      $reg_Ename = $_POST['reg_Ename'];
      $reg_Kname = $_POST['reg_Kname'];
      $reg_Size = $_POST['reg_Size'];
      $reg_Upc = $_POST['reg_Upc'];
      $reg_Itemcode = $_POST['reg_Itemcode'];
      $reg_Vunit = $_POST['reg_Vunit'];
      $reg_Vcont = $_POST['reg_Vcont'];
      $reg_Vtype = $_POST['reg_Vtype'];
      register_item($reg_Ename,$reg_Kname,$reg_Size,$reg_Upc,$reg_Itemcode,$reg_Vunit,$reg_Vcont,$reg_Vtype);
    break;

    case 'ajax_each_save_item':
      $ajax_barcode = $_POST['ajax_barcode'];
      $ajax_code = $_POST['ajax_code'];
      $ajax_unit = $_POST['ajax_unit'];
      $ajax_content = $_POST['ajax_content'];
      $ajax_type = $_POST['ajax_type'];

      ajax_each_save_item($ajax_barcode, $ajax_code, $ajax_unit, $ajax_content, $ajax_type);
    break;

    case 'fetch_vendoritem_admin':
      $vendorId = $_POST['vendorId'];
      fetch_vendoritem_admin($vendorId);
    break;

    case 'search_galcode_prodowncode':
      $barcode = $_POST['barcode'];
      search_galcode_prodowncode($barcode);
    break;

    case 'update_item_confirmed':
      $vendorid = $_POST['vendorid'];
      $vendorcode = $_POST['vendorcode'];
      $barcode = $_POST['barcode'];
      $vendorunit = $_POST['vendorunit'];
      $vendorcontent = $_POST['vendorcontent'];
      $vendortype = $_POST['vendortype'];
      $galcode = $_POST['galcode'];
      $prodowncode = $_POST['prodowncode'];

      update_item_confirmed($vendorid,$vendorcode,$barcode,$vendorunit,$vendorcontent,$vendortype,$galcode,$prodowncode);
    break;

    case 'fetch_custom_orderhistroy_vendor':
      $CID = $_POST['CID'];
      $status = $_POST['status'];
      $deliveryDate = $_POST['deliveryDate'];

      fetch_custom_orderhistroy_vendor($CID,$status,$deliveryDate);
    break;

    case 'ajax_vendor_search':
      $vendorTxt = $_POST['vendorTxt'];

      ajax_vendor_search($vendorTxt);
    break;

    case 'fetch_vendor_list':
      fetch_vendor_list();
    break;

    case 'fetch_vendor_detail':
      $VendorID = $_POST['VendorID'];
      fetch_vendor_detail($VendorID);
    break;

    case 'update_vendor':
      $VendorID = $_POST['ven_ID'];
      $VendorName = $_POST['ven_Name'];
      $VendorPhone = $_POST['ven_Phone'];
      $VendorFax = $_POST['ven_Fax'];
      $VendorEmail = $_POST['ven_Email'];
      $VendorAddress = $_POST['ven_Address'];
      $VendorUseyn = $_POST['ven_Useyn'];
      update_vendor($VendorID,$VendorName,$VendorPhone,$VendorFax,$VendorEmail,$VendorAddress,$VendorUseyn);
    break;

    case 'register_vendor':
      $VendorName = $_POST['ven_Name'];
      $VendorPhone = $_POST['ven_Phone'];
      $VendorFax = $_POST['ven_Fax'];
      $VendorEmail = $_POST['ven_Email'];
      $VendorAddress = $_POST['ven_Address'];
      $VendorUseyn = $_POST['ven_Useyn'];
      register_vendor($VendorName,$VendorPhone,$VendorFax,$VendorEmail,$VendorAddress,$VendorUseyn);
    break;

    case 'admin_search_vendor':
      $vendorTxt = $_POST['vendorTxt'];
      admin_search_vendor($vendorTxt);
    break;

    case 'fetch_hnis_member':
      fetch_hnis_member();
    break;

    case 'fetch_adjust_itemlist':
      $ordno = $_POST['ordno'];
      fetch_adjust_itemlist($ordno);
    break;

    case 'Update_order_balance':
      $ordno = $_POST['ordno'];
      $chk = $_POST['chk'];
      Update_order_balance($ordno,$chk);
    break;

  }
?>
