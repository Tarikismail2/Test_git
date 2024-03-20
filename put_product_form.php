<!DOCTYPE html>
<html>
<head>
    <title>Update Product</title>
</head>
<body>
    <h2>Update Product</h2>
    <?php
    // Vérifier si un ID de produit est passé dans l'URL
    if (isset($_GET['id'])) {
        // Récupérer l'ID du produit à partir de l'URL
        $product_id = $_GET['id'];
        
        // URL de l'API REST pour récupérer les détails du produit spécifique
        $url = 'http://localhost:8080/MyWebApi/rest/products/' . $product_id;

        // Récupérer les détails du produit à partir de l'API REST
        $product_details = file_get_contents($url);

        if ($product_details !== FALSE) {
            // Convertir les données JSON en tableau associatif
            $product = json_decode($product_details, true);
            
            // Vérifier si les détails du produit ont été récupérés avec succès
            if ($product) {
                // Afficher le formulaire avec les détails du produit remplis dans les champs
                ?>
                <form action="" method="post">
                    <input type="hidden" name="_method" value="PUT"> <!-- Champ caché pour spécifier la méthode PUT -->
                    <label for="id">ID:</label><br>
                    <input type="text" id="id" name="id" value="<?php echo htmlspecialchars($product['id']); ?>" readonly><br>
                    <label for="name">Name:</label><br>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>"><br>
                    <label for="description">Description:</label><br>
                    <textarea id="description" name="description"><?php echo htmlspecialchars($product['description']); ?></textarea><br>
                    <label for="price">Price:</label><br>
                    <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>"><br><br>
                    <button type="submit">Update Produit</button> 
                </form>
                <?php
            } else {
                // Afficher un message si les détails du produit n'ont pas pu être récupérés
                echo "Erreur lors de la récupération des détails du produit.";
            }
        } else {
            // Afficher un message si la requête vers l'API REST a échoué
            echo "Erreur lors de la communication avec l'API REST.";
        }
    } else {
        // Afficher un message si aucun ID de produit n'a été passé dans l'URL
        echo "ID du produit non spécifié.";
    }
    ?>

    <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'ID du produit et les nouvelles données sont fournies dans la requête POST
    if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        // URL de l'API REST pour mettre à jour le produit spécifique
        $url = 'http://localhost:8080/MyWebApi/rest/products/' . $id;

        // Données à envoyer dans la requête PUT
        $data = array(
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'price' => $price
        );

        // Convertir les données en JSON
        $json_data = json_encode($data);

        // Configuration des options pour le contexte stream
        $options = array(
            'http' => array(
                'method' => 'PUT', // Définition de la méthode PUT
                'header' => 'Content-Type: application/json', // Spécification du type de contenu JSON
                'content' => $json_data // Données JSON à envoyer
            )
        );

        // Créer le contexte stream
        $context = stream_context_create($options);

        // Effectuer la requête PUT pour mettre à jour le produit
        $result = file_get_contents($url, false, $context);

        // Vérifier si la requête a réussi
        if ($result === FALSE) {
            // Gestion des erreurs pour la requête PUT
            echo "Erreur lors de la mise à jour du produit";
        } else {
            // Affichage d'un message de succès
            echo "Produit mis à jour avec succès !";
            header('Location: get_product.php'); 
        }
    } else {
        // Si les données nécessaires ne sont pas fournies dans la requête POST
        echo "Toutes les données du produit sont requises pour effectuer la mise à jour.";
    }
}
?>

</body>
</html>
