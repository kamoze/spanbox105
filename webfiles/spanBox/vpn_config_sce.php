<?php
session_start();

/* Check Authentication */
if($_SESSION['authenticated'] != true ) {
  header('location:main.php?id=error');
}

/* File upload handling */
$_SESSION['error'] = 0;
if($_POST['upl'] == "yes") {
 if(file_exists("/etc/openvpn/".$_FILES["file"]["name"])) {
   $_SESSION['error'] = 1;
 } 
 $filename = $_FILES["file"]["name"];
 $ext = end(explode('.', $filename));
 if($ext == "conf" || $ext == "ovpn") {
   $filename =  "client-sce.conf";
 }
 $i = move_uploaded_file($_FILES["file"]["tmp_name"], "/etc/openvpn/".$filename); 
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


if($_POST['tgtsce'] == "yes") {
  $command = 'sudo  /usr/bin/spanbox.sh targetse_server '.$_POST['target_server'];
  exec($command);
}

if(isset($_POST['Add'])) {
      $handle = @fopen("/usr/bin/target_server.txt", "r");
      $line_num =0;
      if ($handle) {
        while(($buffer = fgets($handle, 4096)) !== false) {
          if(strcmp($_POST['add_server'],$buffer) < 0 ) {
            $is_set = true;
            $line_num++;
            break;
 
          }else {
            $line_num++;
            continue;
          }
        }
        fclose ($handle);
           $command = 'sudo  /usr/bin/spanbox.sh add_sce_srv '.$line_num.' '.$_POST['add_server'];
           exec($command);
      }
      else {
        echo "No File ";
      }
     
}


if(isset($_POST['Del'])) {
      $handle = @fopen("/usr/bin/target_server.txt", "r");
      $members = array();
      $line_num =0;
      if ($handle) {
        while(($buffer = fgets($handle, 4096)) !== false) {
          if(strncmp($_POST['del_server'],$buffer, strlen($_POST['del_server'])) == 0 ) {
            $line_num++;
            break;
          }else { 
            $line_num++;
          }
        }
        fclose ($handle);
        }
     
           $command = 'sudo  /usr/bin/spanbox.sh del_sce_srv '.$line_num;
            exec($command);
}

/* username password handling */
if(isset($_POST['s-userpass'])) {
   if(empty($_POST['s-user']) || empty($_POST['s-pass'])) {
     $_SESSION['user_error'] = 1;
   } else {
     $_SESSION['user_error'] = 0;
   $command = 'sudo  /usr/bin/spanbox.sh add_pass '.$_POST['s-user'].' '.$_POST['s-pass'];
  exec($command);
  }
}

if($_POST['restart'] == "yes") {
   exec('sudo  /usr/bin/spanbox.sh vpn_restart');
  print "<script type=\"text/javascript\">";
  echo 'alert("Server restarted")';
  print "</script>";

}
?>
<script type="text/javascript">
function submitform5() {
  document.forms["seupload"].submit();
}
function submitform6() {
  document.forms["setarget"].submit();
}
function submitform7() {
  document.forms["sestart"].submit();
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
<div class="tabset0 pws_tabs_list" style="height: 800px;">
<div class="list-wrap">


<h3 style="margin-left:15px;">VPN-CONNECT CONFIG</h3>
<?php 
if($_SESSION['error'] == 1) {
  echo '<p>Warning !!! File Already Exists. Overwritten ...</p>' ;
}
?>
<div id="status_table">
<table width="700 px" style="margin-left:10 px; align:center;">


<tr>
  <td width="200 px" style="text-align:center;">S-CONNECT Enterprise</td>
  <td  width ="350 px" style="border:0px solid green; 
                              padding-top:15px;
                              background-color:;">
    <form method = "post" action="vpn_config_sce.php" name="seupload" id="seupload"
          enctype="multipart/form-data">
    <input type="hidden" name="upl" value="yes">
    <input type="file" name="file" id="file" ><br />
	<span class="cl-effect-8">
    <a href="javascript:submitform5()"> Upload Config File</a>
	</span>
   </form>
  </td>
</tr>
<tr>
  <td width="200 px" style="text-align:center;"></td>
  <td  width ="350 px" style="border:0px solid green; 
                              padding-top:15px;
                              background-color:;">
    <form method = "post" action="vpn_config_sce.php" name="setarget" id="setarget">
    <input type="hidden" name="tgtsce" value="yes">
    <select name="target_server">
<?php
      $handle = @fopen("/usr/bin/target_server.txt", "r+");

      if ($handle) {
        while(($buffer = fgets($handle, 4096)) !== false) {
          echo '<option value = "'.$buffer.'">'.$buffer.'</option>';
        }
        if (!feof($handle)) {
          echo "Error :unexpected ";
        }
        fclose ($handle);
      }
      else {
        echo "No File ";
      }
?>
    </select><br>
	<span class="cl-effect-8">
    <a href="javascript:submitform6()"> Select Target Server</a>
	</span>
   </form></td>
</tr>

<tr>
  <td width="200 px" style="text-align:center;"></td>
  <td  width ="350 px" style="border:0px solid green; 
                              padding-top:15px;
                              background-color:;">
    <form method = "post" action="vpn_config_sce.php" name="" id="">
    <input type="text" name="add_server">
    <input type="submit" name="Add" value="Insert Server" style="margin-top:-10px;">
    </form>
  </td>
</tr>

<tr>
  <td width="200 px" style="text-align:center;"></td>
  <td  width ="350 px" style="border:0px solid green; 
                              padding-top:15px;
                              background-color:;">
    <form method = "post" action="vpn_config_sce.php" name="" id="">
    <input type="text" name="del_server">
    <input type="submit" name="Del" value="Delete Server" style="margin-top:-10px;">
    </form>
  </td>
</tr>

<form method = "post" action="vpn_config_sce.php" name="s-user_pass" id="s-user_pass" >
<tr>
  <td width="200 px" style="text-align:center; "></td>
  <td  width ="350 px" style="background-color:;
                              border:0px solid green;">
            Username <input type="text" name="s-user" />
  </td>
  <td width="10 px"></td>
</tr>
<tr>
  <td width="200 px" style="text-align:center;"></td>
  <td  width ="350 px" style="border:0px solid green; background-color:;">            Password <input type="password" name="s-pass">
  </td>
  <td width="10 px"></td>
</tr>
<tr>
<td width="200 px" style="text-align:center;"></td>
<td style="background-color:;">
<input type="hidden" name="s-userpass" value="1">
<input type="submit" value="submit">
</td>
  <td width="10 px"></td>
</tr>

<tr>
  <td width="200 px" style="text-align:center;"></td>
  <td  width ="350 px" style="border:0px solid green; 
                              padding-top:15px;
                              background-color:;">
    <form method = "post" action="vpn_config_sce.php" name="sestart" id="sestart">
    <input type="hidden" name="restart" value="yes">
	<span class="cl-effect-8">
    <a href="javascript:submitform7()"> START LINK</a>
	</span>
    </form>
  </td>
</tr>
</table>
<br/><br/>
<a href="vpn_config.php"><img src="image/back.jpg" style="margin-left:75px;"></a>
<a href="vpn_clear_dir.php"><img src="image/next.jpg" style="margin-left:450;"></a>
</div>
</div>
</div>
</div>
</div>
</body>
</html>


