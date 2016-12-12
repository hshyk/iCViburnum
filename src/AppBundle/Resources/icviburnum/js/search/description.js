   var $collectionHolder;
   var $characteristicsCounter = 0;
   var page = 0;
   var oldmarker = null;
   
   var allStates = [];

   // setup an "add a tag" link
   var $addCharacteristicsLink = $('<a href="#" class="add_characteristic_link btn btn-primary">Add more characteristics</a>');
   var $newLinkLi = $('<li></li>').append($addCharacteristicsLink);
         
    $( document ).ready(function() {
    	// Get the ul that holds the collection of tags
        $collectionHolder = $('ul.characteristics');

        // add the "add a tag" anchor and li to the tags ul
        $collectionHolder.append($newLinkLi);

        // count the current form inputs we have (e.g. 2), use that as the new
        // index when inserting a new item (e.g. 2)
        $collectionHolder.data('index', $collectionHolder.find(':input').length);

        $addCharacteristicsLink.on('click', function(e) {
            // prevent the link from creating a "#" on the URL
            e.preventDefault();

            // add a new tag form (see next code block)
            addCharacteristicsForm($collectionHolder, $newLinkLi);
        });

        addCharacteristicsForm($collectionHolder, $newLinkLi);
        
	    
	$( 'form' ).submit(function( e ) {
		e.preventDefault();
		page = 0;
		$("ul#resultlist").empty();
		getResults();
	});    
    });
    
    function addCharacteristicsForm($collectionHolder, $newLinkLi) {
        // Get the data-prototype explained earlier
        var prototype = $collectionHolder.data('prototype');

        // get the new index
        var index = $collectionHolder.data('index');

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newForm = prototype.replace(/__name__/g, index);

        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add a tag" link li
        var $newFormLi = $('<li></li>').append(newForm);
        $newLinkLi.before($newFormLi);
        
        loadCharactersStates($characteristicsCounter);
        $characteristicsCounter++;
        
        addCharacteristicsFormDeleteLink($newFormLi);
    }
    
    function addCharacteristicsFormDeleteLink($characteristicsFormLi) {
        var $removeFormA = $('<a href="#" class="btn btn-danger">Remove this Charactersitic</a>');
        $characteristicsFormLi.append($removeFormA);

        $removeFormA.on('click', function(e) {
            // prevent the link from creating a "#" on the URL
            e.preventDefault();

            // remove the li for the tag form
            $characteristicsFormLi.remove();
        });
    }
    
    function loadCharactersStates(number) {
    	 var characterTypeDOM = '#search_by_description_characteristics_' + number + '_character_types';
         var characterDOM = '#search_by_description_characteristics_' + number + '_characters';
         var stateDOM = '#search_by_description_characteristics_' + number + '_states';
         var valueDOM = '#search_by_description_characteristics_' + number + '_value';
         
        var $character_type = $(characterTypeDOM);

        getCharacters($character_type, characterTypeDOM, characterDOM, stateDOM, valueDOM);
        
        $character_type.change(function() {
        	getCharacters( $(this), characterTypeDOM, characterDOM, stateDOM, valueDOM);
        });
    }
    
    function getCharacters($character_type, characterTypeDOM, characterDOM, stateDOM, valueDOM) {
    	$.blockUI({ message: '<div class="loading">Loading options</loading>' });
        var $form = $(this).closest('form');
        var data = {};
        data[$character_type.attr('name')] = $character_type.val();
        // Submit data via AJAX to the form's action path.
        $.ajax({
          url : $form.attr('action'),
          type: $form.attr('method'),
          data : data,
          method: 'POST',
          success: function(html) {
            // Replace current position field ...
            $(characterDOM).replaceWith(
              // ... with the returned one from the AJAX response.
              $(html).find(characterDOM)
            );
            var $character = $(characterDOM);
            getStates($character, characterTypeDOM, characterDOM, stateDOM, valueDOM);
            $character.change(function() {
            	$.blockUI({ message: '<div class="loading">Loading options</loading>' });
            	getStates( $(this), characterTypeDOM, characterDOM, stateDOM, valueDOM);
            });
          }
        });
    }
    
    function getStates($character, characterTypeDOM, characterDOM, stateDOM, valueDOM) {
    	$(valueDOM).parent().remove();
    	
    	// ... retrieve the corresponding form.
        var $form = $(this).closest('form');
        // Simulate form data, but only include the selected sport value.
        var data = {};
        data[$character.attr('name')] = $character.val();
        data[$(characterTypeDOM).attr('name')] = $(characterTypeDOM).val();
        // Submit data via AJAX to the form's action path.
        $.ajax({
         url : $form.attr('action'),
         type: $form.attr('method'),
         data : data,
         method: 'POST',
         success: function(html) {
           // Replace current position field ...
           $(stateDOM).replaceWith(
             // ... with the returned one from the AJAX response.
             $(html).find(stateDOM)
           );
           $(stateDOM).after(
        	 $(html).find(valueDOM).parent()
           );
           if ($(stateDOM).val()) {
        	   allStates.push($(stateDOM).val());
           }
           getStateHelpText(stateDOM);
           $(stateDOM).change(function() {
        	  getStateHelpText(stateDOM);
           });
           $.unblockUI();
           // Position field now displays the appropriate positions.
         }
        });
      
    }
    
    function getStateHelpText(stateDOM)
    {
 
    	$(stateDOM).siblings(".statehelp").remove();
    	var definition = $(stateDOM + ' option:selected').attr('data-help-definition');
    	var image = $(stateDOM + ' option:selected').attr('data-help-url');
    	var credit = $(stateDOM + ' option:selected').attr('data-help-credit')
    	 $(stateDOM).after('<div class="statehelp"><img height="100" src="' + image + '" />' + definition + '<br />Credit: ' + credit + "</div>");
    }
    
 
    function getResults() 
    {
    	$.blockUI({ message: '<div class="loading">Loading results</loading>' });
    	var states = [];
    	var values = {};
    	$.each( $("select[name*='states']"), function(k, v) {
    		states.push($(v).val());
    	});
    	$.each( $("input[name*='value']"), function(k, v) {
    		console.log(k);
    		console.log($(v).parent().parent().find("select[name*='states']").val());
    		
    		values[$(v).parent().parent().find("select[name*='states']").val()] = $(v).val();
    	});
    	
    	$.ajax({
    		  type: "POST",
    		  url: submitUrl,
    		  data: { 
    			  'states': states,
    			  'values': values,
    			  'page': page
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
    