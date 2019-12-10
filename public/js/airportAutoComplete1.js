var options1 = {
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
  
  var test = new Fuse(airports, options1)
  
  
  var ac1 = $('#autocomplete1')
    .on('click', function(e) {
      e.stopPropagation();
    })
    .on('focus keyup', search1)
    .on('keydown', onKeyDown1);
  
  var wrap1 = $('<div>')
    .addClass('autocomplete1-wrapper')
    .insertBefore(ac1)
    .append(ac1);
  
  var list1 = $('<div>')
    .addClass('autocomplete1-results')
    .on('click', '.autocomplete1-result', function(e) {
      e.preventDefault();
      e.stopPropagation();
      selectIndex1($(this).data('index'));
    })
    .appendTo(wrap1);
  
  $(document)
    .on('mouseover', '.autocomplete1-result', function(e) {
      var index1 = parseInt($(this).data('index1'), 10);
      if (!isNaN(index1)) {
        list1.attr('data-highlight', index1);
      }
    })
    .on('click', clearResults1);
  
  function clearResults1() {
    results1 = [];
    numResults1 = 0;
    list1.empty();
  }
  
  function selectIndex1(index1) {
    if (results1.length >= index1 + 1) {
      ac1.val(results1[index1].iata);
      clearResults1();
    }  
  }
  
  var results1 = [];
  var numResults1 = 0;
  var selectedIndex1 = -1;
  
  function search1(e) {
    if (e.which === 38 || e.which === 13 || e.which === 40) {
      return;
    }
    
    if (ac1.val().length > 0) {
      results1 = _.take(test.search(ac1.val()), 7);
      numResults1 = results1.length;
      
      var divs1 = results1.map(function(r, i) {
          return '<div class="autocomplete1-result" data-index="'+ i +'">'
               + '<div><b>'+ r.iata +'</b> - '+ r.name +'</div>'
               + '<div class="autocomplete1-location">'+ r.city +', '+ r.country +'</div>'
               + '</div>';
       });
      
      selectedIndex1 = -1;
      list1.html(divs1.join(''))
        .attr('data-highlight', selectedIndex1);
  
    } else {
      numResults1 = 0;
      list1.empty();
    }
  }
  
  function onKeyDown1(e) {
    switch(e.which) {
      case 38: // up
        selectedIndex1--;
        if (selectedIndex1 <= -1) {
          selectedIndex1 = -1;
        }
        list1.attr('data-highlight', selectedIndex1);
        break;
      case 13: // enter
        selectIndex1(selectedIndex1);
        break;
      case 9: // enter
        selectIndex1(selectedIndex1);
        e.stopPropagation();
        return;
      case 40: // down
        selectedIndex1++;
        if (selectedIndex1 >= numResults1) {
          selectedIndex1 = numResults1-1;
        }
        list1.attr('data-highlight', selectedIndex1);
        break;
  
      default: return; // exit this handler for other keys
    }
    e.stopPropagation();
    e.preventDefault(); // prevent the default action (scroll / move caret)
  }