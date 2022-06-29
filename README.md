# css_generator


Au départ, nous avons un dossier contenant plusieurs images au format PNG.

L’idée principale du projet est de développer un programme, qui concatène toutes ces images en un seul « sprite ».

L’idée secondaire est de générer le fichier CSS représentant cette concaténation.

### Comment lancer le projet ?

Minimum requis concernant les arguments: le dossier qui contient la source des images

``php finalscript.php -r images``

Il est possible de lancer le script avec plusieurs arguments, vous avez le choix de choisir le nom de l'image et du fichier Css qui sera générée.

``php finalscript.php -i generatedImageName.png images -s generatedStyleName.css``


### Les arguments optionnels :

-i Nom de l'image générée + .png

Si vide, le nom par défaut est « sprite.png »

exemple: ``-s generatedImage.png``


-s Nom de la feuille de style générée + .css

Si vide, le nom par défaut est « style.css »

exemple: ``-s styleTest.css``
