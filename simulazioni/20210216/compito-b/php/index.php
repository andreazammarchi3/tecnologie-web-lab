<?php
    class DbOp {
        private $conn;
        // Methods
        function __construct(){
            $this->conn = new mysqli("localhost", "root", "", "febbraio");
        }

        function verify_input() {
            if(isset($_POST["mode"])) {
                if($_POST["mode"] == "html" || $_POST["mode"] == "json") {
                    if($_POST["id"] == null) {
                        return 0;
                    } else {
                        $stmt = $this->conn->prepare("SELECT id FROM dati WHERE id=?");
                        $stmt->bind_param("i", $_POST["id"]);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        $res->fetch_all(MYSQLI_ASSOC);
                        if($res->num_rows == 0) {
                            echo "ERR: Valore parametro 'id' non presente nel DB";
                            return -1;
                        } else {
                            return 1;
                        }
                    }
                } else {
                    echo "ERR: Valore parametro 'mode' non valido";
                    return -1;
                }
            } else {
                echo "ERR: Non passato parametro 'mode' in POST";
                return -1;
            }
        }

        function select_row() {
            if($this->verify_input() == 0) {
                $stmt = $this->conn->prepare("SELECT * FROM dati");
                $stmt->execute();
                $res = $stmt->get_result();
                return $res->fetch_all(MYSQLI_ASSOC);
            } else if($this->verify_input() == 1) {
                $stmt = $this->conn->prepare("SELECT * FROM dati WHERE id=?");
                $stmt->bind_param("i", $_POST["id"]);
                $stmt->execute();
                $res = $stmt->get_result();
                return $res->fetch_all(MYSQLI_ASSOC);
            }  else {
                return null;
            }
        }

        function print_html() {
            $myfile = fopen("risultati.html", "w") or die("Unable to open file!");
            $txt = "<table>";
            foreach($this->select_row() as $key => $row) {
                $txt = $txt."<tr>";
                foreach($row as $key2 => $row2) {
                    $txt = $txt."<td>".$row2."</td>";
                }
                $txt = $txt."</tr>";
            }
            $txt = $txt."</table>";
            fwrite($myfile, $txt);
            fclose($myfile);
            echo "Azione completata con successo";
        }

        function print_json() {
            
            if($this->select_row() == null) {
                echo "ERRORE";
            } else {
                $myfile = fopen("risultati.json", "w") or die("Unable to open file!");
                $txt = json_encode($this->select_row());
                fwrite($myfile, $txt);
                fclose($myfile);
                echo "Azione completata con successo";
            }
        }
    }

    $dbOp = new DbOp();

    if($_POST["mode"] == "json") {
        $dbOp->print_json();
    } else if($_POST["mode"] == "html") {
        $dbOp->print_html();
    }
?>

<input type="button" onClick="location.href = 'risultati.html';" value="Vai a risultati">