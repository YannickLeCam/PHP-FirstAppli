<?php
    session_start();
    ob_start();
    if (isset($_SESSION['error'])) {
        $messageError = $_SESSION['error'];
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        $messageSuccess = $_SESSION['success'];
        unset($_SESSION['success']);
    }


    $title = "Récapitulatif de la commande";
    /**
     * Method createTabHtml Va
     *
     * @return string [HTML Content] Le tebleau structuré grace a HTML
     */
    function createTabHtml():string{
        $totalGen=0;
        $qttTotal=0;
        $htmlContent = '<table class="table table-dark table-striped align-middle">';
        $htmlContent .= '<thead><th><span class="text-center">Id</span class="text-center"></th><th>Nom</th><th>Prix</th><th>Quantité</th><th>Total</th><th>Supprimer | En savoir plus</th></thead><tbody>';
        foreach ($_SESSION["product"] as $id => $product) {
            $htmlContent .= "<tr>";
            $htmlContent .= '<td>'.$id+1 ."</td>";
            $htmlContent .= '<td >'.$product['name']."</td>";
            $htmlContent .= '<td>'.number_format($product['price'],2,","," ")." €</td>";
            $htmlContent .= '<td class="col justify-content-between"><a href="./traitement.php?action=down-qtt&indice='.$id.'"><i class="fa-solid fa-minus" style="color: #ff2929;"></i></a>'.$product['qtt'].'<a href="./traitement.php?action=up-qtt&indice='.$id.'"><i class="fa-solid fa-plus" style="color: #2cce3f;"></i></a></td>';
            $htmlContent .= '<td>'.number_format($product['total'],2,","," ")." €</td>";
            $htmlContent .= '<td class="displayBtn"><a href="./traitement.php?action=delete&indice='.$id.'"><i class="fa-solid fa-xmark" style="color: #ff2929;"></i></a><a href="./detailProduit.php?indice='.$id.'"><i class="fa-solid fa-magnifying-glass"></i></a></td>';
            $totalGen+=$product['total'];
            $qttTotal+=$product['qtt'];
            $htmlContent.="</tr>";
        }
        $htmlContent .= '<tr><td colspan=3>TOTAL :</td><td>'.$qttTotal."</td><td>".number_format($totalGen,2,","," ")." €</td>".'<td><a href="./traitement.php?action=clear"><i class="fa-solid fa-trash-can" style="color: #ff2929;"></i></a></td></tr>';
        $htmlContent .="</tbody></table>";
        return $htmlContent;
    }
?>

    <?php

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
    }
    
    $content = ob_get_clean();
    require_once './template.php';
    ?>

