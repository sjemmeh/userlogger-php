<?php
$env = parse_ini_file('.env');

function logData($type, $vpn, $ip, $provider, $country, $region, $city) {
    global $env;
    $JSON = file_get_contents("https://timeapi.io/api/Time/current/zone?timeZone=" . $env['TIMEZONE']);
    $DATA = json_decode($JSON, true);
    $TIME = $DATA['date'] . " - " . $DATA['time'] ;

    switch ($type) {
        case "text": # Write to text file
            $FILE = $env["TEXT_FILE"];
            
            $current = file_get_contents($FILE);
            $current .= "VPN: " . $vpn . "<br>\n";
            $current .= "IP: " . $ip . "<br>\n";
            $current .= "ISP: " . $provider . "<br>\n";
            $current .= "Country: " . $country . "<br>\n";
            $current .= "Region: " . $region . "<br>\n";
            $current .= "City: " . $city . "<br>\n";
            $current .= "Time: " . $TIME . "<br>\n";
            $current .= "------------------------<br>\n";
            file_put_contents($FILE, $current);
        break;

        case "mysql":
            
            $servername = $env["MYSQL_HOST"];
            $username = $env["MYSQL_USER"];
            $password = $env["MYSQL_PASS"];
            $dbname = $env["MSQL_DB"];

            // Create connection
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $sql = "INSERT INTO userlog (VPN, IP, PROVIDER, COUNTRY, REGION, CITY, TIME)
            VALUES ('$vpn', '$ip', '$provider', '$country', '$region', '$city', '$TIME')";

            mysqli_query($conn, $sql);
            
            
            // Close connection
            mysqli_close($conn);
        break;
        
        case "sqlite":
            $db = new SQLite3($env['SQLITE_DB']);
            // SQL statement to insert data
            $sql =  "INSERT INTO userlog (VPN, IP, PROVIDER, COUNTRY, REGION, CITY, TIME)
            VALUES ('$vpn', '$ip', '$provider', '$country', '$region', '$city', '$TIME')";
            // Execute the SQL statement
            $db->exec($sql);
        break;

    }
    echo "Your data has been logged. </br>";

} 
function showMap($LA, $LO) {
     echo '<iframe width="100%" height="450" src="https://www.openstreetmap.org/export/embed.html?bbox=' . $LO .  ' %2C' . $LA .  ' %2C' . $LO .  ' %2C' . $LA .  ' &amp;layer=mapnik" style="border: 1px solid black"></iframe>';
}
?>