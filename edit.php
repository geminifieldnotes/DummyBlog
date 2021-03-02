<?php

/* Purpose: Processes an edit to a blog post
 * Author: Mariah Garcia <mgarcia50@academic.rrc.ca>
 * Date: February 05, 2021
 */

// Establish connection to the database and user must be authenticated
require 'authenticate.php';
require 'connect.php';


// ID parameter from $_GET
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);

// Get title
$title_query = "SELECT title FROM blogs WHERE id = $id";
$statement = $db->query($title_query);
$title = $statement->fetchColumn();

// Get content
$content_query = "SELECT content FROM blogs WHERE id = $id";
$statement = $db->query($content_query);
$content = $statement->fetchColumn();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Gemini Fieldnotes - Edit Post</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">Gemini Fieldnotes - Edit Post</a></h1>
        </div> <!-- END div id="header" -->
        <ul id="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="create.php">New Post</a></li>
        </ul> <!-- END div id="menu" -->
        <div id="all_blogs">
            <form action="process_post.php" method="post">
                <fieldset>
                    <legend>Edit Blog Post</legend>
                    <p>
                        <label for="title">Title</label>
                        <input name="title" id="title" value="<?= $title ?>" />
                    </p>
                    <p>
                        <label for="content">Content</label>
                        <textarea name="content" id="content"><?= $content ?></textarea>
                    </p>
                    <p>
                        <input type="hidden" name="id" value="<?= $id ?>" />
                        <input type="submit" name="command" value="Update" />
                        <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
                    </p>
                </fieldset>
            </form>
        </div>
        <div id="footer">
            Copywrong 2021 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>

</html>