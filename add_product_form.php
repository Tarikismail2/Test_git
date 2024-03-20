<!DOCTYPE html>
S<html>
<head>
    <title>Ajouter un Produit</title>
</head>
<body>
    <h2>Ajouter un Produit</h2>
    <form action="" method="post" id="productForm">
        <label for="name">Nom:</label><br>
        <input type="text" id="name" name="name"><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description"></textarea><br>
        <label for="price">Prix:</label><br>
        <input type="text" id="price" name="price"><br><br>
        <button type="submit">Ajouter le Produit</button> 
    </form>

   <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si les nouvelles données sont fournies dans la requête POST
    if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        // URL de l'API REST pour ajouter un nouveau produit
        $url = 'http://localhost:8080/MyWebApi/rest/products';

        // Données à envoyer dans la requête POST
        $data = array(
            'name' => $name,
            'description' => $description,
            'price' => $price
        );

        // Convertir les données en JSON
        $json_data = json_encode($data);

        // Configuration des options pour le contexte stream
        $options = array(
            'http' => array(
                'method' => 'POST', // Définition de la méthode POST
                'header' => 'Content-Type: application/json', // Spécification du type de contenu JSON
                'content' => $json_data // Données JSON à envoyer
            )
        );

        // Créer le contexte stream
        $context = stream_context_create($options);

        // Effectuer la requête POST pour ajouter le produit
        $result = file_get_contents($url, false, $context);

        // Vérifier si la requête a réussi
        if ($result === FALSE) {
            // Gestion des erreurs pour la requête POST
            echo "Erreur lors de l'ajout du produit";
        } else {
            // Affichage d'un message de succès
            echo "Produit ajouté avec succès !";
            header('Location: get_product.php');
        }
    } else {
        // Si les données nécessaires ne sont pas fournies dans la requête POST
        echo "Toutes les données du produit sont requises pour ajouter un nouveau produit.";
    }
}
?>

</body>
</html>
