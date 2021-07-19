<?php
session_start();
if($_SESSION['authenticated'] != true ) {
  header('location:main.php?id=error');
}
$i = shell_exec("route -n | wc -l ");

/* destination */
$dest = shell_exec("route -n | sed -n '3~1p'|awk '{print $1}'");
$_SESSION['dest'] = preg_split('/\s+/', $dest);

/* Gateway */
$gate = shell_exec("route -n | sed -n '3~1p'|awk '{print $2}'");
$_SESSION['gate'] = preg_split('/\s+/', $gate);
 
/* MASK */
$genmask = shell_exec("route -n | sed -n '3~1p'|awk '{print $3}'");
$_SESSION['genmask'] = preg_split('/\s+/', $genmask);

/* METRIC */
$metric = shell_exec("route -n | sed -n '3~1p'|awk '{print $5}'");
$_SESSION['metric'] = preg_split('/\s+/', $metric);

/*IFACE */
$iface = shell_exec("route -n | sed -n '3~1p'|awk '{print $8}'");
$_SESSION['iface'] = preg_split('/\s+/', $iface);
?>
<script type="text/javascript">
function submitform() {
  document.forms["form_route"].submit();
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


<h3 style="margin-left:15px;">ROUTE</h3>
<div id="network_table">
<form method="GET" id="form_route" name="form_route"  action="config_apply.php">
<table >
<tr><th style="width:20px"></th><th style="width:100px">Destination</th><th style="width:100px">Gateway</th><th style="width:100px">Genmask</th><th style="width:40px">Metric</th><th style="width:100px">Iface</th></tr>
<?php 
$i = count($_SESSION['dest']);
$j = 0 ;
$dest = $_SESSION['dest'];
$gate = $_SESSION['gate'];
$genmask = $_SESSION['genmask'];
$metric = $_SESSION['metric'];
$iface = $_SESSION['iface'];
while ($j < ($i -1)) {
  echo '<tr><td><input type="checkbox" name="route'.$j.'" ></td><td>'.$dest[$j].'</td><td>'.$gate[$j].'</td><td>'.
        $genmask[$j].'</td><td>'.$metric[$j].'</td><td>'.$iface[$j].'</td></tr>';
  $j = $j + 1;
}
?>
</table>
<br>
<table style="border:none;">
<tr ><td style="border:none;">
<span class="cl-effect-8" style="text-align:left;margin-left:15px;">
<a href="add_route.php"  style="text-decoration:none;">Add Route</a></span></td>
<td style="border:none">
<span class="cl-effect-8" style="text-align:left;margin-left:15px;">
<a href="javascript: submitform()" style="text-decoration:none;">Delete Selected</a></span></td>
</tr>
</table>
<input type="hidden" name = "del" value ="yes">
</form>
<a href="status.php"><img src="image/back.jpg" style="margin-left:75px;"></a>
<br/><h3><br>
</div>
</div>
</div>
</div>
</div>
</body>
</html>


