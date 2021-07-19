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
 if(file_exists("/etc/vpnmgt/vcmgt/".$_FILES["file"]["name"])) {
   $_SESSION['error'] = 1;
 } 
 $filename = $_FILES["file"]["name"];
 $ext = end(explode('.', $filename));
 /* rename file with conf extention */
 if($ext == "conf" || $ext == "ovpn") {
   if($_POST['upl'] == 'vcconnect') {
     $filename =  "vc.conf";
   }
 }
 $i = move_uploaded_file($_FILES["file"]["tmp_name"], "/etc/vpnmgt/vcmgt/".$filename); 
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
   $command = 'sudo  /usr/bin/spanbox.sh add_vcpass '.$_POST['s-user'].' '.$_POST['s-pass'].' '.$_POST['s-server'].' '.$_POST['dev'].' '.$_POST['addr'];
  exec($command);
  }
}

/* s-target server */
if(isset($_POST['tg_sc_gen'])) {
  $command = 'sudo  /usr/bin/spanbox.sh target_vcserver '.$_POST['tg_sc_gen'].' '.$_POST['proto'].' '.$_POST['port'];
  exec($command);
  print "<script type=\"text/javascript\">";
  echo 'alert("Target server applied")';
  print "</script>";
}


/* restart server */
if($_POST['trunk_start'] == "yes") {
   exec('sudo  /usr/bin/spanbox.sh trunk_start');
  print "<script type=\"text/javascript\">";
  echo 'alert("Service Restarted")';
  print "</script>";
}
?>

<script type="text/javascript">
function submitform12() {
  document.forms["vcupload"].submit();
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
<div class="tabset0 pws_tabs_list" style="height: 667px;">
<div class="list-wrap">



<h3 style="margin-left:15px;">VoIP-CONNECT CONFIG</h3>
<?php  $i = exec('sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountStatusGet VC | grep "Session Established" | awk "{print $1}"');
     if(strstr($i, "Session")) {
        echo '<img src="image/green.png" align="right" style="margin-right:15px;"/>';
      } else {
        echo '<img src="image/red.png"  align="right" style="margin-right:15px;"/>';
      }
?>

<br>
<?php 
if($_SESSION['error'] == 1) {
  echo '<p style="color:#FF0000; margin-left:15px;">
         Warning !!! File Already Exists. Overwritten ...
        </p>' ;
}
if($_SESSION['user_error'] == 1) {
  echo '<p style="color:#FF0000; margin-left:15px;">
          Error !!! Please provide username and password
       </p>' ;
}
?>
<div id="status_table">
<table width="700 px" style="margin-left:10 px; align:center;">
</form>
<tr>
  <td width="200 px" style="text-align:center; color:;">VoIP-CONNECT Parameters </td>
  <td width="200 px" style="text-align:center; color:;"></td>

<br/>
<br/>
<form method = "post" action="vc_config.php" name="s-user_pass" id="s-user_pass" >
<tr>
  <td width="200 px" style="text-align:center; color:;">VC Username</td>
  <td  width ="350 px" style="background-color:; 
                              opacity:0.6;
                              filter:alpha(opacity=60); /* For IE8 and earlier */
                              border:0px solid green;"> 
                      <input type="text" name="s-user" />
  </td>
  <td width="10 px"></td>
</tr>
<tr>
  <td width="200 px" style="text-align:center; color:;">VC Password</td>
  <td  width ="350 px" style="border:0px solid green; background-color:;
                              opacity:0.6;
                              filter:alpha(opacity=60); ">
                     <input type="password" name="s-pass">
  </td>
  <td width="10 px"></td>
</tr>
<tr>
  <td width="200 px" style="text-align:center; color:;">VC Hub Server</td>
  <td  width ="350 px" style="border:0px solid green; background-color:;
                              opacity:0.6;
                              filter:alpha(opacity=60); ">
             <input type="text" name="s-server">
  </td>
  <td width="10 px"></td>
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
                              padding-top:15px;
                              opacity:0.6;
                              filter:alpha(opacity=60); /* For IE8 and earlier */
                              background-color:;">
    <form method = "post" action="vc_config.php" name="start" id="start">
    <input type="hidden" name="trunk_start" value="yes">
        <span class="cl-effect-8"> 
    <a href="javascript:submitform3()" style="text-decoration:none;">RESTART VC CONNECTION</a>
       <span class="cl-effect-8">
    </form>
  </td>
  <td width="10 px"></td>
</tr>
<tr></tr>

</table>
<br/><br/>
<a href="vc.php"><img src="image/back.jpg" style="margin-left:75px;"></a>
<a href="status.php"><img src="image/next.jpg" style="margin-left:450;"></a>
<br><h3><br>
</div>
</div>
</div>
</div>
</div>
</body>
</html>



