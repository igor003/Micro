$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#submit_form').on('click', function(){
    $('#form_configuration').submit();
});



$($('#project_conf').on('change', function() {
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

$($('#codice_conf').on('change', function() {
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

function generate_html_connectors(data,entity,admin){
    console.log(data.specification_path);
        var result = '<tr>' +
            '<td class="text-center">'+data.name+'</td>';
            if(data.specification_path){
                result += 
                '<td class="text-center">' +
                '<a href="'+entity+'_list/update_view/'+data.id+'"> <div><img height="50px" width = "50px" src="/img/specific.png" alt=""></div></a>'+
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

function generate_html_photo(data, admin){
    var result ='<tr>' +
                '<td class="text-center">' +data.maked_at.substr(0, data.maked_at.length - 8)+' </td>' +
                '<td class="text-center">' + data.configurations[0].codice.project.name+ '</td>' +
                '<td class="text-center">'+data.configurations[0].codice.name+'</td>' +
                '<td class="text-center">' + data.configurations[0].connecting_element+ '</td>' +
                '<td class="text-center">' + data.configurations[0].components+ '</td>' +
                '<td class="text-center">' + data.operator+ '</td>' +
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
                '<a href="photo_delete/'+data.id+'"> <div><img height="20px" width = "20px" src="/img/delete.png" alt=""></div></a>' +
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
    $('#connector1').on('change',function() {
        get_miniaplicators_list();
    });
    $('#search_configuration').on('keyup',function() {
        get_configuration_list();
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

                $('#table_codice').empty();
                var i = 0;
                while(i< data.parts.length){
                    $('#table_codice').append(generate_html_codice(data.parts[i],'codice',data.admin));
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
              // console.log(data.machines.length);
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
    $.ajax({
        url: '/configuration_list',
        type: 'POST',
        data: {
            filter: filter,
            search:search
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
    })
}

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

    $('#projects>input[type="checkbox"]:checked').each(function () {
        // console.log(this.value);
        project.push(this.value);
    });
    $('#codice>input[type="checkbox"]:checked').each(function () {
        // console.log(this.value);
        codice.push(this.value);
    });
    // console.log(codice);
    // console.log(date_from);
    // console.log(date_);
   
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
            per_page:per_page

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
            if(codice.length == 0 && project.length == 0 && date_to === '' && date_from === ''){// если нет фильтра по codice и project

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
                var pages_with_filter = Math.ceil(data.total_photo_with_filter.length/per_page);
          
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

    $('#datepicker_raport').datepicker({
        dateFormat: "yy-mm-dd",
        autoSize: true,
        buttonText: "Choose",
        beforeShow: function(){
            $(".ui-datepicker").css('font-size', 12)
            get_photo_list();
        }

    });

    $('#datepicker_photo_to, #datepicker_photo_from').datepicker({
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
