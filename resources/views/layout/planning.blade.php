
<!DOCTYPE html>
<!--
Template Name: Metronic - Bootstrap 4 HTML, React, Angular 9 & VueJS Admin Dashboard Theme
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: https://1.envato.market/EA4JP
Renew Support: https://1.envato.market/EA4JP
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="fr" >
    <!--begin::Head-->
    <head>
                <meta charset="utf-8"/>
        <title>G-Planning</title>
        <meta name="description" content="Invoice example"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

        <!--begin::Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>        <!--end::Fonts-->



        <!--begin::Global Theme Styles(used by all pages)-->
					<link href="assets/plugins/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css"/>
                    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
                    <link href="assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css"/>
                    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css"/>


                <!--end::Global Theme Styles-->


        <!--begin::Layout Themes(used by all pages)-->
                <!--end::Layout Themes-->

            </head>
    <!--end::Head-->

    <!--begin::Body-->
    <body  id="kt_body"  class="print-content-only quick-panel-right demo-panel-right offcanvas-right header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-static page-loading"  >

    	<!--begin::Main-->
	<!--begin::Header Mobile-->
<div id="kt_header_mobile" class="header-mobile  header-mobile-fixed " >
	<!--begin::Logo-->
	<a href="index.html">
		<img alt="Logo" src="assets/media/logos/logo.jpeg" class="logo-default max-h-30px"/>
	</a>
	<!--end::Logo-->

	<!--begin::Toolbar-->
	<div class="d-flex align-items-center">
					<button class="btn p-0 burger-icon rounded-0 burger-icon-left" id="kt_aside_tablet_and_mobile_toggle">
				<span></span>
			</button>

		<button class="btn btn-hover-text-primary p-0 ml-3" id="kt_header_mobile_topbar_toggle">
			<span class="svg-icon svg-icon-xl"><!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"/>
        <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
        <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
    </g>
</svg><!--end::Svg Icon--></span>		</button>
	</div>
	<!--end::Toolbar-->
</div>
<!--end::Header Mobile-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Page-->
		<div class="d-flex flex-row flex-column-fluid page">
							<!--begin::Aside-->
<div class="aside aside-left  d-flex flex-column flex-row-auto" id="kt_aside">


    <!-- MENU  -->
    @include("include/menu")


</div>
<!--end::Aside-->

<!--begin::Wrapper-->
<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
				<!--begin::Header-->
<div id="kt_header" class="header  header-fixed " >
	<!--begin::Container-->
	<div class=" container  d-flex align-items-stretch justify-content-between">
		<!--begin::Left-->
		<div class="d-none d-lg-flex align-items-center mr-3">
			<!--begin::Aside Toggle-->
			<button class="btn btn-icon aside-toggle ml-n3 mr-10" id="kt_aside_desktop_toggle">
				<span class="svg-icon svg-icon-xxl svg-icon-dark-75"><!--begin::Svg Icon | path:assets/media/svg/icons/Text/Align-left.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <rect fill="#000000" opacity="0.3" x="4" y="5" width="16" height="2" rx="1"/>
        <rect fill="#000000" opacity="0.3" x="4" y="13" width="16" height="2" rx="1"/>
        <path d="M5,9 L13,9 C13.5522847,9 14,9.44771525 14,10 C14,10.5522847 13.5522847,11 13,11 L5,11 C4.44771525,11 4,10.5522847 4,10 C4,9.44771525 4.44771525,9 5,9 Z M5,17 L13,17 C13.5522847,17 14,17.4477153 14,18 C14,18.5522847 13.5522847,19 13,19 L5,19 C4.44771525,19 4,18.5522847 4,18 C4,17.4477153 4.44771525,17 5,17 Z" fill="#000000"/>
    </g>
</svg><!--end::Svg Icon--></span>			</button>
			<!--end::Aside Toggle-->

			<!--begin::Logo-->
			<a href="">
				<img alt="Logo" src="assets/media/logos/logo.jpeg" class="logo-sticky max-h-35px"/>
				<span style="color:#eab91e; font-weight: bolder;">G-Planning</span>
			</a>
			<!--end::Logo-->

			<!--begin::Desktop Search-->
			<div class="quick-search quick-search-inline ml-20 w-300px" id="kt_quick_search_inline">
				<!--begin::Form-->

				<!--end::Form-->

				<!--begin::Search Toggle-->
				<div id="kt_quick_search_toggle" data-toggle="dropdown" data-offset="0px,1px"></div>
				<!--end::Search Toggle-->

				<!--begin::Dropdown-->
				<div class="dropdown-menu dropdown-menu-left dropdown-menu-lg dropdown-menu-anim-up">
			        <div class="quick-search-wrapper scroll" data-scroll="true" data-height="350" data-mobile-height="200">
			        </div>
				</div>
				<!--end::Dropdown-->
			</div>
			<!--end::Desktop Search-->
		</div>
		<!--end::Left-->

		<!--begin::Topbar-->
		<div class="topbar">
		    <!--begin::Tablet & Mobile Search-->
		    <div class="dropdown d-flex d-lg-none">
                <!--begin::Toggle-->
                <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
        			<div class="btn btn-icon btn-clean btn-lg btn-dropdown mr-1">
        				<span class="svg-icon svg-icon-xl"><!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
        <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"/>
    </g>
</svg><!--end::Svg Icon--></span>        			</div>
                </div>
                <!--end::Toggle-->

                <!--begin::Dropdown-->
    			<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
    				<div class="quick-search quick-search-dropdown" id="kt_quick_search_dropdown">
    <!--begin:Form-->

    <!--end::Form-->

    <!--begin::Scroll-->
    <div class="quick-search-wrapper scroll" data-scroll="true" data-height="325" data-mobile-height="200">
    </div>
    <!--end::Scroll-->
</div>
    			</div>
                <!--end::Dropdown-->
    		</div>
            <!--end::Tablet & Mobile Search-->

			<!--end::Create-->

				<!--begin::Quick Panel-->

				<!--end::Quick Actions-->

			<!--begin::Quick Actions-->

			<!--end::Quick panel-->

			<!--begin::User-->
			<div class="topbar-item mr-4">
				<div class="btn btn-icon btn-sm btn-clean btn-text-dark-75" id="kt_quick_user_toggle">
					<span class="svg-icon svg-icon-lg"><!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"/>
        <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
        <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
    </g>
</svg><!--end::Svg Icon--></span>				</div>
			</div>

		</div>
		<!--end::Topbar-->
	</div>
	<!--end::Container-->
</div>
<!--end::Header-->

				<!--begin::Content-->
				<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
											<!--begin::Subheader-->
<div class=" " id="kt_subheader">

</div>
<!--end::Subheader-->

					<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
			<!--begin::Container-->
		<div class=" container ">

			@section("main")

			@show


		</div>
<!--end::Footer-->
	</div>
			<!--end::Wrapper-->
		</div>
		<!--end::Page-->
	</div>
<!--end::Main-->



                    		<!-- begin::Notifications Panel-->
<div id="kt_quick_notifications" class="offcanvas offcanvas-right p-10">
	<!--begin::Header-->
	<h6>gg</h6>
</div>
<!-- end::Notifications Panel-->

                    		<!--begin::Quick Actions Panel-->
<div id="kt_quick_actions" class="offcanvas offcanvas-right p-10">
	<h6>yy</h6>
	<!--end::Content-->
</div>
<!--end::Quick Actions Panel-->

                    		<!-- begin::User Panel-->
<div id="kt_quick_user" class="offcanvas offcanvas-right p-10">

	<!--begin::Content-->
    <div class="offcanvas-content pr-5 mr-n5">
		<!--begin::Header-->
        <div class="d-flex align-items-center mt-5">
            <div class="symbol symbol-100 mr-5">
                <div class="symbol-label" style="background-image:url('assets/media/users/300_21.jpg')"></div>
				<i class="symbol-badge bg-success"></i>
            </div>
            <div class="d-flex flex-column">
                <a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">
					GNENO Nicolas
				</a>
                <div class="text-muted mt-1">
                    Administrateur
                </div>
                <div class="navi mt-2">
                    <a href="#" class="navi-item">
                        <span class="navi-link p-0 pb-2">
                            <span class="navi-icon mr-1">
								<span class="svg-icon svg-icon-lg svg-icon-primary"><!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-notification.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000"/>
        <circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5"/>
    </g>
</svg><!--end::Svg Icon--></span>							</span>
                            <span class="navi-text text-muted text-hover-primary">gneno@gmail.com</span>
                        </span>
                    </a>

					<a href="#" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">Se Déconnecter</a>
                </div>
            </div>
        </div>

    </div>
	<!--end::Content-->
</div>
<!-- end::User Panel-->


<!--begin::Quick Panel-->

<!--end::Quick Panel-->


        <!--end::Global Config-->

    	<!--begin::Global Theme Bundle(used by all pages)-->
				   <script src="assets/plugins/fullcalendar/fullcalendar.bundle.js"></script>
    	    	   <script src="assets/plugins/global/plugins.bundle.js"></script>
		    	   <script src="assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
		    	   <script src="assets/js/scripts.bundle.js"></script>
                   <script src="assets/js/pages/features/charts/apexcharts.js"></script>
				   <script src="assets/js/main.js"></script>
				   <script src="assets/js/notify.js"></script>





	    <!--end::Global Theme Bundle-->


            </body>
    <!--end::Body-->
</html>
