<?php
session_start();

if(isset($_POST['submit'])){

    switch ($_GET['action']) {
        case 'add':
                //Epuration des données traité avant manipulation
            $name = htmlspecialchars($_POST['name']);
            $price = filter_input(INPUT_POST,"price",FILTER_VALIDATE_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
            $qtt = filter_input(INPUT_POST,"qtt", FILTER_VALIDATE_INT);

            if ($name && $price && $qtt) {
                //On ajoute le nouvel objet dans la session pour pouvoir la récuperer a travers les differetes pages
                $product = [
                    "name"=>$name,
                    "price"=>$price,
                    "qtt"=>$qtt,
                    "total"=>$price*$qtt
                ];

                $_SESSION['product'][]=$product;
                header("Location:index.php?action=add");
            }
            break;
        case 'delete':
            //code
            var_dump($_POST);
            if (isset($_SESSION['product'][(int)$_POST['indice']])) {
                unset($_SESSION['product'][(int)$_POST['indice']]);
            }
            header("Location:index.php?action=delete");
            break;
        case 'clear':
            //code
            break;
        case 'up-qtt':
            //code
            break;
        case 'down-qtt':
            //code
            break;
        default:
            header("Location:index.php");
            break;
    }
}

