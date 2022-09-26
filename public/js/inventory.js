function edit(data) {
    $('#form-edit').attr('action', '/inventory/' + data.id);
    $('#id-edit').val(data.id);
    $('#name2').val(data.name);
}