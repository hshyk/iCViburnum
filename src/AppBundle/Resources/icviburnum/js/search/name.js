var page = 0;
$( document ).ready(function() {
	$( 'form' ).submit(function( e ) {
		e.preventDefault();
		page = 0;
		$("div#resultlist").empty();
		getResults();
	});
});

function getResults() 
{
	$.blockUI({ message: '<div class="loading">Loading results</loading>' });
	$.ajax({
		  type: "POST",
		  url: submitUrl,
		  data: { 
			  'name' : $('#search_by_name_name').val(),
			  'page' : page
		  },
		  success: function(data) {
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
				$('a#seemore').remove();
				$('br#endbreak').remove();
				getResults();
			});
		    page++;
		    $.unblockUI();
		  },
		  error: function() {
			  alert("There was an error searching for the results");
			  $.unblockUI();
		  }
	});
}