<?php
session_start();
$_SESSION['noauth'] = false;;
if($_GET[id] == 'error') {
  $_SESSION['noauth'] = true;;
}

if (isset($_POST["user"])) {
  $pwfile = fopen("users.txt", "w");
  fputs($pwfile, "admin:" . crypt($_POST["cnf"], "pw") . "\n");
  fclose($pwfile);
   header('location:main.php');
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<link rel="stylesheet" type="text/css" href="css/login.css" />
<link type="text/css" rel="stylesheet" href="css/jquery.pwstabs.css">
<link type="text/css" rel="stylesheet" href="css/jquery.pwstabs.min.css">
<link type="text/css" rel="stylesheet" href="js/font-awesome/css/font-awesome.min.css">
<script src='js/ajax.js'></script>
</head>
<body>
<div class="content">
	

<div id="page-wrap">

<div class="header">
      <div id="main_heading"> The SpanBOX 105 Web Manager <span><?php include 'footer.php' ?></span></div>
   </div><!-- header -->
<div class="pws_tabs_container pws_tabs_horizontal pws_tabs_horizontal_top pws_scale">
<ul class="nav pws_tabs_controll">
<li class="main-nav"><a  href="status.php">Status</a></li>
<li class="main-nav"><a  href="mgmt.php">Management</a></li>
<li class="main-nav"><a  href="pbx.php">PBX</a></li>
<li class="main-nav"><a  href="network.php">Network</a></li>
<li class="main-nav"><a  href="vpn.php">VPN-Connect</a></li>
<li class="main-nav"><a href="firewall.php">Firewall</a></li>
</ul>
<br>
</div>
<div class="tabset0 pws_tabs_list" style="height: 667px;">
<div class="list-wrap">

<div id="inner_cont">
<fieldset>

<h3>SpanBOX Web Manager<span style="color:#F09462;"></span></h3>

<p>Change Login Password</p>

<?php  
  if($_SESSION['noauth'] == true ) {
  echo '<p style="color:red">Could not Authenticate. Try Again</p>';
  }
?>
<form method="post" action="">
<table>
<tr><td>New Pwd</td><td><input type="password" name="pass" /></td></tr>
<tr><td>Confirm Pwd</td><td><input type="password" name="cnf" /></td></tr>
<input type="hidden" name="user" value="1">
<tr><td><td><input type="submit" value="SUBMIT"></td></tr>
</table>
</form>
</fieldset>
</div>
<br><br>
</div>
</div>
</div>
</div>
</body>
</html>
