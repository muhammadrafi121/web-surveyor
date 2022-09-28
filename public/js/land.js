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

    $('#tipe').on('change', function() {
        if ($(this).val() == 'row') {
            var optHtml = '';
            var html = '<h6 class="font-weight-light mt-n2">Pilih ROW</h6><select class="form-select form-control" id="row" name="row"></select>';
            $('#pilihan').html(html);
            $.ajax({
                url: APP_URL + '/ajax/location/',
                data: {
                    id: jalur.val()
                },
                success: function(d) {
                    for (var i = 0; i < d[0].rows.length; i++) {
                        var tmp= '<option value="' + d[0].rows[i].id + '">' + d[0].rows[i].firsttower.no + '-' + d[0].rows[i].secondtower.no + '</option>';
                        optHtml += tmp;
                        $('#row').html(optHtml);
                    }
                }
            });
        } else if ($(this).val() == 'tower') {
            var optHtml = '';
            var html = '<h6 class="font-weight-light mt-n2">Pilih Tapak Tower</h6><select class="form-select form-control" id="tower" name="tower"></select>';
            $('#pilihan').html(html);
            $.ajax({
                url: APP_URL + '/ajax/location/',
                data: {
                    id: jalur.val()
                },
                success: function(d) {
                    for (var i = 0; i < d[0].towers.length; i++) {
                        var tmp = '<option value="' + d[0].towers[i].id + '">' + d[0].towers[i].no + '</option>';
                        optHtml += tmp;
                        $('#tower').html(optHtml);
                    }
                }
            });
        }
    });
});

function saveData() {
    if ($('#tower').val()) {
        $('#tower-row').attr('name', 'tower');
        $.ajax({
            url: APP_URL + '/ajax/tower/',
            data: {
                id: $('#tower').val()
            },
            success: function(d) {
                $('#tower-row').val(d[0].id);
                $('#row-tower').html('TOWER : ' + d[0].no);
                $('#data-jalur').html('JALUR : ' + d[0].location.name);
                $('#data-inv').html('INV : ' + d[0].location.inventory.name);
            }
        });
    } else if ($('#row').val()) {
        $('#tower-row').attr('name', 'row');
        $.ajax({
            url: APP_URL + '/ajax/row/',
            data: {
                id: $('#row').val()
            },
            success: function(d) {
                $('#tower-row').val(d[0].id);
                $('#row-tower').html('ROW : ' + d[0].firsttower.no + '-' + d[0].secondtower.no);
                $('#data-jalur').html('JALUR : ' + d[0].location.name);
                $('#data-inv').html('INV : ' + d[0].location.inventory.name);
            }
        });
    }
}

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