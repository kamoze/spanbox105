<?php
session_start();
$_SESSION['error'] = 0;
if($_GET['error'] == 1) {
  $_SESSION['error'] = 1;
}
if($_SESSION['authenticated'] != true ) {
  header('location:main.php?id=error');
}
?>
<script type="text/javascript">
<!--
function dhcp_check(box) {
  document.getElementById('wan_ip').disabled = box.checked;
  document.getElementById('wan_ip').value = '';
  document.getElementById('wan_netmask').disabled = box.checked;
  document.getElementById('wan_netmask').value = '';
  document.getElementById('wan_gateway').disabled = box.checked;
  document.getElementById('wan_gateway').value= '';
  document.getElementById('wan_static').checked = false;
}
function static_check(box) {
  document.getElementById('wan_ip').disabled = false;
  document.getElementById('wan_netmask').disabled = false;
  document.getElementById('wan_gateway').disabled = false;
  document.getElementById('wan_dhcp').checked = false;
}

  /* IP */
  $command = "ifconfig eth0 | awk -F \":\" '/inet addr:/ {print $2}' | awk '{print $1}'";
  $ip = shell_exec($command);

  /* MASK */
  $command = "ifconfig eth0 | awk -F \"Mask:\" '/Mask/ {print $2}'";
  $mask =  shell_exec($command);

//-->
</script>
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
<div class="tabset0 pws_tabs_list" style="height: 1000px;">
<div class="list-wrap">

<h3 style="margin-left:15px;">WAN CONFIGURATION</h3>
<?php 
  if($_SESSION['error'] == 1) {
     echo '<p style="color:#FF0000; margin-left:15px;">Error: Please fill all mandatory fields</p>';

  }
?>
<form method="post" action ="lan_config.php">
<table width="450px" style="margin-left:100px">
<tr>
  <td width="175px"/> 
  <td width="125px"><input type="checkbox" name="wan_dhcp" value="wan_dhcp" id="wan_dhcp" onclick="dhcp_check(this);" >DHCP</td>
  <td width="125px"><input type="checkbox" name="wan_static" id="wan_static" value="wan_static" onclick="static_check(this);" >STATIC</td>
</tr>

<tr>
  <td width="175px">IP Address  <font style="color:#FF0000;">*</font></td>
  <td><input type="text" name="wan_ip" id ="wan_ip" value=<?php echo $_SESSION['wan_ip']; ?> ></td>
</tr>

<tr>
  <td>Netmask  <font style="color:#FF0000;">*</font></td>
  <td><input type="text" name="wan_netmask" id ="wan_netmask" value=<?php echo $_SESSION['wan_netmask']; ?>> </td>

</tr>

<tr>
  <td>Gateway</td>
  <td><input type="text" name="wan_gateway" id ="wan_gateway" value=<?php echo $_SESSION['wan_gateway']; ?>> </td>

</tr>
<tr><td width="175px"/> <td width="125px"><a href="network.php">
<img src="image/back.jpg" ></a></td>
<td width="125px"><input type="image" src="image/next.jpg" ></td></tr>
</table>
<input type="hidden" name="wan_login" value="1" />
</form>
<br><h3><br>
</div>
</div>
</div>
</div>
</body>
</html>


