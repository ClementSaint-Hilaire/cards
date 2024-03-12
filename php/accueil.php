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
            <input type="text" name="search" placeholder="Rechercher par catégorie">
            <button type="submit">Rechercher</button>
            <button class="close">fermer</button>
        </form>
    </div>

    <?php

        $search = isset($_GET['search']) ? $_GET['search'] : '';

        $query = $db->prepare("SELECT * FROM articles WHERE tags LIKE ?");
        $search_param = '%' . $search . '%';
        $query->bindParam(1, $search_param);


        if ($query->execute()) {
            $query->bindColumn('id', $id);
            $query->bindColumn('img', $img);
            $query->bindColumn('titre', $titre);
            $query->bindColumn('description', $description);
            $query->bindColumn('tags', $tags);

            $results_found = false; // Variable pour suivre si des résultats ont été trouvés

            echo '<div class="blog">';

            while ($query->fetch(PDO::FETCH_BOUND)) {
                $results_found = true; // Au moins un résultat a été trouvé
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

            if (!$results_found) { // Si aucun résultat n'a été trouvé
                echo '<p>Aucun résultat trouvé pour cette recherche.</p>';
            }

        } else {
            echo "Erreur lors de l'exécution de la requête : " . $query->errorInfo()[2];
        }

        $db = null;
    ?>

</body>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var loupeButton = document.querySelector('.loupe');
        var closeButton = document.querySelector('.close');
        var form = document.querySelector('.rechercher');

        loupeButton.addEventListener('click', function() {
            form.style.display = 'flex';
        });

        closeButton.addEventListener('click', function() {
            form.style.display = 'none';
        });
    });
    </script>

</html>
