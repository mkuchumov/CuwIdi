$(function(){
    $('#modalButton1').click(function(){
        $('#modal1').modal('show')
            .find('#modalContent1')
            .load($(this).attr('value'));
    });

    $('#modalButton2').click(function(){
        $('#modal2').modal('show')
            .find('#modalContent2')
            .load($(this).attr('value'));
    });

    $('#modalButton3').click(function(){
        $('#modal3').modal('show')
            .find('#modalContent3')
            .load($(this).attr('value'));
    });
});