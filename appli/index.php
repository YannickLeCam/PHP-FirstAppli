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

if (isset($_GET['action'])) {
    $action=$_GET['action'];
}else {
    $action="";
}

$title = "Ajout d'un produit";
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
        <h1>Ajouter un produit</h1>
            <form action="traitement.php?action=add" method="post" enctype="multipart/form-data">
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
                <div>
                    <label for="formFileLg" class="form-label">Image du produit :</label>
                    <input class="form-control form-control-lg" id="formFileLg" type="file" name="image">
                </div>
            </p>
            <p>
                <button type="submit" class="btn btn-primary">Ajouter l'Objet</button>
            </p>
        </form>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
<?php
    $content = ob_get_clean();
    require_once './template.php';
?>