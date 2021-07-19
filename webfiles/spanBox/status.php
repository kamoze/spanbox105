<?php
session_start();
if($_SESSION['authenticated'] != true) {
$auth = false;
$pwfile = fopen("users.txt", "r");
while (!feof($pwfile)) {
  $data = split(":", rtrim(fgets($pwfile, 1024)));
  if ($_POST['username'] == $data[0] && crypt($_POST['password'], "pw") == $data[1]) {
    $auth = true;
    break;
  }
}
fclose($pwfile);
if($auth == true) {
$_SESSION['authenticated'] = true;
}
else {
$_SESSION['authenticated'] = false;
header('location:main.php?id=error');
}
}
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<link type="text/css" rel="stylesheet" href="css/jquery.pwstabs.css">
<link type="text/css" rel="stylesheet" href="css/jquery.pwstabs.min.css">
<link type="text/css" rel="stylesheet" href="js/font-awesome/css/font-awesome.min.css">
<script type="text/javascript" src="js/ajax.js"></script>
<script>
$(function() {
     var pgurl = window.location.href.substr(window.location.href
.lastIndexOf("/")+1);
     $("#nav ul li a").each(function(){
          if($(this).attr("href") == pgurl || $(this).attr("href") == '' )
          $(this).addClass("active");
     })
});
	</script>
</head>
<body>
<div class="content">
	

<div id="page-wrap">

<div class="header">
      <div id="main_heading"> The SpanBOX 105 Web Manager <span><?php include 'footer.php' ?></span></div>
   </div><!-- header -->
<div class="pws_tabs_container pws_tabs_horizontal pws_tabs_horizontal_top pws_scale">
<menu id="nav"> 
<ul class="nav pws_tabs_controll">
<li><a  href="status.php">Status</a></li>
<li><a  href="mgmt.php">Management</a></li>
<li><a  href="pbx.php">PBX</a></li>
<li><a  href="network.php">Network</a></li>
<li><a  href="vpn.php">VPN-Connect</a></li>
<li><a href="firewall.php">Firewall</a></li>
<li><a href="webfilter.php">WebFilter</a></li>
</ul>
</menu>
<br>
</div>
<div class="tabset0 pws_tabs_list" style="height: 667px;">
		
		<div class="list-wrap">
		


<h3 >STATUS </h3>
<div id="status_table">
<table width="700 px" style="margin-left:50px;; align:center;border:none;">
<tr >
  <td width="150 px"><a href="pbx.php"><i class="fa fa-phone fa-fw"></a></td>
  <td width="400 px" style="text-align:center;"><h4>PBX</h4></td>
  <td  width ="150 px">
    <?php  $i = exec('/etc/init.d/asterisk status '); 
      if(strstr($i, "asterisk is running")) {
        echo '<img src="image/traffic_green.jpg" />';
      } else {
        echo '<img src="image/traffic_red.jpg" />';
      } 
    ?>
  </td>
</tr>

<tr>
  <td width="150 px"><a href="network.php"><i class="fa fa-globe fa-fw"></a></td>
  <td width="400 px" style="text-align:center;"><h4>NETWORK</h4></td>
  <td  width ="150 px">
    <?php  $i = exec('/sbin/route -n | grep "0.0.0.0" | grep "UG"'); 
      if(strstr($i, "UG")) {
        echo '<img src="image/traffic_green.jpg" />';
      } else {
        echo '<img src="image/traffic_red.jpg" />';
      } 
    ?>
  </td>
</tr>

<tr>
  <td width="150 px"><a href="vpn.php"><i class="fa fa-plug fa-fw"></a></td>
  <td width="400 px" style="text-align:center;"><h4>VPN-CONNECT</h4></td>
  <td  width ="150 px">
    <?php  $i = exec('sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD VersionGet | grep "completed"'); 
      if(strstr($i, "successfully")) {
        echo '<img src="image/traffic_green.jpg" />';
      } else {
        echo '<img src="image/traffic_red.jpg" />';
      } 
    ?>
  </td>
</tr>

<tr>
  <td width="150 px"><a href="firewall.php"><i class="fa fa-lock fa-fw"></a></td>
  <td width="400 px" style="text-align:center;"><h4>FIREWALL</h4></td>
  <td  width ="150 px">
    <?php  $i = exec('sudo /sbin/shorewall status | grep "running"'); 
      if(strstr($i, "Shorewall is running")) {
        echo '<img src="image/traffic_green.jpg" />';
      } else {
        echo '<img src="image/traffic_red.jpg" />';
      } 
    ?>
  </td>
</tr>
</table>
<br><h3><br>
</div>
</div>
</div>
</div>
</div>
</body>

</html>
