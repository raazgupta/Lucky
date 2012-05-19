<!DOCTYPE html>

<?php 
    if (!$link = mysql_connect('xxx', 'xxx', 'xxx')) {
        echo 'Could not connect to mysql';
        exit;
    }
    
    if (!mysql_select_db('perspective', $link)) {
        echo 'Could not select database';
        exit;
    }
    
    $sql    = 'SELECT * FROM perspectiveTable';
    $result = mysql_query($sql, $link);
    
    if (!$result) {
        echo "DB Error, could not query the database\n";
        echo 'MySQL Error: ' . mysql_error();
        exit;
    }
    
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <title>Happiness in Perspective</title>
        <link href="http://fonts.googleapis.com/css?family=Philosopher" rel='stylesheet' type='text/css'>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <meta property="og:image" content="http://www.soulfulmachine.com/perspective/screenshot-small.png" />
        <style type="text/css">
            #doc_title {
                font-family: 'Philosopher', arial;
                font-weight: bold;
                font-size: xx-large;
            }
            #post {
                margin-left: 5px;
                margin-right: 5px;
                margin-top: 10px;
                margin-bottom: 10px;
            }
            #post_text {
                font-family: 'Philosopher', arial;
                font-size: large;
            }
        </style>
    </head>

    <body>
        
    <div id="doc_title">Happiness in Perspective</div>

    <?php
    
        while ($row = mysql_fetch_assoc($result)) {
            $title = $row['title'];
            $description = $row['description'];
            $link = $row['link'];
            echo "<div id='post'>";
            echo "<div id='post_text'><i>$title</i> : $description</div>";
            echo "<div id='post_text'><a href='$link'>Link</a></div>";
            echo "</div>";
        }
    
    
    
    ?>

    </body>
</html>
