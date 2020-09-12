$('#ads_image,#client_image,#imageonly').change(function(){
	
   var url = $(this).val();    
   var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();    
   if ((ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
    {
        $('#img_upload_error').css('display','none');
   }
   else
   {
     $('#img_upload_error').css('display','block');
     $('#ads_image').val('');
     $('#client_image').val('');
     $('#imageonly').val('');
   }
 });
	
	
 	$(document).ready(function(){     

 
        $('#form_emailsetting').bootstrapValidator({ 
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later       
       fields: {        
        	email_address:   {
                validators:          {
                notEmpty:              {
                        message: 'Please enter a Email'
                                       },
				emailAddress: {
                        message: 'Please enter valid email address'
                    }
                                     }
                                    },
                email_tittle:   {
                validators:          {
                notEmpty:              {
                        message: 'Please enter a Title'
                                       }
                                     }
                                    }
                          
		}
        });
        
         $('#pass-val').bootstrapValidator({ 
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later       
        fields: {        
        	old_password: {                
                validators: {
					notEmpty: {
						//field: 'new_password',
						message: 'Please enter the old password'
						},
                    remote: {
                        url: BASE_URL+'admin/dashboard/check_old_password',
                        // Send { username: 'its value', email: 'its value' } to the back-end
                        data: function(validator) {
                            return {
                                old_password: validator.getFieldElements('old_password').val()
                            };
                        },
                        message: 'The Password is incorrect',
                        type: 'POST'
                    }
                }
            },
            	new_password: {
                validators: { 
                 notEmpty: {
						field: 'new_password',
						message: 'Please enter the new password'
						}	,					
					identical: {
						field: 'confirm_password',
						message: 'The confirm password and its new password are not the same'
						}			
                }
            },
            confirm_password: {
                validators: {
                           notEmpty: {
						field: 'new_password',
						message: 'Please enter the confirm_password'
						}	,					
					identical: {
						field: 'new_password',
						message: 'The new password and its confirm are not the same'
						}
                    }
                }
            }
        }); 



       //  $('#frm_contact').bootstrapValidator({ 
       //  // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later       
       // fields: {

       //      contactname:   {
       //          validators:          {
       //          notEmpty:              {
       //                  message: 'Please enter a full name'
       //                                 }
       //                               }
       //                              },

       //      contactemail:   {
       //          validators:          {
       //          notEmpty:              {
       //                  message: 'Please enter a email'
       //                                 },
       //          emailAddress: {
       //                  message: 'Please enter valid email address'
       //              }
       //                               }
       //                              },                       
                                                
       //       contactphone:   {
       //          validators:          {
       //          notEmpty:              {
       //                  message: 'Please enter a contact number'
       //                                 },
       //          integer: {
       //                  message: 'Please enter valid contact number'
       //              }
       //                               }
       //                              }, 
       //       contactcountry:   {
       //          validators:          {
       //          notEmpty:              {
       //                  message: 'Please select country'
       //                                 }
       //                               }
       //                              },                                                                    

                
                          
       //  }
       //  });  


        $('#buynow_form').bootstrapValidator({ 
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later       
       fields: {

            name:   {
                validators:          {
                notEmpty:              {
                        message: 'Please enter a full name'
                                       }
                                     }
                                    },

            email:   {
                validators:          {
                notEmpty:              {
                        message: 'Please enter a email'
                                       },
                emailAddress: {
                        message: 'Please enter valid email address'
                    }
                                     }
                                    },

             companyname:   {
                validators:          {
                notEmpty:              {
                        message: 'Please enter a company name'
                                       }
                                     }
                                    },                        
                                                
             phoneno:   {
                validators:          {
                notEmpty:              {
                        message: 'Please enter a contact number'
                                       },
                integer: {
                        message: 'Please enter valid contact number'
                    }
                                     }
                                    }, 
             country:   {
                validators:          {
                notEmpty:              {
                        message: 'Please select country'
                                       }
                                     }
                                    }                                                                   

                
                          
        }
        });  
        
    });  // document.ready function  admin_edit_ip  
    
        
