
<!DOCTYPE html>
<html lang="it">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Esercizio 5 - PHP</title>
    <?php
        class DatabaseHelper{
            private $db;
        
            public function __construct($servername, $username, $password, $dbname, $port){
                $this->db = new mysqli($servername, $username, $password, $dbname, $port);
                if($this->db->connect_error){
                    die("Connesione fallita al db");
                }
            }

            public function getIDSets(){
                $stmt = $this->db->prepare("SELECT insieme FROM insiemi GROUP BY insieme");
                $stmt->execute();
                $result = $stmt->get_result();

                return $result->fetch_all(MYSQLI_ASSOC);
            }

            public function getElements($val){
                $stmt = $this->db->prepare("SELECT valore FROM insiemi WHERE insieme = $val");
                $stmt->execute();
                $result = $stmt->get_result();

                return $result->fetch_all(MYSQLI_ASSOC);
            }

            public function insElement($id, $val, $set){
                $query = "INSERT INTO insiemi (id, valore, insieme) VALUES (?, ?, ?)";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('iii',$id, $val, $set);
                $stmt->execute();
                
                return $stmt->insert_id;
            }

            public function getIDs(){
                $stmt = $this->db->prepare("SELECT id FROM insiemi");
                $stmt->execute();
                $result = $stmt->get_result();

                return $result->fetch_all(MYSQLI_ASSOC);
            }
        }

        function showErr($param){
            $message = "Errore: valore di " . $param . " non valido o mancante!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }

        function checkParam($param){
            $dbh = new DatabaseHelper("localhost", "root", "", "giugno", 3306);
            if(isset($_GET[$param]) && is_numeric($_GET[$param]) && $_GET[$param] >= 0)
            {
                $res = "Not found";
                foreach ($dbh->getIDSets() as $set) {
                    if($set['insieme'] == $_GET[$param])
                    {
                        $res = $_GET[$param];
                    }
                }
                if($res == "Not found")
                {
                    showErr($param);
                }
            }
            else
            {
                showErr($param);
                $res = "Error";
            }
            return $res;
        }

        function setToArray($set){
            $dbh = new DatabaseHelper("localhost", "root", "", "giugno", 3306);
            if($set != "Error" && $set != "Not found")
            {
                $arraySet = [];
                foreach ($dbh->getElements($set) as $element) {
                    array_push($arraySet, $element['valore']);
                }
                return $arraySet;
            }
        }
    ?>
</head>
<body>
    <main>
        <?php $dbh = new DatabaseHelper("localhost", "root", "", "giugno", 3306); ?>
        <section>
            <header>
                <h2>Parametri passati</h2>
            </header>
            <ul>
                <li>
                    <?php
                        $A = checkParam("A");
                        echo "A = " . $A;
                    ?>
                    <ul>
                        <li>
                            <?php
                                $arrA = setToArray($A);
                                print_r($arrA);
                            ?>
                        </li>
                    </ul>
                </li>
                <li>
                    <?php
                        $B = checkParam("B");
                        echo "B = " . $B;
                    ?>
                    <ul>
                        <li>
                            <?php
                                $arrB = setToArray($B);
                                print_r($arrB);
                            ?>
                        </li>
                    </ul>
                </li>
                <li>
                    <?php
                        if(isset($_GET['O']) && ($_GET['O'] == "i" || $_GET['O'] == "u"))
                        {
                            $O = $_GET['O'];
                        }
                        else
                        {
                            showErr("O");
                            $O = "Error";
                        }
                        echo "O = " . $O;
                    ?>
                </li>
            </ul>
        </section>
        <section>
            <header>
                <h2>Risultato</h2>
            </header>
            <ul>
                <li>
                    <?php
                        if(($O == "u" || $O == "i") && ($A != "Error" && $A != "Not found") && ($B != "Error" && $B != "Not found"))
                        {
                            if($O == "u")
                            {
                                $newArr = array_unique(array_merge($arrA, $arrB));
                            }
                            else
                            {
                                $newArr = array_intersect($arrA, $arrB);
                            }
                            print_r($newArr);
                        }
                    ?>
                </li>
                <li>
                    <?php
                        $maxIDSets = count($dbh->getIDSets()) + 1;
                        foreach ($newArr as $elem) {
                            $maxIDElem = count($dbh->getIDs()) + 1;
                            $dbh->insElement($maxIDElem, $elem, $maxIDSets);
                        }

                        echo "Array inserito nel DB.";
                    ?>
                </li>
            </ul>
        </section>
    </main>
</body>
</html>