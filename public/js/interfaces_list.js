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
function generate_html_interface(data, cnt){
    var result = '<tr>' +
        '<td class="text-center">' + data.id + '</td>' +
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