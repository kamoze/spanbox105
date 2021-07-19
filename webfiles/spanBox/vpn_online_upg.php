<?php
session_start();
if($_SESSION['authenticated'] != true ) {
  header('location:main.php?id=error');
}
$_SESSION['error'] = 0;
$_SESSION['version'] = 0;
$_SESSION['new_ver'] = 0;
if($_POST['ver'] == "yes") {
   $dir = "/usr/src/upgrade/";
   if($handle = opendir($dir)) {
     while(false !== ($entry = readdir($handle))) {
       if($entry != "." && $entry != "..") {
        $_SESSION['version'] = substr($entry,-4) ; 
       }
     }
     closedir($handle);
   } 
}

if($_POST['check'] == "yes") {
  $conn_id = ftp_connect("upgrade.spantreeng.com");
  // Login
    if (ftp_login($conn_id, "update","sp@ntr33sb105update@#*"))
    {
        // Change the dir
       ftp_pasv($conn_id,true);
       $contents = ftp_nlist($conn_id, "upgrade/upgrade"); 
       $_SESSION['new_ver'] = substr($contents[0], -4);
    } 
}

if($_POST['upgrade'] == "yes") {
  exec('sudo  /usr/bin/spanbox.sh upgrade');
}
?>
<script type="text/javascript">
function submitform() {
  document.forms["version"].submit();
}
function submitform2() {
  document.forms["check"].submit();
}
function submitform3() {
  document.forms["upgrade"].submit();
}
</script>

<html>
<head>
<link rel="stylesheet" type="text/css" href="css/styles.css" />
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




<h3 style="margin-left:15px;">SB-ONLINE Upgrade</h3>
<div id="status_table">
<table width="700 px" style="margin-left:10 px; align:center;">
<tr>
  <td width="200 px" style="text-align:center; color:;">Online Upgrade</td>
  <td  width ="350 px" style="opacity:0.6;
                              filter:alpha(opacity=60);
                              background-color:;"> 
    <form method = "post" action="vpn_online_upg.php" name="version" id="version" >
    <input type="hidden" name="ver" value="yes">
	<span class="cl-effect-8">
    <i href="javascript:submitform() " style="text-decoration:none;"> </i>
</span>	
   </form>
  </td>
</tr>
<tr>
  <td width="200 px" style="text-align:center;">
  <?php 
$ver= '2.8';
   if($ver != 0 ) {
     echo 'current version - ver'. -$ver;
   } 
    ?></td>
  <td  width ="350 px" style="
 opacity:0.6;
                              filter:alpha(opacity=60);
background-color:;"> 
    <form method = "post" action="vpn_online_upg.php" name="check" id="check">
    <input type="hidden" name="check" value="yes">
	<span class="cl-effect-8">
    <a href="javascript:submitform2()" style="text-decoration:none;"> Check for Update </a> 
	</span>
   </form></td>
</tr>

<tr>
  <td width="200 px" style="text-align:center; ">
  <?php
   if(!empty($_SESSION['new_ver']) ) {
     echo 'available version -'.$_SESSION['new_ver'];
   } ?></td>
  <td  width ="350 px" style="background-color:; 
                              opacity:0.6;
                              filter:alpha(opacity=60);"> 
    <form method = "post" action="vpn_online_upg.php" name="upgrade" id="upgrade" >
    <input type="hidden" name="upgrade" value="yes">
	<span class="cl-effect-8">
    <a href="javascript:submitform3()" style="text-decoration:none;"> Upgrade Now</a> 
	</span>
   </form>
</td>
</tr>
</table>
<br>
<a href="mgmt.php"><img src="image/back.jpg" style="margin-left:75px;"></a>
<a href="status.php"><img src="image/next.jpg" style="margin-left:450;"></a>

<br/><h3><br/>
</div>
</div>
</div>
</div>
</div>
</body>
</html>


