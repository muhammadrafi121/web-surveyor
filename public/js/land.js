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
}

function setDataTanaman(data) {
    // $('#id-lahan').val(data.id);

    // $.ajax({
    //     url: APP_URL + '/ajax/land',
    //     data: {
    //         id: data.id
    //     },
    //     success: function(d) {
    //         var html = '';
    //         var totalPlant = 10 - d.plants.length;
    //         var count = 0;
    //         console.log(d.plants);
    //         for (var i = 0; i < d.plants.length; i++) {
    //             var name = d.plants[i].name != null ? d.plants[i].name : '';
    //             var nameValue = d.plants[i].name != null ? `value="` + d.plants[i].name + `"` : '';
                
    //             var age = d.plants[i].age != null ? d.plants[i].age : '';
    //             var ageValue = d.plants[i].age != null ? `value="` + d.plants[i].age + `"` : '';

    //             var height = d.plants[i].height != null ? d.plants[i].height : '';
    //             var heightValue = d.plants[i].height != null ? `value="` + d.plants[i].height + `"` : '';

    //             var diameter = d.plants[i].diameter != null ? d.plants[i].diameter : '';
    //             var diameterValue = d.plants[i].diameter != null ? `value="` + d.plants[i].diameter + `"` : '';

    //             var total = d.plants[i].total != null ? d.plants[i].total : '';
    //             var totalValue = d.plants[i].total != null ? `value="` + d.plants[i].total + `"` : '';

    //             var tmp = ` <tr>
    //                             <input type="hidden" name="idtanaman[]" id="id-` + i + `" value="` + d.plants[i].id + `">
    //                             <td class="data-tanaman" contenteditable="true"
    //                                 id="nama-tanaman-` + i + `">` + name + `</td><input type="hidden"
    //                                 name="namatanaman[]" id="nama-` + i + `" ` + nameValue + `>
    //                             <td class="data-tanaman" contenteditable="true"
    //                                 id="umur-tanaman-` + i + `">` + age + `</td><input type="hidden"
    //                                 name="umurtanaman[]" id="umur-` + i + `" ` + ageValue + `>
    //                             <td class="data-tanaman" contenteditable="true"
    //                                 id="tinggi-tanaman-` + i + `">` + height + `</td><input type="hidden"
    //                                 name="tinggitanaman[]" id="tinggi-` + i + `" ` + heightValue + `>
    //                             <td class="data-tanaman" contenteditable="true"
    //                                 id="diameter-tanaman-` + i + `">` + diameter + `</td><input type="hidden"
    //                                 name="diametertanaman[]" id="diameter-` + i + `" ` + diameterValue + `>
    //                             <td class="data-tanaman" contenteditable="true"
    //                                 id="jumlah-tanaman-` + i + `">` + total + `</td><input type="hidden"
    //                                 name="jumlahtanaman[]" id="jumlah-` + i + `" ` + totalValue + `>
    //                         </tr>
    //             `;
    //             html += tmp;
    //             count++;
    //         }

    //         for (var i = 0; i < totalPlant; i++) {
    //             var tmp = ` <tr>
    //                             <input type="hidden" name="idtanaman[]" id="id-` + count + `">
    //                             <td class="data-tanaman" contenteditable="true"
    //                                 id="nama-tanaman-` + count + `"></td><input type="hidden"
    //                                 name="namatanaman[]" id="nama-` + count + `">
    //                             <td class="data-tanaman" contenteditable="true"
    //                                 id="umur-tanaman-` + count + `"></td><input type="hidden"
    //                                 name="umurtanaman[]" id="umur-` + count + `">
    //                             <td class="data-tanaman" contenteditable="true"
    //                                 id="tinggi-tanaman-` + count + `"></td><input type="hidden"
    //                                 name="tinggitanaman[]" id="tinggi-` + count + `">
    //                             <td class="data-tanaman" contenteditable="true"
    //                                 id="diameter-tanaman-` + count + `"></td><input type="hidden"
    //                                 name="diametertanaman[]" id="diameter-` + count + `">
    //                             <td class="data-tanaman" contenteditable="true"
    //                                 id="jumlah-tanaman-` + count + `"></td><input type="hidden"
    //                                 name="jumlahtanaman[]" id="jumlah-` + count + `">
    //                         </tr>
    //             `;
    //             html += tmp;
    //             count++;
    //         }

    //         $('#tabel-tanaman').html(html);
    //     }
    // });
}