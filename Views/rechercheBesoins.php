<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 13/11/2016
 * Time: 18:28
 */

include __DIR__ . "/../Controls/rechercheObjetsCtrl.php";
include __DIR__ . "/../Models/rechercheB.php";

//Récupération des variables entrées en $_GET

if(isset($_GET['searchWord'])){
    $searchWord = $_GET['searchWord'];
}
else{
    header('Location: Views/pbRecherche.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Lend it - Objets disponibles</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Source jquery -->
    <script src="Scripts/jquery_library.js"></script>
    <!-- Source JavaScript Bootstrap -->
    <script src="Scripts/bootstrap.js"></script>

    <!-- Source CSS Bootstrap -->
    <link rel="stylesheet" href="Styles/bootstrap.css">

    <!-- Source css pour le design du site -->
    <link rel="stylesheet" href="Styles/base.css">
    <!-- Source css pour cette page -->
    <link rel="stylesheet" href="Styles/mesObjets.css">
    <link rel="stylesheet" href="Styles/popupObjets.css">

    <script>
        if ($(window).width() > 768) {
            <?php $DIV = 5; ?> /* tablet : 8 */
        }
        if ($(window).width() > 992) /* ordi : 10 */
        {
            <?php $DIV = 5; ?>
        }
    </script>
</head>
<body>

    <?php include("header.php"); ?>

    <div class="container content">
        <h2>Recherche d'objets</h2>

        <p>Résultats de la recherche:</p>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Photo</th>
                    <th>Nom</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>

                <?php
        $num = 0; // "num" sert à créer les numéros des lignes du tableau
        $informations_objets = get_available_objets($searchWord); // on récupère les informations des objets disponibles de l'utilisateur

        if (sizeof($informations_objets) != 0) {
            foreach ($informations_objets as $infor) {
                if ($infor[3] != $_SESSION['login']) {
                    $num += 1;

                    if ($num > $page * $DIV) // si on a atteint les objets de la page suivante, on s'arrête
                    break;

                    if ($num <= ($page - 1) * $DIV) // si on parcourt les objets des pages précédentes, on continue
                    continue;

                    $id = $infor[2];


                    //Stockage de l'id dans tr pour le javascript
                    print "<tr id=\"$id\">";
                    print "<td class='numObj'>" . $num . "</td>";


                    $path_photo = "Images/Objets/" . $infor[0];
                    $nom = $infor[1];

                    print "<td class='imgObj'>";
                    print "<img src=\"$path_photo\" class=\"img-thumbnail\" alt=\"$nom\" width=\"76\" height=\"59\">"; // on réduit la taille des images
                    print "</td>";

                    print "<td class='nomObj'>" . $nom . "</td>";

                    print "<td class='supObj'>";

                    $page_email = "emailPreteur.php?owner=".$infor[3];

                    //button "get email address"
                    print "<a class=\"btn btn-primary btn-lg pull-right\" href=\"$page_email\">
                    <span class=\"glyphicon glyphicon-envelope\"></span> </a>";
                    ?>

                    <?php
                    print "</td>";
                    print "</tr>";
                }
            }
        } else
        print "Aucun objet n'a été trouvé";
        ?>

    </tbody>
</table>
</div>

<!-- Pour les pages, on crée des boutons "précédent" et "suivant" -->
<div class="text-center">
    <?php $surplus = $num > $page * $DIV; ?> <!-- "surplus" sert à savoir s'il y a trop d'objets pour une seule page -->
    <ul class="pagination">
        <?php if ($page > 1): ?>
            <li><a href="<?php echo "rechercheObjets.php?page=" . ($page - 1); ?>">«</a></li>
            <li><a href="<?php echo "rechercheObjets.php?page=" . ($page - 1); ?>"><?php echo $page - 1; ?></a></li>
            <li class="active"><a href="#"><?php echo $page; ?></a></li>
        <?php endif; ?>
        <?php if ($surplus): ?>
            <?php if ($page == 1): ?>
                <li class="active"><a href="#"><?php echo $page; ?></a></li>
            <?php endif; ?>
            <li><a href="<?php echo "rechercheObjets.php?page=" . ($page + 1); ?>"><?php echo $page + 1; ?></a></li>
            <li><a href="<?php echo "rechercheObjets.php?page=" . ($page + 1); ?>">»</a></li>
        <?php endif; ?>
    </ul>
</div>

<!-- http://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_modal_sm&stacked=h -->
<!-- Modal envoyer une demande-->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Message d'avertissement</h4>
            </div>
            <div class="modal-body">
                <p id="messageConfirmation"></p>
                <p><br/>Êtes-vous sûr de vouloir continuer ?</p>
            </div>
            <div class="modal-footer">
                <a id="link-button" role="button" class="btn btn-success">Envoyer la demande</a>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="dismiss-button">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal information objet-->

<div id="myObject" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="closePopup">&times;</button>
                <h4 class="modal-title" id="nomObjetPopup"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <img id="photoObjet" src="" class="picturePopup col-md-5"/>
                    <div class="col-md-7">
                        <h3>Description :</h3>
                        <p id="descriptionObjet"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="closeModalObject">Close</button>
            </div>
        </div>

    </div>
</div>
<?php include("footer.php"); ?>
</body>

<script type="text/javascript" src="Scripts/config.js"></script>
<script type="text/javascript" src="Scripts/popupObjet.js"></script>
<script type="text/javascript" src="Scripts/demandeSend.js"> </script>

</html>