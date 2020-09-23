
<?php include('traitement/connectbdd.php');?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Rando-Charlo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
    <script src="https://kit.fontawesome.com/yourcode.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
</head>

<body id="page-top">
    <div id="wrapper">

        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0">
                <hr class="sidebar-divider my-1">
                <ul class="nav navbar-nav text-light" id="accordionSidebar">

                    <?php
                    $reccup = $bdd->prepare('SELECT profession FROM recensement_population GROUP BY profession ORDER BY profession');
                    $reccup->execute();
                    echo "<div id='jobList'>";
                    while ($data = $reccup->fetch()){ ?>

                    <div class="nav-link"><?=$data['profession']?></div>

                    <?php }
                    echo "</div>";

                    ?>
                    </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>

        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                    <div id="mapid"></div>
            </div>
            
        </div>

        </div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
    integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
</script>
<!-- filtre metier -->
<script>
    
    $('#jobList > *').click(function() {
        var job = this.innerHTML;
        $.post( "back.php", { job: job }, 
            function( data ) {
                addLayer(data, map);
                console.log(data.length);
            }, 
            'json'
        );

    });

</script>

<script>

    let map = initMap();

// coordoné 

    function initMap() {

        let mymap = L.map('mapid').setView([49.766, 4.72], 13);

        L.tileLayer(
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', 
            {
            attribution: 
            'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'pk.eyJ1IjoieW9oYW5uLWQiLCJhIjoiY2tmZHFkMXVsMXM2OTJ5bXExZXBpM29ubiJ9.LnEUS_p0oHqXSeykd5Uo7w'
        })
        .addTo(mymap);

        return mymap;

    }

    function addLayer(coord, carte) {
        try {
            layerGroup.remove(carte);
        } catch(e) {e}

        let circles = [];
    
        coord.forEach(function(i){
            circles.push(L.circle([i.Y, i.X], {
                color: '#4e73df',
                fillColor: '#4e73df',
                fillOpacity: 1,
                radius: 20
            }));
        });
    
        layerGroup = L.layerGroup(circles);
        layerGroup.addTo(carte);

    }



</script>
</body>

</html>