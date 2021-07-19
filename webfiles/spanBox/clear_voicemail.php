<?php
session_start();
if($_SESSION['authenticated'] != true ) {
  header('location:main.php?id=error');
}

if(isset($_POST['rmvoice']))  {

 $command = 'sudo  /usr/bin/spanbox.sh clear_voicemail'; 
 exec($command);
}

?>
<script type="text/javascript">
function submitform() {
  document.forms["clear_voice"].submit();
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


<h3 style="margin-left:15px;">Voicemail Clear Directory</h3>
<div id="status_table">
<table width="700 px" style="margin-left:10 px; align:center;">
<tr>
<td  style="text-align:center;">
<form action="clear_voicemail.php" method="post" name="clear_voice" id="clear_voice">

<input type ="hidden" name="rmvoice" value="yes">
<input type ="button" value="Clear Voicemail Directory" name"rmvoice"
onClick="if(confirm('Do you want to clear the directory? This cannot be reversed!')) {
  submitform();
}
">
</form>
</td>
</tr>
</table>
<br/><br/>
<a href="voicemail.php"><img src="image/back.jpg" style="margin-left:75px;"></a>
<a href="pbx.php"><img src="image/next.jpg" style="margin-left:450;" />
<br><h3><br>
</div>
</div>
</div>
</div>
</div>
</body>
</html>


