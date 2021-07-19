<?php
session_start();

$_SESSION['error'] = 0;
if($_GET['error'] == 1) {
  $_SESSION['error'] = 1;
}

$_SESSION['lan_dhcp'] = 'no';
$_SESSION['lan_static'] = 'yes';


if(isset($_POST['wan_login'])) { 

 if(!isset($_POST['wan_dhcp'])) {
     if(empty($_POST['wan_ip']) || empty($_POST['wan_netmask'])) {
      header('location: wan_config.php?error=1');
    }
  }
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
  $command = "ifconfig eth1 | awk -F \":\" '/inet addr:/ {print $2}' | awk '{print $1}'";
  $ip = shell_exec($command);

   /* MASK */
  $command = "ifconfig eth1 | awk -F \"Mask:\" '/Mask/ {print $2}'";
  $mask =  shell_exec($command);

  if(isset($_POST['lan_login'])) { 

    if($_POST['lan_dhcp'] == 'on') {
      $_SESSION['lan_dhcp'] = 'yes';
      $_SESSION['lan_static'] = 'no';
      $_SESSION['lan_ip'] = $_POST['lan_ip'];
      $_SESSION['lan_gateway'] = $_POST['lan_gateway'];
      $_SESSION['lan_netmask'] = $_POST['lan_netmask'];
    } else {
      if($_POST['lan_static'] == 'on') {
         $_SESSION['lan_dhcp'] = 'no';
         $_SESSION['lan_static'] = 'yes';
         $_SESSION['lan_ip'] = $_POST['lan_ip'];
         $_SESSION['lan_gateway'] = $_POST['lan_gateway'];
         $_SESSION['lan_netmask'] = $_POST['lan_netmask'];
      } else {
         $_SESSION['lan_dhcp'] = 'yes';
         $_SESSION['lan_static'] = 'yes';
         $_SESSION['lan_ip'] = $_POST['lan_ip'];
         $_SESSION['lan_gateway'] = $_POST['lan_gateway'];
         $_SESSION['lan_netmask'] = $_POST['lan_netmask'];
      }
    }
    $error = 0;
    if(empty($_POST['lan_ip']) || empty($_POST['lan_netmask']) || empty($_POST['lan_gateway'])) {
      header('location: lan_config.php?error=1');
      $_SESSION['error'] = 1;
      $error = 1;
    }
    if(($_SESSION['lan_dhcp'] == 'yes') && ($error == 0))  {

      header('Location: dhcp_config.php?id=lan');

    }  else {
      if($error == 0)  {
        header('Location: wlan_config.php');
      }
    }
  }


?>
<script type="text/javascript">

function static_check(box) {
  if(box.checked == true) {
    document.getElementById('lan_both_i').checked = false;
  }else {
    document.getElementById('lan_both_i').checked = true;
  }

  document.getElementById('lan_ip').disabled = false;
  document.getElementById('lan_netmask').disabled = false;
  document.getElementById('lan_gateway').disabled = false;

}
function both_check(box) {
  if(box.checked == true) {
    document.getElementById('lan_static_i').checked = false;
  }else {
    document.getElementById('lan_static_i').checked = true;
  }
 

  document.getElementById('lan_ip').disabled = false;
  document.getElementById('lan_netmask').disabled = false;
  document.getElementById('lan_gateway').disabled = false;
}
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

<h3 style="margin-left:15px;">LAN CONFIGURATION</h3>
<?php 
  if($_SESSION['error'] == 1 ) {
    echo '<p style="color:#FF0000; margin-left:15px;">Error: Please fill all mandatory fields</p>';
  }
?>

<p>
<br/>
<form method="post" action ="lan_config.php">
<table width="450px" style="margin-left:100px">
<tr>
    <td width="125px"><input type="checkbox" name="lan_static"
        id="lan_static_i" onclick="static_check(this);" checked="true">STATIC </td> 
<!---
    <td width="50px"><input type="checkbox" name="lan_dhcp"
id="lan_dhcp_i" onclick="dhcp_check(this);" >DHCP </td>
-->
    <td width="50px"><input type="checkbox" name="lan_both"
id="lan_both_i"  onclick="both_check(this);"> DHCP SERVER </td>
</tr>
<tr></tr>
<tr><td width="175px">IP Address <font style="color:#FF0000;">*</font> </td>
    <td><input type="text" name="lan_ip" id ="lan_ip" value=<?php echo  $_SESSION['lan_ip']; ?>> </td></tr>
<tr><td>Netmask  <font style="color:#FF0000;">*</font></td>
    <td><input type="text" name="lan_netmask" 
  id ="lan_netmask" value=<?php echo $_SESSION['lan_netmask']; ?>> </td></tr>
<tr><td>Network <font style="color:#FF0000;">*</font></td>
    <td><input type="text" name="lan_gateway" 
  id ="lan_gateway" value=<?php echo $_SESSION['lan_gateway']; ?>> </td></tr>

<input type="hidden" name="lan_login" value="1" />
<tr></tr>
<tr></tr>
<tr>
<td width="175px"/> <td width="125px"><a href="wan_config.php">
<img src="image/back.jpg" ></a></td>
<td width="125px"><input type="image" src="image/next.jpg" ></td></tr>
</table>
</form>
<br><h3><br>
</div>
</div>
</div>
</div>
</body>
</html>


