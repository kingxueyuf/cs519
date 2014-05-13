$(function () {
    $('#container-pie').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Position Statistics of Department'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Browser share',
            data: [
                ['Programmer',   65.0],
                ['Tester',   15.0],
                ['Manager',       10.0],
                {
                    name: 'President',
                    y: 5.0,
                    sliced: true,
                    selected: true
                },
                ['Project Leader',5.0]
            ]
        }]
    });
});
    

function getData()
{
    var query = "uid="+"1";
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
        url:"http://localhost:8888/ci/index.php/site/data",
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

    setTimeout(getData,2000);
};

setTimeout(getData,2000);

function drawLineChart(altitude,humidity,temperature,latitude,longitude,pressure,date)
{   

    var options = {
        title: {
            text: ''
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
    /* xAxis */
    options.series.xAxis.categories = date;

    /* altitude */
    var altitude_arr = {
        data:[]
    };
    for(var i = 0 ; i <altitude.length ; i++)
    {
        altitude_arr.name = "altitude";
        altitude_arr.data.push(altitude);
    }
    options.series.push(altitude_arr);
    
    /* humidity */ 
    var humidity_arr = {
        data:[]
    };
    for(var i = 0 ; i <humidity.length ; i++)
    {
        humidity_arr.name = "humidity";
        humidity_arr.data.push(humidity);
    }
    options.series.push(humidity_arr);

    /* temperature */ 
    var temperature_arr = {
        data:[]
    };
    for(var i = 0 ; i <temperature.length ; i++)
    {
        temperature_arr.name = "temperature";
        temperature_arr.data.push(temperature);
    }
    options.series.push(temperature_arr);

    $('#container-line').highcharts(options);
}

