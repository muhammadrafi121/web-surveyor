$(document).ready(function() {

    $('#wilayah').on('change', function() {
        $.ajax({
            url: APP_URL + '/ajax/datasummary',
            data: {
                inv : $(this).val()
            },
            success: function(d) {
                $('#row-data').html(d.row);
                $('#tower-data').html(d.tower);
            }
        });
    });
    
    // Grafik per wilayah
    $.ajax({
        url: APP_URL + '/ajax/towerinv/',
        data: { },
        success: function(d) {
            new Chart("tower-wilayah-chart", {
                type: "bar",
                data: {
                    labels: d.map(getName),
                    datasets: [
                        {
                            label: "Data Tapak Tower Terisi",
                            backgroundColor: "blue",
                            data: d.map(getFilled)
                        },
                        {
                            label: "Total Data Tapak Tower",
                            backgroundColor: "lightblue",
                            data: d.map(getTotal)
                        },
                    ]
                },
                options:{
                    legend: {display: true},
                    scales: {
                      xAxes: [{ticks: {min: 0, max:d.length}}],
                      yAxes: [{ticks: {min: 0, max:getMax(d)}}],
                    }
                }
            });
        }
    });

    $.ajax({
        url: APP_URL + '/ajax/rowinv/',
        data: { },
        success: function(d) {
            new Chart("row-wilayah-chart", {
                type: "bar",
                data: {
                    labels: d.map(getName),
                    datasets: [
                        {
                            label: "Data RoW Terisi",
                            backgroundColor: "blue",
                            data: d.map(getFilled)
                        },
                        {
                            label: "Total Data RoW",
                            backgroundColor: "lightblue",
                            data: d.map(getTotal)
                        },
                    ]
                },
                options:{
                    legend: {display: true},
                    scales: {
                      xAxes: [{ticks: {min: 0, max:d.length}}],
                      yAxes: [{ticks: {min: 0, max:getMax(d)}}],
                    }
                }
            });
        }
    });

    // akhir grafik wilayah

    //grafik per jalur

    $.ajax({
        url: APP_URL + '/ajax/towerloc/',
        data: { },
        success: function(d) {
            new Chart("tower-jalur-chart", {
                type: "bar",
                data: {
                    labels: d.map(getName),
                    datasets: [
                        {
                            label: "Data Tapak Tower Terisi",
                            backgroundColor: "blue",
                            data: d.map(getFilled)
                        },
                        {
                            label: "Total Data Tapak Tower",
                            backgroundColor: "lightblue",
                            data: d.map(getTotal)
                        },
                    ]
                },
                options:{
                    legend: {display: true},
                    scales: {
                      xAxes: [{ticks: {min: 0, max:d.length}}],
                      yAxes: [{ticks: {min: 0, max:getMax(d)}}],
                    }
                }
            });
        }
    });

    $.ajax({
        url: APP_URL + '/ajax/rowloc/',
        data: { },
        success: function(d) {
            new Chart("row-jalur-chart", {
                type: "bar",
                data: {
                    labels: d.map(getName),
                    datasets: [
                        {
                            label: "Data RoW Terisi",
                            backgroundColor: "blue",
                            data: d.map(getFilled)
                        },
                        {
                            label: "Total Data RoW",
                            backgroundColor: "lightblue",
                            data: d.map(getTotal)
                        },
                    ]
                },
                options:{
                    legend: {display: true},
                    scales: {
                      xAxes: [{ticks: {min: 0, max:d.length}}],
                      yAxes: [{ticks: {min: 0, max:getMax(d)}}],
                    }
                }
            });
        }
    });
    // akhir grafik jalur

    //grafik per jalur

    $.ajax({
        url: APP_URL + '/ajax/towerteam/',
        data: { },
        success: function(d) {
            new Chart("tower-tim-chart", {
                type: "bar",
                data: {
                    labels: d.map(getName),
                    datasets: [
                        {
                            label: "Data Tapak Tower Terisi",
                            backgroundColor: "blue",
                            data: d.map(getFilled)
                        },
                        {
                            label: "Total Data Tapak Tower",
                            backgroundColor: "lightblue",
                            data: d.map(getTotal)
                        },
                    ]
                },
                options:{
                    legend: {display: true},
                    scales: {
                      xAxes: [{ticks: {min: 0, max:d.length}}],
                      yAxes: [{ticks: {min: 0, max:getMax(d)}}],
                    }
                }
            });
        }
    });

    $.ajax({
        url: APP_URL + '/ajax/rowteam/',
        data: { },
        success: function(d) {
            new Chart("row-tim-chart", {
                type: "bar",
                data: {
                    labels: d.map(getName),
                    datasets: [
                        {
                            label: "Data RoW Terisi",
                            backgroundColor: "blue",
                            data: d.map(getFilled)
                        },
                        {
                            label: "Total Data RoW",
                            backgroundColor: "lightblue",
                            data: d.map(getTotal)
                        },
                    ]
                },
                options:{
                    legend: {display: true},
                    scales: {
                      xAxes: [{ticks: {min: 0, max:d.length}}],
                      yAxes: [{ticks: {min: 0, max:getMax(d)}}],
                    }
                }
            });
        }
    });
    // akhir grafik jalur
});

function getName(item) {
    return item.name;
}

function getTotal(item) {
    return item.total;
}

function getFilled(item) {
    return item.filled;
}

function getMax(array) {
    var max = array[0].total;

    for (var i = 1; i < array.length; i++) {
        if (max < array[i].total) max = array[i].total
    }

    return max;
}
