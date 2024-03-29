$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function get_micro_time (){
    var date_micro = $('#datepicker_photo').val();
  

    $('#date_micro').attr('href','/raport_view/'+date_micro); 
}


$('#submit_form').on('click', function(){
    $('#form_configuration').submit();
});




$(
    $('#project_conf').on('change', function() {
        var selected = $(this).val();
        $.ajax({
            url:'/configuration_codice',
            type: 'POST',
            data: {
                project_id: selected
            },
            dataType: 'json',
            success: function(data) {

                $('#codice_conf').empty();
                var i = 0;
                while ( i < data.length){
                    $('#codice_conf').append("<option value="+data[i].id+">"+ data[i].name+"</option>")
                    i++;
                }
            },
            error: function (error) {
                console.log('error; ' + eval(error));
            }
        });
    })
);

$(
    $('#codice_conf').on('change', function() {
        var selected = $(this).val();
        $.ajax({
            url:'/configuration_project',
            type: 'POST',
            data: {
                codice_id: selected
            },
            dataType: 'json',
            success: function(data) {

                $('#project_conf').empty();
                $('#project_conf').append("<option value="+data.id+">"+ data.name+"</option>")
            },
            error: function (error) {
                console.log('error; ' + eval(error));
            }
        });
    })
);

function get_codice_by_project_conf_update(){
    var selected = $('#project_conf').val();
   
    $.ajax({
        url:'/codice_list/filter',
        type: 'POST',
        data: {
            filter: selected
        },
        dataType: 'json',
        success: function(data) {
            var cur_id = $('#codice_conf_update').val();
            $('#codice_conf_update').empty();
           
            var i = 0;
            while(i < data.length){
                if(data[i].id == cur_id){
                    $('#codice_conf_update').append("<option selected='selected' value="+data[i].id+">"+ data[i].name+"</option>");
                    i++;
                }else{
                    $('#codice_conf_update').append("<option value="+data[i].id+">"+ data[i].name+"</option>");
                    i++;
                }
            }
        },
        error: function (error) {
            console.log('error; ' + eval(error));
        }
    });
}
function get_codice_by_project_conf_created(){
    var selected = $('#project_conf_add').val();
    $.ajax({
        url:'/codice_list/filter',
        type: 'POST',
        data: {
            filter: selected
        },
        dataType: 'json',
        success: function(data) {
            $('#codice_conf_add').empty();
            var i = 0;
            while(i < data.length){
                $('#codice_conf_add').append("<option value="+data[i].id+">"+ data[i].name+"</option>");
                i++;
            }
        },
        error: function (error) {
            console.log('error; ' + eval(error));
        }
    });
}


function generate_html(data,entity,admin){
        var result = '<tr>' +
            '<td class="text-center">'+data.name+'</td>';
            // if(admin === true){
                result += '<td class="text-center">' +
                '<a href="'+entity+'_list/update_view/'+data.id+'"> <div><img height="40px" width = "40px" src="/img/update.png" alt=""></div></a>'+
                '</td>' +
                '<td class="text-center">' +
                '<a style="display:block" class="delete" href="'+entity+'_list/delete/'+data.id+'"> <img height="40px" width = "40px" src="/img/delete.png" alt=""></a>'+
                '</td>' 
            // }
        result += '</tr>';
        return result;     
}

function generate_html_validations(data){
         var result = '<tr>' +
            '<td class="text-center">'+data.date+'</td>'+
            '<td class="text-center">'+data.minis.name+'</td>'+
            '<td class="text-center">'+data.minis.connector.name+'</td>'+
            '<td class="text-center">'+data.type_validation+'</td>'+
            '<td class="text-center">' +
                '<a href="/mini/validation_upload/'+data.id+'"> <div><img height="40px" width = "40px" src="/img/upload.png" alt=""></div></a>'+
            '</td>' +
         '</tr>';
        return result;     
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
function generate_html_connectors(data,entity,admin){
    
        var result = '<tr>' +
            '<td class="text-center">'+data.name+'</td>';
            if(data.specification_path){
                result += 
                '<td class="text-center">' +
                '<form method="POST" action="/download_specification">'+
                    ' <input type="hidden" name="path" value="'+data.specification_path+'">'+
                    '<button type="submit"><img height="50px" width = "50px" src="/img/specific.png" alt=""></button>'+
                '</form>' +
                '</td>'
             }else{
                  result += 
                '<td class="text-center">' +
                '<div><img height="50px" width = "100px" src="/img/missing.jpg" alt=""></div>'+
                '</td>'
             }
                result += '<td class="text-center">' +
                '<a href="'+entity+'_list/update_view/'+data.id+'"> <div><img height="40px" width = "40px" src="/img/update.png" alt=""></div></a>'+
                '</td>' +
                '<td class="text-center">' +
                '<a href="'+entity+'_list/delete/'+data.id+'"> <div><img height="40px" width = "40px" src="/img/delete.png" alt=""></div ></a>'+
                '</td>';
            
        result += '</tr>';
        return result;     
}

function generate_machines_html(data,entity,admin){
        var result = '<tr>' +
            '<td class="text-center">'+data.number+'</td>';
            if(admin === true){
                result += '<td class="text-center">' +
                '<a href="'+entity+'_list/update_view/'+data.id+'"> <div><img height="40px" width = "40px" src="/img/update.png" alt=""></div></a>'+
                '</td>' +
                '<td class="text-center">' +
                '<a href="'+entity+'_list/delete/'+data.id+'"> <div><img height="40px" width = "40px" src="/img/delete.png" alt=""></div ></a>'+
                '</td>' 
            }
        result += '</tr>';
        return result;     
}

function generate_html_codice (data,entity,admin){
        var result = '<tr>' +
            '<td class="text-center"><a href="photo_list_view/'+data.id+'">'+data.name+'</a></td>' ;
            if(admin === true){
                result += '<td class="text-center">' +
                '<a href="'+entity+'_list/BOM/'+data.id+'"> <div>BOM</div></a>'+
                '</td>' +
                '<td class="text-center">' +
                '<a href="'+entity+'_list/update_view/'+data.id+'"> <div><img height="40px" width = "40px" src="/img/update.png" alt=""></div></a>'+
                '</td>' +
                '<td class="text-center">' +
                '<a href="'+entity+'_list/delete/'+data.id+'"> <div><img height="40px" width = "40px" src="/img/delete.png" alt=""></div ></a>'+
                '</td>' 
            }
            result +='</tr>';
        return result;
}

function generate_html_reports(data){
        var result = '<tr>' +
            '<td class="text-center">' + data.date + '</td>' +
            '<td class="text-center">' + data.total_launch + '</td>' +
            '<td class="text-center">' + data.total_micr + '</td>' +
            '<td class="text-center">' + data.efectuated_micr + '</td>';
        // if(admin === true){
            result +='<td class="text-center">' +
            '<a href="reports_list/delete/' + data.id + '"> <div class="delete"><img height="30px" width = "30px" src="/img/delete.png" alt=""></div></a>' +
            '</td>';
            // }
            result +='</tr>';
        return result;
}

 

$( document ).ready(function() {
        $('.delete').click(function(event){
            event.preventDefault();
            swal({
                title: "Tu esti uverenii?",
                text: "tu udalesti navsegda",
                icon: "warning",
                buttons: ["Ne udaliati!","Udaliti"],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Tu ai udalit navsegda", {
                      icon: "success",

                    });
                    document.location = $(this).attr('href');
                } else {
                    swal("Tu n-ai udalit nica!");
                }
            });
        });
    
 
    $('#sez_comp').on('keyup',function(){
        var str = $(this).val().split('+');
        console.log(str);
        var summ = 0;
        for(var i = 0;i<str.length;i++){
                summ = Number(summ)+ Number(str[i]);
        }
        $('#total_sez').val(summ.toFixed(2));
        console.log(summ);

    });
    $('.delete_link').on('click', function(){
        confirm("Do you want to delete?");
    });

    $('#project_conf').on('click', function() {
        get_codice_by_project_conf_update();
    });

    $('#project_conf_add').on('click', function(){
        get_codice_by_project_conf_created();
    });
    $("input[type='checkbox']").on('click',function(){
        get_codice_list();
    });
    $("input[type='checkbox']").on('click',function(){
        get_miniaplicators_list();
    });
    $('#search_project').on('keyup',function(){
        get_project_list();
    });
    $('#connector').on('keyup',function(){
        get_miniaplicator_list();
    });
    $('#search_connector').on('keyup',function(){
        get_connector_list();
    });
    $('#search_codice').on('keyup',function() {
        get_codice_list();
    });
    $('#connector1').on('change',function() {
        get_miniaplicators_list();
    });
    $('#codice').on('change',function(){
        get_conf_by_part_id();
    })
    // $('#date_validation').change(function(){
    //     get_validation_done_list();
    // });
  
    // $('#mini').on('change', function(){
    //     get_validation_done_list();
    // });
    // $('#type_val').on('change', function(){
    //     get_validation_done_list();
    // });
    $('#search_miniaplicator').on('keyup',function(){
        get_miniaplicators_list();
    });
    $('#search_machine').on('keyup',function(){
        get_machines_list();
    });

    get_codice_list();
    get_project_list();
    get_codice_by_project_conf_update();
    get_codice_by_project_conf_created();
    get_miniaplicators_list();
    get_connector_list();
    get_machines_list();
    get_reports_list();
    get_validation_list();
    // get_validation_done_list();
   

});

function get_codice_list(){
    var filter = [];
    $('input[type="checkbox"]:checked').each(function () {
        filter.push(this.value);
    });
    var search;
    search = $('#search_codice').val();

    $.ajax({
        url: '/codice_list',
        type: 'POST',
        data: {
            filter: filter,
            search:search
        },
        dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#table_codice').empty();
                var i = 0;
                while(i< data.parts.length){
                    $('#table_codice').append(generate_html_codice(data.parts[i],'codice',data.admin));
                    if(data.parts[i].project){
                            $('#codice_project').html('<h4>'+data.parts[i].project.name+'</h4>');
                    }else{
                         $('#codice_project').html('');
                    }
                    i++;
                }
        },
        error:function(error){
            console.log('error; ' + eval(error));
        }
    })
}

function get_project_list(){
    var search;
    search = $('#search_project').val();

    $.ajax({
        url: '/project_list',
        type: 'POST',
        data: {
            search:search
        },
        dataType: 'json',
        success: function (data) {
            $('#table_projects').empty();
            var i = 0;
            while(i< data.project.length){
                $('#table_projects').append(generate_html(data.project[i],'project',data.admin));
                i++;
            }
        },
        error:function(error){
            console.log('error; ' + eval(error));
        }
    })
}

function get_conf_by_part_id(){
    var cur_part = $('#codice').val();
    $.ajax({
        url:'/configuration/get_by_part_id',
        type: 'POST',
        data:{
            part_id:cur_part
        },
        dataType:'json',
        success: function (data){

            
                $('#calibr_components').empty();
                var i = 0;
                while(i< data.length){
                    $('#calibr_components').append('<option value='+data[i].components+'>'+data[i].components+'</option>');
                    i++;
                };
        },
        error:function (error){
            console.log('error; ' + eval(error));
        }
    })
}

 function generate_html_select_mini(data){
    var result = '<option value="'+data.id+'">'+data.name+'</option>';
    return result;
}
function get_minis_by_terminal(){
    var connector_id = $('#conenctor_id').val();

   $.ajax({
        url: '/get_minis_by_connector',
        type: 'POST',
        data: {
            connector:connector_id
        },
        dataType: 'json',
        success: function (data) {
           console.log(data);
            var i = 0;
            while(i< data.length){
                $('#minis').append(generate_html_select_mini(data[i]));
                i++;
            }
         
        },
        error:function(error){
            console.log('error; ' + eval(error));
        }
    })
}

function get_connector_list(){
    var search;
    search = $('#search_connector').val();
    filter = $('connector').val();
    $.ajax({
        url: '/connector_list',
        type: 'POST',
        data: {
            search:search
        },
        dataType: 'json',
        success: function (data) {
            $('#table_connector').empty();
            var i = 0;
            while(i< data.connectors.length){
                $('#table_connector').append(generate_html_connectors(data.connectors[i],'connector',data.admin));
                i++;
            }
        },
        error:function(error){
            console.log('error; ' + eval(error));
        }
    })
}


function get_machines_list(){
    var search;
    search = $('#search_machine').val();

    $.ajax({
        url: '/machine_list',
        type: 'POST',
        data: {
            search:search,
            filter:filter
        },
        dataType: 'json',
        success: function (data) {
            $('#table_machines').empty();
            var i = 0;
            while(i< data.machines.length){
                $('#table_machines').append(generate_machines_html(data.machines[i],'machine',data.admin));
                i++;
            }
        },
        error:function(error){
            console.log('error; ' + eval(error));
        }
    })
}

function get_validation_list(){
    var search;
    search = $('#search_validarea').val();
    // var filter = $('#connector1').val();
    $.ajax({
        url: '/mini_valid_list',
        type: 'POST',
        data: {
            search:search,
        },
        dataType: 'json',
        success: function (data) {

            $('#table_validation').empty();
            var i = 0;
            while(i< data.length){
                $('#table_validation').append(generate_html_validations(data[i]));
                i++;
            }
        },
        error:function(error){
            console.log('error; ' + eval(error));
        }
    })
}

// function get_validation_done_list(){
//     var search = $('#search_validarea').val();
//     var date = $('#date_validation').val();
//     var mini = $('#mini').val();
//     var type = $('#type_val').val();
//     $.ajax({
//         url: '/mini_valid_done_list',
//         type: 'POST',
//         data: {
//             search:search,
//             date:date,
//             mini:mini,
//             type:type
//         },
//         dataType: 'json',
//         success: function (data) {
//             $('#table_validation_done').empty();
//             var i = 0;
//             while(i< data.length){
//                 $('#table_validation_done').append(generate_html_validations_done(data[i]));
//                 i++;
//             }
//         },
//         error:function(error){
//             console.log('error; ' + eval(error));
//         }
//     })
// }

function get_miniaplicators_list(){
    var search;
    search = $('#search_miniaplicator').val();
    var filter = $('#connector1').val();
    $.ajax({
        url: '/miniaplicator_list',
        type: 'POST',
        data: {
            search:search,
            filter:filter
        },
        dataType: 'json',
        success: function (data) {

            $('#table_miniaplicators').empty();
            var i = 0;
            while(i< data.length){
                $('#table_miniaplicators').append(generate_html(data[i],'miniaplicator',data.admin));
                i++;
            }
        },
        error:function(error){
            console.log('error; ' + eval(error));
        }
    })
}


function get_reports_list(){
     $.ajax({
        url: '/all_reports',
        type: 'POST',
        data: {
            // filter: filter,
            // search:search
        },
        dataType: 'json',
        success: function (data) {

            var reports = data.length;
            $('#table_reports').empty();
            var i = 0;
            while(i< reports){
                $('#table_reports').append(generate_html_reports(data[i]));
                i++;
            }
        },
        error:function(error){
            console.log('error; ' + eval(error));
        }
    });
}


function get_ajax_exec_time_data(handleData){
    var date = $('#datepicker_exec').val();
    var dt = new Date();

    var month  = dt.getMonth() + 1;
    if (month < 10) {month = "0"+month};
    if(date){
        $('#cur_date').html(date);
    }else{
       $('#cur_date').html(dt.getFullYear()+'-'+month+'-'+dt.getDate()); 
    }
    

    $.ajax({
        url:'/data_exec_time',
        type:'POST',
        data:{
            date:date,
        },
       
        dataType:'json',
        success:function(data){
            console.log(data)
            $('#media').html('<h3>Executing average time: ' +data[1]+'min.</h3>');
          

            handleData(data[0]); 
        },
        // error:function(error){
        //     handleData(0); 
        //     $('#media').html('');
        //     console.log('error' + eval(error));
        // }
         error: function (jqXHR, exception) {
                            var msg = '';
                            if (jqXHR.status === 0) {
                                msg = 'Not connect.\n Verify Network.';
                            } else if (jqXHR.status == 404) {
                                msg = 'Requested page not found. [404]';
                            } else if (jqXHR.status == 500) {
                                msg = 'Internal Server Error [500].';
                            } else if (exception === 'parsererror') {
                                msg = 'Requested JSON parse failed.';
                            } else if (exception === 'timeout') {
                                msg = 'Time out error.';
                            } else if (exception === 'abort') {
                                msg = 'Ajax request aborted.';
                            } else {
                                msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            }
                            console.log(msg);
                        },
    })
}

$(function(){
    $('#date_from').datepicker({
        dateFormat: "yy-mm-dd",
        autoSize: true,
        buttonText: "Choose",
        beforeShow: function(){
            $(".ui-datepicker").css('font-size', 12)
        }
    });
    $('#date_to').datepicker({
        dateFormat: "yy-mm-dd",
        autoSize: true,
        buttonText: "Choose",
        beforeShow: function(){
            $(".ui-datepicker").css('font-size', 12)
        }
    });

    // $('#date_validation').datepicker({
    //     dateFormat: "yy-mm-dd",
    //     autoSize: true,
    //     buttonText: "Choose",
    //     onSelect: function(){
    //         $(".ui-datepicker").css('font-size', 12)
    //         get_validation_done_list();
    //     }
    // });

    $('#datepicker_exec').datepicker({
        dateFormat: "yy-mm-dd",
        autoSize: true,
        buttonText: "Choose",
        beforeShow: function(){
            $(".ui-datepicker").css('font-size', 12)
           
        }

    });
    

    $('#datepicker_photo_from, #datepicker_photo').datepicker({
        dateFormat: "yy-mm-dd",
        autoSize: true,
        buttonText: "Choose",
       

    });
    $('#datepicker_config').datetimepicker({
         dateFormat: "yy-mm-dd",
         controlType: 'slider',
         addSliderAccess: true,
         sliderAccessArgs: { touchonly: false },
         
         beforeShow: function(){
             $(".ui-datepicker").css('font-size', 12)
         }
    });
    
    
});
$(document).ready(function (){
    $('#start').on('click', function(){
        // $("#content").removeClass('hide')
         get_minis_by_terminal();
    $.ajax({
        url: '/configuration/serv_datetitme',
        type: 'POST',
        
        dataType: 'json',
        data:{

        },
        success: function (data) {
        $('#start').removeClass('btn btn-danger').addClass('btn btn-success');
           // console.log(data);
        $('#form_microgr').append('<input type="hidden" name="start_time" value="'+data+'">');
   
        },
          error: function (jqXHR, exception) {
                            var msg = '';
                            if (jqXHR.status === 0) {
                                msg = 'Not connect.\n Verify Network.';
                            } else if (jqXHR.status == 404) {
                                msg = 'Requested page not found. [404]';
                            } else if (jqXHR.status == 500) {
                                msg = 'Internal Server Error [500].';
                            } else if (exception === 'parsererror') {
                                msg = 'Requested JSON parse failed.';
                            } else if (exception === 'timeout') {
                                msg = 'Time out error.';
                            } else if (exception === 'abort') {
                                msg = 'Ajax request aborted.';
                            } else {
                                msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            }
                            console.log(msg);
                        },
    });
        
       
        // var dt = new Date();
       
        // var month  = dt.getMonth() + 1;
        // var minutes = dt.getMinutes();
        // var seconds = dt.getSeconds()
        // if (seconds < 10) {seconds = "0"+seconds};
        // if (minutes< 10) {minutes = "0"+minutes};
        // $('#form_microgr').append('<input type="hidden" name="start_time" value="'+dt.getFullYear()+'/'+month+'/'+dt.getDate()+' '+dt.getHours() + ':' +minutes+ ':' +seconds+'">');
         


    })




});

$(function(){
    if($('.alert:visible')){
        $('.alert').delay(1800).slideUp();
    }


});
$(document).ready(function (){
    $('#datepicker_photo').change(function() {
      
get_micro_time();

    });

});
   
$(document).ready(function(){
    $('#raport_monthly, #raport_monthly_year').change(function(){

        var month = $('#raport_monthly').val();
        if(month<10){month = '0'+month}
        var year = $('#raport_monthly_year').val();

        if(month && year != ''){
            $('#month_micro').attr('href','/monthly_report/'+month+'/'+year);
        }else if(month != ''){
           $('#month_micro').attr('href','/monthly_report/'+month); 
        }else{
             $('#month_micro').attr('href','/monthly_report'); 
        }

    });
    $('#raport_yearly').change(function(){
        var year = $('#raport_yearly').val();
        if(year){
            $('#year_micro').attr('href','/yearly_report/'+year);
        }else{
            $('#year_micro').attr('href','/yearly_report');
        }

    });
    function drow_charts(data){
        google.charts.load('current',"1", {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart(data));

        function drawChart(data) {
            var data_foto = data;
            console.log(data_foto);
            var data = new google.visualization.DataTable();
            data.addColumn('number','micrografia nmb');
            data.addColumn('number','time for executing min');
            data.addColumn({'type':'string','role':'tooltip','p': {'html': true}});
            
            data.addRows(data_foto);
            var options = {
                tooltip:{isHtml: true},
                bar: {groupWidth: "75%"},
                legend:'none',
                height: 400,
                opacity: 0.8,
                animation:{
                    duration: 10000,
                    easing: 'out',
                },
                hAxis: {
                    gridlines: {
                    count: 10,
                    }
                },
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_material'));
             
            chart.draw(data, options);
            function resize () {
          
                chart.draw(data , options);
            }
            if (window.addEventListener) {
                window.addEventListener('resize', resize);
            }
            else {
                window.attachEvent('onresize', resize);
            }
        }
    }
      
     
    $('#datepicker_exec').change(function(){
        get_ajax_exec_time_data(function(output){
            var data = output ;
            drow_charts(data);
        });
    });

    get_ajax_exec_time_data(function(output){
        var data = output ;
        drow_charts(data);
    });


});

