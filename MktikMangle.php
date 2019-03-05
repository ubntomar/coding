<?php
session_start();
if ( !isset($_SESSION['login']) || $_SESSION['login'] !== true) 
		{
        $urlSource=$_SERVER["PHP_SELF"];
        ///ispdev/MktikMangle.php
        $page=explode("/",$urlSource);
        $_SESSION['urlsource']= $page[2];    
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
$ipPc="250";
$AddressList="servipetroleos-$ipPc"."";
$Text_comment="1.$ipPc"."";
$markConnectionDownloadText="_$ipPc"."_dw_conn";
$markConnectionUploadText="_$ipPc"."_up_conn";
$markPacketDownloadText="_$ipPc"."_dw_pkg";
$markPacketUploadText="_$ipPc"."_up_pkg";
$markConnectionRestoDownloadText="resto_dw_$ipPc"."_conn";
$markPacketRestoDownloadText="resto_dw_$ipPc"."_pkg";
$markConnectionRestoUploadText="resto_up_$ipPc"."_conn";
$markPacketRestoUploadText="resto_up_$ipPc"."_pkg";
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

// A continuación un plan de 8 megas para 20 usuarios en servipetróleos.  20 Usuarios/8 Megas =2.5 User x Mega ó 0.4M por Usuario Garantízado.
$grupoDescripcion="Grupo 8/4 Megas";
$ip="192.168.".$Text_comment;

$grupoBajadaLimitAt="8M";
$youtubeLimitAtBajada="50k";
$facebookLimitAtBajada="50k";
$restoLimitAtBajada="300k";
$youtubeMaxLimitBajada="1M";
$facebookMaxLimitBajada="1M";
$restoMaxLimitBajada="6M";

$grupoSubidaLimitAt="4M";
$youtubeLimitAtSubida="50k";
$facebookLimitAtSubida="50k";
$restoLimitAtSubida="100k";
$youtubeMaxLimitSubida="1M";
$facebookMaxLimitSubida="1M";
$restoMaxLimitSubida="2M";

$restodwName="resto_$ipPc"."_dw";
$restoUpName="resto_$ipPc"."_up";
echo"Arranca<p>";
echo"\n<p>/queue tree
\n<p>add comment=$ip limit-at=8M max-limit=8M name=\"$grupoDescripcion Dw\" parent=global
\n<p>add limit-at=$youtubeLimitAtBajada max-limit=$youtubeMaxLimitBajada name=\"$Text_comment youtube dw\" packet-mark=youtube$markPacketDownloadText parent=\"$grupoDescripcion Dw\"
\n<p>add limit-at=$facebookLimitAtBajada max-limit=$facebookMaxLimitBajada name=\"$Text_comment facebook dw\" packet-mark=facebook$markPacketDownloadText parent=\"$grupoDescripcion Dw\"
\n<p>add limit-at=$restoLimitAtBajada max-limit=$restoMaxLimitBajada name=$restodwName packet-mark=$markPacketRestoDownloadText parent=\"$grupoDescripcion Dw\"

\n<p>add comment=$ip limit-at=4M max-limit=4M name=\"$grupoDescripcion Up\" parent=global
\n<p>add limit-at=50k max-limit=1M name=\"$Text_comment youtube up\" packet-mark=youtube$markPacketUploadText parent=\"$grupoDescripcion Up\"
\n<p>add limit-at=50k max-limit=1M name=\"$Text_comment facebook up\" packet-mark=facebook$markPacketUploadText parent=\"$grupoDescripcion Up\"
\n<p>add limit-at=100k max-limit=2M name=$restoUpName packet-mark=$markPacketRestoUploadText parent=\"$grupoDescripcion Up\"
";
echo"</p>Termina";
 ?>
</body>
</html>