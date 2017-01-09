<?php
    $file = fopen("G4W/spot/lev1.spo","r");
    $spot_array = array();
    while(! feof($file))
    {
        $number = fgetc($file);
        if ($number == ' ') $number = 'Z';
        $spot_array[] = $number;
    }
    fclose($file);

for ($x = 0; $x < count($spot_array) ; $x++) {
    echo '<div class="div-spo-'.$spot_array[$x].'"></div>';
}
?>

