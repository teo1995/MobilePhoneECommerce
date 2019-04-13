            var myCenter=new google.maps.LatLng(46.159604,15.754443);
            var marker;
            function initialize()
            {
            var mapProp = {
            center:myCenter,
            zoom:5,
            mapTypeId:google.maps.MapTypeId.ROADMAP
            };
            var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
            var marker=new google.maps.Marker({
            position:myCenter,
            animation:google.maps.Animation.BOUNCE
            });
            $.ajax({
            type: "GET",
            url: "lokacije_baza.php",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                $.each(data, function () {
                    var marker=new google.maps.Marker({
                    position:new google.maps.LatLng(this.Latitude,this.Longitude),
                    map:map,
                    animation:google.maps.Animation.BOUNCE
            });
                });
            }
        });
            marker.setMap(map);
            }
            google.maps.event.addDomListener(window, 'load', initialize);