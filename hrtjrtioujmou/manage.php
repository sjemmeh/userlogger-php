


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHPLog managment</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="main">
        <div class="userdata">
            <?php
                require 'functions.php';
                if(array_key_exists('createsqlite', $_POST)) { 
                    createSQLite(); 
                } 
                else if(array_key_exists('resetsqlite', $_POST)) { 
                    resetSQLite(); 
                    createSQLite(); 
                }
                else if(array_key_exists('resetmysql', $_POST)) {
                    resetMySQL(); 
                }
                else if(array_key_exists('resettext', $_POST)) {
                    resetText(); 
                } 
                else if(array_key_exists('read', $_POST)) { 
                    read(); 
                } 
            ?>

            <form method="post"> 
                <input type="submit" name="read" value="Read log" /> <br>
                <?php if ($env['LOG_TYPE'] == 'sqlite') { ?>
                    <input type="submit" name="createsqlite" value="Create Database" /> 
                    <input type="submit" name="resetsqlite" value="Reset Database" /> 
                <?php } else if ($env['LOG_TYPE'] == 'mysql') { ?>
                    <input type="submit" name="resetmysql" value="Reset Database" /> 
                <?php } else if ($env['LOG_TYPE'] == 'text') { ?>
                    <input type="submit" name="resettext" value="Reset Database" /> 
                <?php } ?>
            </form> 
        </div>
    </div>
</body>
</html>