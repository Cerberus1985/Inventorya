/**
 * @author inventorya
 */
$("#FormLoggin").validate({
		rules: {
      userlogin: {
        required: true,
        lettersonly: true
      },
      passwordlogin: {
        required: true,
        lettersonly: true
      }
      
    },
    messages: {
 	userlogin:{
 		userlogin:'algo esta mal con tu usuario'
 					}
    },
    submitHandler: function() {
      alert("formulario enviado");
    }
  });

