<?php
session_start();
if($_SESSION['authenticated'] != true ) {
  header('location:main.php?id=error');
}

if(isset($_POST['restart'])){
       	exec('sudo  /usr/bin/spanbox.sh restart'); 
}
if(isset($_POST['stop'])){
       	exec('sudo  /usr/bin/spanbox.sh stop'); 
}
if(isset($_POST['service'])){
     exec('sudo  /usr/bin/spanbox.sh service'); 
}
if(isset($_POST['trunk_start'])){
        exec('sudo  /usr/bin/spanbox.sh trunk_start');
}
if(isset($_POST['trunk_stop'])){
 exec('sudo  /usr/bin/spanbox.sh trunk_stop');
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

<h3 style="margin-left:15px;">IP PBX </h3>
<span class="cl-effect-8" style="float:right;margin-right:15px;">
  <a href="vc.php" style="text-decoration:none;">VoIP Connect Trunk</a></span>
<div id="status_table">
<table width="700 px" style="margin-left:10 px; align:center;">
<tr>
  <td width="400 px" style="text-align:center;"><h4>STATUS</h4></td>
  <td  width ="150 px">
<?php  
    $i = exec('/etc/init.d/asterisk status ');

    if(strstr($i, "asterisk is running")) {
        echo '<img src="image/green.png" />';
      } else {
        echo '<img src="image/red.png" />';
      }
    ?>
  </td>
</tr>


<tr>
  <td width="400 px" style="text-align:center;"><h4>START PBX</h4></td>
  <td  width ="150 px">
    <form method="POST">
     <input type="image" name="restart" value="restart" src="image/start.png">
    </form>
  </td>
</tr>

<tr>
  <td width="400 px" style="text-align:center;"><h4>STOP PBX</h4></td>
  <td  width ="150 px">
    <form method="POST">
     <input type="image" name="stop" value="stop" src="image/stop.png">
    </form>
  </td>
</tr>

</tr>
  <td width="400 px" style="text-align:center;"><h4>CONFIGURE</h4></td>
  <td  width ="150 px">
   <a href="http://192.168.254.254:85"><img src="image/configure.png" /></a>
  </td>
</tr>

</table>


<a href="status.php"><img src="image/back.jpg" style="margin-left:75px;"></a>
<br/><h3><br/>
</div>
</div>
</div>
</div>
</div>

</body>
</html>

