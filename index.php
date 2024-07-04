<?php
# Use env file
require("functions.php");

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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="main">     
            <div class="userdata">
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

                ?>
            </div>

            <div class="map">
                <?php showMap($LATITUDE, $LONGITUDE); ?>
            </div>
        </div>
            
        
    </body>
</html>