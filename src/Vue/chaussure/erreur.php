<?php
echo "<div class='formulaire'>";
echo "<p>";
if (isset($messageErreur)){
    echo "$messageErreur";
}else if (isset($i)){
    echo"problemme avec la chaussure $i"; //todo changer i si il y a un probleme avec une chaussure en particulier
}

echo "</p>";
echo "</div>";
?>