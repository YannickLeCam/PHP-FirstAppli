<?php
session_start();
if (isset($_SESSION['error'])) {
    $messageError = $_SESSION['error'];
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    $messageSuccess = $_SESSION['success'];
    unset($_SESSION['success']);
}

if (isset($_GET['action'])) {
    $action=$_GET['action'];
}else {
    $action="";
}

/**
 * Method optionItem créer la listes des options en mettant en value l'indice dans le tableau product et 
 *
 * @return string [HTML Content]
 */
function optionItem():string{
    if (isset($_SESSION['product'])) {
        $htmlContent = "";
        foreach ($_SESSION['product'] as $id => $product) {
            $htmlContent.='<option value="'.$id.'">'.$product['name'].'</option>';
        }
        return $htmlContent;
    }
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manipulation Produits</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    </head>
    <body>
        <?php
            require 'elements/nav.php';
            if (isset($messageError)) {
                echo '<div class="alert alert-danger" role="alert">'.$messageError.'</div>';
            }
            if (isset($messageSuccess)) {
                echo '<div class="alert alert-success" role="alert">'.$messageSuccess.'</div>';
            }
        ?>
        <h1>Ajouter un produit</h1>
            <form action="traitement.php?action=add" method="post">
            <p>
                <label>
                    Nom du produit :
                    <input type="text" name="name">
                </label>
            </p>
            <p>
                <label for="">
                    Prix du produit:
                    <input type="number" step="any" name="price" id="">
                </label>
            </p>
            <p>
                <label for="">
                    Quantité désiré :
                    <input type="number" name="qtt" value="1">
                </label>
            </p>
            <p>
                <button type="submit" class="btn btn-primary">Ajouter l'Objet</button>
            </p>
        </form>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>