<?php
session_start();
if($_SESSION['authenticated'] != true ) {
  header('location:main.php?id=error');
}

if(isset($_POST['3gstaticunset']))  {

 $command = 'sudo  /usr/bin/spanbox.sh 3gstaticunset'; 
 exec($command);
}

?>
<script type="text/javascript">
function submitform() {
  document.forms["3gstaticunset"].submit();
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


<h3 style="margin-left:15px;">FAILOVER MODE SET FUNCTION</h3>
<div id="status_table">
<table width="700 px" style="margin-left:10 px; align:center;">
<tr>
<td  style="text-align:center;">
<form action="3gstaticunset.php" method="post" name="3gstaticunset" id="3gstaticunset">

<input type ="hidden" name="3gstaticunset" value="yes">
<input type ="button" value="Set Failover Network Mode" name"3gstaticunset"
onClick="if(confirm('Do you want to reset the device to WAN Ethernet/3G network mode? You can use both networks in failover mode!')) {
  submitform();
}
">
</form>
</td>
</tr>
</table>
<div id="status_table">
<table width="700 px" style="margin-left:10 px; align:center;">
<tr>
  <td width="150 px"><a href="3gstaticunset.php"><img src="image/3gstatic.png" /></a></td>
  <td width="400 px" style="text-align:center;">FAILOVER MODE STATUS</td>
  <td  width ="150 px">
    <?php  $i = exec('cat /usr/bin/connect.sh | grep "Z="$"test1"');
     if(strstr($i, "Z=$test1")) {
        echo '<img src="image/green.png" />';
      } else {
        echo '<img src="image/red.png" />';
      }
 ?>
  </td>
</tr>
</table>
<br/><br/><br/><br/>
<br/><br/><br/><br/>
<a href="3gstaticset.php"><img src="image/back.jpg" style="margin-left:75px;"></a>
<a href="network.php"><img src="image/next.jpg" style="margin-left:450;" />
<br><h3><br>
</div>
</div>
</div>
</div>
</div>
</body>
</html>


