<?
  session_start();
  // if($_SESSION['hnisID'] == '') {
  //   echo '<script>alert("test")</script>';
  // }
  $vendor_Id = $_SESSION['hnisVendorID'];
  $OrdNo = $_GET['OrdNo'];
  require_once 'dompdf-master/dompdf_config.inc.php';
  include_once('includes/include_db.php');
  $Query = "SELECT CONVERT(char(10),c.tDate,120) AS tDate, a.CID, a.tID, c.tOrdNo, tProd, tQty, a.tOUprice, a.tAmt, tPunit, a.tCust, a.ProdKname, a.ProdEname, a.tSize, CONVERT(char(10),c.tDeliveryDate,120) AS tDeliveryDate, a.tMemo AS dMemo, c.tMemo AS mMemo, c.tStatus, c.CustomerPO, c.tAMT, h.Name ".
			 "FROM trOrderDetail a ".
			 "LEFT JOIN trOrderMaster c ON a.tOrdNo = c.tOrdNo ".
       "LEFT JOIN Hnis_Vendor_List h ON c.tCust = h.VendorID ".
			 "WHERE a.tOrdNo = '$OrdNo' ".
			 "ORDER BY tID ASC ";
  $query_result = sqlsrv_query($conn_hannam, $Query, array(), array("scrollable" => 'keyset'));
  $row_num = sqlsrv_num_rows($query_result);

  $content = "";
  $companyname = "";

  while ($row = sqlsrv_fetch_array($query_result)) {
    $tID = $row['tID'];
    $tOrdNo = $row['tOrdNo'];
    $tProd = $row['tProd'];
    $tQty = $row['tQty'];
    $tOUprice = $row['tOUprice'];
    $tOUprice = number_format($tOUprice,2);
    $ProdKname = iconv('EUC-KR','UTF-8',$row['ProdKname']);
    $ProdEname = $row['ProdEname'];
    $tSize = $row['tSize'];
    $tDeliveryDate = $row['tDeliveryDate'];
    $dMemo = $row['dMemo'];
    $mMemo = $row['mMemo'];
    $tStatus = $row['tStatus'];
    $CustomerPO = $row['CustomerPO'];
    $tAmt = $row['tAmt'];
    $tAmt = number_format($tAmt,2);
    $tAMT = $row['tAMT'];
    $tAMT = number_format($tAMT,2);
    $tUnit = "QTY";
    $companyname = $row['Name'];
    $content .= '<tr height="20" style="mso-height-source:userset;height:15.0px">'.
                  '<td height="20" class="xl95" style="height:15.0px">'.$tQty.'</td>'.
                  '<td height="20" class="xl95" style="height:15.0px">'.$tUnit.'</td>'.
                  '<td class="xl96" style="border-left:none">'.$tProd.'</td>'.
                  '<td class="xl97" style="border-left:none">'.$tProd.'</td>'.
                  '<td colspan="2" class="xl103" style="border-left:none;">'.
                  '<span style="font-family:NanumGothic;">'.
                  $ProdEname.' / '.$tSize.
                  '<br />'.
                  $ProdKname.
                  '</span>'.
                  '</td>'.
                  '<td class="xl99" style="border-left:none">$'.$tOUprice.'</td>'.
                  '<td class="xl98" style="border-left:none">$'.$tAmt.'</td>'.
                  '</tr>';
  }

  if($tStatus == 1){
    $header_tStatus = 'SAVED';
  } elseif ($tStatus == 2) {
    $header_tStatus = 'UPDATED';
  } elseif ($tStatus == 3) {
    $header_tStatus = 'SUBMITTED';
  } elseif ($tStatus == 4) {
    $header_tStatus = 'CONFIRMED';
  } elseif ($tstatus == 5) {
    $header_tStatus = 'COMPLETED';
  }

  $header = <<<EOD
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<link rel="stylesheet" href="css/form.css?ver=6">
</head>
<body link="blue" vlink="purple" style="width:712px;">
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;table-layout:fixed;width:100%;">
 <tbody>
 <tr height="78" style="height:58.5px">
  <td colspan="2" height="78" width="150" align="left">
    <img width="100%" height="100%" src="images/nologo.png">
  </td>
  <td colspan="5" class="xl107">SALES ORDER SHEET</td>
 </tr>
 <tr height="7" style="height:5.25px">
  <td height="7" class="xl67" style="height:5.25px">&nbsp;</td>
  <td class="xl67"></td>
  <td class="xl67">&nbsp;</td>
  <td class="xl68">&nbsp;</td>
  <td class="xl69">&nbsp;</td>
  <td class="xl70">&nbsp;</td>
  <td class="xl71">&nbsp;</td>
 </tr>
 <tr height="20" style="height:15.0px">
  <td colspan="3" height="20" class="xl67" style="height:15.0px">[$companyname]</td>
  <td class="xl68">&nbsp;</td>
  <td class="xl66"></td>
  <td class="xl69">Date:</td>
  <td class="xl70">December 11, 2017</td>
 </tr>
 <tr height="18" style="height:14.1px">
  <td colspan="3" rowspan="2" height="36" class="xl108" style="height:28.2px"><span style="">&nbsp;</span>
  </td>
  <td class="xl72">&nbsp;</td>
  <td class="xl66"></td>
  <td class="xl69">Order #:</td>
  <td class="xl69">[$OrdNo]</td>
 </tr>
 <tr class="xl74" height="18" style="height:14.1px">
  <td height="18" class="xl73" style="height:14.1px">&nbsp;</td>
  <td class="xl69">&nbsp;</td>
  <td class="xl69">Status:</td>
  <td class="xl73">[$header_tStatus]</td>
 </tr>
 <tr class="xl74" height="18" style="height:14.1px">
  <td height="18" class="xl73" style="height:14.1px">&nbsp;</td>
  <td class="xl73">&nbsp;</td>
  <td class="xl73">&nbsp;</td>
  <td class="xl73">&nbsp;</td>
  <td class="xl73">&nbsp;</td>
  <td class="xl75">&nbsp;</td>
  <td class="xl73">&nbsp;</td>
 </tr>
 <tr class="xl74" height="18" style="height:14.1px">
  <td height="18" class="xl69" style="height:14.1px">Sold to:</td>
  <td colspan="2" class="xl69">[HANNAM SUPERMARKET]</td>
  <td class="xl73">&nbsp;</td>
  <td colspan="2" class="xl69">&nbsp;</td>
  <td class="xl73">&nbsp;</td>
 </tr>
 <tr class="xl74" height="18" style="height:14.1px">
  <td height="18" class="xl76" style="height:14.1px">&nbsp;</td>
  <td colspan="2" class="xl69">[ROBSON]</td>
  <td class="xl73">&nbsp;</td>
  <td colspan="2" class="xl69">&nbsp;</td>
  <td class="xl73">&nbsp;</td>
 </tr>
 <tr class="xl74" height="18" style="mso-height-source:userset;height:14.1px">
  <td height="18" class="xl73" style="height:14.1px">&nbsp;</td>
  <td class="xl69" colspan="2" style="mso-ignore:colspan">[#202-1323 ROBSON ST]</td>
  <td class="xl73">&nbsp;</td>
  <td colspan="2" class="xl69">&nbsp;</td>
  <td class="xl73">&nbsp;</td>
 </tr>
 <tr class="xl74" height="18" style="mso-height-source:userset;height:14.1px">
  <td height="18" class="xl73" style="height:14.1px">&nbsp;</td>
  <td class="xl69" colspan="2" style="mso-ignore:colspan">[VANCOUVER, BC<span style="mso-spacerun:yes">&nbsp; </span>V6E 2B1]</td>
  <td class="xl69">&nbsp;</td>
  <td colspan="2" class="xl69">&nbsp;</td>
  <td class="xl73">&nbsp;</td>
 </tr>
 <tr class="xl74" height="18" style="mso-height-source:userset;height:14.1px">
  <td height="18" class="xl73" style="height:14.1px">&nbsp;</td>
  <td class="xl69">[604-974-8188]</td>
  <td class="xl69">&nbsp;</td>
  <td class="xl73">&nbsp;</td>
  <td colspan="2" class="xl69">&nbsp;</td>
  <td class="xl73">&nbsp;</td>
 </tr>
 <tr class="xl74" height="18" style="mso-height-source:userset;height:14.1px">
  <td colspan="6" height="18" class="xl73" style="height:14.1px">&nbsp;</td>
  <td class="xl73">&nbsp;</td>
 </tr>
 </tbody>
 </table>
EOD;

$content_header = <<<EOD
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;width:712px;">
<tbody>
<tr height="20" style="height:15.0px">
 <th class="xl92" style="width:20px;">Qty</td>
 <th class="xl92" style="width:30px;">Unit</td>
 <th class="xl92" style="width:35px;">Item #</td>
 <th class="xl69" style="width:45px;">Barcode</td>
 <th colspan="2" class="xl69" style="width:380px;">Description</td>
 <th class="xl69" style="width:80px;">Unit Price</td>
 <th class="xl69" style="width:80px;">Line Total</td>
</tr>
EOD;


$content_footer = <<<EOD
<tr height="20" style="mso-height-source:userset;height:15.0px">
 <td height="20" class="xl80" style="height:15.0px"></td>
 <td class="xl80"></td>
 <td class="xl80"></td>
 <td class="xl80"></td>
 <td class="xl80"></td>
 <td class="xl80"></td>
 <td class="xl93">Total</td>
 <td class="xl102" style="border-top:none"><span style="mso-spacerun:yes">$$tAMT</span></td>
</tr>
<tr height="18" style="mso-height-source:userset;height:14.1px">
 <td height="18" class="xl81" style="height:14.1px">&nbsp;</td>
 <td class="xl81">&nbsp;</td>
 <td class="xl81">&nbsp;</td>
 <td class="xl74"></td>
 <td class="xl82"></td>
 <td class="xl83">&nbsp;</td>
 <td class="xl83">&nbsp;</td>
 <td class="xl66"></td>
</tr>
<tr height="20" style="mso-height-source:userset;height:15.0px">
 <td colspan="7" height="20" class="xl110" width="646" style="height:15.0px;
 width:485px">Thank you for your business!</td>
</tr>
<tr height="13" style="mso-height-source:userset;height:9.95px">
 <td height="13" class="xl84" style="height:9.95px"></td>
 <td class="xl84"></td>
 <td class="xl84"></td>
 <td class="xl84"></td>
 <td class="xl84"></td>
 <td class="xl84"></td>
 <td class="xl84"></td>
 <td class="xl66"></td>
</tr>
<tr class="xl85" height="20" style="mso-height-source:userset;height:15.0px">
 <td colspan="8" height="20" class="xl112" style="height:15.0px"></td>
</tr>
</tbody>
</table>
EOD;

$footer = <<<EOD
</body>
</html>
EOD;

  $html = $header.$content_header.$content.$content_footer.$footer;
  $dompdf = new DOMPDF();
  $dompdf->set_paper("LETTER", "portrait");
  $dompdf->load_html($html);
  $dompdf->render();
  // echo $html;
  // echo $Query;

  $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
  exit(0);
?>
