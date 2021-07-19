<?php

if(isset($_POST['add_rule'])) {
   
     $_SESSION['error'] = 0;
     
     if(($_POST['proto'] == "other") && empty($_POST['other_proto'])) {
             $_SESSION['error'] = 1;
     }

     if(($_POST['src_port'] != "on") && empty($_POST['src_port_val'])) {
           $_SESSION['error'] = 2;
      }
     if(($_POST['dst_port'] != "on") && empty($_POST['dst_port_val'])) {
           $_SESSION['error'] = 3;
      }
     if(!$_SESSION['error']) {
       if(!(empty($_POST['src_zone_add']))) {
         $src_zone = $_POST['src_zone_opt'].':'.$_POST['src_zone_add'];
       }else{
         $src_zone = $_POST['src_zone_opt'];
       } 

       if(!(empty($_POST['dst_zone_add']))) {
         $dst_zone = $_POST['dst_zone_opt'].':'.$_POST['dst_zone_add'];
       }else{
         $dst_zone = $_POST['dst_zone_opt'];
       }

       if($_POST['proto'] == "other") {
          $proto = $_POST['other_proto'];
       }else {
         $proto = $_POST['proto'];
       } 

       if($_POST['src_port'] == "on") {
         $src_port = "";
       }else {
          $src_port = $_POST['src_port_val'];
       }
       if($_POST['dst_port'] == "on") {
         $dst_port = "";
       }else {
          $dst_port = $_POST['dst_port_val'];
       }
       $rule = $_POST['action']."\t".$src_zone."\t".$dst_zone."\t".$proto."\t".$src_port."\t".$dst_port."\n";
       $command = 'sudo /usr/bin/spanbox.sh add_fw_rule '.$rule;
       exec($command);
/*
       $handle = @fopen("/etc/shorewall/rules", "r");
        $members = array();
        if ($handle) {
          while(($buffer = fgets($handle, 4096)) !== false) {
              $members[] = $buffer;
          }
          $members[] = $rule;
          fclose ($handle);
          echo $members[8];
          $handle = @fopen("/etc/shorewall/rules", "w");
          $i = count($members);
          echo $i;
          $j = 0;
          while($j < $i ) {
            fputs($handle, $members[$j]);
            $j = $j + 1;
          }
          fclose ($handle);
        }
*/
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
<script type="text/javascript">
function src_zone_check(box) {

    if(box.checked == true) {
      document.getElementById('src_zone_add').disabled = false;
    } else {
      document.getElementById('src_zone_add').disabled = true;
    }
}

function dst_zone_check(box) {

    if(box.checked == true) {
      document.getElementById('dst_zone_add').disabled = false;
    } else {
      document.getElementById('dst_zone_add').disabled = true;
    }
}

function report(val) {
 if(val == "other") {
      document.getElementById('other_proto').style.display = 'block';
 }else {
      document.getElementById('other_proto').style.display = 'none';
 }
}

function src_port_any(val) {
 if(val.checked == true) {
      document.getElementById('src_port_val').style.display = 'none';
 }else {
      document.getElementById('src_port_val').style.display = 'block';
 }
}
function dst_port_any(val) {
 if(val.checked == true) {
      document.getElementById('dst_port_val').style.display = 'none';
 }else {
      document.getElementById('dst_port_val').style.display = 'block';
 }
}

function submitform() {
  document.forms["add_rule_frm"].submit();
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
<div class="tabset0 pws_tabs_list" style="height: 700px;">
<div class="list-wrap">
<h3 style="margin-left:15px;">Rule Details </h3>
<?php 
  if($_SESSION['error'] == 1) {
    echo '<p style="color:#FF0000; margin-left:15px;">Error: please provide value for protocol</p>'; 
  }
  if($_SESSION['error'] == 2) {
    echo '<p style="color:#FF0000; margin-left:15px;">Error: please provide value for source port or select any</p>'; 
  }
  if($_SESSION['error'] == 3) {
    echo '<p style="color:#FF0000; margin-left:15px;">Error: please provide value for destination port or select any</p>'; 
  }

?>
<form method="post" action="" name="add_rule_frm">
<table>
<tr><td >Action</td>
<td>
<select name="action">
<option value="ACCEPT">ACCEPT</option>
<option value="DROP">DROP</option>
<option value="REJECT">REJECT</option>
</select>
</td></tr>

<tr><td>Source Zone</td>
<td>
<select name="src_zone_opt">
<option value="all">ANY</option>
<option value="in">IN</option>
<option value="out">OUT</option>
<option value="fw">FW</option>
</select>
</td>
<td><input type="checkbox" name="src_zone" id="src_zone" 
    onclick="src_zone_check(this);"> Address</td>
<td><input type="text" id="src_zone_add" name="src_zone_add" disabled="true"></td> 
</tr>
<br>

<tr><td>Destination Zone</td>
<td>
<select name="dst_zone_opt">
<option value="all">ANY</option>
<option value="in">IN</option>
<option value="out">OUT</option>
<option value="fw">FW</option>
</select>
</td>
<td><input type="checkbox" name="dst_zone" id="dst_zone"
    onclick="dst_zone_check(this);"> Address</td>
<td><input type="text" id="dst_zone_add" name="dst_zone_add" disabled="true"></td>
</tr>

<tr><td>Protocols</td>
<td>
<select name="proto" onchange="report(this.value);">
<option value="all">ANY</option>
<option value="tcp">TCP</option>
<option value="udp">UDP</option>
<option value="icmp">ICMP</option>
<option value="other">OTHER</option>
</select>
</td>
<td></td>
<td><input type="text" id="other_proto" name="other_proto" style="display:none;"></td>
</tr>

<tr><td>Source Port</td>
<td><input type="checkbox" name="src_port" id="src_port"
    onclick="src_port_any(this);">Any </td><td></td>
<td><input type="text" id="src_port_val" name="src_port_val" style="display:block;"></td>
</tr>

<tr><td>Destination Port</td>
<td><input type="checkbox" name="dst_port" id="dst_port"
    onclick="dst_port_any(this);">Any </td><td></td>
<td><input type="text" id="dst_port_val" name="dst_port_val" style="display:block;"></td>
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
</div>
</body>
</html>

