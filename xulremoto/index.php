<?php
include('../include/browser.inc.php');
$broswer = new browser();

if( isset( $_SERVER['HTTPS']) )
  if($_SERVER['HTTPS']== 'on')
    {
      header("Location: http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
      exit();
    }


?>
<html>
<meta charset="utf-8">﻿
<?php 
  if ($broswer->isFirefox())
    echo '<meta http-equiv="Refresh" content="2;url=../config/gpos-installer.xpi">';
?>

<style type="text/css">
       div#xBox {
            background-image: url("../img/gpos_instalarxul.png");
            background-repeat: no-repeat;
            background-position: center top; 
	    background-size: 362px 322px;
            width: calc(100%);
            height: 80%;
            margin-top: 10%;
            margin-left: auto;
            margin-right: auto;
            }
       div#xPOS {
            width: calc(30%);
            height: 19em;
            margin-top: 0%;
            border: solid 0px red;
            margin-left: auto;
            margin-right: auto;
            cursor:pointer;
            }
       div#xFox {
            width: calc(30%);
            height: 20em;
            margin-top: 1em;
            border: solid 0px blue;
            margin-left: auto;
            margin-right: auto;
            cursor:pointer;
            }
       body {
            background-image:  url("../img/gpos_bg_login.jpg");
            background-repeat: repeat-x;
            background-color:  #EDEBE4;
       }
</style>
<body>
  <div id="xBox" >
    <div id="xPOS" onclick="javascript:location.href='../'"></div>
    <div id="xFox" onclick="javascript:location.href='index.php'"></div>
  </div>
</body>
</html>';

