<?php
    
    $user_name = "xxx";
    $password = "xxx";
    $database = "xxx";
    $server = "xxx";
    $db_handle = mysql_connect($server, $user_name, $password);
    $db_found = mysql_select_db($database, $db_handle);
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['latlng'];
    print $latitude;
    
    
    
    
    $link = $_POST['link'];
    
    if ($db_found) {
        
        $SQL = "INSERT INTO  `perspective`.`perspectiveTable` (
        `number` ,
        `title` ,
        `description` ,
        `location` ,
        `link`
        )
        VALUES (
        NULL ,  '". $title ."',  '".$description."',  '".$location."',  '".$link."'
        );";
        
        $result = mysql_query($SQL);
        
        mysql_close($db_handle);
        
        header( 'Location: http://www.soulfulmachine.com/perspective/perspective.php' ) ;
        
    }
    else {
        print "Database NOT Found ";
        mysql_close($db_handle);
    }
    
?>