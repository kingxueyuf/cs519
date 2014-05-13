$( document ).ready(function() {
    var today = getCurrentDate();
    $('#dp1').val(today);
    // Handler for .ready() called.
    $( "#search" ).click(function() {
        // alert( "Search" );
        currentDate = $('#dp1').val();
        var needCycle = false;
        getData(needCycle);
        // setTimeout(getData,0); 
        // alert(date);
    });
});


var currentDate;
var cycleTime = 3000;
function getData(needCycle)
{   
    var query = "uid="+"1"+"&date="+currentDate;
    var altitude = new Array();
    var humidity = new Array();
    var temperature = new Array();
    var latitude = new Array();
    var longitude = new Array();
    var pressure = new Array();
    var date = new Array();
    $.ajax(
    {
        type:"GET",
        url:"data",
        data:query,
        success:function(data)
        {
            $.each(data,function(i,item)
            {
                altitude.push(item['altitude']);
                humidity.push(item['humidity']);
                temperature.push(item['temperature']);
                latitude.push(item['latitude']);
                longitude.push(item['longitude']);
                pressure.push(item['pressure']);
                date.push(item['date']);
            });

            drawLineChart(altitude,humidity,temperature,latitude,longitude,pressure,date);
        },
        dataType:"json",
    });

    altitude =[];
    humidity = [];
    temperature = [];
    latitude = [];
    longitude = [];
    pressure = [];
    date = [];

    if(needCycle)
    {
        setTimeout(function() {
        getData(needCycle);
        }, cycleTime);
    }
}

function initPage()
{
    currentDate = getCurrentDate();
    setTimeout(function() {
        getData(true);}, 0);
}

initPage();
     
function getCurrentDate()
{
    var d = new Date();

    var month = d.getMonth()+1;
    var day = d.getDate();

    var output = d.getFullYear() + '-' +
    ((''+month).length<2 ? '0' : '') + month + '-' +
    ((''+day).length<2 ? '0' : '') + day;

    return output;
}

function drawLineChart(altitude,humidity,temperature,latitude,longitude,pressure,date)
{   

    var options = {
        title: {
            text: 'Overview'
        },
        legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
        },
        xAxis: {
            categories: []
        },
        yAxis: {
            title: {
                text: 'Units'
            }
        },
        series: []
    };
    // console.log(date);
    /* xAxis */
    for(var i = 0 ;  i < date.length ; i++)
    {
        // console.log(date[i]);
        options.xAxis.categories.push(parseFloat(date[i]));
    }

    /* temperature */ 
    var temperature_arr = {
        data:[]
    };
    for(var i = 0 ; i <temperature.length ; i++)
    {
        temperature_arr.name = "temperature";
        temperature_arr.data.push(parseInt(temperature[i]));
    }
    options.series.push(temperature_arr);
    /* altitude */
    var altitude_arr = {
        data:[]
    };
    for(var i = 0 ; i <altitude.length ; i++)
    {
        altitude_arr.name = "altitude";
        altitude_arr.data.push(parseInt(altitude[i]));
    }
    options.series.push(altitude_arr);
    /* humidity */ 
    var humidity_arr = {
        data:[]
    };
    for(var i = 0 ; i <humidity.length ; i++)
    {
        humidity_arr.name = "humidity";
        humidity_arr.data.push(parseInt(humidity[i]));
    }
    options.series.push(humidity_arr);
    /* pressure */ 
    var pressure_arr = {
        data:[]
    };
    for(var i = 0 ; i <pressure.length ; i++)
    {
        pressure_arr.name = "pressure";
        pressure_arr.data.push(parseInt(pressure[i]));
    }
    options.series.push(pressure_arr);
    $('#container-line').highcharts(options);

    /***************************/
    /* temperature line chart */
    var options_tem = {
        title: {
            text: 'Temperature Sensor'
        },
        legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
        },
        xAxis: {
            categories: []
        },
        yAxis: {
            title: {
                text: 'Units'
            }
        },
        series: []
    };
    // console.log(date);
    /* xAxis */
    for(var i = 0 ;  i < date.length ; i++)
    {
        // console.log(date[i]);
        options_tem.xAxis.categories.push(parseFloat(date[i]));
    }

    /* temperature */ 
    var temperature_arr = {
        data:[]
    };
    for(var i = 0 ; i <temperature.length ; i++)
    {
        temperature_arr.name = "temperature";
        temperature_arr.data.push(parseInt(temperature[i]));
    }
    options_tem.series.push(temperature_arr);

    $('#container-line-tem').highcharts(options_tem);

    /* temperature line chart end */

    /*****************************/
    /* altitude line chart */

    var options_alt = {
        title: {
            text: 'Altitude Sensor'
        },
        legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
        },
        xAxis: {
            categories: []
        },
        yAxis: {
            title: {
                text: 'Units'
            }
        },
        series: []
    };
    // console.log(date);
    /* xAxis */
    for(var i = 0 ;  i < date.length ; i++)
    {
        // console.log(date[i]);
        options_alt.xAxis.categories.push(parseFloat(date[i]));
    }

    /* altitude */
    var altitude_arr = {
        data:[]
    };
    for(var i = 0 ; i <altitude.length ; i++)
    {
        altitude_arr.name = "altitude";
        altitude_arr.data.push(parseInt(altitude[i]));
    }
    options_alt.series.push(altitude_arr);
    $('#container-line-alt').highcharts(options_alt);
    /* altitude line chart end */


    /***************************/
    /* humidity line chart */
    var options_hum = {
        title: {
            text: 'Humidity Sensor'
        },
        legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
        },
        xAxis: {
            categories: []
        },
        yAxis: {
            title: {
                text: 'Units'
            }
        },
        series: []
    };
    // console.log(date);
    /* xAxis */
    for(var i = 0 ;  i < date.length ; i++)
    {
        // console.log(date[i]);
        options_hum.xAxis.categories.push(parseFloat(date[i]));
    }
    /* humidity */ 
    var humidity_arr = {
        data:[]
    };
    for(var i = 0 ; i <humidity.length ; i++)
    {
        humidity_arr.name = "humidity";
        humidity_arr.data.push(parseInt(humidity[i]));
    }
    options_hum.series.push(humidity_arr);
    $('#container-line-hum').highcharts(options_hum);
    /* humidity line char end */

    /**************************/
    /* pressure line chart */
    var options_pre = {
        title: {
            text: 'Pressure Sensor'
        },
        legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
        },
        xAxis: {
            categories: []
        },
        yAxis: {
            title: {
                text: 'Units'
            }
        },
        series: []
    };
    // console.log(date);
    /* xAxis */
    for(var i = 0 ;  i < date.length ; i++)
    {
        // console.log(date[i]);
        options_pre.xAxis.categories.push(parseFloat(date[i]));
    }
    /* pressure */ 
    var pressure_arr = {
        data:[]
    };
    for(var i = 0 ; i <pressure.length ; i++)
    {
        pressure_arr.name = "pressure";
        pressure_arr.data.push(parseInt(pressure[i]));
    }
    options_pre.series.push(pressure_arr);
    $('#container-line-pre').highcharts(options_pre);
   
}
