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
            '<a class="delete_link" href="configuration_list/update_view/' + data.id + '"> <div class="update"><img height="30px" width = "30px" src="/img/update.png" alt=""></div></a>' +
            '</td>' +
            '<td class="text-center">' +
            '<a  href="configuration_list/delete/' + data.id + '"> <div class="delete"><img height="30px" width = "30px" src="/img/delete.png" alt=""></div></a>' +
            '</td>';
            }
            result +='</tr>';
        return result;
}

function get_configuration_list(){
    var search;
    search = $('#search_configuration').val();
    var total_sez = $('#total_sez').val();
    var dep = $('#department').val();
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
            filter2:filter_connector,
            total_sez:total_sez,
            department:dep
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

$( document ).ready(function() {
    get_configuration_list();
    $("input[type='checkbox']").on('click',function(){
        get_configuration_list();
    });
    $('#conf_connectors').on('change',function(){
        get_configuration_list();
    });
    $('#department').on('change',function(){
        get_configuration_list();
    });
    $('#total_sez').on('change',function(){
        get_configuration_list();
    });
   $('#search_configuration').on('keyup',function() {
        get_configuration_list();
    });
});