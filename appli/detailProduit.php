<?php
session_start();

if (isset($_GET['indice'])) {
    $indiceProduit = $_GET['indice'];
}else {
    header("Location:index.php");
}

if (isset($_SESSION['product'][$indiceProduit])) {
    $produit = $_SESSION['product'][$indiceProduit];
}else {
    header("Location:index.php");
}

/**
 * trouverIndicePrecedent en cas de UNSET cela permet de recupérer l'élément précédant
 *
 * @param  int $indiceCourrant
 * @return int
 */
function trouverIndicePrecedent(int $indiceCourrant):int{
    if ($indiceCourrant==0) {
        return end($_SESSION['product'])['indice'];
    }
    $stock = 0;
    foreach ($_SESSION['product'] as $indice => $val) {
       
        if ($indice==$indiceCourrant) {
            return $stock;
        }
        $stock=$indice;
    }
    
    return 0;
}

/**
 * trouverIndiceSuivant en cas de UNSET cela permet de récupérer l'élément suivant
 *
 * @param  int $indiceCourrant
 * @return int
 */
function trouverIndiceSuivant(int $indiceCourrant):int{
    $stop = 0;
    foreach ($_SESSION['product'] as $indice => $val) {
        if ($stop == 1) {
            return $indice;
        }
        if ($indice==$indiceCourrant) {
            $stop=1;
        }
    }
    
    return 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $produit["name"] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>
<body>
    <?php
    require './elements/nav.php';
    ?>
    <div class="card" style="width: 18rem;">
        <img src="<?= $produit['photo']?>" class="card-img-top" alt="<?= $produit['photo']?>">
        <div class="card-body">
            <h2 class="card-title"><?= $produit["name"] ?></h2>
            <ul class="list-group">
                <li class="list-group-item">Prix unitaire : <?= number_format($produit["price"],2,',',' ') ?> € </td></li>
                <li class="list-group-item">Quantité commandé : <a href="./traitement.php?action=down-qtt&indice=<?=$indiceProduit?>&from=./detailProduit.php?indice=<?=$indiceProduit?>"><i class="fa-solid fa-minus" style="color: #ff2929;"></i></a> <?=$produit["qtt"]?>  <a href="./traitement.php?action=up-qtt&indice=<?=$indiceProduit?>&from=./detailProduit.php?indice=<?=$indiceProduit?>"><i class="fa-solid fa-plus" style="color: #2cce3f;"></i></a> </li>
                <li class="list-group-item">Prix de la commande : <?= number_format($produit["total"],2,',',' ') ?> €</li>
            </ul>
        </div>
    </div>
    <div class="card position-relative" style="width: 18rem;">
        <?php
            $indicePrecedant = trouverIndicePrecedent($indiceProduit);
            echo '<a href="./detailProduit.php?indice='.($indicePrecedant).'" class="position-absolute start-0"> <button class="btn btn-primary">← '.($_SESSION['product'][$indicePrecedant]["name"]).'</button></a>';
            
            $indiceSuivant = trouverIndiceSuivant($indiceProduit);
            echo '<a href="./detailProduit.php?indice='.($indiceSuivant).'" class="position-absolute end-0"><button class="btn btn-primary">'.$_SESSION['product'][$indiceSuivant]["name"].' →</button></a>';
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
