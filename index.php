<?php
$provincie = [];
$regioni = [];

$fileName = 'text\regioni.txt';

$testo = fopen($fileName, "r") or exit("impossibile leggere il file regioni");
while (!feof($testo)) {
    $riga = explode(";", fgets($testo));
    $regioni[] = [
        'codice' => $riga[0],
        'nome' => $riga[1],
    ];
}
fclose($testo);

$fileName = 'text\provincie.txt';
$testo = fopen($fileName, "r") or exit("impossibile leggere il file provincie");
while (!feof($testo)) {
    $riga = explode(";", fgets($testo));
    $provincie[] = [
        'diminutivo' => $riga[0],
        'nome' => $riga[1],
        'nomeRegione' => $riga[2],
        'codice'=>$riga[3]
    ];
}
fclose($testo);
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>regioni e provincie</title>
</head>

<body>
    <div class="boxEsterno">
        <div class="header"></div>
        <div class="articolo">
            <form id="modulo" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
                <label for="regione">regione</label>
                <select name="regione" id="regione" onchange='document.getElementById("modulo").submit()'>
                    <option value="00">scegli una regione</option>
                    <?php
                    foreach ($regioni as $regione) {
                        $selected = (isset($_POST['regione']) && $_POST['regione'] == $regione['codice']) ? 'selected' : '';//controllo se il valore selezionato e uguale a quello nella lista in cas contrario selected rimane vuoto
                        echo "<option value=" . $regione['codice'] . " $selected>" . $regione['nome'] . "</option>";
                    }
                    echo "<br>";
                    ?>
                </select>

                <?php
                if (isset($_POST['regione'])) {
                    echo "<label for=\"provincie\">provincie</label>";
                    echo '<select name="provincie" id="provincie" onchange="provinciaSelezionata()">';
                    echo "<option value=\"00\">scegli una provincia</option>";
                    foreach ($provincie as $provincia) {
                        if ($_POST['regione']==$provincia['codice']) {
                            //$selected = (isset($_POST['provincie']) && $_POST['provincie'] == $provincia['codice']) ? 'selected' : '';
                            echo "<option value=" . $provincia['nome'] . "$selected>" . $provincia['nome'] . "</option>";
                        }
                       
                    }
                    echo "</select>";

                    echo "<script>";
                    echo "function provinciaSelezionata(nomeRegione,nomeProvincia) {
                        var selectedProvincie = document.getElementById(\"provincie\").value;
                        var selectedRegioni = document.getElementById(\"regione\").value;
            
                        // Verifica se l'elemento <p> esiste già
                        var paragrafo = document.getElementById(\"valoreSelezionato\");
            
                        if (!paragrafo) {
                            paragrafo = document.createElement(\"p\");
                            paragrafo.id = \"valoreSelezionato\";
                            document.body.appendChild(paragrafo);
                        }
                        paragrafo.textContent = \"hai selezionato: \"+selectedRegioni +\" in provincia di \" + selectedProvincie;
                    }";
                    echo "</script>";
                }
                ?> 

            </form>
        </div>
    </div>

    <footer>pagina php creata da siepi simone fernardez IV</footer>
</body>

</html>