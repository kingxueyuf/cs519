window.altitude = new Array();
window.humidity = new Array();
window.temperature = new Array();
window.latitude = new Array();
window.longitude = new Array();
window.pressure = new Array();
window.date = new Array();

$( document ).ready(function() 
{
	$('#map_canvas').gmap().bind('init', function(ev, map) {
	$('#map_canvas').gmap('addMarker', {'position': '43.81,-91.23', 'bounds': true}).click(function() {
            $('#map_canvas').gmap('openInfoWindow', {'content': 'Hello World!'}, this);
          });
	$('#map_canvas').gmap('option', 'zoom', 14);
        });

	var today = getCurrentDate();
    $('#dp1').val(today);
	getList(today);
	
	$( "#search" ).click(function() {
        // alert( "Search" );
        $("#list-group").empty();
        var currentDate = $('#dp1').val();
        getList(currentDate);
        // setTimeout(getData,0); 
        // alert(date);
    });
});

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

function getList(currentDate)
{
	altitude =[];
    humidity = [];
    temperature = [];
    latitude = [];
    longitude = [];
    pressure = [];
    date = [];
    
	var query = "uid="+"1"+"&date="+currentDate;
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

            drawListItem();
           	bindClickListener();

           	
        },
        dataType:"json",
    });
};

function drawListItem()
{
	$("#list-group").empty();

	for(var i = 0 ; i < altitude.length ; i++)
	{	
		var html = "<div id=\""+"gps"+i+"\" class=\"list-group-item\">";
		html += "<h5 class=\"list-group-item-heading\"> Time : "+date[i]+":00"+"</h5>";
		html += "<p class=\"list-group-item-text\">";
		html += "<span class=\"label label-success\">GPS: "+latitude[i]+" , "+longitude[i]+"</span>";
		html += "<br>";
		html += "<span class=\"label label-primary\">Pressure: "+ pressure[i] +"</span>";
		html += "<br>";
		html += "<span class=\"label label-info\">Temperature: "+ temperature[i] +"</span>";
		html += "<br>";
		html += "<span class=\"label label-warning\">Humidity: "+ humidity[i]+"</span>";
		html += "<br>";
		html += "<span class=\"label label-danger\">Altitude: "+ altitude[i]+"</span>";
		html += "</p>";
		html += "</div>";

		$("#list-group").append(html);
	}
};

function bindClickListener()
{	
	for(var i = 0 ; i <altitude.length ;i++)
	{
		var itemId = "#gps"+i;
		console.log(i);
		$('#list-group').on('click', itemId , function(){
			var Id = $(this).attr("id");
			console.log(Id);
			var index = parseInt(Id.charAt(3));
			var tempLat = latitude[index];
			var tempLog = longitude[index];
			var latLng = new google.maps.LatLng(tempLat, tempLog);
			console.log(tempLat+" "+tempLog+" "+index);
			$('#map_canvas').gmap('clear', 'markers');
			$('#map_canvas').gmap('option', 'center', latLng);
			$('#map_canvas').gmap('option', 'zoom', 14);     
			$('#map_canvas').gmap('addMarker', {position: latLng,bounds: false});
		});
	}
}

