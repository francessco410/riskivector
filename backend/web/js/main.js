$(function(){
    $('#modalButton').click(function(){
            var flat_id = $('#flat-id').val();
            var link = $(this).attr('value');
            
            $('#modal').modal('show')
                    .find('#modalContent')
                    .load(link+"&id="+flat_id);
    });
});
