<?php
echo "<div class='formulaire'>";
echo "<p>";
if (isset($messageErreur)){
    echo "$messageErreur";
}else if (isset($i)){
    echo"problemme avec l'arbre $i";
}

echo "</p>";
echo "</div>";
?>