<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="js/right_content.js?ver=7"></script>
    <script src="js/common_function.js?ver=3"></script>
  </head>
  <body>
    <input type="text" class="missvcode" name="" value="" placeholder="vendorcode">
    <input type="text" class="missbcode" name="" value="" placeholder="barcode">
    <input type="text" class="missqty" name="" value="" placeholder="qty">
    <button type="button" name="button" onclick="search_item_mismatching()">submit</button>
    <button type="button" name="button" onclick="update_item_mismatching()">update</button>

    <div class="result-div">

    </div>

    <div class="result-div2">

    </div>
  </body>
</html>
