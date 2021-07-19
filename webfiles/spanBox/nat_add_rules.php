<?php

if(isset($_POST['add_rule'])) {
   
     $_SESSION['error'] = 0;
     
     if(empty($_POST['ext_add'])) {
             $_SESSION['error'] = 1;
     }
     if(empty($_POST['int_add'])) {
             $_SESSION['error'] = 2;
     }


     if(!$_SESSION['error']) {
 
       $ext_add = $_POST['ext_add'];
       $int_add = $_POST['int_add'];
       $ext_int_opt = $_POST['ext_int_opt'];

       if($_POST['active_host_yes'] == "on") {
         $active_host = "yes";
       }else {
         $active_host = "no";
       }
       
       if($_POST['active_fw_yes'] == "on") {
         $active_fw = "yes";
       }else {
         $active_fw = "no";
       }
       $rule = $ext_add."\t".$ext_int_opt."\t".$int_add."\t".$active_host."\t".$active_fw."\n";
       $command = 'sudo /usr/bin/spanbox.sh add_nat_rule '.$rule;
       exec($command);
      }

}

?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript">


function active_host_y(val) {
      document.getElementById('active_host_no').checked = false;
}

function active_host_n(val) {
      document.getElementById('active_host_yes').checked = false;
}

function active_fw_y(val) {
      document.getElementById('active_fw_no').checked = false;
}

function active_fw_n(val) {
      document.getElementById('active_fw_yes').checked = false;
}
function submitform() {
  document.forms["add_rule_frm"].submit();
}
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

<h3 style="margin-left:15px;">Firewall NAT Rule Details </h3>
<?php 
  if($_SESSION['error'] == 1) {
    echo '<p style="color:#FF0000; margin-left:15px;">Error: please provide External IP Address</p>'; 
  }
  if($_SESSION['error'] == 2) {
    echo '<p style="color:#FF0000; margin-left:15px;">Error: please provide Internal IP Address</p>'; 
  }

?>
<form method="post" action="" name="add_rule_frm">
<table>

<tr><td>External Address</td>
<td><input type="text" id="ext_add" name="ext_add" ></td> 
</tr>

<tr><td>External Interface</td>
<td>
<select name="ext_int_opt">
<option value="eth0">eth0</option>
<option value="ppp0">ppp0</option>
</select>
</td>
</tr>

<tr><td>Internal Address</td>
<td><input type="text" id="int_add" name="int_add" ></td> 
</tr>


<tr><td>Active For All Hosts</td>
<td><input type="checkbox" name="active_host_yes" id="active_host_yes"
    onclick="active_host_y(this);" checked="true">Yes </td><td></td>
<td><input type="checkbox" name="active_host_no" id="active_host_no"
    onclick="active_host_n(this);">No </td><td></td>
</tr>

<tr><td>Active For All Firewall</td>
<td><input type="checkbox" name="active_fw_yes" id="active_fw_yes"
    onclick="active_fw_y(this);" checked="true">Yes </td><td></td>
<td><input type="checkbox" name="active_fw_no" id="active_fw_no"
    onclick="active_fw_n(this);">No </td><td></td>
</tr>
<input type="hidden" name="add_rule" value="true">
<tr><td colspan="6" align="center">
<input type="button" value="Apply Configuration"
onClick="if(confirm('Do you want to add the rule?')) {
  submitform();}"
>
</td></tr>
</table>

</form>

<a href="firewall_config.php"><img src="image/back.jpg" style="margin-left:75px;"></a>
<br>
<br>

</div>
</div>
</div>
</div>
</body>
</html>

