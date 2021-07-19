<?php
session_start();

/* Deletion of FW Rules */
if($_GET['rule_del'] == 'yes')  {
  $i = count($_SESSION['rules']);
  $j = 0;
  while ($j < $i ) {
    $param = "rule".$j;
    if($_GET[$param] == "on") {
         
         $k = $j + 1;
         $command = $command.'-e '.$k.'d ';
    }
         $j = $j + 1;
  }
         $command = 'sudo  /usr/bin/spanbox.sh rule_del '.$command;
         exec($command);

         header('location:firewall_config.php?id=del_fw');

}

/* Deletion of FW NAT Rules */
if($_GET['nat_rule_del'] == 'yes')  {
  $i = count($_SESSION['nat']);
  $j = 0;
  while ($j < $i ) {
    $param = "rule".$j;
    if($_GET[$param] == "on") {
         
         $k = $j + 1;
         $command = $command.'-e '.$k.'d ';
    }
         $j = $j + 1;
  }
         $command = 'sudo  /usr/bin/spanbox.sh nat_rule_del '.$command;
         exec($command);
         header('location:firewall_config.php?id=del_nat');

}

if($_GET['del'] == 'yes')  {
  $i = count($_SESSION['dest']); 
  $j = 0;
  while ($j < ($i -1)) {
    $param = "route".$j;
    if($_GET[$param] == "on") {
       if($_SESSION['genmask'][$j] == "255.255.255.255") { 
         $command = 'sudo  /usr/bin/spanbox.sh route_del_host '.$_SESSION['dest'][$j];
       }else {
         $command = 'sudo  /usr/bin/spanbox.sh route_del_net '.$_SESSION['dest'][$j].' '.$_SESSION['genmask'][$j];
       }
       exec($command);
    }
    $j = $j + 1;
  }

}
if(isset($_POST['route_apply'])) {
  if(empty($_POST['route_metric'])) {
    $metric = 1; 
  }
  else {
    $metric = $_POST['route_metric']; 
  }
  if($_POST['Host'] == "on") {
  $command = 'sudo  /usr/bin/spanbox.sh route_add_host '.$_POST['net_host'].' '.$_POST['route_gateway'].' '.$metric;
  exec($command);
  }
  if($_POST['Net'] == "on") {
  $command = 'sudo  /usr/bin/spanbox.sh route_add_net '.$_POST['net_host'].' '.$_POST['route_netmask'].' '.$_POST['route_gateway'].' '.$metric;
  exec($command);
  }

}
if($_SESSION['wlan_login'] == '1') { 

  /* Wan Params */ 
  $wan_dhcp =  $_SESSION['wan_dhcp'];
  $wan_static = $_SESSION['wan_static']; 
  $wan_ip = $_SESSION['wan_ip'];
  $wan_gateway = $_SESSION['wan_gateway'];
  $wan_netmask =  $_SESSION['wan_netmask'];

  if(empty($wan_ip)) {
    $command = "cat /etc/network/interfaces |  awk -F \"eth0\"  '/address/ {print $1}' | sed -n '1p' | awk '{print $2}'";
    $wan_ip = shell_exec($command);
    $wan_ip = trim($wan_ip);
  }
  if(empty($wan_gateway)) {
    $command = "cat /etc/network/interfaces |  awk -F \"eth0\"  '/network/ {print $1}' | sed -n '1p' | awk '{print $2}'";
     $wan_gateway = shell_exec($command);
     $wan_gateway = trim($wan_gateway);
  }
  if(empty($wan_netmask)) {
    $command = "cat /etc/network/interfaces |  awk -F \"eth0\"  '/netmask/ {print $1}' | sed -n '1p' | awk '{print $2}'";
     $wan_netmask = shell_exec($command);
     $wan_netmask = trim($wan_netmask);
  }

  /* Lan Params */ 
  $lan_dhcp =  $_SESSION['lan_dhcp'];
  $lan_static = $_SESSION['lan_static']; 
  $lan_ip =  $_SESSION['lan_ip'];
  $lan_gateway = $_SESSION['lan_gateway'];
  $lan_netmask =  $_SESSION['lan_netmask'];

 /* If lan Params are empty, extract them from the existing config */
  if(empty($lan_ip)) {
    $command = "cat /etc/network/interfaces |  awk -F \"eth1\"  '/address/ {print $1}' | sed -n '2p' | awk '{print $2}'";
    $lan_ip = shell_exec($command);
    $lan_ip = trim($lan_ip);
  }
  if(empty($lan_gateway)) {
    $command = "cat /etc/network/interfaces |  awk -F \"eth1\"  '/network/ {print $1}' | sed -n '2p' | awk '{print $2}'";
    $lan_gateway = shell_exec($command);
    $lan_gateway = trim($lan_gateway);
  }
  if(empty($lan_netmask)) {
    $command = "cat /etc/network/interfaces |  awk -F \"eth1\"  '/netmask/ {print $1}' | sed -n '2p' | awk '{print $2}'";
    $lan_netmask = shell_exec($command);
    $lan_netmask = trim($lan_netmask);
  }
  
  /* WLan Params */ 
  $wlan_dhcp =  $_SESSION['wlan_dhcp'];
  $wlan_static = $_SESSION['wlan_static']; 
  $wlan_ip =  $_SESSION['wlan_ip'];
  $wlan_gateway = $_SESSION['wlan_gateway'];
  $wlan_netmask =  $_SESSION['wlan_netmask'];
  $wlan_key =  $_SESSION['wlan_key'];

 /* If Wlan Params are empty, extract them from the existing config */
  if(empty($wlan_ip)) {
    $command = "cat /etc/network/interfaces | awk -F up '/netmask / {print $1}' | sed -n '3p' | awk '{print $3}'";


    $wlan_ip = shell_exec($command);
    $wlan_ip = trim($wlan_ip);
  }

  if(empty($wlan_netmask)) {
    $command = "cat /etc/network/interfaces | awk -F \"upa0\" '/up/ {print $1}' |sed -n '1p' | awk '{print $5}'";  
    $wlan_netmask = shell_exec($command);
    $wlan_netmask = trim($wlan_netmask);
  }

  /* DHCP Params */

  if($lan_dhcp == 'yes' || $wlan_dhcp == 'yes' || $wan_dhcp == 'yes') {
    $dhcp_set = 'yes';
  }    

  /* Initial Config */
  $command = 'sudo  /usr/bin/spanbox.sh network_config ';  
  exec($command);

  /* Clean the DHCP File if DHCP is set */
  if($dhcp_set == 'yes') {
    
    $command = 'sudo  /usr/bin/spanbox.sh dhcp_clean'; 
    exec($command);
  }

 /* Apply Wan Configuration */
  $command = 'sudo  /usr/bin/spanbox.sh wan_config '.$wan_dhcp.' '.$wan_static.' '.$wan_ip.' '.$wan_gateway.' '.$wan_netmask;

  exec($command);



  /* Apply LAN Configuration */ 
  if($lan_static == 'yes') {
    $command = 'sudo  /usr/bin/spanbox.sh lan_config no yes '.$lan_ip.' '.$lan_gateway.' '.$lan_netmask; 

    exec($command);
    }
    
  if($lan_dhcp == 'yes') {
      $lan_dhcp_name = trim($_SESSION['lan_dhcp_name']);
      $lan_dhcp_subnet = trim($_SESSION['lan_dhcp_subnet']);
      $lan_dhcp_netmask = trim($_SESSION['lan_dhcp_netmask']);
      $lan_dhcp_domain = trim($_SESSION['lan_dhcp_domain']);
      $lan_dhcp_gateway = trim($_SESSION['lan_dhcp_gateway']);
      $lan_dhcp_dns = trim($_SESSION['lan_dhcp_dns']);

      $command = 'sudo  /usr/bin/spanbox.sh lan_config yes no '.
                 $lan_dhcp_subnet.' '.
                 $lan_dhcp_netmask.' '.
                 $lan_dhcp_domain.' '.
                 $lan_dhcp_gateway.' '.
                 $lan_dhcp_dns;
      
    exec($command);
    }
  /* Apply WLAN Configuration */
  if($wlan_static == 'yes') {

    $command = 'sudo  /usr/bin/spanbox.sh wlan_config no yes '.$wlan_ip.' '.$wlan_netmask.' '.$wlan_key;

    exec($command);
   } 

  if($wlan_dhcp == 'yes') {
      $wlan_dhcp_name = trim($_SESSION['wlan_dhcp_name']);
      $wlan_dhcp_subnet = trim($_SESSION['wlan_dhcp_subnet']);
      $wlan_dhcp_netmask = trim($_SESSION['wlan_dhcp_netmask']);
      $wlan_dhcp_domain = trim($_SESSION['wlan_dhcp_domain']);
      $wlan_dhcp_gateway = trim($_SESSION['wlan_dhcp_gateway']);
      $wlan_dhcp_dns = trim($_SESSION['wlan_dhcp_dns']);

      $command = 'sudo  /usr/bin/spanbox.sh wlan_config yes no '.
                $wlan_dhcp_subnet.' '.
                $wlan_dhcp_netmask.' '.
                $wlan_dhcp_domain.' '.
                $wlan_dhcp_gateway.' '.
                $wlan_dhcp_dns;

      exec($command);
   }
   if(!empty($wlan_key)) {
      $command = 'sudo  /usr/bin/spanbox.sh wlan_key_apply '.$wlan_key;
      exec($command);
   }
 

  /* Start up Script */ 
  $command = 'sudo  /usr/bin/spanbox.sh network_startup '.$wlan_ip.' '.$wlan_netmask; 
  exec($command);

  if($wlan_dhcp = 'yes' || $wan_dhcp = 'yes' || $lan_dhcp = 'yes') {
    
    $command = 'sudo  /usr/bin/spanbox.sh dhcp_renew'; 
    exec($command);
  }
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


<h3 style="margin-left:15px;">Configuration Applied Successfully</h3>

<br/>
<a href="status.php"><img src="image/back.jpg" style="margin-left:75px;"></a>
<br><h3><br>
</div>
</div>
</div>
</div>
</div>
</body>
</html>


