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

    $('.modalButton3').click(function(){
        event.preventDefault();

        console.log("Ура! Мы здесь.");
        console.log("Вывод значения атрибута:");
        console.log($(this).attr('value'));

        $('#modal3').modal('show')
            .find('#modalContent3')
            .load($(this).attr('value'));
    });

    $('#modalButton4').click(function(){
        event.preventDefault();
        $('#modal4').modal('show')
            .find('#modalContent4')
            .load($(this).attr('value'));
    });

    $('#modalButton5').click(function(){
        event.preventDefault();
        $('#modal5').modal('show')
            .find('#modalContent5')
            .load($(this).attr('value'));
    });
});