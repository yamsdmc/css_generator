<?php
$nom_image = "sprite.png";
$nom_css = "style.css";

if(isset($argv[1]))
{
    global $nom_image;
    for($i = 0;$i < count($argv);$i++)
    {
        if($argv[1] == "-i" || $argv[1] == "-s" || $argv[1] == "-r")
        {
            if($argv[$i] == "-i")
            {
                if(!isset($argv[3]) || !is_dir($argv[3]))
                {
                    echo "Veuillez entrer un argument afin de nommer votre image, si cela est fait entrer un nom de dossier comportant des images au format PNG ! \n";
                    return false;
                }
                elseif(isset($argv[$i+1]))
                {
                    $nom_image = $argv[$i+1];
                }
            }
            if($argv[$i] == "-s")
            {
                if(!isset($argv[3]) || !is_dir($argv[3]))
                {
                    echo "Veuillez entrer un argument afin de nommer votre fichier CSS, si cela est fait entrer un nom de dossier comportant des images au format PNG ! \n";
                    return false;
                }
                elseif(isset($argv[$i+1]))
                {
                    $nom_css = $argv[$i+1];
                }
            }
            if($argv[$i] == "-r")
            {            
                if(!isset($argv[2]) || !is_dir($argv[2]))
                {
                    echo "Dossier inéxistant \n";
                    return false;
                }
                elseif(isset($argv[$i+1]))
                {
                    recu($argv[$i+1]);
                }
            }
        }
        else
        {
            echo "L'argument entré n'est pas valide !\n";
            return false;
        }
    }
}
else
{
    echo "Veuillez entrer un argument valide !\n";
    return false;
}
function recu($repert = '.')
{
    $recupimage = [];
    if(is_dir($repert))
    {
        $dossier = opendir($repert);
        while(false !==($fichier = readdir($dossier)))
        {
            if ($fichier != '.' && $fichier != '..' && is_dir($repert . '/' . $fichier))
            {
                $recupimage = array_merge($recupimage, recu($repert . '/' . $fichier));
            }
            elseif (stristr($fichier,'.png'))
            {
                array_push($recupimage, $repert."/".$fichier);
            }
        }
    }
    return $recupimage;
}

function my_merge_image($argv)
{    
    $total_largeur = array();
    $total_hauteur = array();
    $largeur_background = array();
    $somme_largeur = 0;
    $positionx = 0;
    $largeur_background = 0;
    global $nom_image;
    global $nom_css;

    if(isset($argv[2]) && is_dir($argv[2]))
    {
        $arrRecu = recu($argv[2]);
    }
    elseif(isset($argv[3]) && is_dir($argv[3]))
    {
        $arrRecu = recu($argv[3]);
    }
    foreach($arrRecu as $value)
    {
        $dimension = getimagesize($value);
        array_push($total_largeur, $dimension[0]);
        array_push($total_hauteur, $dimension[1]);
    }
    $hauteur_max = max($total_hauteur);

    foreach($total_largeur as $value)
    {
        $somme_largeur += $value;
    }
    
    $image = imagecreatetruecolor($somme_largeur, $hauteur_max);
    $background = imagecolorallocatealpha($image, 0, 0, 0, 127);
    imagefill($image, 0, 0, $background);
    imagealphablending($image, false);
    imagesavealpha($image, true);

    foreach($arrRecu as $value)
    {
        $superposer = imagecreatefrompng($value);
        $valeurdimension = getimagesize($value);
        imagecopy($image, $superposer,$positionx, 0, 0, 0, $valeurdimension[0], $valeurdimension[1]);
        $positionx += $valeurdimension[0];
    }
    imagepng($image, $nom_image);
    
    $open = fopen($nom_css, "w");
    foreach($arrRecu as $key => $value)
    {
        $namefile = pathinfo($value, PATHINFO_FILENAME);
        fputs($open, "$namefile{\n background-image: url('$arrRecu[$key]');\n width: $total_largeur[$key]px;\n height: $total_hauteur[$key]px;\n background-position:". $largeur_background."px, 0px;\n}\n");
        $largeur_background += $total_largeur[$key];
    }
    fclose($open);
}
my_merge_image($argv);
?>