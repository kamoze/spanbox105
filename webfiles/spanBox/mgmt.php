<?php
session_start();
if($_SESSION['authenticated'] != true ) {
  header('location:main.php?id=error');
}

if(isset($_POST['restart'])){
       	exec('sudo  /usr/bin/spanbox.sh restart'); 
}
if(isset($_POST['stop'])){
       	exec('sudo  /usr/bin/spanbox.sh stop'); 
}

if(isset($_POST['vpn_restart'])){
        exec('sudo  /usr/bin/spanbox.sh vpn_restart');
}
if(isset($_POST['vpn_stop'])){
 exec('sudo  /usr/bin/spanbox.sh vpn_stop');
}

if(isset($_POST['mgt_start'])){
        exec('sudo  /usr/bin/spanbox.sh mgt_start');
}
if(isset($_POST['mgt_stop'])){
 exec('sudo  /usr/bin/spanbox.sh mgt_stop');
}
if(isset($_POST['reboot'])){
 exec('sudo  /usr/bin/spanbox.sh reboot');
}


?>
<html>
<head>
<link type="text/css" rel="stylesheet" href="css/jquery.pwstabs.css">
<link type="text/css" rel="stylesheet" href="css/jquery.pwstabs.min.css">
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<link type="text/css" rel="stylesheet" href="js/font-awesome/css/font-awesome.min.css">
<script type="text/javascript" src="js/ajax.js"></script>
<script src="js/modernizr.custom.js"></script>
<script>
$(function() {
     var pgurl = window.location.href.substr(window.location.href
.lastIndexOf("/")+1);
     $("#nav ul li a").each(function(){
          if($(this).attr("href") == pgurl || $(this).attr("href") == '' )
          $(this).addClass("active");
     })
});
	</script>
</head>
<body>
<div class="content">
	

<div id="page-wrap">

<div class="header">
      <div id="main_heading"> The SpanBOX 105 Web Manager <span><?php include 'footer.php' ?></span></div>
   </div><!-- header -->
<div class="pws_tabs_container pws_tabs_horizontal pws_tabs_horizontal_top pws_scale">
<menu id="nav">
<ul class="nav pws_tabs_controll">
<li><a  href="status.php">Status</a></li>
<li><a  href="mgmt.php">Management</a></li>
<li><a  href="pbx.php">PBX</a></li>
<li><a  href="network.php">Network</a></li>
<li><a  href="vpn.php">VPN-Connect</a></li>
<li><a href="firewall.php">Firewall</a></li>
<li><a href="webfilter.php">WebFilter</a></li>
</ul>
</menu>
<br>
</div>
<div class="tabset0 pws_tabs_list" style="height: 667px;">
<div class="list-wrap">

<h3 >Server Management </h3>
<span class="cl-effect-8" style="float:right;margin-right:15px;">
  <a href="pwd_mgt.php">Change Password</a></span>

<div id="status_table1">
<table width="700 px" style="margin-left:10 px; align:center;">

<tr>
  <td width="400 px" style="text-align:center;"><h4>STATUS</h4></td>
  <td  width ="150 px">
   <?php  $i = exec('sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountStatusGet MGT | grep "Session Established" | awk "{print $1}"');
     if(strstr($i, "Session")) {
        echo '<img src="image/green.png" align="center" style="margin-right:100px;"/>';
      } else {
        echo '<img src="image/red.png"  align="center" style="margin-right:100px;"/>';
      }
?>
  </td>
</tr>

<tr>
</tr>

<tr>
  <td width="400 px" style="text-align:center;"><h4>START REMOTE MGT</h4></td>
  <td  width ="150 px">
    <form method="POST">
     <input type="image" name="mgt_start" value="mgt_start" src="image/start.png">
    </form>
  </td>
</tr>

<tr>
  <td width="400 px" style="text-align:center;"><h4>STOP REMOTE MGT</h4></td>
  <td  width ="150 px">
    <form method="POST">
     <input type="image" name="mgt_stop" value="mgt_stop" src="image/stop.png">
    </form>
  </td>
</tr>

</table>
<hr style="margin-left:80px; margin-right:80px">
<table width="700 px" style="margin-left:10 px; align:center;">
<tr>
  <td width="400 px" style="text-align:center;"><h4>VOICEMAIL</h4></td>
  <td  width ="150 px">
    <a href="voicemail.php"><img src="image/voicemail.png" style="margin-left:0px;"></a>
  </td>
</tr>
</table>

</table>
<hr style="margin-left:80px; margin-right:80px">
<table width="700 px" style="margin-left:10 px; align:center;">
<tr>
  <td width="400 px" style="text-align:center;"><h4>VC-TRUNK</h4></td>
  <td  width ="150 px">
    <a href="vc.php"><img src="image/vc.png" style="margin-left:0px;"></a>
  </td>
</tr>
</table>



</table>
<hr style="margin-left:80px; margin-right:80px">
<table width="700 px" style="margin-left:10 px; align:center;">
<tr>
  <td width="400 px" style="text-align:center;"><h4>REBOOT</h4></td>
  <td  width ="150 px">
    <form method="POST">
     <input type="image" name="reboot" value="reboot" src="image/start.png">
    </form>
  </td>
</tr>
</table>
<hr style="margin-left:80px; margin-right:80px">
<table width="700 px" style="margin-left:10 px; align:center;">
<tr>
  <td width="400 px" style="text-align:center;"><h4>UPGRADE</h4></td>
  <td  width ="150 px">
    <form method="POST">
     <a href="vpn_online_upg.php"><img src="image/upgrade.png" style="margin-left:6px;"></a>
    </form>
  </td>
</tr>
</table>
<a href="status.php"><img src="image/back.jpg" style="margin-left:75px;"></a>
<br><h3><br>
<br>
</div>
</div>
</div>
</div>
</div>
<br>
</body>
</html>


