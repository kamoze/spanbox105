<?php
session_start();
$_SESSION['error'] = 0;
if($_GET['error'] == 1) {
  $_SESSION['error'] = 1;
}


if($_SESSION['authenticated'] != true ) {
  header('location:main.php?id=error');
}
  /* IP */
  $command = "ifconfig uap0 | awk -F \":\" '/inet addr:/ {print $2}' | awk '{print $1}'";
  $ip = shell_exec($command);

   /* MASK */
  $command = "ifconfig uap0 | awk -F \"Mask:\" '/Mask/ {print $2}'";
  $mask =  shell_exec($command);
  if(isset($_POST['wlan_login'])) {
    $error = 0;
   if(empty($_POST['wlan_ip']) || empty($_POST['wlan_netmask'])) {
      header('location: wlan_config.php?error=1');
      $error = 1;
    }
 
    if($_POST['wlan_dhcp'] == 'on') {
      $_SESSION['wlan_dhcp'] = 'yes';
      $_SESSION['wlan_static'] = 'no';
      $_SESSION['wlan_ip'] = $_POST['wlan_ip'];
      $_SESSION['wlan_gateway'] = $_POST['wlan_gateway'];
      $_SESSION['wlan_netmask'] = $_POST['wlan_netmask'];
      $_SESSION['wlan_key'] = $_POST['wlan_key'];
    }
    else {
      if($_POST['wlan_static'] == 'on') {
         $_SESSION['wlan_dhcp'] = 'no';
         $_SESSION['wlan_static'] = 'yes';
         $_SESSION['wlan_ip'] = $_POST['wlan_ip'];
         $_SESSION['wlan_gateway'] = $_POST['wlan_gateway'];
         $_SESSION['wlan_netmask'] = $_POST['wlan_netmask'];
         $_SESSION['wlan_key'] = $_POST['wlan_key'];
      } else {
         $_SESSION['wlan_dhcp'] = 'yes';
         $_SESSION['wlan_static'] = 'yes';
         $_SESSION['wlan_ip'] = $_POST['wlan_ip'];
         $_SESSION['wlan_gateway'] = $_POST['wlan_gateway'];
         $_SESSION['wlan_netmask'] = $_POST['wlan_netmask'];
         $_SESSION['wlan_key'] = $_POST['wlan_key'];
      }
    }
    $_SESSION['wlan_login'] = 1;
    if($error == 0) {
      if($_SESSION['wlan_dhcp'] == 'yes') {
      
        header('Location: dhcp_config.php?id=wlan');
     
      }  else {
         header('Location: config_apply.php');
      }
    }
  }
  
 
?>
<script type="text/javascript">
<!--

function static_check(box) {
  if(box.checked == true) {
    document.getElementById('wlan_both_i').checked = false;
  }else {
    document.getElementById('wlan_both_i').checked = true;
  }

  document.getElementById('wlan_ip').disabled = false;
  document.getElementById('wlan_netmask').disabled = false;

}
function both_check(box) {
  if(box.checked == true) {
    document.getElementById('wlan_static_i').checked = false;
  }else {
    document.getElementById('wlan_static_i').checked = true;
  }

  document.getElementById('wlan_ip').disabled = false;
  document.getElementById('wlan_netmask').disabled = false;
}

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
<div class="tabset0 pws_tabs_list" style="height: 667px;">
<div class="list-wrap">


<h3 style="margin-left:15px;">WLAN CONFIGURATION</h3>
<?php
  if($_SESSION['error'] == 1 ) {
    echo '<p style="color:#FF0000; margin-left:15px;">Error: Please fill all mandatory fields</p>';
  }
?>
<br/>
<form name="wlan_form" id="wlan_form" method="post" action="wlan_config.php">
<table width="450px" style="margin-left:100px">
<tr>
  <td width="125px"><input type="checkbox" name="wlan_static" 
    id="wlan_static_i"  onclick="static_check(this);" checked="true">STATIC</td>

<!--
  <td width="50px"><input type="checkbox" name="wlan_dhcp" 
    id="wlan_dhcp_i" onclick="dhcp_check(this);" >DHCP</td>
-->

  <td width="50px"><input type="checkbox" name="wlan_both" 
    id="wlan_both_i"  onclick="both_check(this);" >DHCP SERVER</td>
</tr>
<tr><td width="175px">IP Address  <font style="color:#FF0000;">*</font></td>
    <td><input type="text" name="wlan_ip" id ="wlan_ip" 
        value="<?php echo $_SESSION['wlan_ip']; ?>" ></td></tr>
<tr><td>Netmask  <font style="color:#FF0000;">*</font></td>
    <td><input type="text" name="wlan_netmask" 
  id ="wlan_netmask" value="<?php echo $_SESSION['wlan_netmask']; ?>"> </td></tr>
<tr><td>Wireless Key</td><td><input type="text" name="wlan_key" id ="wlan_key" value="<?php echo $_SESSION['wlan_key'] ?>" ></td></tr>
<input type="hidden" name="wlan_login" value="1" />
<input type="hidden" name="lan_dhcp" value="<?php echo $_SESSION['lan_dhcp']; ?>" />
<tr><td width="175px"/> <td width="125px"><a href="lan_config.php">
<img src="image/back.jpg" ></a></td>
<td width="125px"><input type="image" src="image/next.jpg" ></td></tr>
<table>
</form>
<br><h3><br>
</div>
</div>
</div>
</div>
</body>
</html>


