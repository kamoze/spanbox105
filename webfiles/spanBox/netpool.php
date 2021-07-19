<?php
session_start();
$_SESSION['user_error'] == 0;

/* Check Authentication */
if($_SESSION['authenticated'] != true ) {
  header('location:main.php?id=error');
}

$_SESSION['error'] = 0;

/* File upload handling */
if(isset($_POST['upl'] )) {
 if(file_exists("/etc/vpnmgt/vvpsmgt/".$_FILES["file"]["name"])) {
   $_SESSION['error'] = 1;
 } 
 $filename = $_FILES["file"]["name"];
 $ext = end(explode('.', $filename));
 /* rename file with conf extention */
 if($ext == "conf" || $ext == "ovpn") {
   if($_POST['upl'] == 'sconnect') {
     $filename =  "vvpscmd.txt";
   }
 }
 $i = move_uploaded_file($_FILES["file"]["tmp_name"], "/etc/vpnmgt/vvpsmgt".$filename); 
if($i) {
  print "<script type=\"text/javascript\">"; 
  echo 'alert("File has been uploaded successfully")'; 
  print "</script>";  
}else {
  print "<script type=\"text/javascript\">"; 
  echo 'alert("Error uploading file")'; 
  print "</script>";  
}
}

/* username password handling */
if(isset($_POST['s-userpass'])) {
   if(empty($_POST['s-user']) || empty($_POST['s-pass'])) {
     $_SESSION['user_error'] = 1;
   } else {
     $_SESSION['user_error'] = 0;
   $command = 'sudo  /usr/bin/spanbox.sh add_pass '.$_POST['s-user'].' '.$_POST['s-pass'].' '.$_POST['proto'];
  exec($command);
  }
}

/* s-target server */
if(isset($_POST['tg_sc_gen'])) {
  $command = 'sudo  /usr/bin/spanbox.sh pool_server '.$_POST['tg_sc_gen'].' '.$_POST['port'].' '.$_POST['dev'].' '.$_POST['addr'].' '.$_POST['routing'];
  exec($command);
  print "<script type=\"text/javascript\">"; 
  echo 'alert("Pool Generated")'; 
  print "</script>";  
}


/* restart server */
if($_POST['slastart'] == "yes") {
   exec('sudo  /usr/bin/spanbox.sh sla_start');
  print "<script type=\"text/javascript\">"; 
  echo 'alert("Service Started")'; 
  print "</script>";  
}

/* stop server */
if($_POST['slastop'] == "yes") {
   exec('sudo  /usr/bin/spanbox.sh pool_init');
  print "<script type=\"text/javascript\">";
  echo 'alert("Sync Initiated")';
  print "</script>";
}
?>

<script type="text/javascript">
function submitform() {
  document.forms["upload"].submit();
}
function submitform2() {
  //document.forms["target"].submit();
  document.getElementById('tg_sc_gen').value = document.getElementById('target_server').value;
  submitform_gen();
}
function submitform_gen() {
  document.forms["vpn_opt"].submit();
}
function submitform3() {
  document.forms["slastart"].submit();
}
function submitform4() {
  document.forms["slastop"].submit();
}
function submitform5() {
  document.forms["slastart"].submit();
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
<div class="tabset0 pws_tabs_list" style="height: 1050px;">
<div class="list-wrap">



<h3 style="margin-left:15px;">NETWORK SYNC - IP POOL</h3>

<?php  $i = exec('grep -rl "1" /usr/bin/checkiprouterun.txt');
     if(strstr($i, "/usr/bin/checkiprouterun.txt")) {
        echo '<img src="image/green.png" align="right" style="margin-right:15px;"/>';
      } else {
        echo '<img src="image/red.png"  align="right" style="margin-right:15px;"/>';
      }
?>

<br>
<?php 
if($_SESSION['error'] == 1) {
  echo '<p style="color:; margin-left:15px;">
         Warning !!! File Already Exists. Overwritten ...
        </p>' ;
}
if($_SESSION['user_error'] == 1) {
  echo '<p style="color:; margin-left:15px;">
          Error !!! Please provide username and password
       </p>' ;
}
?>
<div id="status_table">
<table width="700 px" style="margin-left:10 px; align:center;">
<tr>
  <td width="200 px" style="text-align:center; color:;">Private IP Pool Cfg</td>
  <td  width ="150 px" style="padding-top:5px; ></td>
  <td width="210 px"></td>
</tr>
<form method = "post" action="netpool.php" name="vpn_opt" id="vpn_opt" >
<br/><br/>
<tr>
  <td width="200 px" style="text-align:left; "></td>
  <td  width ="50 px" style="text-align:left;"> 
   Output Address Class
  </td><td width="210 px" style="text-align:left;">
   <select name="dev">
   <option value="24">CLASS-C</option>
   <option value="16">CLASS-B</option>
   </select>
  </td>
</tr>

<input type="hidden" name="tg_sc_gen" id="tg_sc_gen" value="" />

</form>
</table>
<br>
<table width="700 px" style="margin-left:10 px; align:center;">
<tr>
  <td width="200 px" style="text-align:center;"></td>
  <td  width ="350 px" style="padding-top:5px; >
  PORT
  <input type="text" name="port" value="port" />
  </td>
  <td width="10 px"></td>
</tr>
<tr>
  <td width="200 px" style="text-align:center;"></td>
  <td  width ="350 px" style="padding-top:5px; >
  Static-Address
  <input type="text" name="addr" value="addr" />
  </td>
  <td width="10 px"></td>
</tr>

</form>
<tr>
  <td width="200 px" style="text-align:center; color:;">Input Source Network (e.g 10.10.0.0/16)</td>
  <td  width ="350 px" style="border:0px solid green; 
                              padding-top:15px; 
                              background-color:;
                              opacity:0.6;
                              filter:alpha(opacity=60); /* For IE8 and earlier */
                              padding-bottom: 1em;"> 
    <form method = "post" action="netpool.php" name="target" id="target">
    <input type="hidden" name="tgt" value="yes">
<!---
    <select name="target_server" id="target_server">
      <option value = "vpn-s1.spanboxng.com">vpn-s1.spanboxng.com</option>
      <option value = "vpn-s2.spanboxng.com">vpn-s2.spanboxng.com</option>
      <option value = "vpn-s3.spanboxng.com">vpn-s3.spanboxng.com</option>
    </select><br>
-->
    <input type="text" name="target_server" id="target_server"><br>
	<span class="cl-effect-8" style="margin-top:-35px;">
    <a href="javascript:submitform2()" style="text-decoration:none; margin-top:-9px;">Generate Network Pool</a> 
	</span>
   </form></td>
  <td width="10 px"></td>
</tr>

<tr>
  <td width="200 px" style="text-align:right;"></td>
  <td  width ="350 px" style="border:0px solid red;
                              padding-top:15px;
                              opacity:0.6;
                              filter:alpha(opacity=60); /* For IE8 and earlier */
                              background-color:;">
    <form method = "post" action="netpool.php" name="slastop" id="slastop">
    <input type="hidden" name="slastop" value="yes">
        <span class="cl-effect-8">
    <a href="javascript:submitform4()" style="text-decoration:none;">Initiate Network Sync</a>
       <span class="cl-effect-8">
    </form>
  </td>
  <td width="10 px"></td>
</tr>
</table>
<br/><br/>
<a href="netsync_config.php"><img src="image/back.jpg" style="margin-left:75px;"></a>
<a href="status.php"><img src="image/next.jpg" style="margin-left:450;"></a>
<br><h3><br>
</div>
</div>
</div>
</div>
</div>
</body>
</html>



