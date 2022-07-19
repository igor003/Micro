function get_photo_list(cur_page){
    var date_from;
    var date_to;
    var project = [];
    var codice;
    var per_page = 15;
    var show_pages = 9;
    var finish_page = Number(cur_page)+4;
    var start_page = Number(cur_page)-4;

    codice = $('#codice').val();
    date_from = $('#datepicker_photo_from').val();
    date_to = $('#datepicker_photo_to').val();
    mini = $('#mini').val();
    machine = $('#machine').val();
    configuration = $('#configurations').val();
    var work_order = $('#work_ord').val();
    $('#projects>input[type="checkbox"]:checked').each(function () {
       
        project.push(this.value);
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
            machine:machine,
            work_order:work_order,
            configuration:configuration

        },
        success: function (data) {
      

            if(data.configurations != null && data.config_flag == 0){
                      $('#configurations').empty();
                 $('#configurations').removeAttr('disabled');
                    $configur_html = '<option  value=""></option>';
                    var i = 0;
                    while(i< data.configurations[0].configuration.length){
                         $configur_html+='<option value="'+data.configurations[0].configuration[i].id+'">'+data.configurations[0].configuration[i].components+'</option>';
                         i++;
                    }
                    console.log($configur_html);
                    $('#configurations').append($configur_html);
            }
                        
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
            if(codice.length == 0 && project.length == 0 && date_to === '' && date_from === '' && mini === '' && machine === '' && work_order === '' && configuration === ''){// если нет фильтра по codice и project

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
                        $(this).css("box-shadow","0 0 15px rgba(210, 210, 210, 0.9)");
                        get_photo_list($(this).text());
                    });
            }else{//если есть фильтры 
                var pages_with_filter = Math.ceil(data.total_photo_with_filter/per_page);
                console.log('foto wiht filter:'+data.total_photo_with_filter);
                console.log(pages_with_filter);
                console.log(cur_page);
          
                $('#pagin').append('<li class="page-item1 prev"><a href="#" class="page-link" >Previous</a></li>'); 
               
                if(cur_page >6){
                    $('#pagin').append('<li class="page-item disabled"><a class="page-link disabled">...</a></li>'); 
                    for(var cnt = 1; cnt<=pages_with_filter; cnt++){
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
                }
                 if(pages_with_filter>show_pages && cur_page < pages_with_filter-4){
                        $('#pagin').append('<li class="page-item disabled"><a class="page-link disabled">...</a></li>');
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


$(function(){
     get_photo_list();

    $('#datepicker_raport').datepicker({
        dateFormat: "yy-mm-dd",
        autoSize: true,
        buttonText: "Choose",
        beforeShow: function(){
            $(".ui-datepicker").css('font-size', 12)
            get_photo_list();
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

    $('#datepicker_photo_to').change(function() {
        get_photo_list();
    });
    $('#mini').on('change', function(){
        get_photo_list()
    });
    $('#work_ord').on('change', function(){
        get_photo_list();
    });
    $('#machine').on('change', function(){
        get_photo_list();
    });
    $('#projects>input[type="checkbox"]').on('click',function(){
        get_photo_list();
    });
    $('#codice').on('change', function(){
        get_photo_list();

    });
    $('#configurations').on('change',function(){
        get_photo_list();
    })
});