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
});

function tambah() {
    $('#exampleModal').modal('show');
    $('.modal-title').text('Input Data Lahan');
    $('#pilihan').html('');
    $('#form-action').attr('action', '/land/');
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
            console.log(d);
            $('#pemilik-detail').html('Nama Pemilik : ' + d.owner.name);
            $('#desa-detail').html('Desa / Kelurahan : ' + d.owner.village);
            $('#kecamatan-detail').html('Kecamatan : ' + d.owner.district);
            $('#kabupaten-detail').html('Kabupaten : ' + d.owner.regency);
        }
    });

    var daftarP = $('#detail-lahan').DataTable({
        ajax: {
            url: APP_URL + '/ajax/land?id=' + data.id,
            type: 'GET',
            data: function(d) { }
        },
        columns: [{
            data: "type",
            "targets": 0
        },
        {
            data: "area",
            "targets": 1
        },
        {
            data: "type",
            "targets": 2
        },
        {
            data: "area",
            "targets": 3
        },
        {
            data: "area",
            "targets": 4
        },
        {
            data: "area",
            "targets": 5
        },
        {
            data: "area",
            "targets": 6
        },
        ],
        order: [2, 'asc']
    });
}