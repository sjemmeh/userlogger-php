<?php
# Use env file
require("functions.php");
$env = parse_ini_file('.env');

# Get IP from user
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $IP = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $IP = $_SERVER['REMOTE_ADDR'];
}
?>
<html>
    <head>
    <title>Document</title>
    <meta name="description" content="Document" />
    <meta property="og:title" content="Document" />
    <meta property="og:url" content="<?php echo $env["URL"] ?>" />
    <meta property="og:description" content="Document" />
    </head>
    <body>
        <?php 


            # Process IP for data
            $VPNAPI_KEY = $env["VPNAPI_KEY"];
            $JSON = file_get_contents("https://vpnapi.io/api/" . $IP . "?key=" . $VPNAPI_KEY);

            # Decode the JSON
            $DATA = json_decode($JSON, true);

            # All data
            $VPN = $DATA['security']['vpn'];
            $PROXY = $DATA['security']['proxy'];
            $TOR = $DATA['security']['tor'];
            $RELAY = $DATA['security']['relay'];
            $COUNTRY = $DATA['location']['country'];
            $REGION = $DATA['location']['region'];
            $CITY = $DATA['location']['city'];
            $PROVIDER = $DATA['network']['autonomous_system_organization'];

            $LATITUDE = $DATA['location']['latitude'];
            $LONGITUDE = $DATA['location']['longitude'];
            
            if ($VPN == false && $PROXY == false && $TOR== false && $RELAY == false) {
                $HASVPN = "false";
            } else {
                $HASVPN = "true";
            }
            
            echo "<p>VPN: " . $HASVPN . "</p>";
            echo "<p>IP: " . $IP . "</p>";
            echo "<p>ISP: " . $PROVIDER . "</p>";
            echo "<p>Country: " . $COUNTRY . "</p>";
            echo "<p>Region/State: " . $REGION . "</p>";
            echo "<p>City: " . $CITY . "</p>";
            echo "<p>Thank you :) </p>";
            # Logging to database
            if ($env["LOG"] == true) {
                logData($env['LOG_TYPE'], $HASVPN, $IP, $PROVIDER, $COUNTRY, $REGION, $CITY);
            }


            showMap($LATITUDE, $LONGITUDE);
        ?>
    </body>
</html>