<?php
    $file = fopen("G4W/socoban/lev1.soc","r");
    $socoban_array = array();
    while(! feof($file))
    {
        $number = fgetc($file);
        if ($number == ' ') $number = 'Z';
        $socoban_array[] = $number;
    }
    fclose($file);

for ($x = 0; $x < count($socoban_array) ; $x++) {
    echo '<div class="div-soc-'.$socoban_array[$x].'"></div>';
}
?>

