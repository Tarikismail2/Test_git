<!DOCTYPE html>
<html>
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
        <button type="submit">Ajouter le Produit</button> <!-- Utilisation d'un bouton pour soumettre le formulaire -->
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Vérifier si les données nécessaires sont fournies dans la requête POST
        if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price'])) {
            // Créer un tableau associatif avec les données du produit
            $product_data = array(
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price']
            );

            // Convertir le tableau associatif en JSON
            $json_product_data = json_encode($product_data);

            // URL de l'API JSONPlaceholder pour ajouter un nouveau produit
            $url = 'http://localhost:8080/MyWebApi/rest/products';

            // Configuration des options pour la requête cURL POST
            $curl_options = array(
                CURLOPT_URL => $url,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $json_product_data,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
                CURLOPT_RETURNTRANSFER => true
            );

            // Initialiser cURL et exécuter la requête
            $curl = curl_init();
            curl_setopt_array($curl, $curl_options);
            $response = curl_exec($curl);

            // Vérifier s'il y a des erreurs
            if ($response === FALSE) {
                // Gestion des erreurs pour la requête POST
                echo "Erreur lors de l'ajout du produit : " . curl_error($curl);
            } else {
                // Affichage d'un message de succès
                echo "Produit ajouté avec succès !";
                header( 'Location: get_product.php'); 
            }

            // Fermer la session cURL
            curl_close($curl);
        } else {
            // Si les données nécessaires ne sont pas fournies dans la requête POST
            echo "Toutes les données du produit sont requises pour ajouter un nouveau produit.";
        }
    }
    ?>
</body>
</html>
