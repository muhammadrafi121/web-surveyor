const jalur = $('#jalur');
const tower1_1 = $('#notower1');
const tower2_1 = $('#notower2');

const jalur2 = $('#jalur2');
const tower1_2 = $('#notower1_2');
const tower2_2 = $('#notower2_2');

$(document).ready(function() {

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var $TABLE = $('#table');  
    var $BTN = $('#export-btn');  
    var $EXPORT = $('#export');

    $('.table-add').click(function () {
        var $clone = $TABLE.find('tr.hide').clone(true).removeClass('hide table-line');
        $TABLE.find('table').append($clone);
    });
    
    $('.table-remove').click(function () {
        $(this).parents('tr').detach();
    });
    
    $('.table-up').click(function () {
        var $row = $(this).parents('tr');
        if ($row.index() === 1) return;
        $row.prev().before($row.get(0));
    });
    
    $('.table-down').click(function () {
        var $row = $(this).parents('tr');
        $row.next().after($row.get(0));
    });
    
    jQuery.fn.pop = [].pop;  
    jQuery.fn.shift = [].shift;  
    
    $BTN.click(function () {
        var $rows = $TABLE.find('tr:not(:hidden)');
        var headers = [];
        var data = [];
        $($rows.shift()).find('th:not(:empty)').each(function () {
            headers.push($(this).text().toLowerCase());
        });
        
        $rows.each(function () {
            var $td = $(this).find('td');
            var h = {};
            headers.forEach(function (header, i) {
                h[header] = $td.eq(i).text();
            });
            data.push(h);
        });
    });

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

    $('.data-tanaman').on('DOMSubtreeModified', function(){
        var id_lahan = $('#id-lahan').val();
        var id = $(this).attr('id');
        var id_arr = id.split('-');
        const index = id_arr.indexOf('tanaman');
        id_arr.splice(index, 1);
        id = id_arr.join('-');
        $('#' + id).val($(this).html());
        console.log($('#' + id + '-' + id_lahan));
    });

    // get data api daerah indonesia

    // provinsi
    $.ajax({
        url: 'https://muhammadrafi121.github.io/api-wilayah-indonesia/api/provinces.json',
        type: 'GET',
        data: { },
        success: function(d) {
            var html = '<option value="">Pilih Provinsi</option>';
            for (var i = 0; i < d.length; i++) {
                html += '<option value="' + d[i].id + '">' + d[i].name + '</option>'
            }
            $('#provinsi').html(html);
        }
    });

    $('#provinsi').on('change', function() {
        $.ajax({
            url: 'https://muhammadrafi121.github.io/api-wilayah-indonesia/api/regencies/' + $(this).val() + '.json',
            data: { },
            success: function(d) {
                var html = '<option value="">Pilih Kabupaten</option>';
                for (var i = 0; i < d.length; i++) {
                    html += '<option value="' + d[i].id + '">' + d[i].name + '</option>'
                }
                $('#kabupaten').html(html);
            }
        });
    });

    $('#kabupaten').on('change', function() {
        $.ajax({
            url: 'https://muhammadrafi121.github.io/api-wilayah-indonesia/api/districts/' + $(this).val() + '.json',
            data: { },
            success: function(d) {
                var html = '<option value="">Pilih Kecamatan</option>';
                for (var i = 0; i < d.length; i++) {
                    html += '<option value="' + d[i].id + '">' + d[i].name + '</option>'
                }
                $('#kecamatan').html(html);
            }
        });
    });

    $('#kecamatan').on('change', function() {
        $.ajax({
            url: 'https://muhammadrafi121.github.io/api-wilayah-indonesia/api/villages/' + $(this).val() + '.json',
            data: { },
            success: function(d) {
                var html = '<option value="">Pilih Kelurahan / Desa</option>';
                for (var i = 0; i < d.length; i++) {
                    html += '<option value="' + d[i].id + '">' + d[i].name + '</option>'
                }
                $('#desa').html(html);
            }
        });
    });
});

function tambah() {
    $('#exampleModal').modal('show');
    $('.modal-title').text('Input Data Lahan');
    $('#pilihan').html('');
    $('#form-action').attr('action', '/land');
    $('input[name="_method"]').val('POST');
}

function edit(data) {
    $('#exampleModal').modal('show');
    $('.modal-title').text('Update Data Lahan');

    $.ajax({
        url: APP_URL + '/ajax/land/',
        data: {
            id: data.id
        },
        success: function(d) {
            
            $.ajax({
                url: 'https://muhammadrafi121.github.io/api-wilayah-indonesia/api/regency/' + d.owner.regency + '.json',
                type: 'GET',
                data: { },
                success: function(dkab) {
                    
                    $.ajax({
                        url: 'https://muhammadrafi121.github.io/api-wilayah-indonesia/api/province/' + dkab.province_id + '.json',
                        type: 'GET',
                        data: { },
                        success: function(dprov) {
                            $('#provinsi').val(dprov.id).change();

                            $.ajax({
                                url: 'https://muhammadrafi121.github.io/api-wilayah-indonesia/api/regencies/' + $('#provinsi').val() + '.json',
                                data: { },
                                success: function(pilihankab) {
                                    var html = '<option value="">Pilih Kabupaten</option>';
                                    for (var i = 0; i < pilihankab.length; i++) {
                                        html += '<option value="' + pilihankab[i].id + '">' + pilihankab[i].name + '</option>'
                                    }
                                    $('#kabupaten').html(html);
                                    $('#kabupaten').val(dkab.id).change();
                                    $.ajax({
                                        url: 'https://muhammadrafi121.github.io/api-wilayah-indonesia/api/districts/' + $('#kabupaten').val() + '.json',
                                        data: { },
                                        success: function(pilihankec) {
                                            var html = '<option value="">Pilih Kecamatan</option>';
                                            for (var i = 0; i < pilihankec.length; i++) {
                                                html += '<option value="' + pilihankec[i].id + '">' + pilihankec[i].name + '</option>'
                                            }
                                            $('#kecamatan').html(html);
                                            $.ajax({
                                                url: 'https://muhammadrafi121.github.io/api-wilayah-indonesia/api/district/' + d.owner.district + '.json',
                                                type: 'GET',
                                                data: { },
                                                success: function(dkec) {
                                                    $('#kecamatan').val(dkec.id).change();
                                                    $.ajax({
                                                        url: 'https://muhammadrafi121.github.io/api-wilayah-indonesia/api/villages/' + $('#kecamatan').val() + '.json',
                                                        data: { },
                                                        success: function(pilihandes) {
                                                            var html = '<option value="">Pilih Kelurahan / Desa</option>';
                                                            for (var i = 0; i < pilihandes.length; i++) {
                                                                html += '<option value="' + pilihandes[i].id + '">' + pilihandes[i].name + '</option>'
                                                            }
                                                            $('#desa').html(html);
                                                            $.ajax({
                                                                url: 'https://muhammadrafi121.github.io/api-wilayah-indonesia/api/village/' + d.owner.village + '.json',
                                                                type: 'GET',
                                                                data: { },
                                                                success: function(ddes) {
                                                                    $('#desa').val(ddes.id).change();
                                                                }
                                                            });
                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    });
        
                }
            });


            var html = '';
            for (var i = 0; i < d[0].locations.length; i++) {
                html += '<option value="' + d[0].locations[i].id + '">' + d[0].locations[i].name + '</option>'
            }
            jalur2.html(html);
        }
    });
    if (data.row_id) {
        $('#tipe').val('row');
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
                    $('#row').val(data.row_id);
                }
            }
        });
    }
    if (data.tower_id) {
        $('#tipe').val('tower');
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
                    $('#tower').val(data.tower_id);
                }
            }
        });
    }

    $('#form-action').attr('action', '/land/' + data.id);
    $('#id-edit').val(data.id);
    $('input[name="_method"]').val('PUT');
    $('#owner-id').val(data.owner.id);
    $('#nama').val(data.owner.name);
    $('#desa').val(data.owner.village);
    $('#kecamatan').val(data.owner.district);
    $('#kabupaten').val(data.owner.regency);
    $('#jenis').val(data.type);
    $('#luas').val(data.area);
}

function saveData() {
    $('#exampleModal').modal('hide');
    $('#exampleModal3').modal('show');
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

function setDetail(data) {
    $.ajax({
        url: APP_URL + '/ajax/land',
        data: {
            id: data.id
        },
        success: function(d) {
            $('#pemilik-detail').html('Nama Pemilik : ' + d.owner.name);
            $.ajax({
                url: 'https://muhammadrafi121.github.io/api-wilayah-indonesia/api/regency/' + d.owner.regency + '.json',
                type: 'GET',
                data: { },
                success: function(dkab) {
                    $('#kabupaten-detail-' + d.id).html('Kabupaten : ' + dkab.name);
                }
            });

            $.ajax({
                url: 'https://muhammadrafi121.github.io/api-wilayah-indonesia/api/district/' + d.owner.district + '.json',
                type: 'GET',
                data: { },
                success: function(dkec) {
                    $('#kecamatan-detail-' + d.id).html(`Kecamatan &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: ` + dkec.name);
                }
            });

            $.ajax({
                url: 'https://muhammadrafi121.github.io/api-wilayah-indonesia/api/village/' + d.owner.village + '.json',
                type: 'GET',
                data: { },
                success: function(ddes) {
                    $('#desa-detail-' + d.id).html(`Desa / Kelurahan &nbsp;: ` + ddes.name);
                }
            });
        }
    });
}

function showHistory(id) {
    $('#modal-' + id).modal('hide');
    $('#history-modal-' + id).modal('show');
}