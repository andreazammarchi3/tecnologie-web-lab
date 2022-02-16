<?php
    $servername = "localhost";
    $username = "root";
    $password = "";

    $db = new mysqli($servername, $username, $password);
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
      }
    echo "Connected successfully";

    //header("Content-Type: application/json"); //imposto la pagina per dire che contiene del json
    $log = array();
    if(!isset($_POST["action"]) || $_POST["action"] == "") {
        array_push($log, "Errore: valore non valido per la variabile 'action' tramite POST");
    } else if($_POST["action"] == "extract") {
        
        array_push($log, "Riuscito: valore variabile ACTION = extract");
    }
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Esito ACTION</title>
    </head>
    <body>
        <header><h1>Esito ACTION</h1></header>
        <section>
            <form action="./input.php">
                <input type="submit" value="Indietro"/>
            </form>
            <p id="message"><?php echo json_encode($log); ?></p>
        </section>
    </body>
</html>