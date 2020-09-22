<?php 
include('traitement/connectbdd.php');

$job = $_POST;
$res = [];
function convertGeo($X, $Y)
{
    // définition des constantes
    $c = 11754255.426096; //constante de la projection
    $e = 0.0818191910428158; //première exentricité de l'ellipsoïde
    $n = 0.725607765053267; //exposant de la projection
    $xs = 700000; //coordonnées en projection du pole
    $ys = 12655612.049876; //coordonnées en projection du pole

    // pré-calcul
    $a = (log($c / (sqrt(pow(($X - $xs), 2) + pow(($Y - $ys), 2)))) / $n);

    // calcul
    $LONGITUDE = ((atan(- ($X - $xs) / ($Y - $ys))) / $n + 3 / 180 * PI()) / PI() * 180;
    $LATITUDE = asin(tanh((log($c / sqrt(pow(($X - $xs), 2) + pow(($Y - $ys), 2))) / $n) + $e * atanh($e * (tanh($a + $e * atanh($e * (tanh($a + $e * atanh($e * (tanh($a + $e * atanh($e * (tanh($a + $e * atanh($e * (tanh($a + $e * atanh($e * (tanh($a + $e * atanh($e * sin(1)))))))))))))))))))))) / PI() * 180;

    return ['X' => $LONGITUDE, 'Y' => $LATITUDE];
}

foreach($job as $key => $value){

    echo $key;
$req = $bdd->prepare("  SELECT x, y 
                        FROM histo_geo 
                        WHERE user IN 
                        (
                            SELECT id_individu FROM recensement_population WHERE profession = '$key'
                        )
");
$req->execute();
while($coord = $req->fetch()){
    
    echo json_encode(convertGeo($coord['x'], $coord['y']));

}}