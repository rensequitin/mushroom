var $valJQ = jQuery.noConflict();
$valJQ(document).ready(function(){
  $valJQ('#changePass #password-form').validate({
    rules: {
		
	newPassword: {
		required: true,
        minlength: 6
        
      },
      confirmPassword: {
		required: true,
        equalTo: "#newPassword"
		
      }
     
    },
	/* messages: {
		newPassword: {
			required: 'Please enter a password',
		}
	}, */
    success: function(label) {
		label.text('OK!').addClass('valid');
		//label.remove();
    }
  });
});