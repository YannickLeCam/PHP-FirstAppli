<?php
    session_start();



    
    /**
     * Method createTabHtml Va
     *
     * @return string [HTML Content] Le tebleau structuré grace a HTML
     */
    function createTabHtml():string{
        $totalGen=0;
        $htmlContent = '<table class="table table-dark table-striped">';
        $htmlContent .= "<thead><th>Id</th><th>Nom</th><th>Prix</th><th>Quantité</th><th>Total</th></thead><tbody>";
        foreach ($_SESSION["product"] as $id => $product) {
            $htmlContent .= "<tr>";
            $htmlContent .= "<td>".$id+1 ."</td>";
            $htmlContent .= "<td>".$product['name']."</td>";
            $htmlContent .= "<td>".number_format($product['price'],2,","," ")." €</td>";
            $htmlContent .= "<td>".$product['qtt']."</td>";
            $htmlContent .= "<td>".number_format($product['total'],2,","," ")." €</td>";
            $totalGen+=$product['total'];
            $htmlContent.="</tr>";
        }
        $htmlContent .= "<tr><td colspan=4>TOTAL :</td><td>".number_format($totalGen,2,","," ")." €</td></tr>";
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
</head>
<body>

    <?php
    //verification de l'existance de Serve'' sinon redrect to index
    if (!isset($_SESSION["product"]) || empty($_SESSION['product']) ) {
        echo "<p>Aucun produit disponible pour l'instant ... </p>";
    }
    echo createTabHtml();

    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>