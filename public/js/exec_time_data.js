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

$(document).ready(function(){
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
}