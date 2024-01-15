<?php
    require_once "get_coords.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

</head>
<style>
    #map{
        position:absolute;
        left:0;
        right:0;
        top:0;
        bottom:0;
        
    }
</style>
<body>
    <div id="map"></div>
    <script>
        let map=L.map('map').setView([45,25],5);
        L.tileLayer('https://api.maptiler.com/maps/streets-v2/{z}/{x}/{y}.png?key=zu81qp5yGvbAgHoNquf3',
        {
            attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',
        }).addTo(map);
        var  officeIcon = L.icon ({
            iconUrl: 'https://i.postimg.cc/kMBzqYWm/1.png',
            iconSize: [35, 35],
        });
        var  distIcon = L.icon ({
            iconUrl: 'https://i.postimg.cc/vHyr3cYN/2.png',
            iconSize: [10, 10],
        });
        <?php
            foreach($points as $point){
                if($point[3]!=0){
                    if($point[2]>=$avg_count[0][0]){
                        echo("
                            officeIcon = L.icon ({
                                iconUrl: 'https://i.postimg.cc/kMBzqYWm/1.png',
                                iconSize: [35*".$point[2]."/".$max_count[0][0].", 35*".$point[2]."/".$max_count[0][0]."],
                            });
                            let marker".$point[0]."=L.marker([".$point[4].", ".$point[5]."], {icon: officeIcon}).addTo(map);
                            marker".$point[0].".bindPopup('<b>".$point[1]."</b>');
                        ");
                    }else if($point[2]<$avg_count[0][0]&&$point[2]>=$avg_count[0][0]/2){
                        echo("
                            officeIcon = L.icon ({
                                iconUrl: 'https://i.postimg.cc/kMBzqYWm/1.png',
                                iconSize: [35*2*".$point[2]."/".$max_count[0][0].", 35*2*".$point[2]."/".$max_count[0][0]."],
                            });
                            let marker".$point[0]."=L.marker([".$point[4].", ".$point[5]."], {icon: officeIcon}).addTo(map);
                            marker".$point[0].".bindPopup('<b>".$point[1]."</b>');
                        ");
                    }else{
                        echo("
                            officeIcon = L.icon ({
                                iconUrl: 'https://i.postimg.cc/kMBzqYWm/1.png',
                                iconSize: [10, 10],
                            });
                            let marker".$point[0]."=L.marker([".$point[4].", ".$point[5]."], {icon: officeIcon}).addTo(map);
                            marker".$point[0].".bindPopup('<b>".$point[1]."</b>');
                        ");
                    }
                }else if($point[3]==0){
                    echo("
                        let marker".$point[0]."=L.marker([".$point[4].", ".$point[5]."], {icon: distIcon}).addTo(map);
                        marker".$point[0].".bindPopup('<b>".$point[1]."</b>');
                    ");
                }
            };
        ?>
        L.Control.Watermark=L.Control.extend({
            onAdd:function(map){
                let img=L.DomUtil.create('img');
                img.src='https://i.postimg.cc/9FHpDv3K/logo-1.png';
                img.style.width='10vw';
                return img;
            },
            onRemove:function(map){}
        });
        L.control.watermark=function(opts){
            return new L.Control.Watermark(opts);
        }

        L.control.watermark({position:'bottomleft'}).addTo(map);
    </script>
</body>
</html>