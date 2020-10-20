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
                '<a href="'+entity+'_list/delete/'+data.id+'"> <div><img height="40px" width = "40px" src="/img/delete.png" alt=""></div ></a>'+
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

function generate_html_configuration(data,admin){
        var result = '<tr>' +
            '<td class="text-center"><a href="configuration/upload_view/'+data.id+'">'+ data.codice.name +'</a></td>' +
            '<td class="text-center">' + data.components + '</td>' +
            '<td class="text-center">' + data.connector.name + '</td>' +
            '<td class="text-center">' + data.sez_components + '</td>' +
            '<td class="text-center">' + data.total_sez + '</td>' +
            '<td class="text-center">' + data.nr_strand + '</td>' +
            '<td class="text-center">' + data.height + '</td>' +
            '<td class="text-center">' + data.width + '</td>';
        if(admin === true){
            result +='<td class="text-center">' +
            '<a href="configuration_list/update_view/' + data.id + '"> <div class="update"><img height="30px" width = "30px" src="/img/update.png" alt=""></div></a>' +
            '</td>' +
            '<td class="text-center">' +
            '<a href="configuration_list/delete/' + data.id + '"> <div class="delete"><img height="30px" width = "30px" src="/img/delete.png" alt=""></div></a>' +
            '</td>';
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

function generate_html_interface(data, cnt){
    var result = '<tr>' +
        '<td class="text-center">' + data.name + '</td>' +
        '<td class="text-center">' + data.code + '</td>' +
        '<td class="text-center">' + data.blocket + '</td>'+
        '<td class="text-center">'+
            '<form method="POST" action="/interface/download">'+
            '<input type="hidden" name="id" value="'+data.id+'">'+
            '<input type="hidden" name="format" value="stl">'+
           
            '<button type="submit"><img height="20px" width = "20px" src="/img/download.png" alt=""></button>'+
            '</form>'+
        '</td>'+
        '<td class="text-center">'+
            '<form method="POST" action="/interface/download">'+
            '<input type="hidden" name="id" value="'+data.id+'">'+
            '<input type="hidden" name="format" value="f3d">'+
            
            '<button type="submit"><img height="20px" width = "20px" src="/img/download.png" alt=""></button>'+
            '</form>'+
        '</td>'+
        '<td class="text-center">'+
            '<form method="POST" action="/interface/download">'+
            '<input type="hidden" name="id" value="'+data.id+'">'+
            '<input type="hidden" name="format" value="jpg">'+
           
            '<button style="width:20px; height:20px;" class="interf_btn" id="jpg_'+data.id+'" type="submit"></button>'+
            '</form>'+
        '</td>'+
         '<td class="text-center">'+
            
           
      ' <a href="/interfaces/update_view/'+data.id+'"><button type="submit"><img height="20px" width = "20px" src="/img/update.png" alt=""></button></a>'+
         
        '</td>';
        result +='</tr>';
    return result;
}

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

function generate_html_photo(data, admin){
    var result ='<tr>' +
                '<td class="text-center">' +data.maked_at.substr(0, data.maked_at.length - 8)+' </td>' +
                '<td class="text-center">'+data.configurations[0].codice.name+'</td>' +
                '<td class="text-center">' + data.configurations[0].connector.name+ '</td>' +
                '<td class="text-center">' + data.configurations[0].components+ '</td>';
                if(data.minis && data.machines){
                     result +='<td class="text-center">' + data.minis.name+ '</td>' +
                              '<td class="text-center">' + data.machines.number+ '</td>';
                }else{
                     result +='<td class="text-center">' +'--'+ '</td>' +
                              '<td class="text-center">' +'--'+ '</td>';
                }
           
            result += '<td class="text-center">' + data.operator+ '</td>' +
                '<td class="text-center">'+
                '<form method="POST" action="/photo_download">'+
                '<input type="hidden" name="photo_1" value="'+data.foto1+'">'+
                '<input type="hidden" name="photo_2" value="'+data.foto2+'">'+
                '<input type="hidden" name="photo_3" value="'+data.foto3+'">'+
                '<div></div>'+
                '<button type="submit"><img height="20px" width = "20px" src="/img/download.png" alt=""></button>'+
                '</form>'+
                '</td>' ;
    if(admin === true){
        result+='<td class="text-center">' +
                '<a href="photo_delete/'+data.id+'"> <div><img height="20px" width ="20px" src="/img/delete.png" alt=""></div></a>' +
                '</td>' 
    };
    result +='</tr>';

    return result;
}

$( document ).ready(function() {
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
    $("input[type='checkbox']").on('click',function(){
        get_configuration_list();
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
    $('#search_calibration').on('keyup', function(){
        get_calibrations_list();
    });
    $('#search_machines').on('keyup', function(){
        get_calibrations_list();
    });
    $('#search_miniaplicators').on('keyup', function(){
        get_calibrations_list();
    });
    $('#connector1').on('change',function() {
        get_miniaplicators_list();
    });
    $('#codice').on('change',function(){
        get_conf_by_part_id();
    })
    $('#conf_connectors').on('change',function(){
        get_configuration_list();
    });
    $('#date_validation').change(function(){
        get_validation_done_list();
    });
    $('#search_configuration').on('keyup',function() {
        get_configuration_list();
    });
    $('#mini').on('change', function(){
        get_photo_list()
    });
    $('#mini').on('change', function(){
        get_validation_done_list();
    });
    $('#type_val').on('change', function(){
        get_validation_done_list();
    });
    $('#machine').on('change', function(){
        get_photo_list();
    });
    $('#projects>input[type="checkbox"]').on('click',function(){
        get_photo_list();
    });
    $('#codice>input[type="checkbox"]').on('click',function(){
        get_photo_list();
    });
    $('#search_miniaplicator').on('keyup',function(){
        get_miniaplicators_list();
    });
    $('#search_machine').on('keyup',function(){
        get_machines_list();
    });
   $('#name_interface').on('change', function(){
        get_interfaces_list();
    });
   $('#code_interface').on('change', function(){
        get_interfaces_list();
    });
   $('#blocket_interface').on('change', function(){
        get_interfaces_list();
    });
    get_codice_list();
    get_project_list();
    get_configuration_list();
    get_photo_list();
    get_codice_by_project_conf_update();
    get_codice_by_project_conf_created();
    get_miniaplicators_list();
    get_connector_list();
    get_machines_list();
    get_reports_list();
    get_calibrations_list();
    get_validation_list();
    get_validation_done_list();
    get_interfaces_list();

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

function get_configuration_list(){
    var search;
    search = $('#search_configuration').val();
    var filter = [];
    $('input[id="projects"]:checked').each(function () {
        filter.push(this.value);
    });
      
     if(filter.length <1){
        $('.excell').attr('href','/configuration/get_list_excel');
     }else{
        $('.excell').attr('href','/configuration/get_list_excel/'+filter.toString());
     }
     
    var filter_connector = $('#conf_connectors').val();
    $.ajax({
        url: '/configuration_list',
        type: 'POST',
        data: {
            filter: filter,
            search:search,
            filter2:filter_connector
        },
        dataType: 'json',
        success: function (data) {

            var count_conf = data.conf.length;
            $('#table_configuration').empty();
            var i = 0;
            while(i< count_conf){
                $('#table_configuration').append(generate_html_configuration(data.conf[i], data.admin));
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

function get_interfaces_list(){
    var name = $('#name_interface').val();
    var code = $('#code_interface').val();
    var blocket = $('#blocket_interface').val();
    $.ajax({
        url: '/interface/get_list',
        type: 'POST',
        data: {
            name:name,
            code:code,
            blo:blocket
        },
        dataType: 'json',
        success: function (data) {
            var interfaces = data.length;
            $('#interfaces_body').empty();
            var i = 0;
            while(i< interfaces){
                $('#interfaces_body').append(generate_html_interface(data[i],i));
                i++;
            }
            $('.interf_btn').on('mouseenter', function(evt){
console.log('mouseenter');
                $.ajax({
                    url: '/interface/preview',
                    type: 'POST',
                    data: {
                        id:$(this).attr('id')
                    },
                    dataType: 'json',
                    success: function (data) {
                        var str = data;
                        $('#preview').html('<img id="preview_img" style="width:200px; width:200px;  " alt="fotki net" title="asdsadsad" src="'+str+'"></img>');
                        $('#preview').css({left: evt.pageX+30, top: evt.pageY-15}).show();
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
        
            });
            $('.interf_btn').on('mouseleave', function(){
                console.log('mouseeout');
                    $('#preview').hide();
                     $(document).off('mousemove');
            })
        },
        error:function(error){
            console.log('error; ' + eval(error));
        }
    })
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
            $('#media').html('<h3>Executing average time: ' +data[1]+'min.</h3>');
          

            handleData(data[0]); 
        },
        error:function(error){
            handleData(0); 
            $('#media').html('');
            console.log('error' + eval(error));
        }
    })
}
// funtion get_monthly_micro(){
//     $month = $('#get_monthly_micro').val();

//       $.ajax({
//         url: '/get_monthly_micro',
//         type: 'POST',
//         data: {
//              $month:$month
//         },
//         dataType: 'json',
//         success: function (data) {

//             var reports = data.length;
//             $('#table_reports').empty();
//             var i = 0;
//             while(i< reports){
//                 $('#table_reports').append(generate_html_reports(data[i]));
//                 i++;
//             }
//         },
//         error:function(error){
//             console.log('error; ' + eval(error));
//         }
//     })

    
// }

function get_photo_list(cur_page){
    var date_from;
    var date_to;
    var project = [];
    var codice = [];
    var per_page = 15;
    var show_pages = 9;
    var finish_page = Number(cur_page)+4;
    var start_page = Number(cur_page)-4;
    
    date_from = $('#datepicker_photo_from').val();
    date_to = $('#datepicker_photo_to').val();
    mini = $('#mini').val();
    machine = $('#machine').val();
    $('#projects>input[type="checkbox"]:checked').each(function () {
       
        project.push(this.value);
    });
    $('#codice>input[type="checkbox"]:checked').each(function () {
        
        codice.push(this.value);
    });
   
    $.ajax({
        url: '/photo_list',
        type: 'POST',
        dataType: 'json',
        data: {
            date_from:date_from,
            date_to:date_to,
            project:project,
            codice:codice,
            cur_page:cur_page,
            per_page:per_page,
            mini:mini,
            machine:machine

        },
        success: function (data) {

            $('#table_photo').empty();
            var i = 0;
            while(i< data.photos.length){
                if(data.photos[i].configurations[0].codice.name){
                    $('#table_photo').append(generate_html_photo(data.photos[i],data.admin));
                    i++;
                }else{
                    i++;
                    continue;  
                }
            }
            var pages = Math.ceil(data.total_count/per_page);
            $('#pagin').empty();
            if(codice.length == 0 && project.length == 0 && date_to === '' && date_from === '' && mini === '' && machine === ''){// если нет фильтра по codice и project

                // if(){// если нет фильтра по date
                    $('#pagin').append('<li class="page-item1 prev"><a href="#" class="page-link" >Previous</a></li>');
                    // если текущая страница больше 6 добавляем кнопку ...
                    if(cur_page >6){
                        $('#pagin').append('<li class="page-item disabled"><a class="page-link disabled">...</a></li>'); 
                        for(var cnt = 1; cnt<=pages; cnt++){
                            if( cnt >= start_page && cnt<=finish_page){
                                if( cnt == cur_page){
                                    $('#pagin').append('<li class="page-item active "><a class="page-link" href="#">'+cnt+'</a></li>');
                                }else{
                                    $('#pagin').append('<li class="page-item  "><a class="page-link" href="#">'+cnt+'</a></li>');
                                }
                            }else{
                                continue;
                            }
                        }
                    }else{
                        for(var cnt = 1; cnt<=pages; cnt++){
                            if(cur_page == undefined){
                                $('#pagin').append('<li class="page-item active"><a class="page-link " href="#">1</a></li>');    
                                cur_page = true;
                            }else if( cnt == cur_page){
                                $('#pagin').append('<li class="page-item active "><a class="page-link" href="#">'+cnt+'</a></li>');
                            }else{
                                $('#pagin').append('<li class="page-item"><a class="page-link" href="#">'+cnt+'</a></li>');
                            }
                            if(cnt>show_pages){
                                break;
                            }
                        }
                    }
                    if(pages>show_pages && cur_page < pages-4){
                        $('#pagin').append('<li class="page-item disabled"><a class="page-link disabled">...</a></li>');
                    } 
                    $('#pagin').append('<li class="page-item1 next"><a href="#" class="page-link disabled" >Next</a></li>');
                    $('#pagin').append('<div class="pages alert alert-info"><strong>Info! </strong>Total pages: '+pages+'</div>');
                   // если мы на первой странице кнопку prev дизэйблим
                    if(cur_page == 1){
                        $('.prev>a .page-link').addClass('disabled');
                        $('.prev').addClass('disabled');
                    }
                    // если мы на последней странице кнопку next дизэйблим
                    if(cur_page == pages){
                        $('.next>a .page-link').addClass('disabled');
                        $('.next').addClass('disabled');
                    }
                    // клик на кнопку prev
                    $('.prev').on('click',function(){
                        if(cur_page >1){
                            get_photo_list(Number(cur_page) - 1);
                        }else{
                             return false;
                        }
                    });
                    // клик на кнопку next
                    $('.next').on('click',function(){
                        if(cur_page != pages){
                            get_photo_list(Number(cur_page) + 1);
                        }else{
                            return false;
                        }
                    });
                    // клик на элемент пагинации
                    $('.page-item').on('click',function(){
                        $('#pagin>li.active').removeClass('active');
                        $(this).addClass('active');
                        get_photo_list($(this).text());
                    });
            }else{//если есть фильтры 
                var pages_with_filter = Math.ceil(data.total_photo_with_filter/per_page);
          
                $('#pagin').append('<li class="page-item1 prev"><a href="#" class="page-link" >Previous</a></li>'); 
                if(pages_with_filter>show_pages && cur_page < pages_with_filter-4){
                        $('#pagin').append('<li class="page-item disabled"><a class="page-link disabled">...</a></li>');
                }
                for(var cnt = 1; cnt<=pages_with_filter; cnt++){
                    if(cur_page == undefined){
                        $('#pagin').append('<li class="page-item active"><a class="page-link " href="#">1</a></li>');    
                        cur_page = true;
                    }else if( cnt == cur_page){
                        $('#pagin').append('<li class="page-item active "><a class="page-link" href="#">'+cnt+'</a></li>');
                    }else{
                        $('#pagin').append('<li class="page-item"><a class="page-link" href="#">'+cnt+'</a></li>');
                    }
                    if(cnt>show_pages){
                        break;
                    }
                }
                // клик на элемент пагинации
                $('.page-item').on('click',function(){
                    $('#pagin>li.active').removeClass('active');
                    $(this).addClass('active');
                    get_photo_list($(this).text());
                });
                // клик на кнопку prev
                $('.prev').on('click',function(){
                    if(cur_page >1){
                        get_photo_list(Number(cur_page) - 1);
                    }else{
                         return false;
                    }
                });
            }
        },
        error:function(error){
            console.log('error; ' + eval(error));
        }
    });
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

    $('#date_validation').datepicker({
        dateFormat: "yy-mm-dd",
        autoSize: true,
        buttonText: "Choose",
        onSelect: function(){
            $(".ui-datepicker").css('font-size', 12)
            get_validation_done_list();
        }
    });

    $('#datepicker_raport').datepicker({
        dateFormat: "yy-mm-dd",
        autoSize: true,
        buttonText: "Choose",
        beforeShow: function(){
            $(".ui-datepicker").css('font-size', 12)
            get_photo_list();
        }

    });
       $('#datepicker_exec').datepicker({
        dateFormat: "yy-mm-dd",
        autoSize: true,
        buttonText: "Choose",
        beforeShow: function(){
            $(".ui-datepicker").css('font-size', 12)
           
        }

    });
    

    $('#datepicker_photo_to, #datepicker_photo_from, #datepicker_photo').datepicker({
        dateFormat: "yy-mm-dd",
        autoSize: true,
        buttonText: "Choose",
        beforeShow: function(){
            $(".ui-datepicker").css('font-size', 12)
            get_photo_list();
        }

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
    $('#datepicker_photo_to').change(function() {
        get_photo_list();
    });

   
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

