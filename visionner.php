
<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("location: index.php");
}
require('entete2.php');
require_once('connect.php');
if ($c) { 
    echo '<body>';
    echo '<span><button class="bouton3" onclick="window.location.href=\'gestion_droit.php\'">retour</button></span>';
    echo '<div id="legende">';
    echo '<div class="ligne">';
    echo '<div id="rouge"></div>';
    echo '<div>droit en écriture et en lecture</div>';
    echo '</div>';
    echo '<br>';
    echo '<div class="ligne">';
    echo '<div id="vert"></div>';
    echo '<div>droit en lecture seul</div>';
    echo '</div>';
    echo '<br>';
    echo '<div class="ligne">';
    echo '<div id="rien"></div>';
    echo '<div>Aucun droit attribué</div>';
    echo '</div>';
    echo '<br>';
    echo '</div>';
    echo '<div id="global">';
    
    echo '<div id="top">';
    echo '<div id="head">';
    $s1 = 'select * from account where nom is not null and prenom is not null order by nom';
    $r1 = pg_query($s1);
    $tab1 = pg_fetch_all($r1);
    foreach ($tab1 as $l) 
        { 
        echo '<div class ="log"><p>'.$l['login'].'</p></div>';
        }
    echo '</div>';
    echo '</div>';
    echo '<div id="main">';
    echo '<div id="left">';
    $s4 = 'select index , dossier as dos, id_dos as id from dossier order by index';
    $r4 = pg_query($s4);
    $tab4 = pg_fetch_all($r4);
    foreach ($tab4 as $l) { 
                echo '<div class ="dos"><p>';
                if (strlen($l['index']) > 1) {
                    if (strlen($l['index']) > 2) {
                        if (strlen($l['index']) > 3) {
                            if (strlen($l['index']) > 4) {
                                echo '- - - - | ';
                            } else {
                                echo '- - - | ';
                                }
                        } else {
                            echo '- - | ';
                            }
                    } else {
                        echo '- | ';
                        }
                } else {
                    echo '| ';
                    }
                echo $l['index'] . '-' . $l['dos'];
                echo '</p></div>';
        }
    echo '</div>';
    echo '<div id="right">';
    echo '<div class="line">';
    $s3 = 'select count(id_ac) as max from account where nom is not null and prenom is not null';
    $r3 = pg_query($s3);
    $tab3 = pg_fetch_all($r3);
    $max = intval($tab3[0]['max']);
    for($i = 0; $i <$max;$i++)
        {
        echo '<div class="col">';
        foreach ($tab4 as $l) 
            { 
            
            $s = 'select id_l,id_e,login,dossier from attribution join dossier on attribution.id_dos = dossier.id_dos join account on attribution.id_ac = account.id_ac where attribution.id_dos = \''.$l['id'].'\'  and login = \''.$tab1[$i]['login'].'\'  and nom is not null and prenom is not null order by nom asc, index asc';
            $r = pg_query($s);
            $tab = pg_fetch_all($r);
            if($tab == null || $tab =='' || $tab == false)
                {
                echo '<div class="rien"></div>';
                }
            else
                {
                foreach($tab as $t)
                    { 
                    if($t['id_e'] == 1 && $t['id_l'] == 1)
                        {
                        echo '<div class="rouge" value="'.$t['login'].'-'.$t['dossier'].'"></div>';
                        }
                    else
                        {
                        if($t['id_l'] == 1)
                            {
                            echo '<div class="vert" value="'.$t['login'].'-'.$t['dossier'].'"></div>';
                            }
                        else
                            {
                            echo '<div class="rien" value="'.$t['login'].'-'.$t['dossier'].'"></div>';
                            }
                        }
                    }
                }    
            }
            echo '</div>';
        }
    echo '</div>';
    echo '</div>';
    echo '</div>';

    echo '</div>';
    echo '</body>';
    } 
