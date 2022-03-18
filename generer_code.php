<?php
if (isset($_SESSION['admin'])) {
    header("location: index.php");
}
require_once('connect.php');

$donner = '\Donnees\\';


if ($c) {
    $f = 'docs/crea_doss.cmd';
    $handle = fopen($f, "w");
    if (fwrite($handle, '') === FALSE) {
        echo 'Impossible d\'écrire dans le fichier ' . $f . '';
        exit;
    }
    $f2 = 'docs/attribution.cmd';
    $handle2 = fopen($f2, "w");

    $f3 = 'docs/crea_groupes.cmd';
    $handle3 = fopen($f3, "w");
    if (fwrite($handle, '') === FALSE) {
        echo 'Impossible d\'écrire dans le fichier ' . $f3 . '';
        exit;
    }
    // regarde si le fichier est accessible en écriture
    if (is_writable($f)) {
        if (is_writable($f2)) {
            if (is_writable($f3)) {
                $crlf = chr(13) . chr(10);
                $r = 'select * from dossier where id_dos_parent is null';
                $req = pg_query($r);
                $tab = pg_fetch_all($req);
                foreach ($tab as $t) {
                    $chemin = $t['index'] . '-' . $t['dossier'];
                    $index = $t['index'];
                    $crea_doc = 'mkdir "' . $donner . $chemin . '" ' . $crlf .'icacls "' . $donner . $chemin . '" /inheritance:r /t ' . $crlf . 'icacls "' . $donner . $chemin . '" /grant GL_RO_' . $index . ':R ' . $crlf . 'icacls "' . $donner . $chemin . '" /grant GL_RW_' . $index . ':R ' . $crlf;
                    file_put_contents($f, $crea_doc, FILE_APPEND);
                    chemin($chemin, $t['id_dos'], $f, $donner);
                    $crea_groupes = 'net group "GG_RW_' . $index . '" /add  ' . $crlf . 'net localgroup "GL_RW_' . $index . '" /add ' . $crlf . 'net group "GG_RO_' . $index . '" /add ' . $crlf . 'net localgroup "GL_RO_' . $index . '" /add ' . $crlf . 'net localgroup "GL_RO_' . $index . '" "GG_RO_' . $index . '" /add ' . $crlf . 'net localgroup "GL_RW_' . $index . '" "GG_RW_' . $index . '" /add ' . $crlf;
                    file_put_contents($f3, $crea_groupes, FILE_APPEND);
                    group($t['id_dos'], $f3);
                }

                $s = 'select login,id_ac from account where nom is not null';
                $re = pg_query($s);
                $ta = pg_fetch_all($re);
                foreach ($ta as $l) {
                    $s = 'select dossier.index as index, account.login as login, id_l,id_e from attribution join dossier on attribution.id_dos = dossier.id_dos join account on attribution.id_ac = account.id_ac where  attribution.id_ac = ' . $l['id_ac'];
                    $re = pg_query($s);
                    $ta = pg_fetch_all($re);
                    $i = 0;
                    foreach ($ta as $f) {
                        if ($f['id_l'] == 1) {
                            $rep = 'net group GG_RO_' . $f['index'] . ' ' . $f['login'] . ' /add' . $crlf;
                        } else {
                            $rep = 'net group GG_RO_' . $f['index'] . ' ' . $f['login'] . ' /delete' . $crlf;
                        }
                        if ($f['id_e'] == 1) {
                            $rep = $rep . 'net group GG_RW_' . $f['index'] . ' ' . $f['login'] . ' /add' . $crlf;
                        } else {
                            $rep = $rep . 'net group GG_RW_' . $f['index'] . ' ' . $f['login'] . ' /delete' . $crlf;
                        }
                        if (fwrite($handle2, $rep) === FALSE) {
                            echo 'Impossible d\'écrire dans le fichier ' . $f2 . '';
                            exit;
                        }
                    }
                    if ($ta == null) {
                        $s = 'select index from dossier';
                        $re = pg_query($s);
                        $ta = pg_fetch_all($re);
                        foreach ($ta as $f) {
                            $rep = 'net group GG_RO_' . $f['index'] . ' ' . $l['login'] . ' /delete' . $crlf;
                            $rep = $rep . 'net group GG_RW_' . $f['index'] . ' ' . $l['login'] . ' /delete' . $crlf;
                            if (fwrite($handle2, $rep) === FALSE) {
                                echo 'Impossible d\'écrire dans le fichier ' . $f2 . '';
                                exit;
                            }
                        }
                    }
                }
                echo 'Ecriture terminé';
                fclose($handle);
                fclose($handle2);
                fclose($handle3);
                $rins = 'update modifs set modif = true where id_modifs =0';
                $query = pg_query($rins);
                header('location: gestion_droit.php');
            } else {
                echo 'Impossible d\'écrire dans le fichier ' . $f3 . '';
            }
        } else {
            echo 'Impossible d\'écrire dans le fichier ' . $f2 . '';
        }
    } else {
        echo 'Impossible d\'écrire dans le fichier ' . $f . '';
    }
}

function chemin($chemin, $id, $fichier,$d)
{
    $crlf = chr(13) . chr(10);
    $r = 'select * from dossier where id_dos_parent = ' . $id . 'order by index asc';
    $req = pg_query($r);
    $tab2 = pg_fetch_all($req);
    foreach ($tab2 as $l) {
        $index = $l['index'];
        $chemin2 = $chemin . '\\' . $l['index'] . '-' . $l['dossier'];
        $ch = 'mkdir "' . $d . $chemin2 . '" ' . $crlf . 'icacls "' . $d . $chemin2 . '" /inheritance:r /t ' . $crlf . 'icacls "' . $d . $chemin2 . '" /grant GL_RO_' . $index . ':R ' . $crlf . 'icacls "' . $d . $chemin2 . '" /grant GL_RW_' . $index . ':R ' . $crlf;
        file_put_contents($fichier, $ch, FILE_APPEND);
        chemin($chemin2, $l['id_dos'], $fichier, $d);
    }
}


function group($id, $fichier)
{
    $crlf = chr(13) . chr(10);
    $r = 'select * from dossier where id_dos_parent = ' . $id . 'order by index asc';
    $req = pg_query($r);
    $tab2 = pg_fetch_all($req);
    foreach ($tab2 as $l) {
        $index = $l['index'];
        $id_dos_parent = $l['id_dos_parent'];
        $r = 'select index from dossier where id_dos = ' . $id_dos_parent;
        $req = pg_query($r);
        $tab = pg_fetch_all($req);

        $ch = 'net group "GG_RW_' . $index . '" /add' . $crlf . 'net localgroup "GL_RW_' . $index . '" /add ' . $crlf . 'net group "GG_RO_' . $index . '" /add ' . $crlf . 'net localgroup "GL_RO_' . $index . '" /add ' . $crlf . 'net localgroup "GL_RO_' . $index . '" "GG_RO_' . $index . '" /add ' . $crlf . 'net localgroup "GL_RW_' . $index . '" "GG_RW_' . $index . '" /add ' . $crlf . 'net localgroup "GL_RO_' . $tab[0]['index'] . '" "GG_RO_' . $index . '" /add ' . $crlf . 'net localgroup "GL_RO_' . $tab[0]['index'] . '" "GG_RW_' . $index . '" /add ' . $crlf;
        file_put_contents($fichier, $ch, FILE_APPEND);
        group($l['id_dos'], $fichier);
    }
}
