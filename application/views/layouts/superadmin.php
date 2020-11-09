<?php if (config_item('timezone')) { date_default_timezone_set(config_item('timezone')); } ?>
<!DOCTYPE html>
<html lang="<?=lang('lang_code')?>" class="app">
<head>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="author" content="<?=config_item('site_author')?>">
	<meta name="keyword" content="<?=config_item('site_desc')?>">
	
	<title><?php echo $template['title'];?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />

	 <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>superadmin_assets/img/favicon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>superadmin_assets/css/bootstrap.min.css">


	<!--	<link rel="stylesheet" href="<?php echo base_url();?>assets/js/datepicker/datepicker.css"/>-->

		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/plugins/toastr.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>superadmin_assets/css/font-awesome.min.css">
		
		<!-- Feathericon CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>superadmin_assets/css/feathericon.min.css">

        <!-- Select2 CSS -->
		<link rel="stylesheet" href="<?php echo base_url();?>superadmin_assets/css/select2.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>superadmin_assets/plugins/datatables/datatables.min.css" type="text/css"/>
		<link rel="stylesheet" href="<?=base_url()?>superadmin_assets/css/bootstrap-datetimepicker.min.css">
		<!-- Main CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>superadmin_assets/css/style.css">		

		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/typeahead.css">
		
			<?php if (isset($editor)) { ?>
		<link href="<?=base_url()?>assets/css/plugins/summernote.css" rel="stylesheet">
		<?php } ?>
		
		<?php if (isset($datepicker)) { ?>
		<link rel="stylesheet" href="<?=base_url()?>assets/js/slider/slider.css">
		<link rel="stylesheet" href="<?=base_url()?>superadmin_assets/css/bootstrap-datetimepicker.min.css">
		<?php } ?>
	
	<?php 
	$family = 'Lato';
	$font = config_item('system_font');
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
	
	<style>
		#pie-chart{
			min-height: 250px;
		}
		.morris-hover{position:absolute;z-index:1000;}
		.morris-hover.morris-default-style{border-radius:10px;padding:6px;color:#666;background:rgba(255, 255, 255, 0.8);border:solid 2px rgba(230, 230, 230, 0.8);font-family:sans-serif;font-size:12px;text-align:center;}
		.morris-hover.morris-default-style .morris-hover-row-label{font-weight:bold;margin:0.25em 0;}
		.morris-hover.morris-default-style .morris-hover-point{white-space:nowrap;margin:0.1em 0;}
		body { font-family: '<?=$family?>'; }
		.error{ color:red;  }
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
	<script src="js/ie/html5shiv.js"></script>
	<script src="js/ie/respond.min.js"></script>
	<script src="js/ie/excanvas.js"></script>
	<![endif]-->

</head>
<body>
	
		<!-- Main Wrapper -->
        <div class="main-wrapper">
		
			<!-- Header -->
            <div class="header">
			
				<!-- Logo -->
                <div class="header-left">
                    <a href="<?php echo base_url();?>superadmin" class="logo">
						<img src="<?php echo base_url();?>superadmin_assets/img/logo-small.png" alt="Logo">
					</a>
					<a href="<?php echo base_url();?>superadmin" class="logo logo-small">
						<img src="<?php echo base_url();?>superadmin_assets/img/logo-small.png" alt="Logo" width="30" height="30">
					</a>
                </div>
				<!-- /Logo -->
				
			<!--	<a href="javascript:void(0);" id="toggle_btn">
					<i class="fe fe-text-align-left"></i>
				</a>-->
				
				<!--<div class="top-nav-search">
					<form>
						<input type="text" class="form-control" placeholder="Search here">
						<button class="btn" type="submit"><i class="fa fa-search"></i></button>
					</form>
				</div>-->
				
				<!-- Mobile Menu Toggle -->
				<a class="mobile_btn" id="mobile_btn">
					<i class="fa fa-bars"></i>
				</a>
				<!-- /Mobile Menu Toggle -->
				
				<!-- Header Right Menu -->
				<ul class="nav user-menu">

					<!-- App Lists -->
					<!-- <li class="nav-item dropdown app-dropdown">
						<a class="nav-link dropdown-toggle" aria-expanded="false" role="button" data-toggle="dropdown" href="#"><i class="fe fe-app-menu"></i></a>
						<ul class="dropdown-menu app-dropdown-menu">
							<li>
								<div class="app-list">
									<div class="row">
										<div class="col"><a class="app-item" href="inbox.html"><i class="fa fa-envelope"></i><span>Email</span></a></div>
										<div class="col"><a class="app-item" href="calendar.html"><i class="fa fa-calendar"></i><span>Calendar</span></a></div>
										<div class="col"><a class="app-item" href="chat.html"><i class="fa fa-comments"></i><span>Chat</span></a></div>
									</div>
								</div>
							</li>
						</ul>
					</li> -->
					<!-- /App Lists -->
					
					<!-- Notifications -->
				<!--	<li class="nav-item dropdown noti-dropdown">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
							<i class="fe fe-bell"></i> <span class="badge badge-pill">3</span>
						</a>
						<div class="dropdown-menu notifications">
							<div class="topnav-dropdown-header">
								<span class="notification-title">Notifications</span>
								<a href="javascript:void(0)" class="clear-noti"> Clear All </a>
							</div>
							<div class="noti-content">
								<ul class="notification-list">
									<li class="notification-message">
										<a href="#">
											<div class="media">
												<span class="avatar avatar-sm">
													<img class="avatar-img rounded-circle" alt="User Image" src="<?php echo base_url();?>superadmin_assets/img/profiles/avatar-02.jpg">
												</span>
												<div class="media-body">
													<p class="noti-details"><span class="noti-title">Carlson Tech</span> has approved <span class="noti-title">your estimate</span></p>
													<p class="noti-time"><span class="notification-time">4 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
									<li class="notification-message">
										<a href="#">
											<div class="media">
												<span class="avatar avatar-sm">
													<img class="avatar-img rounded-circle" alt="User Image" src="<?php echo base_url();?>superadmin_assets/img/profiles/avatar-11.jpg">
												</span>
												<div class="media-body">
													<p class="noti-details"><span class="noti-title">International Software Inc</span> has sent you a invoice in the amount of <span class="noti-title">$218</span></p>
													<p class="noti-time"><span class="notification-time">6 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
									<li class="notification-message">
										<a href="#">
											<div class="media">
												<span class="avatar avatar-sm">
													<img class="avatar-img rounded-circle" alt="User Image" src="<?php echo base_url();?>superadmin_assets/img/profiles/avatar-17.jpg">
												</span>
												<div class="media-body">
												<p class="noti-details"><span class="noti-title">John Hendry</span> sent a cancellation request <span class="noti-title">Apple iPhone XR</span></p>
												<p class="noti-time"><span class="notification-time">8 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
									<li class="notification-message">
										<a href="#">
											<div class="media">
												<span class="avatar avatar-sm">
													<img class="avatar-img rounded-circle" alt="User Image" src="<?php echo base_url();?>superadmin_assets/img/profiles/avatar-13.jpg">
												</span>
												<div class="media-body">
													<p class="noti-details"><span class="noti-title">Mercury Software Inc</span> added a new product <span class="noti-title">Apple MacBook Pro</span></p>
													<p class="noti-time"><span class="notification-time">12 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
								</ul>
							</div>
							<div class="topnav-dropdown-footer">
								<!-- <a href="#">View all Notifications</a> -->
						<!--	</div>
						</div>
					</li>-->
					<!-- /Notifications -->
					
					<!-- User Menu -->
					<li class="nav-item dropdown has-arrow">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
							<span class="user-img"><img class="rounded-circle" src="<?php echo base_url();?>superadmin_assets/img/profiles/avatar-01.jpg" width="31" alt="Ryan Taylor"></span>
						</a>
						<div class="dropdown-menu">
							<div class="user-header">
								<div class="avatar avatar-sm">
									<img src="<?php echo base_url();?>superadmin_assets/img/profiles/avatar-01.jpg" alt="User Image" class="avatar-img rounded-circle">
								</div>
								<div class="user-text">
									<h6>Ryan Taylor</h6>
									<p class="text-muted mb-0">Administrator</p>
								</div>
							</div>
							<!-- <a class="dropdown-item" href="<?php echo base_url();?>superadmin">My Profile</a>
							<a class="dropdown-item" href="<?php echo base_url();?>superadmin">Account Settings</a> -->
							<a class="dropdown-item" href="<?php echo base_url();?>logout">Logout</a>
						</div>
					</li>
					<!-- /User Menu -->
					
				</ul>
				<!-- /Header Right Menu -->
				
            </div>
			<!-- /Header -->
			
			<!-- Sidebar -->
            <div class="sidebar" id="sidebar">
                <div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<ul>
							<!-- <li class="menu-title"> 
								<span>Main</span>
							</li> -->
							<!-- <li class="<?php echo ($page == lang('subscription'))?'active':'';?>"> 
								<a href="<?php echo base_url();?>superadmin"><i class="fe fe-home"></i> <span><?php echo lang('subscription')?></span></a>
							</li> -->
							<li class="<?php echo ($page == lang('subscription_list'))?'active':'';?>"> 
								<a href="<?php echo base_url();?>superadmin/subscription_list"><i class="fa fa-cart-arrow-down"></i> <span><?php echo lang('subscription_list')?></span></a>
							</li>
							<li class="<?php echo ($page == lang('subscribed_companies'))?'active':'';?>"> 
								<a href="<?php echo base_url();?>superadmin/subscribed_companies"><i class="fa fa-building"></i> <span><?php echo  lang('subscribed_companies')?></span></a>
							</li>
							<li class="submenu <?php echo ($page == lang('invoices'))?'active':'';?>"> 
								<a href="#"><i class="fa fa-files-o "></i> <span><?php echo  lang('invoices')?></span><span class="menu-arrow"></span></a>
								<!-- <ul class="nav lt"> -->
                                <ul style="display:none">
			                        <li class="<?php if($sub_menu == lang('invoices')){echo  "active"; }?>">
			                            <a href="<?=base_url()?>subscriber_invoices">
			                                
			                                <span><?=lang('invoices')?></span>
			                            </a>
			                        </li>
			                        <li class="<?php if($sub_menu == lang('items')){echo  "active"; }?>">
			                            <a href="<?=base_url()?>subscriber_items">
			                                
			                                <span><?=lang('items')?></span>
			                            </a>
			                        </li>
		                        	<li class="<?php if($sub_menu == lang('tax_rates')){echo  "active"; }?>">
			                            <a href="<?=base_url()?>subscriber_invoices/tax_rates">
			                                
			                                <span><?=lang('tax_rates')?></span>
			                            </a>
			                        </li>
		                        
	                    		</ul>
							</li>
							<li class="<?php echo ($page == lang('price_per_employee'))?'active':'';?>"> 
								<a href="<?php echo base_url();?>price_per_employee"><i class="fa fa-usd"></i> <span><?php echo  lang('price_per_employee')?></span></a>
							</li>
						</ul>
					</div>
                </div>
            </div>
			<!-- /Sidebar -->

			<?php  echo $template['body'];?>
	
        </div>

	<script>
		var locale = '<?=lang('lang_code')?>';
		var base_url = '<?=base_url()?>';
	</script>

	<!-- jQuery -->
        <script src="<?php echo base_url();?>superadmin_assets/js/jquery-3.2.1.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="<?php echo base_url();?>superadmin_assets/js/popper.min.js"></script>
        <script src="<?php echo base_url();?>superadmin_assets/js/bootstrap.min.js"></script>

        <script src="<?php echo base_url();?>assets/js/jquery.validate.js"></script>

		<!-- <script src="<?php echo base_url();?>assets/js/datepicker/bootstrap-datepicker.js"></script> -->

       <!--  <script src="<?php echo base_url();?>assets/js/datatables/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/datatables/dataTables.bootstrap.min.js"></script> -->
		
		<!-- Slimscroll JS -->
        <script src="<?php echo base_url();?>superadmin_assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <!-- Select2 JS -->
		<script src="<?php echo base_url();?>superadmin_assets/js/select2.min.js"></script>
		<script src="<?php echo base_url();?>superadmin_assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url();?>superadmin_assets/plugins/datatables/datatables.min.js"></script>
		<!-- Custom JS -->
		<script src="<?php echo base_url();?>assets/js/app.js"></script>
		<script src="<?php echo base_url();?>assets/js/libs/toastr.min.js"></script>

		<script src="<?php echo base_url();?>assets/js/libs/typeahead.jquery.min.js"></script>
	<script src="<?=base_url()?>superadmin_assets/js/moment.min.js"></script>
		<script src="<?=base_url()?>superadmin_assets/js/bootstrap-datetimepicker.min.js"></script>
		<script  src="<?php echo base_url();?>superadmin_assets/js/script.js"></script>

		<!-- Datetimepicker JS -->
		
		
<?php if (isset($datepicker)) { ?>
<script src="<?=base_url()?>superadmin_assets/js/moment.min.js"></script>
		<script src="<?=base_url()?>superadmin_assets/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?=base_url()?>assets/js/slider/bootstrap-slider.js"></script>
<!--<script src="<?=base_url()?>assets/js/datepicker/bootstrap-datepicker.js"></script>
<!-- <script src="<?=base_url()?>assets/js/bootstrap-datetimepicker.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/locales/bootstrap-datepicker.<?=(lang('lang_code') == 'en' ? 'en-GB': lang('lang_code'))?>.min.js"></script>


<script type="text/javascript">
$('.datepicker-input').datepicker({
    todayHighlight: true,
    todayBtn: "linked",
    autoclose: true
});


$('.datepicker-schedule').datepicker({
    todayHighlight: true,
    todayBtn: "linked",
    minDate: new Date(),
    autoclose: true
 });
var todaydate = new Date();
$('.start_date-schedule').datepicker({
    todayHighlight: true,
    todayBtn: "linked",
    minDate: new Date(),
    autoclose: true
 });

 
$('.TimeSheetDate').datepicker();
    $('.datepicker-input').datepicker({
    todayHighlight: true,
    todayBtn: "linked",
    //autoclose: true
 }).on('hide', function(e) {
        console.log($(this).val());
        $(this).val($(this).val());
        if($(this).val() != '')
        {
        $(this).parent().parent().addClass('focused');
        }
        else  
        {
        $(this).parent().parent().removeClass('focused');
        }
    });
     
</script>

<?php } ?>
<?php
if (isset($datatables)) {
    $sort = strtoupper(config_item('date_picker_format'));
?>
<!-- <script src="<?=base_url()?>assets/js/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/js/datatables/dataTables.bootstrap.min.js"></script> -->






<script type="text/javascript">
        jQuery.extend( jQuery.fn.dataTableExt.oSort, {
            "currency-pre": function (a) {
                a = (a==="-") ? 0 : a.replace( /[^\d\-\.]/g, "" );
                return parseFloat( a ); },
            "currency-asc": function (a,b) {
                return a - b; },
            "currency-desc": function (a,b) {
                return b - a; }
        });
        $.fn.dataTableExt.oApi.fnResetAllFilters = function (oSettings, bDraw/*default true*/) {
                for(iCol = 0; iCol < oSettings.aoPreSearchCols.length; iCol++) {
                        oSettings.aoPreSearchCols[ iCol ].sSearch = '';
                }
                oSettings.oPreviousSearch.sSearch = '';

                if(typeof bDraw === 'undefined') bDraw = true;
                if(bDraw) this.fnDraw();
        }

        $(document).ready(function() {

        // $.fn.dataTable.moment('<?=$sort?>');
        // $.fn.dataTable.moment('<?=$sort?> HH:mm');

        var oTable1 = $('.AppendDataTables').dataTable({
        "bProcessing": true,
        "sDom": "<'row'<'col-sm-4'l><'col-sm-8'f>r>t<'row'<'col-sm-4'i><'col-sm-8'p>>",
        "sPaginationType": "full_numbers",
        "iDisplayLength": <?=config_item('rows_per_table')?>,
        "oLanguage": {
                "sProcessing": "<?=lang('processing')?>",
                "sLoadingRecords": "<?=lang('loading')?>",
                "sLengthMenu": "<?=lang('show_entries')?>",
                "sEmptyTable": "<?=lang('empty_table')?>",
                "sInfo": "<?=lang('pagination_info')?>",
                "sInfoEmpty": "<?=lang('pagination_empty')?>",
                "sInfoFiltered": "<?=lang('pagination_filtered')?>",
                "sInfoPostFix":  "",
                "sSearch": "<?=lang('search')?>:",
                "sUrl": "",
                "oPaginate": {
                        "sFirst":"<?=lang('first')?>",
                        "sPrevious": "<?=lang('previous')?>",
                        "sNext": "<?=lang('next')?>",
                        "sLast": "<?=lang('last')?>"
                }
        },
        "tableTools": {
                    "sSwfPath": "<?=base_url()?>assets/js/datatables/tableTools/swf/copy_csv_xls_pdf.swf",
              "aButtons": [
                      {
                      "sExtends": "csv",
                      "sTitle": "<?=config_item('company_name').' - '.lang('invoices')?>"
                  },
                      {
                      "sExtends": "xls",
                      "sTitle": "<?=config_item('company_name').' - '.lang('invoices')?>"
                  },
                      {
                      "sExtends": "pdf",
                      "sTitle": "<?=config_item('company_name').' - '.lang('invoices')?>"
                  },
              ],
        },
        "aaSorting": [],
        "aoColumnDefs":[{
                    "aTargets": ["no-sort"]
                  , "bSortable": false
              },{
                    "aTargets": ["col-currency"]
                  , "sType": "currency"
              }]
        });
            $("#table-tickets").dataTable().fnSort([[0,'desc']]);
            $("#table-tickets-archive").dataTable().fnSort([[1,'desc']]);


            $("#table-projects-client").dataTable().fnSort([[4,'asc']]);
            $("#table-projects-archive").dataTable().fnSort([[5,'desc']]);
            $("#table-teams").dataTable().fnSort([[0,'asc']]);
            $("#table-milestones").dataTable().fnSort([[2,'desc']]);
            $("#table-milestone").dataTable().fnSort([[2,'desc']]);
            $("#table-tasks").dataTable().fnSort([[2,'desc']]);
            $("#table-files").dataTable().fnSort([[2,'desc']]);
            $("#table-links").dataTable().fnSort([[0,'asc']]);
            $("#table-project-timelog").dataTable().fnSort([[0,'desc']]);
            $("#table-tasks-timelog").dataTable().fnSort([[0,'desc']]);

            $("#table-clients").dataTable().fnSort([[0,'asc']]);

            /* client search Hide start */

            var tableclients = $('#table-clients-compaines').DataTable();

            $('#client_search').click(function(){
                var clientname = $('#client_name').val();
                var client_email = $('#client_email').val();
                
                tableclients
                .columns( 0 )
                .search(  clientname )
                .columns( 4 )
                .search(  client_email )
                .draw();
                
            });
            $('#table-clients-compaines_filter').hide();

            var tableassets = $('#table-assets').DataTable();

            $('#asset_search').click(function(){
                var category_name = $('#category_name').val();
                
                tableassets
                .columns( 4 )
                .search(  category_name )
                .draw();
                
            });
            $('#table-clients-compaines_filter').hide();


            /* client search Hide end */
            /* Project Data table start  */

             var tableprojects = $("#table-projects").DataTable(); //dataTable().fnSort([[0,'desc']]);

               $('#project_search_btn').click(function(){

                var project_title = $('#project_title').val();
                var client_name = $('#client_name').val();

                
                tableprojects
                .columns( 1 )
                .search(  project_title )
                .columns( 2 )
                .search(  client_name )
                .draw();
                
            });
            $('#table-projects_filter').hide();
            /* Project Data table END  */
            /* User Data Table Start */

            //$("#table-users").dataTable().fnSort([[4,'desc']]);
          /*   var tableusers = $("#table-users").DataTable();

               $('#users_search_btn').click(function(){

                var username = $('#username').val();
                var company = $('#company').val();
                var user_role = $('#user_role').val();

                tableusers
                .columns( 0 )
                .search(  username )
                .columns( 2 )
                .search(  company )
                .columns( 3 )
                .search(  user_role )
                .draw();
            });
            $('#table-users_filter').hide();*/

             var tableemployee = $("#table-employee").DataTable();

               $('#employee_search_btn').click(function(){

                var employee_id = $('#employee_id').val();
                var employee_email = $('#employee_email').val();
                var username = $('#username').val();
                var company = $('#company').val();

                tableemployee
                .columns( 0 )
                .search(  username )
                .columns( 1 )
                .search(  company )
                .columns( 2 )
                .search(  employee_id )
                .columns( 3 )
                .search(  employee_email )
                .draw();
            });
            $('#table-employee_filter').hide();

            /* User Data Table End */
            
            /* Ticked  Data Table Start  */

            //$("#table-tickets").dataTable().fnSort([[0,'desc']]);
             var tabletickets = $("#table-tickets").DataTable();

               $('#ticket_search_btn').click(function(){

                var employee_name = $('#employee_name').val();
                var ticket_status = $('#ticket_status').val();
                var ticked_priority = $('#ticked_priority').val();
                var ticket_from = $('#ticket_from').val();
                var ticket_to = $('#ticket_to').val();

                tabletickets
                .columns(2 )
                .search(  employee_name )
                .columns( 6 )
                .search(  ticket_status )
                .columns( 4 )
                .search(  ticked_priority )
                .draw();
                 if(ticket_from !='' && ticket_to!=''){

                 tabletickets.draw();

                 }
            });
               <?php if($this->uri->segment(3) == 'absences_report'){
                    if($absenses_order =='asc'){?>
                        $("#table-absences_report").dataTable().fnSort([[1,'asc']]);
                    <?php } else{                    ?>
                        $("#table-absences_report").dataTable().fnSort([[1,'desc']]);
                    <?php }
                ?>
                    
               <?php } ?>
                <?php if($this->uri->segment(3) == 'late_arrival_report'){
                    if($absenses_order =='asc'){?>
                        $("#table-late_arrival_report").dataTable().fnSort([[1,'asc']]);
                    <?php } else{                    ?>
                        $("#table-late_arrival_report").dataTable().fnSort([[1,'desc']]);
                    <?php }
                ?>
                    
               <?php } ?>
                  <?php if($this->uri->segment(3) == 'work_code_report'){
                    if($workcode_order =='asc'){?>
                        $("#table-work_order_report").dataTable().fnSort([[2,'asc']]);
                    <?php } else{                    ?>
                        $("#table-work_order_report").dataTable().fnSort([[2,'desc']]);
                    <?php }
                ?>
                    
               <?php } ?>
               <?php if($this->uri->segment(1) == 'tickets'){ ?>

                $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                var min  = $('#ticket_from').val();
                var max  = $('#ticket_to').val();

                var createdAt = data[7] || 0; // Our date column in the table

                if  (
                ( min == "" || max == "" )
                ||
                ( moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max) )
                )
                {
                return true;
                }
                return false;
                }
                );
            <?php }  ?>

             $('#table-tickets_filter').hide();
            /* Ticked  Data Table End */

               /* Invoice  Data Table Start */
            // $("#table-invoices").dataTable().fnSort([[0,'desc']]);
            var tableinvoices = $("#table-invoices").DataTable();
            $('#tableinvoices_btn').click(function(){

                var invoices_status = $('#invoices_status').val();

                var ticket_from = $('#invoice_date_from').val();
                var ticket_to = $('#invoice_date_to').val();

                tableinvoices
                .columns(2 )
                .search(  invoices_status )
                .draw();
                 if(ticket_from !='' && ticket_to!=''){

                 tableinvoices.draw();

                 }
            });
               <?php if($this->uri->segment(1) == 'invoices'){ ?>
               $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                var min  = $('#invoice_date_from').val();
                var max  = $('#invoice_date_to').val();

                var createdAt = data[1] || 0; // Our date column in the table

                if  (
                ( min == "" || max == "" )
                ||
                ( moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max) )
                )
                {
                return true;
                }
                return false;
                }
                );
            <?php } ?>

             $('#table-invoices_filter').hide();
            /* Invoice  Data Table End */
            /* Expenses  Data Table Start */
            //$("#table-expenses").dataTable().fnSort([[0,'desc']]);
             var tableexpenses = $("#table-expenses").DataTable(
                {

                    "columnDefs": [
                                {
                                    orderable: false, targets: -1 //set not orderable
                                },
                                ],
                            });

              $('#search_expenses_btn').click(function(){

                var expenes_project = $('#expenes_project').val();
                var expenes_client = $('#expenes_client').val();
                var expenses_category = $('#expenses_category').val();

                var from = $('#expenses_date_from').val();
                var to = $('#expenses_date_to').val();

                tableexpenses
                .columns(1 )
                .search(  expenes_project )
                .columns( 3 )
                .search(  expenes_client )
                .columns( 5 )
                .search(  expenses_category )
                .draw();
                 if(from !='' && to!=''){

                 tableexpenses.draw();

                 }
            });

              <?php if($this->uri->segment(1) == 'expenses'){ ?>
               $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                var min  = $('#expenses_date_from').val();
                var max  = $('#expenses_date_to').val();

                var createdAt = data[6] || 0; // Our date column in the table

                if  (
                ( min == "" || max == "" )
                ||
                ( moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max) )
                )
                {
                return true;
                }
                return false;
                }
                );
            <?php } ?>

             $('#table-expenses_filter').hide();
            /* Expenses  Data Table End */

              /* estimates  Data Table Start */
            // $("#table-estimates").dataTable().fnSort([[0,'desc']]);
             var tableestimates = $("#table-estimates").DataTable();

              $('#search_estimates_btn').click(function(){

                var estimates_status = $('#estimates_status').val();
                var from = $('#estimates_from').val();
                var to = $('#estimates_to').val();

                tableestimates
                .columns( 4 )
                .search(  estimates_status )
                .draw();
                 if(from !='' && to!=''){

                 tableestimates.draw();

                 }
            });

              <?php if($this->uri->segment(1) == 'estimates'){ ?>
               $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                var min  = $('#estimates_from').val();
                var max  = $('#estimates_to').val();

                var createdAt = data[1] || 0; // Our date column in the table

                if  (
                ( min == "" || max == "" )
                ||
                ( moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max) )
                )
                {
                return true;
                }
                return false;
                }
                );
            <?php } ?>

             $('#table-estimates_filter').hide();
            /* estimates  Data Table End */

            $("#table-client-details-1").dataTable().fnSort([[1,'asc']]);
            $("#table-client-details-2").dataTable().fnSort([[2,'desc']]);
            $("#table-client-details-3").dataTable().fnSort([[0,'asc']]);
            $("#table-client-details-4").dataTable().fnSort([[1,'asc']]);
            $("#table-templates-1").dataTable().fnSort([[0,'asc']]);
            $("#table-templates-2").dataTable().fnSort([[0,'asc']]);
            $("#table-templates-3").dataTable().fnSort([[3,'asc']]);
            $("#table-attendance_reports").dataTable().fnSort([[0,'asc']]);
            $("#table-attendance_records").dataTable().fnSort([[0,'asc']]);
           



            //$("#table-payments").dataTable().fnSort([[0,'desc']]);

            // $("#table-rates").dataTable().fnSort([[0,'asc']]);
            $("#table-bugs").dataTable().fnSort([[1,'desc']]);
            $("#table-stuff").dataTable().fnSort([[0,'asc']]);
            $("#table-activities").dataTable().fnSort([[0,'desc']]);

            $("#table-strings").DataTable().page.len(-1).draw();
            if ($('#table-strings').length == 1) { $('#table-strings_length, #table-strings_paginate').remove(); $('#table-strings_filter input').css('width','200px'); }


        $('#save-translation').on('click', function (e) {
            e.preventDefault();
            // oTable1.fnResetAllFilters();
            $.ajax({
                url: base_url+'settings/translations/save/?settings=translations',
                type: 'POST',
                data: { json : JSON.stringify($('#form-strings').serializeArray()) },
                success: function() {
                    toastr.success("<?=lang('translation_updated_successfully')?>", "<?=lang('response_status')?>");
                },
                error: function(xhr) {
                    alert('Error: '+JSON.stringify(xhr));
                }
            });
        });
        $('#table-translations').on('click','.backup-translation', function (e) {
            e.preventDefault();
            var target = $(this).attr('data-href');
            $.ajax({
                url: target,
                type: 'GET',
                data: {},
                success: function() {
                    toastr.success("<?=lang('translation_backed_up_successfully')?>", "<?=lang('response_status')?>");
                },
                error: function(xhr) {
                    alert('Error: '+JSON.stringify(xhr));
                }
            });
        });
        $("#table-translations").on('click', '.restore-translation', function (e) {
            e.preventDefault();
            var target = $(this).attr('data-href');
            $.ajax({
                url: target,
                type: 'GET',
                data: {},
                success: function() {
                    toastr.success("<?=lang('translation_restored_successfully')?>", "<?=lang('response_status')?>");
                },
                error: function(xhr) {
                    alert('Error: '+JSON.stringify(xhr));
                }
            });
        });
        $('#table-translations').on('click','.submit-translation', function (e) {
            e.preventDefault();
            var target = $(this).attr('data-href');
            $.ajax({
                url: target,
                type: 'GET',
                data: {},
                success: function() {
                    toastr.success("<?=lang('translation_submitted_successfully')?>", "<?=lang('response_status')?>");
                },
                error: function(xhr) {
                    alert('Error: '+JSON.stringify(xhr));
                }
            });
        });
        $("#table-translations").on('click','.active-translation',function (e) {
            e.preventDefault();
            var target = $(this).attr('data-href');
            var isActive = 0;
            if (!$(this).hasClass('btn-success')) { isActive = 1; }
            $(this).toggleClass('btn-success').toggleClass('btn-default');
            $.ajax({
                url: target,
                type: 'POST',
                data: { active: isActive },
                success: function() {
                    toastr.success("<?=lang('translation_updated_successfully')?>", "<?=lang('response_status')?>");
                },
                error: function(xhr) {
                    alert('Error: '+JSON.stringify(xhr));
                }
            });
        });

        // $(".menu-view-toggle").on('click',function (e) {
        $(document).on('click','.menu-view-toggle',function(e){
            e.preventDefault();
            var target = $(this).attr('data-href');
            var role = $(this).attr('data-role');
            var vis = 1;
            if ($(this).hasClass('btn-success')) { vis = 0; }
            $(this).toggleClass('btn-success').toggleClass('btn-default');
            $.ajax({
                url: target,
                type: 'POST',
                data: { visible: vis, access: role },
                success: function() {},
                error: function(xhr) {}
            });
        });

        $(".cron-enabled-toggle").on('click',function (e) {
            e.preventDefault();
            var target = $(this).attr('data-href');
            var role = $(this).attr('data-role');
            var ena = 1;
            if ($(this).hasClass('btn-success')) { ena = 0; }
            $(this).toggleClass('btn-success').toggleClass('btn-default');
            $.ajax({
                url: target,
                type: 'POST',
                data: { enabled: ena, access: role },
                success: function() {},
                error: function(xhr) {}
            });
        });


        $('[data-rel=tooltip]').tooltip();
});
</script>
<?php }  ?>
		<script>
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
	<?php if (isset($editor)) { ?>
	<script src="<?=base_url()?>assets/js/wysiwyg/summernote.min.js"></script>
	<script>
	$(document).ready(function() {
	$('.foeditor').summernote({ height: 200, codemirror: { theme: 'monokai' } });
	$('.foeditor-estimate-cnote').summernote({ height: 200, codemirror: { theme: 'monokai' } });
	$('.foeditor-550').summernote({ height: 550, codemirror: { theme: 'monokai' } });
	$('.foeditor-500').summernote({ height: 500, codemirror: { theme: 'monokai' } });
	$('.foeditor-400').summernote({ height: 400, codemirror: { theme: 'monokai' } });
	$('.foeditor-300').summernote({ height: 300, codemirror: { theme: 'monokai' } });
	$('.foeditor-100').summernote({ height: 100, codemirror: { theme: 'monokai' } });
	$('.foeditor-project-discussion').summernote({ height: 100, codemirror: { theme: 'monokai' } });
	$('.foeditor-client-comment').summernote({ height: 100, codemirror: { theme: 'monokai' } });
	$('.foeditor-project-add').summernote({ height: 100, codemirror: { theme: 'monokai' } });
	$('.foeditor-project-edit').summernote({ height: 100, codemirror: { theme: 'monokai' } });
	$('.foeditor-taskview-comment').summernote({ height: 100, codemirror: { theme: 'monokai' } });
	$('.foeditor-invoice-create').summernote({ height: 100, codemirror: { theme: 'monokai' } });
	$('.foeditor-invoice-edit').summernote({ height: 100, codemirror: { theme: 'monokai' } });
	$('.foeditor-send-message').summernote({ height: 100, codemirror: { theme: 'monokai' } });
	$('.foeditor-send-conversation').summernote({ height: 100, codemirror: { theme: 'monokai' } });
	});
	</script>

	<?php } ?>
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

	<?php if($this->uri->segment(2) == ''){?>
		<script>
			var min_slider = document.getElementById("min-slider");
			var min_output = document.getElementById("min-output");
			min_output.innerHTML = min_slider.value;

			min_slider.oninput = function()
			{
				min_output.innerHTML = min_slider.value;
			}

		</script>
	<?php }?>
		<script>
			function show2(){
			  document.getElementById('div2').style.display ='flex';
			   document.getElementById('div1').style.display ='none';
			}
			function show1(){
			  document.getElementById('div1').style.display = 'flex';
			  document.getElementById('div2').style.display = 'none';
			}

		</script>
		<script type="text/javascript">
			    /*question category form*/
    $(document).on('click','#AddPlanBtn',function(){
    

        $("#AddPlanForm").validate({
            onsubmit: true,
            rules: {
                plan_name: {
                    required: true
                },
                plan_amount: {
                    required: true,
                    digits: true
                },
                plan_type: {
                    required: true
                },
                no_of_users: {
                    required: true,
                    digits: true
                },
                no_of_projects: {
                    required: true,
                    digits: true
                },
                no_of_storage: {
                    required: true,
                    digits: true
                },
                description: {
                    required: true
                }
               
            },
            messages: {
                plan_name: {
                    required: "Plan Name is Required"
                },
                plan_amount: {
                    required: "Plan amount is Required",
                    digits: "Numbers only Allowed"
                },
                plan_type: {
                    required: "Choose Plan Type"
                },
                no_of_users: {
                    required: "No of Users field is Required",
                    digits: "Numbers only Allowed"
                },
                no_of_projects: {
                    required: "No of Projects field is Required",
                    digits: "Numbers only Allowed"
                },
                no_of_storage: {
                    required: "No of Storage field is Required",
                    digits: "Numbers only Allowed"
                },
                description: {
                    required: "Description is Required"
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
            
           });
        });


    $(document).on('click','.PlansEditBtn',function(){
    	var plan_id = $(this).data('pid');

        $("#edit_plan"+plan_id).validate({
            onsubmit: true,
            rules: {
                plan_name: {
                    required: true
                },
                plan_amount: {
                    required: true,
                    digits: true
                },
                plan_type: {
                    required: true
                },
                no_of_users: {
                    required: true,
                    digits: true
                },
                no_of_projects: {
                    required: true,
                    digits: true
                },
                no_of_storage: {
                    required: true,
                    digits: true
                },
                description: {
                    required: true
                }
               
            },
            messages: {
                plan_name: {
                    required: "Plan Name is Required"
                },
                plan_amount: {
                    required: "Plan amount is Required",
                    digits: "Numbers only Allowed"
                },
                plan_type: {
                    required: "Choose Plan Type"
                },
                no_of_users: {
                    required: "No of Users field is Required",
                    digits: "Numbers only Allowed"
                },
                no_of_projects: {
                    required: "No of Projects field is Required",
                    digits: "Numbers only Allowed"
                },
                no_of_storage: {
                    required: "No of Storage field is Required",
                    digits: "Numbers only Allowed"
                },
                description: {
                    required: "Description is Required"
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
            
           });
        });

    	 /* Invoice Submodule  */

         $(document).on('click','#tableinvoices_btn',function(){
            var from = $('#invoice_date_from').val();
            var to = $('#invoice_date_to').val();
            var status =  $('#invoices_status option:selected').val();
           
            if(from == '' && to == '' && status == ''){
                $('#invoice_date_from').focus();
                $('#invoice_date_from').css('border-color','#77A7DB');
                $('#invoice_date_to').css('border-color','#77A7DB');
                $('#invoice_date_from_error').removeClass('display-none').addClass('display-block');
                $('#invoice_date_to_error').removeClass('display-none').addClass('display-block');
                $('#invoices_status_error').removeClass('display-none').addClass('display-block');
                console.log("invalid")
                return false;
            }
            else{
                $('#invoice_date_from').css('border-color','#ccc');
                $('#invoice_date_to').css('border-color','#ccc');
                $('#invoice_date_from_error').removeClass('display-block').addClass('display-none');
                $('#invoice_date_to_error').removeClass('display-block').addClass('display-none');
                $('#invoices_status_error').removeClass('display-block').addClass('display-none');
                console.log("valid")
            }
        });

        $(document).on('click','#invoice_email_template',function(){

            $("#invoiceEmailForm").validate({
                ignore: [],
                rules: {
                    subject: {
                        required: true
                    }
                },
                messages: {
                    subject: {
                        required: 'Subject is required'
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
                
            });

          
        });

        $(document).on('click','#inview_add_item',function(){

            $("#invoiceAddItem").validate({
                ignore: [],
                rules: {
                    item: {
                        required: true
                    }
                },
                messages: {
                    item: {
                        required: 'Item is required'
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
                
            });

          
        });

        $(document).on('click','#invoice_reminder_template',function(){

            $("#invoiceReminderForm").validate({
                ignore: [],
                rules: {
                    subject: {
                        required: true
                    }
                },
                messages: {
                    subject: {
                        required: 'Subject is required'
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
                
            });

          
        });


        $(document).on('click','#invoice_create_submit',function(){

            function isTax1Present() {
                console.log($('#invoice_create_tax1').val());
                var tax1 = $('#invoice_create_tax1').val();
                if(tax1 != '')
                {
                    if(/^(\d*\.)?\d+$/.test(tax1) && (tax1 === "" || parseInt(tax1) <= 100 || tax1 == 0))
                    {
                        $('#create_invoice_tax1_error').removeClass('display-block').addClass('display-none');
                        return true;
                    }
                    else
                    {
                        $('#create_invoice_tax1_error').removeClass('display-none').addClass('display-block');
                        $('#invoice_create_tax1').focus();
                    }
                }
                else{
                    $('#create_invoice_tax1_error').removeClass('display-block').addClass('display-none');
                    return true;
                }
            }

            function isTax2Present() {
                var tax2 = $('#invoice_create_tax2').val();
                if(tax2 != '')
                {
                    if(/^(\d*\.)?\d+$/.test(tax2) && (tax2 === "" || parseInt(tax2) <= 100 || tax2 == 0))
                    {
                        $('#create_invoice_tax2_error').removeClass('display-block').addClass('display-none');
                        return true;
                    }
                    else
                    {
                        $('#create_invoice_tax2_error').removeClass('display-none').addClass('display-block');
                        $('#invoice_create_tax2').focus();
                    }
                }
                else{
                    $('#create_invoice_tax2_error').removeClass('display-block').addClass('display-none');
                    return true;
                }
            }

            if(isTax1Present() == true && isTax2Present() == true && isDiscountPresent() == true && isExtrafeePresent() == true){
                
               
               
            }
            else{
                return false;
            }

            function isDiscountPresent() {
                console.log($('#invoice_create_discount').val());
                var discount = $('#invoice_create_discount').val();
                if(discount != '')
                {
                    if(/^(\d*\.)?\d+$/.test(discount) && (discount === "" || parseInt(discount) <= 100 || discount == 0))
                    {
                        $('#create_invoice_discount_error').removeClass('display-block').addClass('display-none');
                        return true;
                    }
                    else
                    {
                        $('#create_invoice_discount_error').removeClass('display-none').addClass('display-block');
                        $('#invoice_create_discount').focus();
                    }
                }
                else{
                    $('#create_invoice_discount_error').removeClass('display-block').addClass('display-none');
                    return true;
                }
            }

            function isExtrafeePresent() {
                console.log($('#invoice_create_extrafee').val());
                var fee = $('#invoice_create_extrafee').val();
                if(fee != '')
                {
                    if(/^(\d*\.)?\d+$/.test(fee))
                    {
                        $('#create_invoice_fee_error').removeClass('display-block').addClass('display-none');
                        return true;
                    }
                    else
                    {
                        $('#create_invoice_fee_error').removeClass('display-none').addClass('display-block');
                        $('#invoice_create_extrafee').focus();
                    }
                }
                else{
                    $('#create_invoice_fee_error').removeClass('display-block').addClass('display-none');
                    return true;
                }
            }
            
            var textareaValue = $('.foeditor-invoice-create').summernote('code');
            console.log(textareaValue)
            if(textareaValue == '<p><br></p>' || textareaValue == '')
            {
            $('#create_invoice_error').removeClass('display-none').addClass('display-block');
            $('.note-editable').trigger('focus');
            return false;
            }
            else
            {
            $('#create_invoice_error').removeClass('display-block').addClass('display-none');
            console.log('comes');
            $("#createInvoiceForm").validate({
                ignore: [],
                rules: {
                    client: {
                        required: true
                    },
                    due_date: {
                        required: true
                    }
                },
                messages: {
                    client: {
                        required: 'Please select a client'
                    },
                    due_date: {
                        required: 'Deadline must not empty'
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
                
               });

            }
        });

        $(document).on('click','#invoice_edit_submit',function(){

            function isTax1Present() {
                console.log($('#invoice_edit_tax1').val());
                var tax1 = $('#invoice_edit_tax1').val();
                if(tax1 != '')
                {
                    if(/^(\d*\.)?\d+$/.test(tax1) && (tax1 === "" || parseInt(tax1) <= 100 || tax1 == 0))
                    {
                        $('#edit_invoice_tax1_error').removeClass('display-block').addClass('display-none');
                        return true;
                    }
                    else
                    {
                        $('#edit_invoice_tax1_error').removeClass('display-none').addClass('display-block');
                        $('#invoice_create_tax1').focus();
                    }
                }
                else{
                    $('#edit_invoice_tax1_error').removeClass('display-block').addClass('display-none');
                    return true;
                }
            }

            function isTax2Present() {
                var tax2 = $('#invoice_edit_tax2').val();
                if(tax2 != '')
                {
                    if(/^(\d*\.)?\d+$/.test(tax2) && (tax2 === "" || parseInt(tax2) <= 100 || tax2 == 0))
                    {
                        $('#edit_invoice_tax2_error').removeClass('display-block').addClass('display-none');
                        return true;
                    }
                    else
                    {
                        $('#edit_invoice_tax2_error').removeClass('display-none').addClass('display-block');
                        $('#invoice_create_tax2').focus();
                    }
                }
                else{
                    $('#edit_invoice_tax2_error').removeClass('display-block').addClass('display-none');
                    return true;
                }
            }

            if(isTax1Present() == true && isTax2Present() == true && isDiscountPresent() == true && isExtrafeePresent() == true){
                
               
               
            }
            else{
                return false;
            }

            function isDiscountPresent() {
                console.log($('#invoice_edit_discount').val());
                var discount = $('#invoice_edit_discount').val();
                if(discount != '')
                {
                    if(/^(\d*\.)?\d+$/.test(discount) && (discount === "" || parseInt(discount) <= 100 || discount == 0))
                    {
                        $('#edit_invoice_discount_error').removeClass('display-block').addClass('display-none');
                        return true;
                    }
                    else
                    {
                        $('#edit_invoice_discount_error').removeClass('display-none').addClass('display-block');
                        $('#invoice_edit_discount').focus();
                    }
                }
                else{
                    $('#edit_invoice_discount_error').removeClass('display-block').addClass('display-none');
                    return true;
                }
            }

            function isExtrafeePresent() {
                console.log($('#invoice_edit_extrafee').val());
                var fee = $('#invoice_edit_extrafee').val();
                if(fee != '')
                {
                    if(/^(\d*\.)?\d+$/.test(fee))
                    {
                        $('#edit_invoice_fee_error').removeClass('display-block').addClass('display-none');
                        return true;
                    }
                    else
                    {
                        $('#edit_invoice_fee_error').removeClass('display-none').addClass('display-block');
                        $('#invoice_create_extrafee').focus();
                    }
                }
                else{
                    $('#edit_invoice_fee_error').removeClass('display-block').addClass('display-none');
                    return true;
                }
            }
            
            var textareaValue = $('.foeditor-invoice-edit').summernote('code');
            console.log(textareaValue)
            if(textareaValue == '<p><br></p>' || textareaValue == '')
            {
            $('#edit_invoice_error').removeClass('display-none').addClass('display-block');
            $('.note-editable').trigger('focus');
            return false;
            }
            else
            {
            $('#edit_invoice_error').removeClass('display-block').addClass('display-none');
            console.log('comes');
            $("#editInvoiceForm").validate({
                ignore: [],
                rules: {
                    client: {
                        required: true
                    },
                    due_date: {
                        required: true
                    },
                    due_date: {
                        required: true
                    }
                },
                messages: {
                    client: {
                        required: 'Please select a client'
                    },
                    due_date: {
                        required: 'Deadline must not empty'
                    },
                    due_date: {
                        required: 'Deadline must not empty'
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
                
               });

            }
        });
 $(document).on('click','.add_price_per_employee',function(){

        $("#add_price_per_employees").validate({
            onsubmit: true,
            rules: {
                plan1: {
                    required: true
                },
                plan2: {
                    required: true
                },
                plan3: {
                    required: true
                },
                employee_count: {
                    required: true
                }
               
            },
            messages: {
                plan1: {
                    required: "Plan1 Value is Required"
                },
                plan2: {
                    required: "Plan2 Value is Required"
                },
                plan3: {
                    required: "Plan3 Value is Required"
                },
                employee_count: {
                    required: "Employee count is Required",
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
            
           });
        });
	 $(document).on('click','.edit_price_per_employee',function(){
    	var id = $(this).data('id');

        $("#edit_price_per_employee"+id).validate({
            onsubmit: true,
            rules: {
                plan1: {
                    required: true
                },
                plan2: {
                    required: true
                },
                plan3: {
                    required: true
                },
                emplyee_count: {
                    required: true
                }
               
            },
            messages: {
                plan1: {
                    required: "Plan1 Value is Required"
                },
                plan2: {
                    required: "Plan2 Value is Required"
                },
                plan3: {
                    required: "Plan3 Value is Required"
                },
                emplyee_count: {
                    required: "Employee count is Required",
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
            
           });
        });
		</script>

		<?php
if($this->session->flashdata('message')){
$message = $this->session->flashdata('message');
$alert = $this->session->flashdata('response_status'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        swal({
            title: "<?=lang($alert)?>",
            text: "<?=$message?>",
            type: "<?=$alert?>",
            timer: 5000,
            confirmButtonColor: "#38354a"
        });
});
</script>
<?php } ?>

<?php if (isset($typeahead)) { ?>
<script type="text/javascript">
    $(document).ready(function(){

        var scope = $('#auto-item-name').attr('data-scope');
        if (scope == 'invoices' || scope == 'estimates') {

        var substringMatcher = function(strs) {
          return function findMatches(q, cb) {
            var substrRegex;
            var matches = [];
            substrRegex = new RegExp(q, 'i');
            $.each(strs, function(i, str) {
              if (substrRegex.test(str)) {
                matches.push(str);
              }
            });
            cb(matches);
          };
        };

        $('#auto-item-name').on('keyup',function(){ $('#hidden-item-name').val($(this).val()); });

        $.ajax({
            url: base_url + scope + '/autoitems/',
            type: "POST",
            data: {},
            success: function(response){
                $('.typeahead').typeahead({
                    hint: true,
                    highlight: true,
                    minLength: 2
                    },
                    {
                    name: "item_name",
                    limit: 10,
                    source: substringMatcher(response)
                });
                $('.typeahead').bind('typeahead:select', function(ev, suggestion) {
                    $.ajax({
                        url: base_url + scope + '/autoitem/',
                        type: "POST",
                        data: {name: suggestion},
                        success: function(response){
                            $('#hidden-item-name').val(response.item_name);
                            $('#auto-item-desc').val(response.item_desc).trigger('keyup');
                            $('#auto-quantity').val(response.quantity);
                            $('#auto-unit-cost').val(response.unit_cost);
                        }
                    });
                });
            }
        });
    }


    });
</script>
<?php } ?>
<script type="text/javascript">
	// $(".close,btn-danger").click(function(){
	// 	alert();
	// 	$("#ajaxModal").css("display","none");
	// });
 function menu_function(id,status) {
 	// alert(id);
 	// alert(status);
 		status =  $('#add_menu_name_'+id).val();
 	    $.post('<?=base_url()?>superadmin/plan_menu_status',{id:id,status:status},function(data){
        if(data == 1){
            
            $('#add_menu_name_'+id).val(0);
            $('#add_menu_name_'+id).prop("checked",false);
            toastr.success("<?=lang('status_updated_successfully')?>");  
        }else{
        	$('#add_menu_name_'+id).val(1);
            $('#add_menu_name_'+id).prop("checked",true);
            toastr.success("<?=lang('status_updated_successfully')?>");  
        }
    });
 }
</script><div class="sidebar-overlay"></div>

    </body>
</html>