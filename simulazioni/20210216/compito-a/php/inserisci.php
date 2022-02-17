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

    if(isset($_POST['chiave']) && isset($_POST['valore']) && isset($_POST['metodo'])) {
        $key = $_POST['chiave'];
        $value = $_POST['valore'];
        if($_POST['metodo'] == "cookie") {
            if(!isset($_COOKIE[$key])) {
                setcookie($key, $value, time() + (86400 * 30), "/"); // 86400 = 1 day
                echo "aggiunto cookie";
            } else if($_COOKIE[$key] != $value) {
                $_COOKIE[$key] = $value;
                echo "aggiornato cookie";
            }
        } else if($_POST['metodo'] == "db") {
            $stmt = $conn->prepare("SELECT * FROM dati WHERE chiave=?");
            $stmt->bind_param("s", $key);
            $stmt->execute();
            $res = $stmt->get_result();
            $res->fetch_all(MYSQLI_ASSOC);
            if($res->num_rows == 0) {
                $stmt = $conn->prepare("INSERT INTO dati (chiave, valore) VALUES (?, ?)");
                $stmt->bind_param("ss", $key, $value);
                $stmt->execute();
                $stmt->insert_id;
                echo "Nuova chiave ".$key." aggiunta col valore ".$value;
            } else {
                $stmt = $conn->prepare("UPDATE dati SET valore=? WHERE chiave=?");
                $stmt->bind_param("ss", $value, $key);
                $stmt->execute();
                echo "Chiave ".$key." aggiornata col valore ".$value;
            }
        } else {
            echo "Errore nella variabile 'metodo'";
        }
    } else {
        echo "Errore nelle variabili in POST";
    }
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Esercizio PHP</title>
    </head>
    <body>
        <section>
            <h1>Vai alla pagina 'mostra.php'</h1>
            <form action= "mostra.php">
                <input type="submit" value="Submit">
            </form>
        </section>
    </body>
</html>