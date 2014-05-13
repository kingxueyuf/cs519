$( document ).ready(function() 
{	
	$( "#export" ).click(function() {

        var from = $('#dp1').val();
        var to = $('#dp2').val();

        var query = "from="+from+"&to="+to;

        window.location.href = "/ci/index.php/exportExcel/excel?"+query;
    });
});