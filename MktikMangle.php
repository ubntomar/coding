<?php
session_start();
if ( !isset($_SESSION['login']) || $_SESSION['login'] !== true) 
		{
        $urlSource=$_SERVER['REQUEST_URI'];
        $_SESSION['urlsource']=$urlSource;    
		header('Location: login/index.php');
		exit;
		}
else    {
        $user=$_SESSION['username'];
        
		}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Php Mangle Api</title>
</head>
<body>
<?php
echo "<h1>$urlSource</h1>";
$AddressList="servipetroleos-250";
$Text_comment="1.250";
$markConnectionDownloadText="_250_dw_conn";
$markConnectionUploadText="_250_up_conn";
$markPacketDownloadText="_250_dw_pkg";
$markPacketUploadText="_250_up_pkg";
$markConnectionRestoDownloadText="resto_dw_250_conn";
$markPacketRestoDownloadText="resto_dw_250_pkg";
$markConnectionRestoUploadText="resto_up_250_conn";
$markPacketRestoUploadText="resto_up_250_pkg";
echo"Arranca<p>";
echo "        
    \n<p>add action=mark-connection chain=forward comment=\
        \"Marcado de Paquetes de Youtube $Text_comment\" dst-address-list=$AddressList \
        in-interface=wlan1 layer7-protocol=youtube log=yes log-prefix=\
        youtube$markConnectionDownloadText new-connection-mark=youtube$markConnectionDownloadText passthrough=yes
    \n<p>add action=mark-packet chain=forward connection-mark=youtube$markConnectionDownloadText \
        new-packet-mark=youtube$markPacketDownloadText passthrough=no
    \n<p>add action=mark-connection chain=forward in-interface=LAN layer7-protocol=\
        youtube new-connection-mark=youtube$markConnectionUploadText passthrough=yes \
        src-address-list=$AddressList
    \n<p>add action=mark-packet chain=forward connection-mark=youtube$markConnectionUploadText \
        new-packet-mark=youtube$markPacketUploadText passthrough=no
    \n<p>add action=mark-connection chain=forward comment=\
        \"Marcado de paquetes de facebook $Text_comment\" dst-address-list=$AddressList \
        in-interface=wlan1 layer7-protocol=facebook log=yes log-prefix=\
        facebook$markConnectionDownloadText new-connection-mark=facebook$markConnectionDownloadText passthrough=\
        yes
    \n<p>add action=mark-packet chain=forward connection-mark=facebook$markConnectionDownloadText \
        new-packet-mark=facebook$markPacketDownloadText passthrough=no
    \n<p>add action=mark-connection chain=forward in-interface=LAN layer7-protocol=\
        facebook new-connection-mark=facebook$markConnectionUploadText passthrough=yes \
        src-address-list=$AddressList
    \n<p>add action=mark-packet chain=forward connection-mark=facebook$markConnectionUploadText \
        new-packet-mark=facebook$markPacketUploadText passthrough=no
    \n<p>add action=mark-connection chain=forward comment=\"resto download $Text_comment\
    \" 
        dst-address-list=$AddressList in-interface=wlan1 new-connection-mark=\
        $markConnectionRestoDownloadText passthrough=yes
    \n<p>add action=mark-packet chain=forward connection-mark=$markConnectionRestoDownloadText \
        new-packet-mark=$markPacketRestoDownloadText passthrough=no
    \n<p>add action=mark-connection chain=forward in-interface=LAN new-connection-mark=\
        $markConnectionRestoUploadText passthrough=yes src-address-list=servipetroleos-250
    \n<p>add action=mark-packet chain=forward connection-mark=$markConnectionRestoUploadText \
        new-packet-mark=$markPacketRestoUploadText passthrough=no       

     ";   

echo"</p>Termina";

 ?>
</body>
</html>