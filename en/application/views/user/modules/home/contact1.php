 $('#contact-form').on('submit', function (e) {
                  alert("baasss");
                  return false;
			      if (!e.isDefaultPrevented()) {
			         console.log("Sasas")
			         var re = /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/;
			         var emailFormat = re.test($("#form_email").val());// this return result in boolean type
			         if (emailFormat) {
			            $('#alert_message').css({ 'display': 'none' })
			            var url = "contact.php";
			            $.ajax({
			               type: "POST",
			               url: url,
			               data: $(this).serialize(),
			               success: function (data) {
			                  var messageAlert = 'alert-' + data.type;
			                  var messageText = data.message;
			                  var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '</div>';
			                  if (messageAlert && messageText) {
			                     $('#contact-form').find('.messages').html(alertBox);
			                     $('#contact-form')[0].reset();
			                  }
			               }
			            });
			         }
			         else {
			            $('#alert_message').css({ 'display': 'block' });
			            $('#form_email').focus();
			            return false;
			         }
			         return false;
			      }
			   })