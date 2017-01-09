<?php
    $file = fopen("G4W/rotms/lev1.rot","r");
    $rotms_array = array();
    while(! feof($file))
    {
        $number = fgetc($file);
        if ($number == ' ') $number = 'Z';
        $rotms_array[] = $number;
    }
    fclose($file);

for ($x = 0; $x < count($rotms_array) ; $x++) {
    echo '<div class="div-rot-'.$rotms_array[$x].'"></div>';
}
?>

