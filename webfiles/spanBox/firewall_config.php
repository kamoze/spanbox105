<?php
session_start();
/* Check Authentication */
if($_SESSION['authenticated'] != true ) {
  header('location:main.php?id=error');
}
$_SESSION['rules'] = array();
$_SESSION['nat'] = array();
 

/* Reading contents of Rules */
$handle = @fopen("/etc/shorewall/rules", "r");
$buffer = array();
if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
        if($buffer[0] == "#") {
        }
        else {
          $_SESSION['rules'][] = $buffer; 
        } 
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}
     

/* Reading contents of NAT */
$buffer_nat = array();
$handle = @fopen("/etc/shorewall/nat", "r");
if ($handle) {
    while (($buffer_nat = fgets($handle, 4096)) !== false) {
        if($buffer_nat[0] == "#") {
        }
        else {
          $_SESSION['nat'][] = $buffer_nat; 
        } 
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}
?>
<script type="text/javascript">
function submitform() {
  document.forms["fw_rule"].submit();
}

function submitform_nat() {
  document.forms["nat_rule"].submit();
}
</script>
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


<h3 style="margin-left:15px;">RULES</h3>
<span class="cl-effect-8">
<a href="https://sb105.spanboxng.com:84/shorewall/" style="text-decoration:none;">Advanced FW</a>
</span>

<div id="network_table">
<form method="GET" id="fw_rule" name="fw_rule"  action="config_apply.php">
<table>
<tr><th style="width:15px"></th><th style="width:100px">Action</th><th style="width:100px">Source</th><th style="width:100px">Destination</th><th style="width:100px">Protocol</th><th style="width:100px">Source Port</th><th style="width:100px">Dest. Port</th></tr>
<?php
$i = count($_SESSION['rules']);
$j = 0 ;
while ($j < $i ) {
  $SplitContent = explode(" ", $_SESSION['rules'][$j]);
  foreach($SplitContent as $CurrValue)
  {
    $var[$j][] = $CurrValue;
  }
  if($var[$j][4] == 80) {
      $var[$j][4] = 'any';
      $var[$j][5] = 80;
  }
  echo '<tr><td><input type="checkbox" name="rule'.$j.'"  ></td><td>'.$var[$j][0].'</td><td>'.$var[$j][1].'</td><td>'.$var[$j][2].'</td><td>'.$var[$j][3].'</td><td>'.$var[$j][4].'</td><td>'.$var[$j][5].'</td></tr>';
  $j = $j + 1;
}
?>
<input type="hidden" name = "rule_del" value ="yes">
</table>
</form>
</div>
<br>
<table>
<tr><td width="500px">
<span class="cl-effect-8">
<a href="fw_add_rules.php" style="text-decoration:none;">Add Rules</a></td>
</span>
<td width="200px" align="right">
<span class="cl-effect-8">
<a href="javascript: submitform()" style="text-decoration:none;">Delete  Selected</a>
</span>
</td>
</tr>
</table>
<h3 style="margin-left:15px;">STATIC NAT</h3>
<div id="network_table">
<form method="GET" id="nat_rule" name="nat_rule"  action="config_apply.php">
<table>

<tr><th style="width:15px"></th><th style="width:100px">External Address</th><th style="width:100px">External Interface</th><th style="width:100px">Internal Interface</th></tr>

<?php
$i = count($_SESSION['nat']);
$j = 0 ;
while ($j < $i ) {
  $SplitContent = explode(" ", $_SESSION['nat'][$j]);
  foreach($SplitContent as $CurrValue)
  {
    $var_nat[$j][] = $CurrValue;
  }
  echo '<tr><td><input type="checkbox" name="rule'.$j.'" ></td><td>'.$var_nat[$j][0].'</td><td>'.$var_nat[$j][1].'</td><td>'.$var_nat[$j][2].'</td></tr>';
  $j = $j + 1;
}
?>
<input type="hidden" name = "nat_rule_del" value ="yes">
</table>
</form>
</div>



<br>
<table>
<tr><td width="500px">
<span class="cl-effect-8">
<a href="nat_add_rules.php" style="text-decoration:none;">Add NAT</a></span>
<td width="200px" align="right">
<span class="cl-effect-8">
<a href="javascript: submitform_nat()" style="text-decoration:none;">Delete  Selected</a>
</span>
</td>
</tr>
<tr><td width="175px"> <a href="firewall.php">
<img src="image/back.jpg" ></a></td>
</tr>
</table>
<br><h3><br>
</div>
</div>
</div>
</div>

</body>
</html>

