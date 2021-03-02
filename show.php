<?php

require 'connect.php';

// ID parameter from $_GET
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);

// Get DateTime value
$date_query = "SELECT created_at FROM blogs WHERE id = $id";
$statement = $db->query($date_query);
$date = $statement->fetchColumn();

// Get title
$title_query = "SELECT title FROM blogs WHERE id = $id";
$statement = $db->query($title_query);
$title = $statement->fetchColumn();

// Get content
$content_query = "SELECT content FROM blogs WHERE id = $id";
$statement = $db->query($content_query);
$content = $statement->fetchColumn();

?>


<html>

<head>
    <meta charset="utf-8">
    <title>Gemini Fieldnotes - <?= $title ?></title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">Gemini Fieldnotes - <?= $title ?></a></h1>
        </div> <!-- END div id="header" -->
        <ul id="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="create.php">New Post</a></li>
        </ul> <!-- END div id="menu" -->
        <div id="all_blogs">
            <div class="blog_post">
                <h2><a href="index.php">?= $title ?></a></h2>
                <p>
                    <small>
                        <?php echo date('F d, Y g:i a', strtotime($date)) ?>
                        <a href="edit.php?id=<?= $id ?>">edit</a> <!-- MODIFY ID HERE -->
                    </small>
                </p>
                <div class='blog_content'>
                    <?= $content ?>
                </div>
            </div>
        </div>
        <div id="footer">
            Copywrong 2021 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>

</html>