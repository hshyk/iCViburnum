var page = 0;
var oldmarker = null;

$( document ).ready(function() {
	  map.addListener('click', function(event) {
	        if (oldmarker != null) {
	            oldmarker.setMap(null);
	        }
	        placeMarker(event.latLng);
	        $('#search_by_location_latitude').val(event.latLng.lat());
	        $('#search_by_location_longitude').val(event.latLng.lng());
	    });
	    
	    $('#search_by_location_searchOptions').on('change', function() {
	    	checkSearchOptionsValue($(this).val());
	    	 // alert( this.value ); // or $(this).val()
	    });
	    
		var $region = $('select.regions');
		// When sport gets selected ...
		//$region.change(function() {
		$(document).on('change',"select.regions", function(){
		  // ... retrieve the corresponding form.
		  var $form = $(this).closest('form');
		  // Simulate form data, but only include the selected sport value.
		  var data = {};
		  
		  var selectedRegion = $(this).attr('name');
		  var continueSelect = true;
		  
		  $.each( $('select.regions'), function(k, v) {
			  if (continueSelect == true) {
				  data[$(v).attr('name')] = $(v).val();
			  }
			  
			  if ($(v).attr('name') == selectedRegion) {
				  continueSelect = false;
			  }
		  });
		  
		  $.blockUI({ message: '<div class="loading">Loading results</loading>' });
		  // Submit data via AJAX to the form's action path.
		  $.ajax({
		    url : $form.attr('action'),
		    type: $form.attr('method'),
		    data : data,
		    success: function(html) {
		      // Replace current position field ...
		      $('#regions').replaceWith(
		        // ... with the returned one from the AJAX response.
		        $(html).find('#regions')
		      );
		      $('#regions').css('display','block');
		      $.unblockUI();
		    },
		    error: function (xhr, ajaxOptions, thrownError) {
		      $.unblockUI();
		    }
		  });
		});
	    
	$( 'form' ).submit(function( e ) {
		e.preventDefault();
		page = 0;
		$("ul#resultlist").empty();
		getResults();
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
    $('#search_by_location_latitude').val(position.coords.latitude);
    $('#search_by_location_longitude').val(position.coords.longitude);
}

function checkSearchOptionsValue(searchOptions) {
	$('#search_by_location_latitude').val(null);
    $('#search_by_location_longitude').val(null);
	$('#regions').css('display','none');
	$('#map_canvas').css('display','none');
	
	switch(searchOptions) {
	    case "current":
	    	if (navigator.geolocation) {
	            navigator.geolocation.getCurrentPosition(currentPosition);
	    	}
	    	break;
	    case "region":
	    	$('#regions').css('display','block');
	    	break;
	    case "map":
	    	$('#map_canvas').css('display','block');
	    	google.maps.event.trigger(map,'resize') 
	    	break;
	}
	
}

function getResults() 
{
	$.blockUI({ message: '<div class="loading">Loading results</loading>' });
    
	var regions = [];
	$.each( $('select.regions'), function(k, v) {
		regions.push($(v).val());
	});
	$.ajax({
		  type: "POST",
		  url: submitUrl,
		  data: { 
			  'type': $("#search_by_location_searchOptions").val(),
			  'latitude' : $('#search_by_location_latitude').val(),
			  'longitude': $('#search_by_location_longitude').val(),
			  'regions': regions,
			  'page' : page
		  },
		  success: function(data) {
			if (data.success == true) {
		    $.each(data.organisms, function(key, value) {
				$("div#resultlist").append(
					'<div class="col-md-3 col-sm-6"> '+
			        '        <div class="panel panel-default text-center"> '+
			        '            <div class="panel-heading"> '+
			        '				<span class="fa-stack fa-5x">' +
			        '                     <a style="" specimenname="' + value.scientificName + '" href="" photoid=""> '+
			        '					      <img src="' + value.image + '" style="max-width:100%; max-height: 100%"  /> ' +
			        '                     </a>' +
			        '				</span>' +
			        '            </div> '+
			        '            <div class="panel-body"> '+
			        '                <h4>'+ value.shortName +'</h4> '+
			        '               <a href="/app_dev.php/taxon/' + value.url +  '" class="btn btn-primary">Learn More</a> '+
			        '            </div> '+
			        '        </div> '+
			        '   </div>	'		   
				   );
		     });
		    if (data.organisms.length == 10) {
		    	$("div#resultlist").append('<br id="endbreak" clear="both" /><a id="seemore" class="label label-success">See More Results</a>');
		    }
		    $('a#seemore').click(function() {
				getResults();
			});
		    page++;
			}
			else {
				alert(data.error);
			}
		    $.unblockUI();
		  },
		  error: function() {
			  alert("There was an error searching for the results");
			  $.unblockUI();
		  }
	});
}