<?php
$env = parse_ini_file('../.env');

switch ($env['LOG_TYPE']) {
    case "sqlite":
        // Open a connection to the SQLite database
        $db = new SQLite3('../' . $env['SQLITE_DB']);

        // SQL statement to query data
        $sql = "SELECT * FROM userlog";

        // Execute the query and get the result set
        $result = $db->query($sql);

        // Fetch and display the data
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            echo "ID: " . $row['ID'] . "<br>";
            echo "VPN: " . $row['VPN'] . "<br>";
            echo "IP: " . $row['IP'] . "<br>";
            echo "Provider: " . $row['PROVIDER'] . "<br>";
            echo "Country: " . $row['COUNTRY'] . "<br>";
            echo "Region: " . $row['REGION'] . "<br>";
            echo "City: " . $row['CITY'] . "<br>";
            echo "Time: " . $row['TIME'] . "<br>";
            echo "------------------------<br>";
        }
    break;
    
    case "mysql":
        $servername = $env["MYSQL_HOST"];
        $username = $env["MYSQL_USER"];
        $password = $env["MYSQL_PASS"];
        $dbname = $env["MSQL_DB"];

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        $sql = "SELECT * FROM userlog";

        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                echo "ID: " . $row['ID'] . "<br>";
                echo "VPN: " . $row['VPN'] . "<br>";
                echo "IP: " . $row['IP'] . "<br>";
                echo "Provider: " . $row['PROVIDER'] . "<br>";
                echo "Country: " . $row['COUNTRY'] . "<br>";
                echo "Region: " . $row['REGION'] . "<br>";
                echo "City: " . $row['CITY'] . "<br>";
                echo "Time: " . $row['TIME'] . "<br>";
                echo "------------------------<br>";
            }
            } else {
            echo "0 results";
            }
            
            mysqli_close($conn);
    break;

    case "text":
        $FILE = file_get_contents($env["TEXT_FILE"]);
        echo $FILE;
    break;
}
