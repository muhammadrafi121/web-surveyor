function edit(data) {
    $('#form-edit').attr('action', '/location/' + data.id);
    $('#id-edit').val(data.id);
    $('#wilayah2').val(data.inventory_id);
    $('#name2').val(data.name);
}