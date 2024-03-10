<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../img/logo.png" />
    <link rel="stylesheet" href="../css/article.css">
    <title>cards - csh</title>
</head>
<body>

<?php 
    include './navbar.php';
    include '../configuration/database.php';

    echo '<section class="article_container">';

        // Récupérer l'identifiant de l'article depuis l'URL
        $article_id = isset($_GET['id']) ? $_GET['id'] : null;

        if ($article_id) {
            // Préparer la requête en utilisant un paramètre pour l'identifiant de l'article
            $query = $db->prepare("SELECT * FROM articles WHERE id = :id");
            $query->bindParam(':id', $article_id);

            if ($query->execute()) {
                // Récupérer les données de l'article
                $article = $query->fetch(PDO::FETCH_ASSOC);

                if ($article) {
                    // Supprimer la virgule dans les tags
                    $tags_array = explode(',', $article['tags']);
                    $tags_without_comma = implode(' ', $tags_array);

                    // Appliquer les styles CSS aux portions de texte spécifiées
                    $content_with_styles = preg_replace_callback(
                        '/\*([^*]+)\*/',
                        function($matches) {
                            return '<span class="textbold">' . $matches[1] . '</span>';
                        },
                        $article['content']
                    );

                    $content_with_styles = preg_replace_callback(
                        '/#([^#]+)#/',
                        function($matches) {
                            return '<span class="textitalic">' . $matches[1] . '</span>';
                        },
                        $content_with_styles
                    );

                    $content_with_styles = preg_replace_callback(
                        '/@@/',
                        function($matches) {
                            return '<hr class="ligne">';
                        },
                        $content_with_styles
                    );

                    $content_with_styles = preg_replace_callback(
                        '/\|([^|]+)\|/',
                        function($matches) {
                            return '<img src="' . $matches[1] . '">';
                        },
                        $content_with_styles
                    );
                    
                    echo '<div class="article">';
                        // Utiliser $tags_with_spans à la place de $article['tags']
                        echo '<h1>' . htmlspecialchars( $tags_without_comma) . '</h1>';
                        echo '<h2>' . htmlspecialchars($article['titre']) . '</h2>';
                        echo '<img src="' . htmlspecialchars($article['img']) . '">';
                        echo '<h3>' . $content_with_styles . '</h3>';
                    echo '</div>';
                } else {
                    echo "Aucun article trouvé avec l'identifiant spécifié.";
                }

            } else {
                echo "Erreur lors de l'exécution de la requête : " . $query->errorInfo()[2];
            }
        } else {
            echo "Identifiant de l'article non spécifié dans l'URL.";
        }

    echo '</section>';

    $db = null;
?>




</body>