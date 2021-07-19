<?php
session_start();

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<link rel="stylesheet" type="text/css" href="css/login.css" />
<link type="text/css" rel="stylesheet" href="css/jquery.pwstabs.css">
<link type="text/css" rel="stylesheet" href="css/jquery.pwstabs.min.css">
<link type="text/css" rel="stylesheet" href="js/font-awesome/css/font-awesome.min.css">
<script src='js/ajax.js'></script>
<script type="text/javascript">
function host_check(box) {
  if(box.checked == true) {
    document.getElementById('Net').checked = false;
    document.getElementById('Host').checked = true;
  }else {
    document.getElementById('Net').checked = true;
    document.getElementById('Host').checked = false;
  }
}
function net_check(box) {
  if(box.checked == true) {
    document.getElementById('Net').checked = true;
    document.getElementById('Host').checked = false;
  }else {
    document.getElementById('Net').checked = false;
    document.getElementById('Host').checked = true;
  }
}
</script>
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

<h3 >NETWORK - ADD ROUTE</h3>
<br/>
<form method="post" action ="config_apply.php">
<table width="450px" style="margin-left:100px">
<tr> <td width="70px"></td><td width="45px"><input type="checkbox" name="Net"  id="Net" onclick="net_check(this);" checked>NET</td>
<td width="55px"><input type="checkbox" name="Host" id="Host" onclick="host_check(this);" >Host</td>
</tr>
<tr><td width="175px">Network/Host*</td><td><input type="text" name="net_host" id ="net_host" ></td></tr>
<tr><td>Netmask *</td><td><input type="text" name="route_netmask" 
  id ="route_netmask" > </td></tr>
<tr><td>Gateway * </td><td><input type="text" name="route_gateway" id ="route_gateway" </td></tr>
<tr><td>Metric</td><td><input type="text" name="route_metric" id ="route_metric" </td></tr>
<input type="hidden" name="route_apply" value=1>
<tr><td><input type="submit" value="Apply" /></td></tr>
</table>
</form>
<br><h3><br>
</div>
</div>
</div>
</div>
</body>
</html>


