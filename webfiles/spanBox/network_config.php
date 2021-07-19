<?php
session_start();

if($_SESSION['authenticated'] != true ) {
  header('location:main.php?id=error');
}

$i = shell_exec("/sbin/ifconfig -a | sed 's/[ \t].*//;/^$/d'");
$_SESSION['dev'] = preg_split('/\s+/', $i);
$dev = $_SESSION['dev'];

$j = 0;
while($j < (count($dev) - 1)) {
  /* IP */
  $command = "/sbin/ifconfig ".$dev[$j]." | awk -F \":\" '/inet addr:/ {print $2}' | awk '{print $1}'";
  $ip[$j] = shell_exec($command);
 
  /* MASK */
  $command = "/sbin/ifconfig ".$dev[$j]." | awk -F \"Mask:\" '/Mask/ {print $2}'";
  $mask[$j] =  shell_exec($command);

  /* MAC */
  $command = "/sbin/ifconfig ".$dev[$j]." | awk '/HWaddr/ {print $5}'";
  $mac[$j] =  shell_exec($command);

  /* B'CAST */
  $command = "/sbin/ifconfig ".$dev[$j]." | awk '/BROADCAST/ {print $1}'";
  $bcast[$j] =  shell_exec($command);
  $j = $j + 1;
}
$_SESSION['ip'] = $ip;
$_SESSION['mask'] = $mask;
$_SESSION['mac'] = $mac;
$_SESSION['bcast'] = $bcast;
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


<h3 style="margin-left:15px;">NETWORK</h3>
<tr>
  <td width="200 px" style="text-align:right;"></td>
  <td  width ="350 px" style="border:0px solid green;
                              opacity:0.6;
                              filter:alpha(opacity=60); /* For IE8 and earlier */
                              padding-top:5px;
                              background-color:;">
                                                          <span class="cl-effect-8">
    <a href="advancednet.php" style="text-decoration:none;"> Advanced Net Cfg - IP Tracking</a>
        </span>
    </form>
  </td>
  <td width="10 px"></td>
</tr>
<tr>
  <td width="200 px" style="text-align:right;"></td>
  <td  width ="350 px" style="border:0px solid green;
                              opacity:0.6;
                              filter:alpha(opacity=60); /* For IE8 and earlier */
                              padding-top:5px;
                              background-color:;">
                                                          <span class="cl-effect-8">
    <a href="networksync.php" style="text-decoration:none;"> Advanced Net Cfg - Network Sync</a>
        </span>
    </form>
  </td>
  <td width="10 px"></td>
</tr>

<div id="network_table">
<table >
<tr><th style="width:100px">Device</th><th style="width:80px">Type</th><th style="width:120px">IP</th><th style="width:120px">Mask</th><th style="width:100px">MAC</th><th style="width:100px">Status</th></tr>
<?php 
$i = count($_SESSION['dev']);
$j = 0 ;
$dev = $_SESSION['dev'];
$ip = $_SESSION['ip'];
$mask = $_SESSION['mask'];
$mac = $_SESSION['mac'];
$bcast = $_SESSION['bcast'];
while ($j < ($i -1)) {
  if($dev[$j] == 'eth0') {
   $alink = 'wlan_config.php';
  }
  echo '<tr><td>'.$dev[$j].'</td><td></td><td>'.$ip[$j].'</td><td>'.
        $mask[$j].'</td><td>'.$mac[$j].'</td><td>'.$bcast[$j].'</td></tr>';
  $j = $j + 1;
}
?>
</table>
<br/>
<h4 style="text-align:right;margin-right:15px;">
<span class="cl-effect-8">
<a href="route_display.php" style="text-decoration:none;">View Network Routes</h4>
</span>
<br>
<a href="network.php"><img src="image/back.jpg" style="margin-left:75px;"></a>
</div>
</div>
</div>
</div>
</div>
</body>
</html>


