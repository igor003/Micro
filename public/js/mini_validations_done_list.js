
function get_validation_done_list(){
    var search = $('#search_validarea').val();
    var date = $('#date_validation').val();
    var mini = $('#mini').val();
    var type = $('#type_val').val();
    $.ajax({
        url: '/mini_valid_done_list',
        type: 'POST',
        data: {
            search:search,
            date:date,
            mini:mini,
            type:type
        },
        dataType: 'json',
        success: function (data) {
            $('#table_validation_done').empty();
            var i = 0;
            while(i< data.length){
                $('#table_validation_done').append(generate_html_validations_done(data[i]));
                i++;
            }
        },
        error:function(error){
            console.log('error; ' + eval(error));
        }
    })
}
function generate_html_validations_done(data){
         var result = '<tr>' +
            '<td class="text-center">'+data.date+'</td>'+
            '<td class="text-center">'+data.minis.name+'</td>'+
            '<td class="text-center">'+data.minis.connector.name+'</td>'+
            '<td class="text-center">'+data.type_validation+'</td>'+
            '<td class="text-center">' +
                // '<a href="/mini/validation_download/'+data.id+'"> <div><img height="40px" width = "40px" src="/img/download.png" alt=""></div></a>'+
            '<form method="POST" action="/mini/download_validation">'+
                ' <input type="hidden" name="path" value="'+data.path+'">'+
                 '<button type="submit"><img height="20px" width = "20px" src="/img/download.png" alt=""></button>'+
            '</form>'+
                
            '</td>' +
         '</tr>';
        return result;     
}

    $('#date_validation').datepicker({
        dateFormat: "yy-mm-dd",
        autoSize: true,
        buttonText: "Choose",
        onSelect: function(){
            $(".ui-datepicker").css('font-size', 12)
            get_validation_done_list();
        }
    });
    $( document ).ready(function() {
        get_validation_done_list();
        $('#date_validation').change(function(){
            get_validation_done_list();
        });
      
        $('#mini').on('change', function(){
            get_validation_done_list();
        });
        $('#type_val').on('change', function(){
            get_validation_done_list();
        });
          
    })