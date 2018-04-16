/* $(function(){
	$.validator.setDefaults({
		errorClass: 'help-block',
		highlight: function(element){
			$(element)
			.closest('form-group')
			.addClass('has-error');
		},
		unhighlight: function(element){
			$(element)
			.closest('form-group')
			.removeClass('has-error');
		}
	});
	
}); */

var $adminJQ = jQuery.noConflict();
$adminJQ(document).ready(function(){
  $adminJQ('.regForm-personal #reg-form').validate({
    rules: {
      inputFirstName: {
        required: true,
		lettersonly: true
      },
      txtEmail: {
        required: true,
        email: true
      },
	  txtContact: {
        required: true,
		number: true,
        rangelength: [10,10]
		
      }
     
    },
    success: function(label) {
      label.text('OK!').addClass('valid');
	 // label.remove();
    }
  });
});



