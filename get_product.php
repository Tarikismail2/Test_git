<?php
// URL de l'API REST pour les produits
$url = 'http://localhost:8080/MyWebApi/rest/products';
// Requête GET pour récupérer tous les produits
$result = file_get_contents($url);
if ($result === FALSE) {
    // Gestion des erreurs pour la requête GET
    echo "Erreur lors de la requête GET";
} else {
    // Traitement de la réponse de la requête GET
    $products = json_decode($result);
    // Vérifier si des produits ont été récupérés
    if (!empty($products)) {
        echo "<h2>Liste des Produits</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nom</th><th>Prix</th><th>Description</th><th>Actions</th></tr>";
        // Parcourir chaque produit et afficher ses données dans une ligne de tableau
        foreach ($products as $product) {
            echo "<tr>";
            echo "<td>" . $product->id . "</td>";
            echo "<td>" . $product->name . "</td>";
            echo "<td>" . $product->price . "</td>";
            echo "<td>" . $product->description . "</td>";
            // Ajout des liens pour éditer et supprimer
            echo "<td>";
            echo "<a href='put_product_form.php?id=" . $product->id . "'>Modifier</a>";
            echo " | ";
            echo "<a href='delete_product.php?id=" . $product->id . "'>Supprimer</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</br>";
        echo "<a href='add_product_form.php'>Ajoutez un nouveau produit</a>";
    } else {
        echo "Aucun produit trouvé.";  }}
?>
