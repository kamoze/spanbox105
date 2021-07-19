<?php
session_start();
if($_SESSION['authenticated'] != true ) {
  header('location:main.php?id=error');
}

if(isset($_POST['cdmaset']))  {

 $command = 'sudo  /usr/bin/spanbox.sh cdmaset'; 
 exec($command);
}

?>
<script type="text/javascript">
function submitform() {
  document.forms["cdmaset"].submit();
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


<h3 style="margin-left:15px;">CDMA SET FUNCTION</h3>
<div id="status_table">
<table width="700 px" style="margin-left:10 px; align:center;">
<tr>
<td  style="text-align:center;">
<form action="cdmaset.php" method="post" name="cdmaset" id="cdmaset">

<input type ="hidden" name="cdmaset" value="yes">
<input type ="button" value="Set CDMA 3G" name"cdmaset"
onClick="if(confirm('Do you want to set the device to CDMA mode? You can only use CDMA dongles!')) {
  submitform();
}
">
</form>
</td>
</tr>
</table>
<br/><br/>
<a href="3g.php"><img src="image/back.jpg" style="margin-left:75px;"></a>
<a href="network.php"><img src="image/next.jpg" style="margin-left:450;" />
<br><h3><br>
</div>
</div>
</div>
</div>
</div>
</body>
</html>


