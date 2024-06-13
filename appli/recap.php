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


    
    /**
     * Method createTabHtml Va
     *
     * @return string [HTML Content] Le tebleau structuré grace a HTML
     */
    function createTabHtml():string{
        $totalGen=0;
        $qttTotal=0;
        $htmlContent = '<table class="table table-dark table-striped">';
        $htmlContent .= "<thead><th>Id</th><th>Nom</th><th>Prix</th><th>Quantité</th><th>Total</th><th>Supprimer</th></thead><tbody>";
        foreach ($_SESSION["product"] as $id => $product) {
            $htmlContent .= "<tr>";
            $htmlContent .= "<td>".$id+1 ."</td>";
            $htmlContent .= "<td>".$product['name']."</td>";
            $htmlContent .= "<td>".number_format($product['price'],2,","," ")." €</td>";
            $htmlContent .= '<td><a href="./traitement.php?action=down-qtt&indice='.$id.'"><i class="fa-solid fa-minus" style="color: #ff2929;"></i></a>'.$product['qtt'].'<a href="./traitement.php?action=up-qtt&indice='.$id.'"><i class="fa-solid fa-plus" style="color: #2cce3f;"></i></a></td>';
            $htmlContent .= "<td>".number_format($product['total'],2,","," ")." €</td>";
            $htmlContent .= '<td><a href="./traitement.php?action=delete&indice='.$id.'"><i class="fa-solid fa-xmark" style="color: #ff2929;"></i></a><a href="./traitement.php?indice='.$id.'"><i class="fa-solid fa-magnifying-glass"></i></a></td>';
            $totalGen+=$product['total'];
            $qttTotal+=$product['qtt'];
            $htmlContent.="</tr>";
        }
        $htmlContent .= "<tr><td colspan=3>TOTAL :</td><td>$qttTotal</td><td>".number_format($totalGen,2,","," ")." €</td>".'<td><a href="./traitement.php?action=clear"><i class="fa-solid fa-trash-can" style="color: #ff2929;"></i></a></td></tr>';
        $htmlContent .="</tbody></table>";
        return $htmlContent;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif des produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    //verification de l'existance de Serve'' sinon redrect to index
    if (!isset($_SESSION["product"]) || empty($_SESSION['product']) ) {
        echo "<p>Aucun produit disponible pour l'instant ... </p>";
    }else {
        echo createTabHtml();
        echo $_SESSION["product"][0]["photo"];
        echo "<img src\"".$_SESSION["product"][0]["photo"]["tmp_name"]."\"></img>";
    }
    

    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>