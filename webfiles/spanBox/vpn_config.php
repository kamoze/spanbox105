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
  $command = 'sudo  /usr/bin/spanbox.sh target_server '.$_POST['tg_sc_gen'].' '.$_POST['port'].' '.$_POST['dev'].' '.$_POST['addr'].' '.$_POST['routing'];
  exec($command);
  print "<script type=\"text/javascript\">"; 
  echo 'alert("Target server and parameters applied")'; 
  print "</script>";  
}


/* restart server */
if($_POST['restart'] == "yes") {
   exec('sudo  /usr/bin/spanbox.sh vpn_restart');
  print "<script type=\"text/javascript\">"; 
  echo 'alert("Service Started")'; 
  print "</script>";  
}
/* stop server */
if($_POST['trunk_stop'] == "yes") {
   exec('sudo  /usr/bin/spanbox.sh vpn_stop1');
  print "<script type=\"text/javascript\">";
  echo 'alert("Service Stopped")';
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
  document.forms["start"].submit();
}
function submitform4() {
  document.forms["stop"].submit();
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
<li class="main-nav"><a href="webfilter.php">Webfilter</a></li>
</ul>
<br>
</div>
<div class="tabset0 pws_tabs_list" style="height: 1050px;">
<div class="list-wrap">



<h3 style="margin-left:15px;">VPN-CONNECT - SD-WAN</h3>
<tr>
  <td width="200 px" style="text-align:left;"></td>
  <td  width ="350 px" style="border:0px solid green;
                              opacity:0.6;
                              filter:alpha(opacity=60); /* For IE8 and earlier */
                              padding-top:5px;
                              background-color:;">
                                                          <span class="cl-effect-8">
    <a href="vpn_config_pc.php" style="text-decoration:none;"> VPN-CONNECT - INTERNET</a>
        </span>
    </form>
  </td>
  <td width="10 px"></td>
</tr>
<tr>
  <td width="200 px" style="text-align:right;"></td>
  <td  width ="350 px" style="border:0px solid green;
                              opacity:0.6;
                              filter:alpha(opacity=60); /* For IE8 and earlier */
                              padding-top:5px;
                              background-color:;">
                                                          <span class="cl-effect-8">
    <a href="networksync.php" style="text-decoration:none;">NETWORK SYNC</a>
        </span>
    </form>
  </td>
  <td width="10 px"></td>
</tr>

<?php  $i = exec('sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountStatusGet VVPS | grep "Session Established" | awk "{print $1}"');
     if(strstr($i, "Session")) {
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
  <td width="200 px" style="text-align:center; color:;">Account Parameters</td>
  <td  width ="150 px" style="padding-top:5px; ></td>
  <td width="210 px"></td>
</tr>
<form method = "post" action="vpn_config.php" name="vpn_opt" id="vpn_opt" >
<br/><br/>
<tr>
  <td width="200 px" style="text-align:left;"></td>
  <td  width ="50 px" style="text-align:left;"> 
  Port
  </td><td width="210 px" style="text-align:left;">
  <input type="text" name="port" value="443"/>
  </td>
</tr>
<tr>
  <td width="200 px" style="text-align:left; "></td>
  <td  width ="50 px" style="text-align:left;"> 
   Address Type
  </td><td width="210 px" style="text-align:left;">
   <select name="dev">
   <option value="0">DHCP</option> 
   <option value="1">STATIC</option> 
   </select>
  </td>
</tr>
<tr>
  <td width="200 px" style="text-align:left;"></td>
  <td  width ="50 px" style="text-align:left;">
  Static Address
  Ex. 10.1.2.3/16
  </td><td width="210 px" style="text-align:left;">
  <input type="text" name="addr" value=""/>
  </td>
</tr>
<tr>
  <td width="200 px" style="text-align:left; "></td>
  <td  width ="50 px" style="text-align:left;">
   Routing Type
  </td><td width="210 px" style="text-align:left;">
   <select name="routing">
   <option value="0">Partial</option>
   <option value="1">Full</option>
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
  <td width="200 px" style="text-align:center; color:;">Certs (Optional)</td>
  <td  width ="350 px" style="padding-top:5px; 
                              border:0px solid green; 
                              padding-bottom: 1em;
                              opacity:0.6;
                              filter:alpha(opacity=60); /* For IE8 and earlier */
                              background-color:;"> 
    <form method = "post" action="vpn_config.php" name="upload" id="upload" 
          enctype="multipart/form-data">
    <input type="hidden" name="upl" value="sconnect">
    <input type="file" name="file" id="file" ><br />
	<span class="cl-effect-8">
    <a href="javascript:submitform()" style="text-decoration:none;"> Upload Certificate Files</a> 
	</span>
   </form>
  </td>
  <td width="10 px"></td>
</tr>
<tr>
  <td width="200 px" style="text-align:center; color:;">VPN HUB Server</td>
  <td  width ="350 px" style="border:0px solid green; 
                              padding-top:15px; 
                              background-color:;
                              opacity:0.6;
                              filter:alpha(opacity=60); /* For IE8 and earlier */
                              padding-bottom: 1em;"> 
    <form method = "post" action="vpn_config.php" name="target" id="target">
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
    <a href="javascript:submitform2()" style="text-decoration:none; margin-top:-9px;"> Insert Target Server</a> 
	</span>
   </form></td>
  <td width="10 px"></td>
</tr>

<form method = "post" action="vpn_config.php" name="s-user_pass" id="s-user_pass" >
<tr>
  <td  width ="200 px" style="text-align:center;">Auth Type</td>
  <td width="250 px" style="text-align:left;">
   <select name="proto">
   <option value="standard">STANDARD</option>
   <option value="radius">RADIUS</option>
   </select>
  </td>
</tr>
<td width="10 px"></td>
<tr>
  <td width="200 px" style="text-align:center; color:;"> VPN Username</td>
  <td  width ="350 px" style="background-color:; 
                              opacity:0.6;
                              filter:alpha(opacity=60); /* For IE8 and earlier */
                              border:0px solid green;"> 
             <input type="text" name="s-user" />
  </td>
  <td width="10 px"></td>
</tr>
<tr>
  <td width="200 px" style="text-align:center; color:;"> VPN Password</td>
  <td  width ="350 px" style="border:0px solid green; background-color:;
                              opacity:0.6;
                              filter:alpha(opacity=60); ">
             <input type="password" name="s-pass">
  </td>
  <td width="10 px"></td>
</tr>
<tr>
<td width="300 px" style="text-align:center;"></td>
<td style="background-color:;
                              opacity:0.6;
                              filter:alpha(opacity=60); ">
<input type="hidden" name="s-userpass" value="1">
<input type="submit" value="SUBMIT Credentials">
</td>
  <td width="20 px"></td>
</tr>
</form>

<tr>
  <td width="200 px" style="text-align:center;"></td>
  <td  width ="350 px" style="border:0px solid green; 
                              padding-top:5px;
                              opacity:0.6;
                              filter:alpha(opacity=60); /* For IE8 and earlier */
                              background-color:;">
    <form method = "post" action="vpn_config.php" name="start" id="start">
    <input type="hidden" name="restart" value="yes">
	<span class="cl-effect-8">
    <a href="javascript:submitform3()" style="text-decoration:none;"> START VPN CONNECTION</a>
	<span class="cl-effect-8">
    </form>
  </td>
  <td width="10 px"></td>
</tr>
<tr></tr>
<tr>
  <td width="200 px" style="text-align:right;"></td>
  <td  width ="350 px" style="border:0px solid red;
                              padding-top:15px;
                              opacity:0.6;
                              filter:alpha(opacity=60); /* For IE8 and earlier */
                              background-color:;">
    <form method = "post" action="vpn_config.php" name="stop" id="stop">
    <input type="hidden" name="trunk_stop" value="yes">
        <span class="cl-effect-8">
    <a href="javascript:submitform4()" style="text-decoration:none;">STOP VPN CONNECTION</a>
       <span class="cl-effect-8">
    </form>
  </td>
  <td width="10 px"></td>
</tr>

</table>
<br/><br/>
<a href="vpn.php"><img src="image/back.jpg" style="margin-left:75px;"></a>
<a href="vpn_config_pc.php"><img src="image/next.jpg" style="margin-left:450;"></a>
<br><h3><br>
</div>
</div>
</div>
</div>
</div>
</body>
</html>



