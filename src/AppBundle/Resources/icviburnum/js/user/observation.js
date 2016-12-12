var oldmarker = null;

$(document).ready(function() {
    map.addListener('click', function(event) {
        if (oldmarker != null) {
            oldmarker.setMap(null);
        }
        placeMarker(event.latLng);
        $('#user_observation_latitude').val(event.latLng.lat());
        $('#user_observation_longitude').val(event.latLng.lng());
    });
    
    $('#user_observation_howAdd').on('change', function() {
    	checkHowAddValue($(this).val());
    	 // alert( this.value ); // or $(this).val()
    });
    
    checkHowAddValue($('#user_observation_howAdd').val());

	$('#fileupload').fileupload({
		url: fileuploadurl
	});
	 $('#fileupload').addClass('fileupload-processing');
     $.ajax({
         // Uncomment the following to send cross-domain cookies:
         //xhrFields: {withCredentials: true},
         url: '/app_dev.php/user/observations/images/upload',
         dataType: 'json',
         context: $('#fileupload')[0]
     }).always(function () {
         $(this).removeClass('fileupload-processing');
     }).done(function (result) {
         $(this).fileupload('option', 'done')
             .call(this, $.Event('done'), {result: result});
     });
     
     $("form#fileupload").submit( function(eventObj) {
    	 var fileuploads = [];
    	 $('.files tr td p.name span').each(function (i, row) {   
    		 fileuploads.push($(row).text());
    	 });
    	 
         $('<input />').attr('type', 'hidden')
         	.attr('name', "fileuploads[]")
         	.attr('value', fileuploads)
         	.appendTo('form#fileupload');
         return true;
     });
	 
	 
});
    
function placeMarker(location) {
    var marker = new google.maps.Marker({
        position: location, 
        map: map
    });
    oldmarker = marker;    
}

function currentPosition(position) {
    $('#user_observation_latitude').val(position.coords.latitude);
    $('#user_observation_longitude').val(position.coords.longitude);
}

function checkHowAddValue(howAdd) {
	$('#user_observation_latitude').val(null);
    $('#user_observation_longitude').val(null);
	$('#address').css('display','none');
	$('#map_canvas').css('display','none');
	$('#previous').css('display','none');

	switch(howAdd) {
	    case "current":
	    	if (navigator.geolocation) {
	            navigator.geolocation.getCurrentPosition(currentPosition);
	    	}
	    	break;
	    case "address":
	    	$('#address').css('display','block');
	    	break;
	    case "map":
	    	$('#map_canvas').css('display','block');
	    	google.maps.event.trigger(map,'resize') 
	    	break;
	    case "previous":
	    	$('#previous').css('display','block');
	    	break;
	}
}
