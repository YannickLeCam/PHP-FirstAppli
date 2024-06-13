<?php
session_start();


/**
 * Method verificationImage Cette fonction va vérifier si le fichier est bien une image 
 *
 * @param array $file [explicite description]
 *
 * @return string src de l'image si "" = mauvais format ou imcompatible
 */
function verificationImage(array $file):string{
    $tmp_name=$file['tmp_name'];
    $name = $file['name'];
    $size = $file['size'];

    //image trop grosse
    if ($size > 40000) {
        return "";
    }
    $tabExtensionValide=["jpeg","png","svg"];
    
}

function isInProduct(string $name):bool{
    if (isset($_SESSION['product'])) {
        foreach ($_SESSION['product'] as $product) {
            if ($product['name']==$name) {
                return true;
            }
        }
    }
    return false;
}



    switch ($_GET['action']) {
        case 'add':
                //Epuration des données traité avant manipulation
            $name = htmlspecialchars($_POST['name']);
            $price = filter_input(INPUT_POST,"price",FILTER_VALIDATE_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
            $qtt = filter_input(INPUT_POST,"qtt", FILTER_VALIDATE_INT);
            $image = verificationImage($_FILES['image']);
            if ($name && $price && $qtt) {
                //On ajoute le nouvel objet dans la session pour pouvoir la récuperer a travers les differetes pages
                if (isInProduct($name)) {
                    $_SESSION['error']="L'objet a déja été initialisé ...";
                }else {
                    $product = [
                        "name"=>$name,
                        "photo"=>$image,
                        "price"=>$price,
                        "qtt"=>$qtt,
                        "total"=>$price*$qtt
                    ];
    
                    $_SESSION['product'][]=$product;
                    $_SESSION['success']="L'objet $name a bien été implémenté !";
                }

                header("Location:index.php?action=add");
            }
            break;
        case 'delete':
            
            if (isset($_SESSION['product'][(int)$_GET['indice']])) {
                $_SESSION['success']="Vous avez bien supprimé l'élément ".$_SESSION['product'][$_GET['indice']]["name"];
                unset($_SESSION['product'][(int)$_GET['indice']]);
            }else {
                $_SESSION['error']="Echec de la supprission . . .";
            }
            header("Location:recap.php");
            break;
        case 'clear':
            if (isset($_SESSION['product'])||$_SESSION['product']!=[]) {
                $_SESSION['product']=[];
                $_SESSION['success']="Vous avez bien tout supprimé !";
            }else{
                $_SESSION['error']="Il n'y avait rien a supprimer . . .";
            }
            header("Location:recap.php");
            break;
        case 'up-qtt':
            $indice = $_GET['indice'];
            if (isset($_SESSION['product'][$indice])) {
                $_SESSION['product'][$indice]['qtt']+=1;
                $_SESSION['product'][$indice]['total']=$_SESSION['product'][$indice]['qtt']*$_SESSION['product'][$indice]['price'];
                $_SESSION['success']="Vous avez bien modifier la quantité de ".$_SESSION['product'][$indice]['name'];
            }else {
                $_SESSION['error']="Le produit n'existe pas";
            }
            header("Location:recap.php");
            break;
        case 'down-qtt':
            $indice = $_GET['indice'];
            if (isset($_SESSION['product'][$indice])) {
                $_SESSION['product'][$indice]['qtt']-=1;
                if ($_SESSION['product'][$indice]['qtt']==0) {
                    header("Location:traitement.php?action=delete&indice=$indice");
                    break;
                }else {
                    $_SESSION['product'][$indice]['total']=$_SESSION['product'][$indice]['qtt']*$_SESSION['product'][$indice]['price'];
                    $_SESSION['success']="Vous avez bien modifier la quantité de ".$_SESSION['product'][$indice]['name'];
                }
            }else {
                $_SESSION['error']="Le produit n'existe pas";
            }
            header("Location:recap.php");
            break;
        default:
            header("Location:index.php");
            break;
    }


