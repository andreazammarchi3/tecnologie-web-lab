<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "febbraio";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT chiave, valore FROM dati";
    $res = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Esercizio PHP</title>
    </head>
    <body>
        <section>
            <h1>Mostra</h1>
            <h2>db</h2>
            <ul>
                <?php
                    if ($res->num_rows > 0) {
                        // output data of each row
                        while($row = $res->fetch_assoc()) {
                            echo "<li>[".$row["chiave"].": ".$row["valore"]."]</li>";
                        }
                    } else {
                        echo "0 results";
                    }
                ?>
            </ul>
            <h2>cookie</h2>
            <ul>
                <?php
                    foreach($_COOKIE as $key=>$val) {
                        echo "<li>[".$key.": ".$val."]</li>";
                    }
                ?>
            </ul>
        </section>
    </body>
</html>