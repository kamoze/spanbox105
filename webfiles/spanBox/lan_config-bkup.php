<?php
session_start();

if(isset($_POST['wan_login'])) { 
  if(isset($_POST['wan_dhcp'])) {
    $_SESSION['wan_dhcp'] = 'yes';
  }else {
    $_SESSION['wan_dhcp'] = 'no';
  }

  if(isset($_POST['wan_static'])) {
    $_SESSION['wan_static'] = 'yes';
  }else {
    $_SESSION['wan_static'] = 'no';
  }

  $_SESSION['wan_ip'] = $_POST['wan_ip'];
  $_SESSION['wan_gateway'] = $_POST['wan_gateway'];
  $_SESSION['wan_netmask'] = $_POST['wan_netmask'];
}

  /* IP */
  $command = "ifconfig eth0 | awk -F \":\" '/inet addr:/ {print $2}' | awk '{print $1}'";
  $ip = shell_exec($command);

   /* MASK */
  $command = "ifconfig eth0 | awk -F \"Mask:\" '/Mask/ {print $2}'";
  $mask =  shell_exec($command);

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript">
<!--
function dhcp_check(box) {
  document.getElementById('lan_ip').disabled = box.checked;
  document.getElementById('lan_netmask').disabled = box.checked;
  document.getElementById('lan_gateway').disabled = box.checked;
  document.getElementById('lan_static').checked = false;
}
function static_check(box) {
  document.getElementById('lan_ip').disabled = false;
  document.getElementById('lan_netmask').disabled = false;
  document.getElementById('lan_gateway').disabled = false;
  document.getElementById('lan_dhcp').checked = false;
}
//-->
</script>
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


<h3 style="margin-left:15px;">LAN CONFIGURATION</h3>
<br/>
<form method="post" action ="wlan_config.php">
<table width="450px" style="margin-left:100px">
<tr><td width="175px"/> <td width="125px"><input type="checkbox" name="lan_dhcp" value="lan_dhcp" id="lan_dhcp" onclick="dhcp_check(this);" >DHCP Server</td>
</tr>
<tr><td width="175px">IP Address *</td><td><input type="text" name="lan_ip" id ="lan_ip" value=<?php echo $ip; ?> ></td></tr>
<tr><td>Netmask *</td><td><input type="text" name="lan_netmask" 
  id ="lan_netmask" value=<?php echo $mask; ?>> </td></tr>
<tr><td>Gateway</td><td><input type="text" name="lan_gateway" id ="lan_gateway" </td></tr>
<input type="hidden" name="lan_login" value="1" />
<tr><td><input type="submit" value="NEXT" /></td></tr>
</table>
</form>

</div>
</div>
</div>
</div>
</body>
</html>


