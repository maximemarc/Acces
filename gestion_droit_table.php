<?php
session_start();
$disabled = 'disabled="disabled"';
if (isset($_SESSION['admin'])) {
    $disabled = '';
}
require_once('connect.php');

?>

<form action="gestion_droit_go.php" id="form_droit" method="POST">
    <?php
    $id = intval($_GET['id']);
    $i = 0;
    $j = 0;
    $s = "select nom,prenom from account where id_ac =" . $id;
    $s4 = 'select index , dossier as dos, id_dos as id from dossier order by index';

    $r = pg_query($s);;
    $r4 = pg_query($s4);

    $tab = pg_fetch_all($r);
    $tab4 = pg_fetch_all($r4);

    $max = intval(pg_fetch_all(pg_query('select count(id_dos) as max from dossier'))[0]['max']);

    if (isset($_SESSION['admin'])) {
        echo '<div id="b"><button class ="bouton" >valider</button></div>';
    }

    echo '<table>';
    ?>
    <tr id="prenom">
        <td>
            <?php
            echo '<H1 >' . $tab[0]['nom'] . ' ' . $tab[0]['prenom'] . '</H1>';
            echo '<input type="hidden" name="id_ac" value="' . $id . '"/>';

            echo '</td>';
            if (isset($_SESSION['admin'])) {
                echo '<td><a href="ajout_dossier.php" class="bouton">Création d\'un dossier</a> </td>';
                echo '<td></td><td></td>';
                echo '<td><a href="suppression_dossier.php" class="bouton">Suppression d\'un dossier</a> </td>';
                echo '<td></td><td></td>';
            }
            $vis = pg_fetch_all(pg_query('select modif from modifs where id_modifs = 0'))[0]['modif'];
            if ($vis == 'f') {
                echo '<td><a href="visionner.php" class="bout">Visionner les droits</a> </td>';
            } else {
                echo '<td><a href="visionner.php" class="bouton">Visionner les droits</a> </td>';
            }
            ?>
    </tr>
    <tr id="top1">
        <th id='doc' width="50%">
            Dossier :
        </th>
        <th width="25%">
            Droit en lecture :
        </th>
        <th id="ec" width="25%">
            Droit en écriture :
        </th>
    </tr>
    <tr id="sep">
        <?php

        echo '<div id="scroll_gauche">';
        foreach ($tab4 as $l) {
            echo '<tr>';
            echo '<td class="dos">';
            if (strlen($l['index']) > 1) {
                if (strlen($l['index']) > 2) {
                    if (strlen($l['index']) > 3) {
                        if (strlen($l['index']) > 4) {
                            echo '<p>- - - - | ';
                        } else {
                            echo '<p>- - - | ';
                        }
                    } else {
                        echo '<p>- - | ';
                    }
                } else {
                    echo '<p>- | ';
                }
            } else {
                echo '<p>| ';
            }
            echo $l['index'] . '-' . $l['dos'] . '</p>';
            echo '<input type="hidden" name="dos[]" value="' . $l['id'] . '"/>';
            echo '</td>';
            $s3 = 'select id_l,id_e from attribution  where id_ac =' . $id . ' and id_dos = ' . $l['id'];
            $r3 = pg_query($s3);
            $tab3 = pg_fetch_all($r3);
            $i++;
            if ($tab3 == null) {
                echo '<td class="id_l">';
                echo '<input type="hidden" name="id_l[]" id="l' . $i . '" value="0">';
                echo '<input type="checkbox"  onchange="document.getElementById(\'l' . $i . '\').value = this.value; (this.value ==0)?this.value = 1:this.value = 0;" value="1" '
                 . $disabled . '/> ';
                echo '</td><td class="id_e">';
                echo '<input type="hidden" name="id_e[]" id="e' . $i . '" value="0">';
                echo '<input type="checkbox"  onchange="document.getElementById(\'e' . $i . '\').value = this.value; (this.value ==0)?this.value = 1:this.value = 0;" value="1" '
                 . $disabled . '/> ';
                echo '</td>';
            } else {
                foreach ($tab3 as $t) {
                    echo '<td class="id_l">';
                    if ($t['id_l'] == 1) {
                        echo '<input type="hidden" name="id_l[]" id="l' . $i . '" value="1" />';
                        echo '<input type="checkbox"  onchange="document.getElementById(\'l' . $i . '\').value = this.value; (this.value ==0)?this.value = 1:this.value = 0;" 
                        value="0" checked ="checked" ' . $disabled . '/> ';
                    } else {
                        echo '<input type="hidden" name="id_l[]" id="l' . $i . '" value="0">';
                        echo '<input type="checkbox"  onchange="document.getElementById(\'l' . $i . '\').value = this.value; (this.value ==0)?this.value = 1:this.value = 0;"
                         value="1" ' . $disabled . '/> ';
                    }
                    echo '</td><td class="id_e">';
                    if ($t['id_e'] == 1) {
                        echo '<input type="hidden" name="id_e[]" id="e' . $i . '" value="1" />';
                        echo '<input type="checkbox"  onchange="document.getElementById(\'e' . $i . '\').value = this.value; (this.value ==0)?this.value = 1:this.value = 0;" 
                        value="0" checked ="checked" ' . $disabled . '/> ';
                    } else {
                        echo '<input type="hidden" name="id_e[]" id="e' . $i . '" value="0">';
                        echo '<input type="checkbox"  onchange="document.getElementById(\'e' . $i . '\').value = this.value; (this.value ==0)?this.value = 1:this.value = 0;" 
                        value="1" ' . $disabled . '/> ';
                    }
                    echo '</td>';
                }
            }

            $j++;
            echo '</tr>';
        }

        ?>
        </div>
        </table>
</form>