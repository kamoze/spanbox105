<?php
session_start();
if($_SESSION['authenticated'] != true ) {
  header('location:main.php?id=error');
}
if(isset($_POST['sync_start'])){
 exec('sudo  /usr/bin/spanbox.sh sync_start');
}
if(isset($_POST['sync_stop'])){
 exec('sudo  /usr/bin/spanbox.sh sync_stop');
}
?>
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

<h3 style="margin-left:15px;">Network Sync - WAN</h3>
<div id="status_table">
<table width="700 px" style="margin-left:10 px; align:center;">
<tr>

<tr>
  <td width="400 px" style="text-align:center;">STATUS</td>
  <td  width ="150 px">
<?php  
	$i = exec('grep -rl "1" /usr/bin/checkiprouterun.txt ');
     if(strstr($i, "/usr/bin/checkiprouterun.txt")) {
        echo '<img src="image/green.png" />';
      } else {
        echo '<img src="image/red.png" />';
      }
    ?>
  </td>
</tr>

<tr>
</tr>

<tr>
  <td width="400 px" style="text-align:center;">ENABLE NETWORK SYNC</td>
  <td  width ="150 px">
    <form method="POST">
     <input type="image" name="sync_start" value="sync_start" src="image/start.png">
    </form>
  </td>
</tr>

<tr>
  <td width="400 px" style="text-align:center;">DISABLE NETWORK SYNC</td>
  <td  width ="150 px">
    <form method="POST">
     <input type="image" name="sync_stop" value="sync_stop" src="image/stop.png">
    </form>
  </td>
</tr>

</tr>
  <td width="400 px" style="text-align:center;">CONFIGURE</td>
  <td  width ="150 px">
   <a href="netsync_config.php"><img src="image/configure.png" /></a>
  </td>
</tr>


</table>

<a href="vpn_config.php"><img src="image/back.jpg" style="margin-left:75px;"></a>
<br/><h3><br/>
</div>
</div>
</div>
</div>
</div>
</body>
</html>


