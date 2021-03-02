<?php

/* Purpose: Home page of the blog, displays the 5 most recent blog entries 
 * Author: Mariah Garcia <mgarcia50@academic.rrc.ca>
 * Date: February 05, 2021
 */

// Establish connection to the database
require 'connect.php';

// Query the tweets table for last 5 rows
$query = "SELECT * FROM blogs ORDER BY id DESC LIMIT 5";
$statement = $db->prepare($query); // returns PDOstatement object, $db is connection to database.
$statement->execute(); // return true or false, executes the prepared statement.

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Gemini Fieldnotes - Index</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>

    <!--Displays when there are no rows in blogs table-->
    <?php if (!($statement->rowCount() > 0)) : ?>
        <h1>*pen drop*</h1>
        <h2 style="color: white;">It is quite serene... perhaps you can post.</h2>
    <?php endif ?>

    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">Gemini Fieldnotes - Index</a></h1>
        </div> <!-- END div id="header" -->
        <ul id="menu">
            <li><a href="index.php" class='active'>Home</a></li>
            <li><a href="create.php">New Post</a></li>
        </ul> <!-- END div id="menu" -->
        <div id="all_blogs">
            <div class="blog_post">
                <!-- Only display top 5 blog posts -->
                <?php for ($i = 0; $i < 6; $i++) : ?>
                    <!--If there are rows in the tweets table, then display every row-->
                    <?php while ($row = $statement->fetch()) : ?>
                        <h2><?= $row['title'] ?></h2>
                        <p>
                            <small>
                                <?php echo date('F d, Y g:i a', strtotime($row['created_at'])); ?>
                                <a href="edit.php?id=<?= $row['id'] ?>">edit</a> <!-- MODIFY ID HERE -->
                            </small>
                        </p>
                        <div class="blog_content">
                            <!-- Content is truncated when size is greater than 200 -->
                            <?php if (strlen($row['content']) > 200) : ?>
                                <?= substr($row['content'], 0, 200) . "..." ?>
                                <a href="show.php?id=<?= $row['id'] ?>">Read more</a>
                            <?php endif ?>
                            <?php if (strlen($row['content']) <= 200) : ?>
                                <?= $row['content'] ?>
                            <?php endif ?>
                        </div>
                    <?php endwhile ?>
                <?php endfor ?>
            </div>
        </div>
        <div id="footer">
            Copywrong 2021 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>

</html>