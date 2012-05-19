<?php
    /*
     =====================================================
     Mobile version detection
     -----------------------------------------------------
     compliments of http://www.buchfelder.biz/
     =====================================================
     */
    
    $mobile = "http://www.soulfulmachine.com/perspective/perspectiveMobile.php";
    $text = $_SERVER['HTTP_USER_AGENT'];
    $var[0] = 'Mozilla/4.';
    $var[1] = 'Mozilla/3.0';
    $var[2] = 'AvantGo';
    $var[3] = 'ProxiNet';
    $var[4] = 'Danger hiptop 1.0';
    $var[5] = 'DoCoMo/';
    $var[6] = 'Google CHTML Proxy/';
    $var[7] = 'UP.Browser/';
    $var[8] = 'SEMC-Browser/';
    $var[9] = 'J-PHONE/';
    $var[10] = 'PDXGW/';
    $var[11] = 'ASTEL/';
    $var[12] = 'Mozilla/1.22';
    $var[13] = 'Handspring';
    $var[14] = 'Windows CE';
    $var[15] = 'PPC';
    $var[16] = 'Mozilla/2.0';
    $var[17] = 'Blazer/';
    $var[18] = 'Palm';
    $var[19] = 'WebPro/';
    $var[20] = 'EPOC32-WTL/';
    $var[21] = 'Tungsten';
    $var[22] = 'Netfront/';
    $var[23] = 'Mobile Content Viewer/';
    $var[24] = 'PDA';
    $var[25] = 'MMP/2.0';
    $var[26] = 'Embedix/';
    $var[27] = 'Qtopia/';
    $var[28] = 'Xiino/';
    $var[29] = 'BlackBerry';
    $var[30] = 'Gecko/20031007';
    $var[31] = 'MOT-';
    $var[32] = 'UP.Link/';
    $var[33] = 'Smartphone';
    $var[34] = 'portalmmm/';
    $var[35] = 'Nokia';
    $var[36] = 'Symbian';
    $var[37] = 'AppleWebKit/413';
    $var[38] = 'UPG1 UP/';
    $var[39] = 'RegKing';
    $var[40] = 'STNC-WTL/';
    $var[41] = 'J2ME';
    $var[42] = 'Opera Mini/';
    $var[43] = 'SEC-';
    $var[44] = 'ReqwirelessWeb/';
    $var[45] = 'AU-MIC/';
    $var[46] = 'Sharp';
    $var[47] = 'SIE-';
    $var[48] = 'SonyEricsson';
    $var[49] = 'Elaine/';
    $var[50] = 'SAMSUNG-';
    $var[51] = 'Panasonic';
    $var[52] = 'Siemens';
    $var[53] = 'Sony';
    $var[54] = 'Verizon';
    $var[55] = 'Cingular';
    $var[56] = 'Sprint';
    $var[57] = 'AT&T;';
    $var[58] = 'Nextel';
    $var[59] = 'Pocket PC';
    $var[60] = 'T-Mobile';    
    $var[61] = 'Orange';
    $var[62] = 'Casio';
    $var[63] = 'HTC';
    $var[64] = 'Motorola';
    $var[65] = 'Samsung';
    $var[66] = 'NEC';
    $var[67] = 'iPhone';
    
    $result = count($var);
    
    for ($i=0;$i<$result;$i++)
    {    
        $ausg = stristr($text, $var[$i]);    
        if(strlen($ausg)>0)
        {
            header("location: $mobile");
            exit;
        }
        
    }
?>
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
            src="http://maps.googleapis.com/maps/api/js?key=xxx&sensor=false">
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
        </script>
    </head>
    
    <body onload="initialize()">
        <div id="map_title">Happiness in Perspective</div>
        <div id="map_canvas"></div>
        <div id="entry">
            <form id="perspectiveForm" name="input" action="enter_perspective.php" method="post">
                Title: <input type="text" name="title" />
                Description: <input type="text" name="description" />
                Location (Lat,Lng): <input type="text" name="location" />
                Link: <input type="text" name="link" />
                <input type="submit" value = "Add"/> 
            </form>
        </div>
    </body>
</html>
            
