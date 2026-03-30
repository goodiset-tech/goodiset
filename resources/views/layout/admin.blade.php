<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Dashboard analytics - Vuexy - Bootstrap HTML admin template</title>
    <link rel="apple-touch-icon" href="{{asset('')}}assets/admin/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('')}}assets/admin/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('')}}assets/admin/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}assets/admin/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}assets/admin/vendors/css/extensions/tether-theme-arrows.css">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}assets/admin/vendors/css/extensions/tether.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}assets/admin/vendors/css/extensions/shepherd-theme-default.css">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}assets/admin/vendors/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}assets/admin/vendors/css/file-uploaders/dropzone.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}assets/admin/vendors/css/tables/datatable/extensions/dataTables.checkboxes.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('')}}assets/admin/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}assets/admin/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}assets/admin/css/colors.css">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}assets/admin/css/components.css">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}assets/admin/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}assets/admin/css/themes/semi-dark-layout.css"> 

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('')}}assets/admin/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}assets/admin/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}assets/admin/css/pages/dashboard-analytics.css">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}assets/admin/css/pages/card-analytics.css">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}assets/admin/css/plugins/tour/tour.css">

    <link rel="stylesheet" type="text/css" href="{{asset('')}}assets/admin/css/plugins/file-uploaders/dropzone.css">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}assets/admin/css/pages/data-list-view.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static   menu-collapsed" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">


    <!--{{ view('admin.header') }}-->
    <!--{{ view('admin.side-bar') }}-->
    @yield('content')            </div>
        </div>
    </div>

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    {{ view('admin.footer') }}


    <!-- BEGIN: Vendor JS-->
    <script src="{{asset('')}}assets/admin/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('')}}assets/admin/vendors/js/charts/apexcharts.min.js"></script>
    <script src="{{asset('')}}assets/admin/vendors/js/extensions/tether.min.js"></script>
    <script src="{{asset('')}}assets/admin/vendors/js/extensions/shepherd.min.js"></script>

    <script src="{{asset('')}}assets/admin/vendors/js/extensions/dropzone.min.js"></script>
    <script src="{{asset('')}}assets/admin/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="{{asset('')}}assets/admin/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="{{asset('')}}assets/admin/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
    <script src="{{asset('')}}assets/admin/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script>
    <script src="{{asset('')}}assets/admin/vendors/js/tables/datatable/dataTables.select.min.js"></script>
    <script src="{{asset('')}}assets/admin/vendors/js/tables/datatable/datatables.checkboxes.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{asset('')}}assets/admin/js/core/app-menu.js"></script>
    <script src="{{asset('')}}assets/admin/js/core/app.js"></script>
    <script src="{{asset('')}}assets/admin/js/scripts/components.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{asset('')}}assets/admin/js/scripts/pages/dashboard-analytics.js"></script>
    <script src="{{asset('')}}assets/admin/js/scripts/ui/data-list-view.js"></script>
    <!-- END: Page JS-->
    @yield('scripts')
    <script type="text/javascript">
    
        $('#uploadbtn').click(function () {
            $('#fileupload').click();
        });

        $('#datacatagory').on('change',function(e) {
        var cat_id = e.target.value;
        $.ajax({
            url:'{{ route("subcat") }}',
            type:"POST",
            data: {
            cat_id: cat_id,
            "_token": "{{ csrf_token() }}",
            },
            success:function (data) {
                $('#subcategory').empty();
                $("#subcategory").html(data);
            }
        });

        });

        $('#subcategory').on('change',function(e) {
        var cat_id = e.target.value;
        $.ajax({
            url:'{{ route("childcat") }}',
            type:"POST",
            data: {
            cat_id: cat_id,
            "_token": "{{ csrf_token() }}",
            },
            success:function (data) {
                $('#childcategory').empty();
                $("#childcategory").html(data);
            }
        });

        });


        
    </script>

</body>
<!-- END: Body-->

</html>