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
if(isset($_POST['service'])){
     exec('sudo  /usr/bin/spanbox.sh service'); 
}
if(isset($_POST['trunk_start'])){
        exec('sudo  /usr/bin/spanbox.sh trunk_start');
}
if(isset($_POST['trunk_stop'])){
 exec('sudo  /usr/bin/spanbox.sh trunk_stop');
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

<h3 style="margin-left:15px;">VoIP-Connect Trunk</h3>
<div id="status_table">
<table width="700 px" style="margin-left:10 px; align:center;">
<tr>

<tr>
  <td width="400 px" style="text-align:center;">STATUS</td>
  <td  width ="150 px">
    <?php  $i = exec('sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountStatusGet VC | grep "Session Established" | awk "{print $1}"');
     if(strstr($i, "Session")) {
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
  <td width="400 px" style="text-align:center;">ENABLE TRUNK ACCESS</td>
  <td  width ="150 px">
    <form method="POST">
     <input type="image" name="trunk_start" value="trunk_start" src="image/start.png">
    </form>
  </td>
</tr>

<tr>
  <td width="400 px" style="text-align:center;">DISABLE TRUNK ACCESS</td>
  <td  width ="150 px">
    <form method="POST">
     <input type="image" name="trunk_stop" value="trunk_stop" src="image/stop.png">
    </form>
  </td>
</tr>

</tr>
  <td width="400 px" style="text-align:center;">CONFIGURE</td>
  <td  width ="150 px">
   <a href="vc_config.php"><img src="image/configure.png" /></a>
  </td>
</tr>


</table>

<a href="pbx.php"><img src="image/back.jpg" style="margin-left:75px;"></a>
<br/><h3><br/>
</div>
</div>
</div>
</div>
</div>
</body>
</html>


