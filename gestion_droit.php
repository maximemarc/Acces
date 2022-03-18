<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("location: index.php");
}
require('entete.php');

?>

<body>
    <div class="global">
        <div id="gauche">
            <?php 
            require_once('connect.php');
            
                $vis = pg_fetch_all(pg_query('select modif from modifs where id_modifs = 0'))[0]['modif'];
                if (isset($_SESSION['admin'])) {
                ?>
                <div id="bu">
                    
                    <?php
                    if($vis == 'f')
                    {
                    echo '<button class="bouton" onclick="window.location.href=\'generer_code.php\'">Générer Code</button>';               
                    }
                    else
                    {
                    echo '<button class="bouton2" onclick="window.location.href=\'download_goup.php\'">Script de Création des groupes<p style="color:black;">(execution dans le controleur de Domaine)</p></button>';
                    echo '<button class="bouton2" onclick="window.location.href=\'download_ad.php\'">Script d\'attribution des droits<p style="color:black;">(execution dans le controleur de Domaine)</p></button>'; 
                    echo '<button class="bouton2" onclick="window.location.href=\'download_dos.php\'" >Script de Création de Dossier<p style="color:black;">(execution dans le serveur de fichier)</p></button>';
                    }
                    ?>
                </div>
            <?php
            }
            ?>
            <H1> Utilisateur :</H1>

            <?php
           
            if ($c) {
                $s = "SELECT * FROM account order by nom";
                $r = pg_query($s);
                $tab = pg_fetch_all($r);
                echo '<script type="text/javascript">';
                if($_GET['id'])
                    {
                     echo   'ajax(\'gestion_droit_table.php?id=' . $_GET['id']. '\', \'droit\');';
                       
                    }
                else{
                    echo   'ajax(\'gestion_droit_table.php?id=' . $tab[0]['id_ac'] . '\', \'droit\');';     
                    }
                       
                 echo '</script>';
                if($vis == 'f' || !isset($_SESSION['admin']))
                    {
                    echo  '<div id ="scroll2"> ';
                    }
                 else
                    {
                    echo  '<div id ="scroll"> ';
                    }
                foreach ($tab as $t) {
                    if ($t['nom'] != null && $t['prenom'] != null) {
                        echo '<div class="name" onclick="ajax(\'gestion_droit_table.php?id=' . $t['id_ac'] . '\', \'droit\')">';

                        echo '<p >' . $t['nom'] . ' ' . $t['prenom'] . '</p>';

                        echo '</div>';
                    }
                }
            }
            ?>
        </div>
    </div>
    <div id="droit">

    </div>

</body>