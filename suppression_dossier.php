<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("location: index.php");
}
require_once('connect.php');
require('entete.php');
?>
<script type="text/javascript">
    function suppr(id) 
        {
        if(confirm('Confirmez-vous la suppression ?'))
            {
            window.location.href='suppression_dossier_go.php?id='+id;
            }
        }
</script>

    <?php
    $s4 = 'select index , dossier as dos, id_dos from dossier order by index';
    $r4 = pg_query($s4);
    $tab4 = pg_fetch_all($r4);
    
    echo '<table>';
    ?>
    </tr>
    </tr>
    <tr id="top">
        <th id='doc' width="50%">
            Dossier :
        </th>
        <th width="50%">
            supprimer :
        </th>
    </tr>
    <tr id="sep">
    </tr>
        <?php
        foreach ($tab4 as $l) {
            echo '<tr>';
            echo '<td>';
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
            echo '</td>';
            echo '<td>';
            echo '<button class=\'bouton\' onclick="suppr('.$l['id_dos'].')">Supprimer</button>';
            echo '</td></tr>';
        }

        ?>
        </table>
        <button class="bouton3" onclick="window.location.href='gestion_droit.php'">retour</button>
