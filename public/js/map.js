$(document).ready(function() {

    // var map = L.map('map').setView([-3.24487, 104.67105], 15);
    var map = L.map('map', {
        doubleClickZoom: false
    }).locate({
        setView: true,
        maxZoom: 15
    });
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 25,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    $.ajax({
        url: APP_URL + '/ajax/allrow/',
        data: { },
        success: function(d) {
            console.log(d[0].firsttower, d[0].secondtower);
            for (var i = 0; i < d.length; i++) {
                L.marker([
                    d[i].firsttower.lat,
                    d[i].firsttower.long,
                ]).addTo(map);
                
                L.marker([
                    d[i].secondtower.lat,
                    d[i].secondtower.long,
                ]).addTo(map);

                L.polygon([
                    [d[i].firsttower.lat, d[i].firsttower.long],
                    [d[i].secondtower.lat, d[i].secondtower.long]
                ]).addTo(map);
            }
        }
    });

    // function onMapClick(e) {
    //     points.push(e.latlng);
    // }

    // map.on('click', onMapClick);
});
