const jalur = $('#jalur');
const tower1_1 = $('#notower1');
const tower2_1 = $('#notower2');

const jalur2 = $('#jalur2');
const tower1_2 = $('#notower1_2');
const tower2_2 = $('#notower2_2');

$(document).ready(function() {

    $('#wilayah').on('change', function() {
        $.ajax({
            url: APP_URL + '/ajax/inventory/',
            data: {
                id: $(this).val()
            },
            success: function(d) {
                var html = '';
                for (var i = 0; i < d[0].locations.length; i++) {
                    html += '<option value="' + d[0].locations[i].id + '">' + d[0].locations[i].name + '</option>'
                }
                jalur.html(html);

                $.ajax({
                    url: APP_URL + '/ajax/location/',
                    data: {
                        id: d[0].locations[0].id
                    },
                    success: function(d) {
                        var html = '';
                        for (var i = 0; i < d[0].towers.length; i++) {
                            html += '<option value="' + d[0].towers[i].id + '">' + d[0].towers[i].no + '</option>'
                        }
                        tower1_1.html(html);
                        tower2_1.html(html);
                    }
                });
            }
        });
    });

    $('#jalur').on('change', function() {
        $.ajax({
            url: APP_URL + '/ajax/location/',
            data: {
                id: $(this).val()
            },
            success: function(d) {
                var html = '';
                for (var i = 0; i < d[0].towers.length; i++) {
                    html += '<option value="' + d[0].towers[i].id + '">' + d[0].towers[i].no + '</option>'
                }
                tower1_1.html(html);
                tower2_1.html(html);
            }
        });
    });

    $('#wilayah2').on('change', function() {
        $.ajax({
            url: APP_URL + '/ajax/inventory/',
            data: {
                id: $(this).val()
            },
            success: function(d) {
                var html = '';
                for (var i = 0; i < d[0].locations.length; i++) {
                    html += '<option value="' + d[0].locations[i].id + '">' + d[0].locations[i].name + '</option>'
                }
                jalur2.html(html);

                $.ajax({
                    url: APP_URL + '/ajax/location/',
                    data: {
                        id: d[0].locations[0].id
                    },
                    success: function(d) {
                        var html = '';
                        for (var i = 0; i < d[0].towers.length; i++) {
                            html += '<option value="' + d[0].towers[i].id + '">' + d[0].towers[i].no + '</option>'
                        }
                        tower1_2.html(html);
                        tower2_2.html(html);
                    }
                });
            }
        });
    });

    $('#jalur2').on('change', function() {
        $.ajax({
            url: APP_URL + '/ajax/location/',
            data: {
                id: $(this).val()
            },
            success: function(d) {
                var html = '';
                for (var i = 0; i < d[0].towers.length; i++) {
                    html += '<option value="' + d[0].towers[i].id + '">' + d[0].towers[i].no + '</option>'
                }
                tower1_2.html(html);
                tower2_2.html(html);
            }
        });
    });
});

function edit(data) {
    $.ajax({
        url: APP_URL + '/ajax/inventory/',
        data: {
            id: data.location.inventory_id
        },
        success: function(d) {
            var html = '';
            for (var i = 0; i < d[0].locations.length; i++) {
                html += '<option value="' + d[0].locations[i].id + '">' + d[0].locations[i].name + '</option>'
            }
            jalur2.html(html);
        }
    });
    $('#form-edit').attr('action', '/row/' + data.id);
    $('#id-edit').val(data.id);
    $('#wilayah2').val(data.location.inventory_id);
    $('#jalur2').val(data.location_id);
    $('#notower1_2').val(data.tower1_id);
    $('#notower2_2').val(data.tower2_id);
}

function showHistory(id) {
    $('#modal-' + id).modal('hide');
    $('#history-modal-' + id).modal('show');
}