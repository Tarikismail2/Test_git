<!DOCTYPE html>
<html>
<head>
    <title>Update Product</title>
</head>
<body>
    <h2>Update Product</h2>
    <form action="" method="post">
        <input type="hidden" name="_method" value="PUT"> <!-- Champ caché pour spécifier la méthode PUT -->
        <label for="id">ID:</label><br>
        <input type="text" id="id" name="id" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>" readonly><br>
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description"></textarea><br>
        <label for="price">Price:</label><br>
        <input type="text" id="price" name="price"><br><br>
        <button type="submit">Update Produit</button> 
    </form>

    <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'ID du produit et les nouvelles données sont fournies dans la requête POST
    if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        // URL de l'API JSONPlaceholder pour mettre à jour le produit spécifique
        $url = 'http://localhost:8080/MyWebApi/rest/products/' . $id;

        // Données à envoyer dans la requête PUT
        $data = array(
            'name' => $name,
            'description' => $description,
            'price' => $price
        );

        // Convertir les données en JSON
        $json_data = json_encode($data);

        // Configuration des options pour la requête cURL PUT
        $curl_options = array(
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'PUT', // Définition de la méthode PUT
            CURLOPT_POSTFIELDS => $json_data, // Données JSON à envoyer
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json', // Spécification du type de contenu JSON
                'Content-Length: ' . strlen($json_data) // Spécification de la longueur des données
            ),
            CURLOPT_RETURNTRANSFER => true // Récupérer la réponse
        );

        // Initialiser cURL et exécuter la requête
        $curl = curl_init();
        curl_setopt_array($curl, $curl_options);
        $response = curl_exec($curl);

        // Vérifier s'il y a des erreurs
        if ($response === FALSE) {
            // Gestion des erreurs pour la requête PUT
            echo "Erreur lors de la mise à jour du produit : " . curl_error($curl);
        } else {
            // Affichage d'un message de succès
            echo "Produit mis à jour avec succès !";
            header( 'Location: get_product.php'); 
        }

        // Fermer la session cURL
        curl_close($curl);
    } else {
        // Si les données nécessaires ne sont pas fournies dans la requête POST
        echo "Toutes les données du produit sont requises pour effectuer la mise à jour.";
    }
}
?>

</body>
</html>
