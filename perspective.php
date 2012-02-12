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
        <title>Happiness in Perspective</title>
        <link href="http://fonts.googleapis.com/css?family=Philosopher" rel='stylesheet' type='text/css'>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <meta property="og:image" content="http://www.soulfulmachine.com/perspective/screenshot-small.png" />
        <style type="text/css">
            html {height: 100%}
            body {height: 100%; margin: 0; padding: 0}
            #map_canvas { 
                height: 100%; 
                width: 100%;
                z-index: 1;
            }
            #map_title {
                z-index: 2;
                position: fixed;
                left: 50px;
                top: 20px;
                font-family: 'Philosopher', arial;
                font-weight: bold;
                font-size: xx-large;
                color: white;
            }
            #title { 
                font-family: 'Philosopher', arial;
                font-size: x-large;
            }
            #entry {
                position: relative;
                margin: 0 auto;
                bottom: 25px;
                width: 60%;
                border-radius: 4px;
                background: #ffffff;
                opacity: 1.0;
                z-index: 2;
                padding-top: 2px;
                padding-bottom: 2px;
                padding-left: 5px;
                padding-right: 5px;
                font-family: 'Philosopher', arial;
                font-size: large;
                text-align: center;
            }
        </style>
        <script type="text/javascript"
            src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA-94VWWxvX0H0AfJmbsEe-ylqT4VR-2uo&sensor=false">
        </script>
            
        <script type="text/javascript">
            function initialize(){
                var latlng = new google.maps.LatLng(25.482951,150.253906);
                var myOptions = {
                    zoom: 3,
                    center: latlng,
                    disableDefaultUI: true,
                    mapTypeId: google.maps.MapTypeId.SATELLITE
                };
                var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
                
                //php code repeating the Javascript code for each DB entry
                <?php
                
                $counter = 1;
                
                while ($row = mysql_fetch_assoc($result)) {
                    $title = $row['title'];
                    $description = $row['description'];
                    $location = $row['location'];
                    $link = $row['link'];
                    echo "
                    var latlng$counter = new google.maps.LatLng($location);
                    var marker$counter = new google.maps.Marker({
                    position: latlng$counter,
                    map:map,
                    title: '$title'
                    });
                    
                    var infowindow$counter = new google.maps.InfoWindow({
                    content: \"<div id='title'><p>$description</p><p><a href='$link' target='_blank'>Link</a></p></div>\"
                    });
                    google.maps.event.addListener(marker$counter, 'click', function(){
                    infowindow$counter.open(map, marker$counter);
                    });
                    ";
                    $counter = $counter + 1;

                }
                
                
                
                ?>
                
                                
            }
            
            function findLatLng(form){
                var location = form.location.value;

                
                var geocoder = new google.maps.Geocoder();
                var results, status;
                var latlng = '';
                geocoder.geocode( { 'address': location}, function(results,status)
                                          {
                                            var latlng = '';
                                            if (status == google.maps.GeocoderStatus.OK)
                                            {
                                                var latlng = String(results[0].geometry.location.Pa).concat(",".concat(String(results[0].geometry.location.Qa)));
                                            }
                                            form = document.getElementById('perspectiveForm');
                                            form.latlng.value = latlng;
                                            form.submit();
                                          });
            }
        </script>
    </head>
    
    <body onload="initialize()">
        <div id="map_title">Happiness in Perspective</div>
        <div id="map_canvas"></div>
        <div id="entry">
            <form id="perspectiveForm" name="input" action="enter_perspective.php" method="post">
                Title: <input type="text" name="title" />
                Description: <input type="text" name="description" />
                Location: <input type="text" name="location" />
                Link: <input type="text" name="link" />
                <input type="hidden" name="latlng" value=""/>
                <input type="button" name="button" value = "Add" onClick="findLatLng(this.form)"/> 
            </form>
        </div>
    </body>
</html>
            
