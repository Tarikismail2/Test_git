<?php
    // Vérifier si l'ID du produit est fourni dans la requête DELETE
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // URL de l'API REST pour supprimer le produit spécifique
        $url = 'http://localhost:8080/MyWebApi/rest/products/' . $id;

        // Configuration des options pour la requête DELETE
        $options = array(
            'http' => array(
                'method' => 'DELETE' // Définition de la méthode DELETE
            )
        );
        $context = stream_context_create($options);

        // Effectuer la requête DELETE pour supprimer le produit
        $result = file_get_contents($url, false, $context);

        if ($result === FALSE) {
            // Gestion des erreurs pour la requête DELETE
            echo "Erreur lors de la suppression du produit";
        } else {
            // Affichage d'un message de succès
            echo "Produit supprimé avec succès !";
            header( 'Location: get_product.php'); 
        }
    } else {
        // Si l'ID du produit n'est pas fourni dans la requête DELETE
        echo "L'ID du produit est requis pour effectuer la suppression.";
    }

?>
