<?php
session_start();

if(isset($_POST['submit'])){
    //Epuration des données traité avant manipulation
    $name = htmlspecialchars($_POST['name']);
    $price = filter_input(INPUT_POST,"price",FILTER_VALIDATE_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    $qtt = filter_input(INPUT_POST,"qtt", FILTER_VALIDATE_INT);
    var_dump($name);

    if ($name && $price && $qtt) {

        $product = [
            "name"=>$name,
            "price"=>$price,
            "qtt"=>$qtt,
            "total"=>$price*$qtt
        ];

        $_SESSION['product'][]=$product;
    }
}

//header("Location:index.php");