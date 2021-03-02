<?php

/* Purpose: Processes the different functionalities and handling of blog posts in the website (e.g. create, update, delete)
 * Author: Mariah Garcia <mgarcia50@academic.rrc.ca>
 * Date: February 05, 2021
 */

//Establish connection to the database
require 'connect.php';
require 'authenticate.php';

//Universal error when either fields are invalid.
$blog_error = "Eek. An error occured while processing your post.";

$command = $_POST['command'];

//Validates and sanitizes the title and content input.
$user_title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$user_content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$post_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT, FILTER_VALIDATE_INT);

// Block for ID checker
$id_exist = false;
$id_query = "SELECT id FROM blogs WHERE id = '$post_id'";
$statement = $db->query($id_query);
$id = $statement->fetchColumn();

// ID existence checker
if ($id != "") {
    $id_exist = true;
} else {
    $id_exist = false;
}


// If form is posted
if ($_POST) {
    print_r($_POST);

    // Create a new post and insert into database
    if (validate_title() && validate_content() && $id_exist == false) {

        $query = "INSERT INTO blogs (title, content) values (:user_title, :user_content)";
        $statement = $db->prepare($query);
        $statement->bindValue(':user_title', $user_title);
        $statement->bindValue(':user_content', $user_content);

        $statement->execute();

        $insert_id = $db->lastInsertId();

        //header("Location: index.php");
        //exit;
    } else if ((validate_title() && validate_content() && $id_exist == true)) {

        switch ($command) {
            case 'Update':
                print_r($_POST);
                // Update an existing post from the database
                $query = "UPDATE blogs SET title = :user_title, content = :user_content WHERE id = :id";
                $statement = $db->prepare($query);
                $statement->bindvalue(':user_title', $user_title);
                $statement->bindvalue(':user_content', $user_content);
                $statement->bindValue(':id', $post_id, PDO::PARAM_INT);

                $statement->execute();
                break;

            case 'Delete':
                print_r($_POST);
                // Delete existing post from the database
                $query = "DELETE FROM blogs WHERE id = :id LIMIT 1";
                $statement = $db->prepare($query);
                $statement->bindValue(':id', $post_id, PDO::PARAM_INT);

                $statement->execute();
                break;
        }

        //header("Location: index.php");
        //exit;
    }
}


//Check if title is not empty.
function validate_title()
{
    if (!empty($_POST['title']) && (strlen($_POST['title']))) {
        return true;
    }
}

//Checks if content is not empty.
function validate_content()
{
    if (!empty($_POST['content'])) {
        return true;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Gemini Fieldnotes - Process Post</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
    <div id="wrapper">
        <!--Display when the blog post input is invalid-->
        <?php if (!validate_title() && !validate_content()) : ?>
            <h1><?= $blog_error ?></h1>
            <p style="color: maroon;">The title and content field must both be at least 1 character.</p>
        <?php endif ?>
        <?php if (!validate_title() && validate_content()) : ?>
            <h1><?= $blog_error ?></h1>
            <p style="color: maroon;">The title field must be at least 1 character.</p>
        <?php endif ?>
        <?php if (validate_title() && !validate_content()) : ?>
            <h1><?= $blog_error ?></h1>
            <p style="color: maroon;">The content field must be at least 1 character.</p>
        <?php endif ?>

        <a href="index.php">Return Home</a>

        <div id="footer">
            Copywrong 2021 - No Rights Reserved
        </div>
    </div>
</body>

</html>