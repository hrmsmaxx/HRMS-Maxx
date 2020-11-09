<!DOCTYPE html>
<html lang="<?=lang('lang_code')?>">
	<head>

            <?php
                $theme_settings = $this->db->get_where('subdomin_theme_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
                $favicon_settings = $this->db->get_where('subdomin_favicon_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
                $appleicon_settings = $this->db->get_where('subdomin_appleicon_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
                $logo_settings = $this->db->get_where('subdomin_logo_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();

                $theme_settings = unserialize($theme_settings['theme_settings']);

                $system_settings = $this->db->get_where('subdomin_system_settings',array('subdomain_id'=>$this->session->userdata('subdomain_id')))->row_array();
                
                $systems = unserialize(base64_decode($system_settings['system_settings']));

                $website_name = $theme_settings['website_name']?$theme_settings['website_name']:$template['title'];
                $logo_or_icon = $theme_settings['logo_or_icon']?$theme_settings['logo_or_icon']:config_item('logo_or_icon');
                $system_font = $theme_settings['system_font']?$theme_settings['system_font']:config_item('system_font');
                $sidebar_theme = $theme_settings['sidebar_theme']?$theme_settings['sidebar_theme']:config_item('sidebar_theme');
                $theme_color = $theme_settings['theme_color']?$theme_settings['theme_color']:config_item('theme_color');
                $top_bar_color = $theme_settings['top_bar_color']?$theme_settings['top_bar_color']:config_item('top_bar_color');
                $login_title = $theme_settings['login_title']?$theme_settings['login_title']:config_item('login_title');

                $site_favicon = $favicon_settings['fav_icon']?$favicon_settings['fav_icon']:config_item('favicon_settings');
                $site_appleicon = $appleicon_settings['fav_icon']?$appleicon_settings['fav_icon']:config_item('site_appleicon');
                $site_logo = $logo_settings['company_logo']?$logo_settings['company_logo']:config_item('company_logo');

                $use_gravatar = $systems['use_gravatar']?$systems['use_gravatar']:config_item('use_gravatar');
            ?>

            <meta charset="utf-8">
            <?php $favicon = $site_favicon; $ext = substr($favicon, -4); ?>
            <?php if ( $ext == '.ico') : ?>
            <link rel="shortcut icon" href="<?=base_url()?>assets/images/<?=$site_favicon?>">
            <?php endif; ?>
            <?php if ($ext == '.png') : ?>
            <link rel="icon" type="image/png" href="<?=base_url()?>assets/images/<?=$site_favicon?>">
            <?php endif; ?>
            <?php if ($ext == '.jpg' || $ext == 'jpeg') : ?>
            <link rel="icon" type="image/jpeg" href="<?=base_url()?>assets/images/<?=$site_favicon?>">
            <?php endif; ?>
            <?php if ($site_appleicon != '') : ?>
            <link rel="apple-touch-icon" href="<?=base_url()?>assets/images/<?=$site_appleicon?>">
            <link rel="apple-touch-icon" sizes="72x72" href="<?=base_url()?>assets/images/<?=$site_appleicon?>">
            <link rel="apple-touch-icon" sizes="114x114" href="<?=base_url()?>assets/images/<?=$site_appleicon?>">
            <link rel="apple-touch-icon" sizes="144x144" href="<?=base_url()?>assets/images/<?=$site_appleicon?>">
            <?php endif; ?>
            <title><?php echo $website_name;?></title>
            <meta name="description" content="<?=config_item('site_desc')?>">
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
			<link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap.min.css">
			<link rel="stylesheet" href="<?=base_url()?>assets/css/font-awesome.min.css">
            <link rel="stylesheet" href="<?=base_url()?>assets/css/app.css" type="text/css">
            <link rel="stylesheet" href="<?=base_url()?>assets/css/plugins/toastr.min.css">
            <?php
            $family = 'Lato';
            $font = $system_font;
            switch ($font) {
                    case "open_sans": $family="Open Sans";  echo "<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,latin-ext,greek-ext,cyrillic-ext' rel='stylesheet' type='text/css'>"; break;
                    case "open_sans_condensed": $family="Open Sans Condensed";  echo "<link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700&subset=latin,greek-ext,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>"; break;
                    case "roboto": $family="Roboto";  echo "<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700&subset=latin,greek-ext,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>"; break;
                    case "roboto_condensed": $family="Roboto Condensed";  echo "<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700&subset=latin,greek-ext,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>"; break;
                    case "ubuntu": $family="Ubuntu";  echo "<link href='https://fonts.googleapis.com/css?family=Ubuntu:400,300,500,700&subset=latin,greek-ext,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>"; break;
                    case "lato": $family="Lato";  echo "<link href='https://fonts.googleapis.com/css?family=Lato:100,300,400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>"; break;
                    case "oxygen": $family="Oxygen";  echo "<link href='https://fonts.googleapis.com/css?family=Oxygen:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>"; break;
                    case "pt_sans": $family="PT Sans";  echo "<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>"; break;
                    case "source_sans": $family="Source Sans Pro";  echo "<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>"; break;
					case "montserrat": $family="Montserrat";  echo "<link href='https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>"; break;
					case "fira_sans": $family="Fira Sans";  echo "<link href='https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600,700' rel='stylesheet' type='text/css'>"; break;
					case "circularstd": $family="CircularStd"; break;
            }
            ?>
            <style type="text/css">
                    body { font-family: '<?=$family?>'; }
            </style>
            
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-132757834-1"></script>
            <script>
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());

              gtag('config', 'UA-132757834-1');
            </script>

            <!--[if lt IE 9]>
            <script src="js/ie/html5shiv.js" cache="false">
            </script>
            <script src="js/ie/respond.min.js" cache="false">
            </script>
            <script src="js/ie/excanvas.js" cache="false">
            </script> <![endif]-->
	</head>
	<body class="theme-<?=$top_bar_color?> account-page">


<div class="main-wrapper">
	<!--main content start-->
      <?php  echo $template['body'];?>
      <!--main content end-->
	  </div>

      <script type="text/javascript">
    var base_url = '<?php echo base_url();?>';
    
</script>

        <script src="<?=base_url()?>assets/js/jquery-2.2.4.min.js"></script>
        <script src="<?=base_url()?>assets/js/jquery-ui.min.js"></script>   
        <script src="<?=base_url()?>assets/js/jquery.validate.js"></script>
	    <script src="<?=base_url()?>assets/js/app.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script src="<?=base_url()?>assets/js/libs/toastr.min.js"></script>
        <script>
        // $(document).ready(function(){
        //     // alert('Renewal');  
        //     setInterval(function(){ alert("Renewal"); }, 3000);
        // });
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "positionClass": "toast-bottom-right",
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }          

    </script>


    <?php if ($this->session->flashdata('tokbox_success')  != ''){ ?>
    <script type="text/javascript">
        toastr.success("<?php echo $this->session->flashdata('tokbox_success'); ?>");
    </script>

    <?php } ?>

    <?php if ($this->session->flashdata('tokbox_error')  != ''){ ?>
    <script type="text/javascript">
        toastr.error("<?php echo $this->session->flashdata('tokbox_error'); ?>");
    </script>

    <?php } ?>

        <script type="text/javascript">
        $(document).ready(function(){
         $(".dropdown-toggle").click(function(){
            $(".dropdown-menu").toggle();
        });
        });
        </script>
        <script type="text/javascript">
        $(document).ready(function(){
            // function isPhonePresent() {
            //     console.log($('#create_client_phone').val().length > 0);
            //     return $('#create_client_phone').val().length > 0;
            // }

            // $.validator.addMethod("mobilevalidation",
            // function(value, element) {
            //         return /^(\+\d{1,3}[- ]?)?\d{10}$/.test(value);
            // },
            // "Please enter a valid mobile number."
            // );
            
            // $.validator.addMethod("phonevalidation",
            //     function(value, element) {
            //         return /^(\+\d{1}[- ]?)?\d{6,14}[0-9]$/.test(value);
            //             //return /^\+(?:[0-9] ?){6,14}[0-9]$/.test(value);
            //     },
            // "Please enter a valid phone number."
            // );
            $(document).on('click','.SubscribeBtn',function(){
            $.validator.addMethod("emailvalidation",
                    function(value, element) {
                            return /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/.test(value);
                    },
            "Please enter a valid email address."
            );

            $("#SubscribeForm").validate({
                onsubmit: true,
                ignore: [] ,
                rules: {
                    workspace: {
                        required: true
                    },
                    company_name: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    country: {
                        required: true
                    },
                    fullname: {
                        required: true
                    },
                    username: {
                        required: true
                    },
                    subscriber_email: {
                        required: true,
                        emailvalidation: 'emailvalidation'
                    },
                    password: {
                        required: true,
                        minlength : 6
                    },
                    confirm_password: {
                        required: true,
                        minlength : 6,
                        equalTo : "#subpassword"
                    }
                },
                messages: {
                    workspace: {
                        required: "workspace must not be empty"
                    },
                    company_name: {
                        required: "Company Name must not be empty"
                    },
                    city: {
                        required: "City must not be empty"
                    },
                    country: {
                        required: "Country must not be empty"
                    },
                    fullname: {
                        required: "Fullname must not be empty"
                    },
                    username: {
                        required: "Username must not be empty"
                    },
                    subscriber_email: {
                        required: "Email Id is required",
                        emailvalidation: "Please enter a valid email Id"
                    },
                    password: {
                        required: "Password must not be empty",
                        minlength : "Password required minimum 6 characters"
                    },
                    confirm_password: {
                        required: "Confirm Password must not be empty",
                        minlength : "Confirm Password required minimum 6 characters",
                        equalTo : "Password Mismatched"
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
               });
               });


            $(document).on('change','#workspace',function(){
                var workspace = $(this).val();
                if(workspace != ''){                    
                    $.post('<?php echo base_url();?>auth/check_workspace',{workspace:workspace},function(data){
                        // alert(data);
                        if(data != 0){
                            toastr.error('Already WorkSpace Exists!');
                            $('.SubscribeBtn').attr('disabled','disabled');
                            return false;
                        }else{
                            toastr.success('Workspace Available');
                            $('.SubscribeBtn').removeAttr('disabled');
                        }
                    });
                }
            });

            $(document).on('change','#subscriber_email',function(){
                var subscriber_email = $(this).val();
                if(subscriber_email != ''){                    
                    $.post('<?php echo base_url();?>auth/check_subscriberemail',{subscriber_email:subscriber_email},function(data){
                        if(data != 0){
                            toastr.error('Already Email Exists!');
                            $('.SubscribeBtn').attr('disabled','disabled');
                            return false;
                        }else{
                            $('.SubscribeBtn').removeAttr('disabled');
                        }
                    });
                }
            });

            $(document).on('change','#subscribe_username',function(){
                var subscribe_username = $(this).val();
                if(subscribe_username != ''){                    
                    $.post('<?php echo base_url();?>auth/check_subscribe_username',{subscribe_username:subscribe_username},function(data){
                        if(data != 0){
                            toastr.error('Already Username Exists!');
                            $('.SubscribeBtn').attr('disabled','disabled');
                            return false;
                        }else{
                            toastr.success('Username Available');
                            $('.SubscribeBtn').removeAttr('disabled');
                        }
                    });
                }
            });

            $(document).on('keyup','#company_name',function(){
                var company_name = $(this).val();
                var company_nam = company_name.toLowerCase();
                $('#workspace').val(company_nam);
                if(company_nam != ''){                    
                    $.post('<?php echo base_url();?>auth/check_workspace',{workspace:company_nam},function(data){
                        if(data != 0){
                            toastr.error('Already WorkSpace Exists!');
                            $('.SubscribeBtn').attr('disabled','disabled');
                            return false;
                        }else{
                            toastr.success('Workspace Available');
                            $('.SubscribeBtn').removeAttr('disabled');
                        }
                    });
                }
            });




        });
            
        </script>
</body>
</html>
