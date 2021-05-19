function generate_calibration_html (data,admin){
    var result = '<tr>' +
        '<td class="text-center">' + data.codice.name + '</td>' +
        '<td class="text-center">' + data.components + '</td>' +
        '<td class="text-center">' + data.minis.connector.name + '</td>'+
        '<td class="text-center">' + data.machines.number + '</td>' +
        '<td class="text-center">' + data.minis.name + '</td>'+
        '<td class="text-center">' + data.calibration_up + '</td>'+
        '<td class="text-center">' + data.calibration_down + '</td>';
            if(admin === true){
                result +=    '<td class="text-center">'+
                '<a href="reports_list/update/' + data.id + '"> <div class="delete"><img height="30px" width = "30px" src="/img/update.png" alt=""></div></a>' +
                '</td>'+
                '<td class="text-center">' +
                '<a href="/mini_calibration_delete/' + data.id + '"> <div class="delete"><img height="30px" width = "30px" src="/img/delete.png" alt=""></div></a>' +
                '</td>';
            }
        result +='</tr>';
    return result;
}
function get_calibrations_list(){
     search = $('#search_calibration').val();
     search_2 = $('#search_machines').val();
     search_3 = $('#search_miniaplicators').val();
     $.ajax({
        url: '/mini_calibaration_list',
        type: 'POST',
        data:{
            search:search,
            search2:search_2,
            search3:search_3
        },
        dataType:'json',
        success:function(data){
       
            $('#calibrations').empty();
            var i = 0;
            while(i< data.all_mini_calib.length){
                $('#calibrations').append(generate_calibration_html(data.all_mini_calib[i],data.admin));
                i++;
            }
        },
        error:function(error){
            console.log('error; ' + eval(error));
        }
     })
}
$( document ).ready(function() {

    $('#search_calibration').on('keyup', function(){
        get_calibrations_list();
    });
    $('#search_machines').on('keyup', function(){
        get_calibrations_list();
    });
    $('#search_miniaplicators').on('keyup', function(){
        get_calibrations_list();
    });
     get_calibrations_list();
 }