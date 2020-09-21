<?php session_start(); 
include('traitement/connectbdd.php');
$mail = $_SESSION['mail'];
if (isset($mail)){?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>maps</title>
</head>
<body>
<?php 
if(isset($_GET['success'])){
        if($_GET['success'] == 1 ) {?><br><br>
        <center><div class="alert alert-success" role="success">
        vous êtes bien connecter.
        </div></center>
<?php }} ?>
<div class="map">
        <div class="row mx-0 mb-4">
            <div class="col-lg-3 col-md-2 col-sm-1 col-xs-0 col-0"></div>
            <div class="col-lg-6 col-md-8 col-sm-10 col-xs-12 col-0 position-relative">
                <div class="position-absolute blur">
                    <div class="d-flex align-items-center justify-content-center h-100 w-100">
                    </div>
                </div>
                <div id="map"></div>
            </div>
            <div class="col-lg-3 col-md-2 col-sm-1 col-xs-0 col-0"></div>
        </div>
    </div>

</body>
</html>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
	    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.0.0/build/ol.js"></script>

<script>
        function showMap() {
            $('.blur').fadeOut();
        }
	</script>
	
	<script>

		// On initialise la latitude et la longitude de Paris (centre de la carte)

var lat = 49.77003;

var lon = 4.71955;

var macarte = null;

var geolocation = null;

var MarkerLayer = null;



var UserD = {

    Marker: null,

    feature: null,

    Latitude: 0,

    Longitude: 0

}



var Markers = [

//     
//     $req=$bdd->prepare("SELECT * FROM recensement_population WHERE profession = 'abbé'");
//     $req->execute();
//     while ($donnees = $req->fetch()){
//         $habitant = $donnees["id_individu"];

//         $req2=$bdd->prepare("SELECT * FROM histo_geo WHERE user = $habitant");
//         $req2->execute();
//         while ($donnees2 = $req2->fetch()){

//             $LONGITUDE = $donnees2['x'];
//             $LATITUDE = $donnees2['y'];
//     
//     {

//         lat: ,

//         lng: ,

//         is_enabled: true,

//     },
//
    {

        lat: 49.430910,

        lng: 4.843672,

        is_enabled: true,

    },

];



var attribution = new ol.control.Attribution({

    collapsible: false

});



function calcCrow(lat1, lon1, lat2, lon2) {

    var R = 6371; // km

    var dLat = toRad(lat2 - lat1);

    var dLon = toRad(lon2 - lon1);

    var lat1 = toRad(lat1);

    var lat2 = toRad(lat2);



    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +

        Math.sin(dLon / 2) * Math.sin(dLon / 2) * Math.cos(lat1) * Math.cos(lat2);

    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

    var d = R * c;

    return d;

}



function toRad(Value) {

    return Value * Math.PI / 180;

}



function initMap() {

    macarte = new ol.Map({

        controls: ol.control.defaults({attribution: false}).extend([attribution]),

        target: 'map',

        layers: [

            new ol.layer.Tile({

                source: new ol.source.OSM()

            })

        ],

        view: new ol.View({

            center: ol.proj.fromLonLat([lon, lat]),

            zoom: 14

        })

    });

}



function createMarkers() {

    var features = [];



    for (var i = 0; i < Markers.length; i++) {

        var item = Markers[i];

        var longitude = item.lng;

        var latitude = item.lat;



        if (item.is_enabled) {

            var iconFeature = new ol.Feature({

                geometry: new ol.geom.Point(ol.proj.transform([longitude, latitude], 'EPSG:4326', 'EPSG:3857'))

            });



            var iconStyle = new ol.style.Style({

                image: new ol.style.Icon(({

                    anchor: [0.5, 1],

                    src: "https://cdn.mapmarker.io/api/v1/pin?size=32&hoffset=1&background=DB2B39"

                }))

            });



            iconFeature.setStyle(iconStyle);

            features.push(iconFeature);



            Markers[i].Marker = iconFeature;

        }

    }



    var vectorSource = new ol.source.Vector({

        features: features

    });



    var vectorLayer = new ol.layer.Vector({

        source: vectorSource

    });



    MarkerLayer = vectorLayer;

    macarte.addLayer(vectorLayer);

}



function deleteMarker(QuestionId) {

    var mDatas;

    for (var i = 0; i < Markers.length; i++) {

        var item = Markers[i];



        if (item.question_id == QuestionId) {

            mDatas = Markers[i];

            Markers[i].is_enabled = false;

        }

    }



    if (mDatas) {

        macarte.removeLayer(MarkerLayer);

        createMarkers();

    }

}



function createUserMarker(User) {

    var features = [];



    var item = User;

    var longitude = item.lng;

    var latitude = item.lat;



    var iconFeature = new ol.Feature({

        geometry: new ol.geom.Point(ol.proj.transform([longitude, latitude], 'EPSG:4326', 'EPSG:3857'))

    });



    var iconStyle = new ol.style.Style({

        image: new ol.style.Icon(({

            anchor: [0.5, 1],

            src: "https://cdn.mapmarker.io/api/v1/pin?size=32&hoffset=1&background=00ABE7"

        }))

    });



    iconFeature.setStyle(iconStyle);

    features.push(iconFeature);





    var vectorSource = new ol.source.Vector({

        features: features

    });



    var vectorLayer = new ol.layer.Vector({

        source: vectorSource

    });



    UserD.Latitude = User.lat;

    UserD.Longitude = User.lon;

    UserD.Marker = vectorLayer;

    UserD.feature = iconFeature;



    macarte.addLayer(vectorLayer);

}



function checkDistance(QuestionId) {

    var mDatas;

   for (var i = 0; i < Markers.length; i++) {

        var item = Markers[i];

        

        if (item.question_id == QuestionId) {

            mDatas = Markers[i];

        }

   }



    if (mDatas) {

        var distance = calcCrow(mDatas.lat, mDatas.lng, UserD.Latitude, UserD.Longitude) * 1000

        return distance;

    }

 }



$(document).keypress(function() {
    checkDistance(45);

});



$(document).ready(function() {

    initMap();

    createMarkers();



    var view = new ol.View({

        center: [lon, lat],

        zoom: 2

    });



    geolocation = new ol.Geolocation({

        trackingOptions: {

            enableHighAccuracy: false

        },

        projection: view.getProjection()

    });



    geolocation.setTracking(true);



   createUserMarker({

      lat: lat,

        lng: lon

   })



    geolocation.on('change:position', function () {

        var coords = geolocation.position_;



        macarte.setView(new ol.View({

           center: ol.proj.fromLonLat([coords[0], coords[1]]),

            zoom: 16
        }));



       var pos = { longitude: coords[0], latitude: coords[1] }

        UserD.Latitude = pos.latitude;

        UserD.Longitude = pos.longitude;



        UserD.feature.setGeometry(new ol.geom.Point(geolocation.getPosition()));

    });

});
	</script>
    <script type="text/javascript" src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
<script>
scanner = new Instascan.Scanner({ video: video, scanPeriod: 4, mirror:false })
                .then(handleSuccess)
                .catch(handleError);
             //Start scanning
            scanner.addListener('scan', foundCode);

            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                }
                if (cameras.length > 1) {
                    scanner.start(cameras[1]);
                }
                 
             });
</script>
<?php 
}else{header('location: index.php');} ?>