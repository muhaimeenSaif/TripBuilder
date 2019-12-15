$(document).ready(function() {
    var max_fields      = 5; //maximum input boxes allowed
    var wrapper         = $("#dynamicAppend"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div id="removeAfterDone" class="removeAfterDone">'
            +'<br> <hr/>'
            +'<div class="row">'
            +'<div class="input-group col-md-2">'
            +' </div>'
                            +'<div class="input-group col-md-4">'
                                +'<div class="input-group-prepend">'
                                    +'<span class="input-group-text">From</span>'
                                +'</div>'
                                +'<input autocomplete="off" class="form-control autocomplete"  id="autocomplete[' + x + ']" name="departure_airport[' + x + ']" type="text" placeholder="City name" required=""/>'
                            +'</div>'
                              
                            +'<div class="input-group col-md-4">'
                                +'<div class="input-group-prepend">'
                                +'<span class="input-group-text">To</span>'
                                +'</div>'
                                +'<input autocomplete="off" class="form-control autocomplete" id="autocomplete[' + x + ']" name="arrival_airport[' + x + ']" type="text" placeholder="City name" required=""/>'
                                +'</div>'
                            +'</div>'
                      
                            +'<br>'
                            +'<div class="row">'
                            +'<div class="input-group col-md-2">'
                            +' </div>'
                                +'<div class="input-group col-md-4">'
                                    +'<div class="input-group-prepend">'
                                        +'<span class="input-group-text ">Departure</span>'
                                    +'</div>'
                                    +'<input type="text" autocomplete="off" class="form-control datePickerr"  name="departure_date[' + x + ']" id="departure_date" placeholder="Departure date" required="">'
                                    +'<div class="invalid-feedback" style="width: 100%;">'
                                        +'Departure date is required'
                                    +'</div>'
                                +'</div>'
                                    +'<br>'
                +'</div> <a href="#" class="remove_field btn btn-danger" style="float: right" >Remove</a></div>')
        
        }
        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
          e.preventDefault(); 
          $(this).parent('div').remove(); 
          x--;
      })

        $(document).ready(function(){
          $('.datePickerr').each(function() {
              $(".datePickerr").datepicker({
              startDate : new Date(),
              autoclose: true,
              }).on('changeDate', function (selected) {
              var minDate = new Date(selected.date.valueOf());
              $('.datePickerr').datepicker('setStartDate', minDate);
              });
            });

          });
        var options = {
            shouldSort: true,
            threshold: 0.4,
            maxPatternLength: 32,
            keys: [{
              name: 'iata',
              weight: 0.5
            }, {
              name: 'name',
              weight: 0.3
            }, {
              name: 'city',
              weight: 0.2
            }]
          };
          
          var fuse = new Fuse(airports, options)
          
          $('.autocomplete').each(function() {
            var ac = $(this);
            
             ac.on('click', function(e) {
              e.stopPropagation();
            })
            .on('focus keyup', search)
            .on('keydown', onKeyDown);
            
            var wrap = $('<div>')
              .addClass('autocomplete-wrapper')
              .insertBefore(ac)
              .append(ac);
            
              var list = $('<div>')
                .addClass('autocomplete-results')
                .on('click', '.autocomplete-result', function(e) {
                  e.preventDefault();
                  e.stopPropagation();
                  selectIndex($(this).data('index'), ac);
              })
              .appendTo(wrap);
          });
          
          $(document)
            .on('mouseover', '.autocomplete-result', function(e) {
              var index = parseInt($(this).data('index'), 10);
              if (!isNaN(index)) {
                $(this).attr('data-highlight', index);
              }
            })
            .on('click', clearResults);
          
          function clearResults() {
            results = [];
            numResults = 0;
            $('.autocomplete-results').empty();
          }
          
          function selectIndex(index, autoinput) {
            if (results.length >= index + 1) {
              autoinput.val(results[index].iata);
              clearResults();
            }  
          }
          
          var results = [];
          var numResults = 0;
          var selectedIndex = -1;
          
          function search(e) {
            if (e.which === 38 || e.which === 13 || e.which === 40) {
              return;
            }
            var ac = $(e.target);
            var list = ac.next();
            if (ac.val().length > 0) {
              results = _.take(fuse.search(ac.val()), 7);
              numResults = results.length;
              
              var divs = results.map(function(r, i) {
                  return '<div class="autocomplete-result" data-index="'+ i +'">'
                       + '<div><b>'+ r.iata +'</b> - '+ r.name +'</div>'
                       + '<div class="autocomplete-location">'+ r.city +', '+ r.country +'</div>'
                       + '</div>';
               });
              
              selectedIndex = -1;
              list.html(divs.join(''))
                .attr('data-highlight', selectedIndex);
          
            } else {
              numResults = 0;
              list.empty();
            }
          }
          
          function onKeyDown(e) {
            var ac = $(e.currentTarget);
            var list = ac.next();
            switch(e.which) {
              case 38: // up
                selectedIndex--;
                if (selectedIndex <= -1) {
                  selectedIndex = -1;
                }
                list.attr('data-highlight', selectedIndex);
                break;
              case 13: // enter
                selectIndex(selectedIndex, ac);
                break;
              case 9: // enter
                selectIndex(selectedIndex, ac);
                e.stopPropagation();
                return;
              case 40: // down
                selectedIndex++;
                if (selectedIndex >= numResults) {
                  selectedIndex = numResults-1;
                }
                list.attr('data-highlight', selectedIndex);
                break;
          
              default: return; // exit this handler for other keys
            }
            e.stopPropagation();
            e.preventDefault(); // prevent the default action (scroll / move caret)
          }
          
          
          
    });
    
   
});