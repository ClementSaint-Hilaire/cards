<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../img/logo.png" />
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/accueil.css">
    <title>cards - csh</title>
</head>
<body>

    <?php
        include './navbar.php';
        include '../configuration/database.php';
    ?>

    <div class="recherche_container">
        <button class="loupe">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_97_10300)">
                    <path d="M3 10C3 10.9193 3.18106 11.8295 3.53284 12.6788C3.88463 13.5281 4.40024 14.2997 5.05025 14.9497C5.70026 15.5998 6.47194 16.1154 7.32122 16.4672C8.1705 16.8189 9.08075 17 10 17C10.9193 17 11.8295 16.8189 12.6788 16.4672C13.5281 16.1154 14.2997 15.5998 14.9497 14.9497C15.5998 14.2997 16.1154 13.5281 16.4672 12.6788C16.8189 11.8295 17 10.9193 17 10C17 9.08075 16.8189 8.1705 16.4672 7.32122C16.1154 6.47194 15.5998 5.70026 14.9497 5.05025C14.2997 4.40024 13.5281 3.88463 12.6788 3.53284C11.8295 3.18106 10.9193 3 10 3C9.08075 3 8.1705 3.18106 7.32122 3.53284C6.47194 3.88463 5.70026 4.40024 5.05025 5.05025C4.40024 5.70026 3.88463 6.47194 3.53284 7.32122C3.18106 8.1705 3 9.08075 3 10Z" stroke="#1D1D1F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M21 21L15 15" stroke="#1D1D1F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </g>
                <defs>
                    <clipPath id="clip0_97_10300">
                        <rect width="24" height="24" fill="white"/>
                    </clipPath>
                </defs>
            </svg>
        </button>
        <form action="./accueil.php" method="GET" class="rechercher">
            <input type="text" name="search" placeholder="Rechercher par catégorie, titre...">
            <button type="submit" hidden></button>
            <div class="key_container">
                <h1>ctrl</h1>
                <h1>+</h1>
                <h1>K</h1>
            </div>
            <button class="close_search">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.1662 1.44743C13.5323 1.08131 14.1259 1.08131 14.492 1.44743V1.44743C14.8581 1.81354 14.8581 2.40714 14.492 2.77325L2.66004 14.6052C2.29392 14.9713 1.70033 14.9713 1.33421 14.6052V14.6052C0.968094 14.2391 0.968094 13.6455 1.33421 13.2794L13.1662 1.44743Z" fill="#1D1D1F"/>
                    <path d="M3.1764 1.44743C2.81028 1.08131 2.21669 1.08131 1.85058 1.44743V1.44743C1.48446 1.81354 1.48446 2.40714 1.85058 2.77325L13.6826 14.6052C14.0487 14.9713 14.6423 14.9713 15.0084 14.6052V14.6052C15.3745 14.2391 15.3745 13.6455 15.0084 13.2794L3.1764 1.44743Z" fill="#1D1D1F"/>
                </svg>

            </button>
        </form>
    </div>

   <?php
   $search = isset($_GET['search']) ? $_GET['search'] : '';
   $limit = 6; 
   $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

   $previous_offset = max(0, $offset - $limit);

   $query = $db->prepare("SELECT * FROM articles WHERE tags LIKE ? OR titre LIKE ? OR description LIKE ? LIMIT ?, ?");
   $search_param = '%' . $search . '%';
   $query->bindParam(1, $search_param);
   $query->bindParam(2, $search_param);
   $query->bindParam(3, $search_param);
   $query->bindParam(4, $offset, PDO::PARAM_INT);
   $query->bindParam(5, $limit, PDO::PARAM_INT);

   if ($query->execute()) {
       $query->bindColumn('id', $id);
       $query->bindColumn('img', $img);
       $query->bindColumn('titre', $titre);
       $query->bindColumn('description', $description);
       $query->bindColumn('tags', $tags);
   
       $results_found = false; 
   
       echo '<div class="blog">';
   
       while ($query->fetch(PDO::FETCH_BOUND)) {
           $results_found = true; 
           $tags_array = explode(',', $tags);
           $tags_without_comma = implode(' - ', $tags_array);
       
           echo '<a class="card"  href="./article.php?id='.$id.'">';
               echo '<img src="' . htmlspecialchars($img) . '">';
               echo '<h1>' . htmlspecialchars($tags_without_comma) . '</h1>';
               echo '<h2>' . htmlspecialchars($titre) . '</h2>';
               echo '<h3>' . htmlspecialchars($description) . '</h3>';
           echo '</a>';
       }
   
       echo '</div>';
       echo '<section class="charger_plus_container">';

       if (!$results_found) {
           echo '<section class="message_null">';
               echo '<h1>Aucun résultat ne correspond à votre recherche.</h1>';
           echo '</section>';
       } elseif ($results_found && $query->rowCount() >= $limit) {
           $next_offset = $offset + $limit;
               echo '<a class="charger_bouton" href="./accueil.php?search=' . urlencode($search) . '&offset=' . $next_offset . '">PAGE SUIVANTE</a>';
       }

       // Afficher le bouton pour revenir à la pagination précédente si l'offset actuel est supérieur à zéro
       if ($offset > 0) {
           echo '<a class="charger_bouton" href="./accueil.php?search=' . urlencode($search) . '&offset=' . $previous_offset . '">PAGE PRÉCÉDENTE</a>';
           echo '</section>';
       }
   
   } else {
       echo "Erreur lors de l'exécution de la requête : " . $query->errorInfo()[2];
   }

   // Cacher le bouton "Charger plus d'articles" s'il n'y a plus d'articles supplémentaires à charger
   if ($results_found && $query->rowCount() < $limit) {
       echo '<style>.charger_plus_bouton { visibility: hidden; }</style>';
       echo '<style>.charger_plus_container { flex-direction: row; }</style>';
   }

   $db = null;
?>
</body>
<script src="../js/barre_de_recherche.js"></script>
</html>
