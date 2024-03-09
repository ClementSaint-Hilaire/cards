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

        $query = $db->prepare("SELECT * FROM articles");

        if ($query->execute()) {
            $query->bindColumn('id', $id);
            $query->bindColumn('img', $img);
            $query->bindColumn('titre', $titre);
            $query->bindColumn('description', $description);
            $query->bindColumn('tags', $tags);

            echo '<div class="blog">';

            while ($query->fetch(PDO::FETCH_BOUND)) {
                $tags_array = explode(',', $tags);
                $tags_without_comma = implode(' ', $tags_array);

                echo '<a class="card"  href="./article.php/'.htmlspecialchars($id).'">';
                    echo '<img src="' . htmlspecialchars($img) . '">';
                    echo '<h1>' . htmlspecialchars($tags_without_comma) . '</h1>';
                    echo '<h2>' . htmlspecialchars($titre) . '</h1>';
                    echo '<h3>' . htmlspecialchars($description) . '</h2>';
                echo '</a>';
            }

            echo '</div>';

        } else {
            echo "Erreur lors de l'exécution de la requête : " . $query->errorInfo()[2];
        }

        $db = null;
    ?>

</body>
</html>