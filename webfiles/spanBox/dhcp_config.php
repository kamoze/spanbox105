<?php 
session_start(); 
if($_GET['id'] == 'lan') {
  $_SESSION['name'] = '#LAN';
}
if($_GET['id'] == 'wlan') {

  $_SESSION['name'] = '#WLAN';
}

if(isset($_POST['dhcp_login'])) {
  echo 'hello'; 

  if($_SESSION['name'] == '#LAN') {
    $_SESSION['lan_dhcp_name'] = $_POST['dhcp_name'];
    $_SESSION['lan_dhcp_subnet'] = $_POST['dhcp_subnet'];
    $_SESSION['lan_dhcp_netmask'] = $_POST['dhcp_netmask'];
    $_SESSION['lan_dhcp_domain'] = $_POST['dhcp_domain'];
    $_SESSION['lan_dhcp_gateway'] = $_POST['dhcp_gateway'];
    $_SESSION['lan_dhcp_dns'] = $_POST['dhcp_dns'];
  }

  if($_SESSION['name'] == '#WLAN') {
    $_SESSION['wlan_dhcp_name'] = $_POST['dhcp_name'];
    $_SESSION['wlan_dhcp_subnet'] = $_POST['dhcp_subnet'];
    $_SESSION['wlan_dhcp_netmask'] = $_POST['dhcp_netmask'];
    $_SESSION['wlan_dhcp_domain'] = $_POST['dhcp_domain'];
    $_SESSION['wlan_dhcp_gateway'] = $_POST['dhcp_gateway'];
    $_SESSION['wlan_dhcp_dns'] = $_POST['dhcp_dns'];
  }

  if($_SESSION['name'] == '#LAN')  {

    header('Location: wlan_config.php');

  }  
  if($_SESSION['name'] == '#WLAN')  {

    header('Location: config_apply.php');

  }

}


?>
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
<div class="tabset0 pws_tabs_list" style="height: 667px;">
<div class="list-wrap">


<h3 style="margin-left:15px;">DHCP CONFIGURATION</h3>
<br/>
<form method="post" action="dhcp_config.php">
<table width="450px" style="margin-left:100px">
<tr><td colspan="3" >Enter DHCP information for the interface here </td></tr> 

<tr>
  <td>Name </td>
  <td><input type="text" name="dhcp_name" id ="dhcp_lan_name" value="<?php echo $_SESSION['name']; ?>"> </td>
</tr>
<br/>

  <td>Subnet </td>
  <td><input type="text" name="dhcp_subnet" id ="dhcp_subnet" > </td>
</tr>

<tr>
  <td>Netmask</td>
  <td><input type="text" name="dhcp_netmask" id ="dhcp_netmask" ></td>
</tr>
<br/>
<tr>
  <td>Domain</td>
  <td><input type="text" name="dhcp_domain" id ="dhcp_domain" ></td>
</tr>

<tr>
  <td>Gateway</td>
  <td><input type="text" name="dhcp_gateway" id ="dhcp_gateway" ></td>
</tr>
<br/>
<tr>
  <td>DNS</td>
  <td><input type="text" name="dhcp_dns" id ="dhcp_dns" ></td>
</tr>

<input type="hidden" name="dhcp_login" value="1" />
<tr> 
<td width="125px"><input type="image" src="image/next.png" ></td></tr>
<table>
</form>
<br><h3><br>
</div>
</div>
</div>
</div>
</body>
</html>


