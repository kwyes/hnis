<?php

require 'PHPmailer/PHPMailerAutoload.php';

  function sendmail($email){
    $mail = new PHPMailer;
    $today = date('Y-m-d');
    $mail->IsSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mail.westviewinvestment.ca';  // smtp 주소
    $mail->SMTPAuth = false;                               // Enable SMTP authentication
    $mail->Username = 'chano.lee';                            // SMTP username 메일주소
    $mail->Password = 'ch2017';                           // SMTP password 메일 접속 시 비밀번호
    $mail->Port = 25;

    $mail->CharSet = "utf-8";
    $mail->Encoding = "base64";

    $mail->From = 'chano.lee@westviewinvestment.ca';                 //보내는 사람 메일 주소
    $mail->FromName = 'HANNAM SUPERMARKET';
    // $mail->Sender = $email;                           //보내는 사람 이름
    $mail->AddAddress($email);  // Add a recipient 받는 사람 주소, 받는 사람 이름
    $mail->AddReplyTo( 'chano.lee@westviewinvestment.ca', 'Hannam Supermarket' );

    $mail->WordWrap = 50;
    $mail->IsHTML(true);                                  // Set email format to HTML  메일을 보낼 때 html 형식으로 메일을 보낼 경우 true
    $body = 'test';

    $mail->Subject = "한남수퍼마켓 카카오톡 플러스 친구 가입 이벤트";                //메일 주소
    $mail->Body    = $body;  //메일 본문

    if(!$mail->Send()) {
      $status = 'Failed';
    } else {
      $status = 'Success';
    }
    return $status;
}

sendmail('kwyes3@gmail.com');

// $query = "WITH TEMPTABLE AS (
// select ROW_NUMBER() OVER (ORDER BY d.EMail) AS seq, d.CardNo, d.EMail from
//  (SELECT distinct(colcust) as colC FROM [db1gal].[dbo].[tfcollection2]
//   WHERE convert(datetime, colDate) between '2016-08-01' and '2017-07-31'
//  ) c,
//  (SELECT a.CardNo, a.EMail
//    FROM [dbgal].[dbo].[tblCustomer] a LEFT OUTER JOIN [dbgal].[dbo].[tblCustomerHist] b ON a.CardNo = b.CardNo
//    WHERE  b.NewCardNo is null
//    AND a.Active = 1
//    and CustLanguage = 'kor'
//  ) d
// where c.colC = d.CardNo and d.EMail <> '' and d.EMail <> 'x' and LEN(d.EMail) > 8
//  and d.Email NOT IN ('.@gmail.com','0@hotmail.com','1@hotmail.com', '1@gmail.com')
//  )
//  SELECT *
// FROM TEMPTABLE WHERE seq BETWEEN 7001 and 7479";
//
// $query_result = mssql_query($query);
// $row_num = mssql_num_rows($query_result);
//
// ?>
