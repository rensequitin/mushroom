$('body').click(function(evt){    
       if(evt.target.id == "menu_content")
          return;
       //For descendants of menu_content being clicked, remove this check if you do not want to put constraint on descendants.
       if($(evt.target).closest('#menu_content').length)
          return;             

      //Do processing of click event here for every element except with id menu_content

});