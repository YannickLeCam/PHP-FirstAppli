<?php
session_start();


/**
 * Cette fonction va vérifier si le fichier est bien une image si return "" alors une erreur est détecté et le message d'erreur est set-up deans SESSION['error']
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
    if ($size > 400000) {
        $_SESSION['error']="L'image est trop grosse . . .";
        return "";
    }
    $tabExtensionValide=["jpeg","png","svg","jpg"];
    $extension=explode(".",$name);
    $extension=strtolower(end($extension));
    //Si l'extension du fichier n'est pas dans les valide on l'exclue directement
    if (!in_array($extension,$tabExtensionValide)) {
        $_SESSION['error']="Erreur sur l'extension du fichier envoyer nous reprenons que les format jpeg, png , svg ou jpg . . .";
        return "";
    }else {
        // ici la fichier on est sur que c'est une image
        move_uploaded_file($tmp_name,"./uploadimg/".$name);
        return "./uploadimg/".$name;
    }
    $_SESSION['error']="Erreur inconnue sur image dans la fonction verificationImage . . .";
    return ""; //Si l'image a eu un pb un endroit car il n'a pas passé tout les tests il se retrouve ici (Juste sécurité).
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
            if (isset($_FILES['image'])) {
                if ($_FILES['image']["error"]!=0) {
                    $_SESSION["error"] = "Erreur dans l'upload de l'image : ".$_FILES['image']["error"]." Echec de l'ajout du produit";
                    header("Location:index.php");
                    break;
                }
                $image = verificationImage($_FILES['image']);
                if ($image=="") {
                    //les messages d'erreur sont set-up dans la fonction verificationImage()
                    header("Location:index.php");
                    break;
                }
            }else {
                $_SESSION['error']="Error l'image est ilisible ou est manquante";
                header("Location:index.php");
                break;
            }
            if ($name && $price && $qtt) {
                //On ajoute le nouvel objet dans la session pour pouvoir la récuperer a travers les differetes pages
                if (isInProduct($name)) {
                    $_SESSION['error']="L'objet a déja été initialisé ...";
                    header("Location:index.php");
                    break;
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

                header("Location:index.php");
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
            if (isset($_GET['from'])) {
                header("Location:".$_GET['from']);
                break;
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
            if (isset($_GET['from'])) {
                header("Location:".$_GET['from']);
                break;
            }
            header("Location:recap.php");
            break;
        default:
            header("Location:index.php");
            break;
    }


