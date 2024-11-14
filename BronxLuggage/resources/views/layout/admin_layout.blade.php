<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>

<head>
    <title>Visitors an Admin Panel Category Bootstrap Responsive Website Template | Home :: w3layouts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- bootstrap-css -->
    <link rel="stylesheet" href="{{asset('admin')}}/css/bootstrap.min.css">
    <!-- //bootstrap-css -->
    <!-- Custom CSS -->
    <link href="{{asset('admin')}}/css/style.css" rel='stylesheet' type='text/css' />
    <link href="{{asset('admin')}}/css/style-responsive.css" rel="stylesheet" />
    <!-- font CSS -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <!-- font-awesome icons -->
    <link rel="stylesheet" href="{{asset('admin')}}/css/font.css" type="text/css" />
    <link href="{{asset('admin')}}/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('admin')}}/css/morris.css" type="text/css" />
    <!-- calendar -->
    <link rel="stylesheet" href="{{asset('admin')}}/css/monthly.css">
    <!-- //calendar -->
    <!-- //font-awesome icons -->
    <script src="{{asset('admin')}}/js/jquery2.0.3.min.js"></script>
    <script src="{{asset('admin')}}/js/raphael-min.js"></script>
    <script src="{{asset('admin')}}/js/morris.js"></script>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <script type="text/javascript">
        $(document).ready(function() {
            if ($('.productId').length > 0) {
                load_gallery();

                function load_gallery() {
                    var productId = $('.productId').val();
                    var _token = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: "{{ url('/select-gallery') }}",
                        method: "POST",
                        data: {
                            productId: productId,
                            _token: _token
                        },
                        success: function(data) {
                            $('#gallery_load').html(data);
                        }
                    });
                }
            }
        });
        //photo
        $(document).ready(function() {
            $('#file').change(function() {
                var error = '';
                var files = $('#file')[0].files;

                if (files.length > 6) {
                    error += '<p>Select up to 6 photos</p>';
                } else if (files.length == 0) {
                    error += '<p>Please select at least one photo</p>';
                } else {
                    for (var i = 0; i < files.length; i++) {
                        if (files[i].size > 2000000) {
                            error += '<p>File size of "' + files[i].name + '" is too large</p>';
                        }
                    }
                }

                if (error == '') {
                    $('#error_gallery').html('');
                } else {
                    $('#file').val('');
                    $('#error_gallery').html('<span class="text-danger">' + error + '</span>');
                }
            });

            //update
            $(document).on('blur', '.edit_gal_name', function() {
                var gal_id = $(this).data('gal_id');
                var gal_text = $(this).text();
                var _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: "{{ url('/update-gallery-name') }}",
                    method: "POST",
                    data: {
                        gal_id: gal_id,
                        gal_text: gal_text,
                        _token: _token
                    },
                    success: function(data) {
                        if (data.success) {
                            $('#error_gallery').html('<span class="text-success">' + data.message + '</span>');
                        } else {
                            $('#error_gallery').html('<span class="text-danger">' + data.message + '</span>');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#error_gallery').html('<span class="text-danger">An error occurred: ' + error + '</span>');
                    }
                });
            });
            // delete
            $(document).on('click', '.delete-gallery', function() {
                var gal_id = $(this).data('gal_id');
                var _token = $('meta[name="csrf-token"]').attr('content');
                if (confirm('Are you sure you want to delete this photo??')) {
                    $.ajax({
                        url: "{{ url('/delete-gallery') }}",
                        method: "POST",
                        data: {
                            gal_id: gal_id,
                            _token: _token
                        },
                        success: function(data) {
                            if (data.success) {
                                $('#error_gallery').html('<span class="text-success">' + data.message + '</span>');
                                load_gallery();
                            } else {
                                $('#error_gallery').html('<span class="text-danger">' + data.message + '</span>');
                            }
                        },
                        error: function(xhr, status, error) {
                            $('#error_gallery').html('<span class="text-danger">An error occurred: ' + error + '</span>');
                        }
                    });
                }
            });
            //hien thi anh
            $(document).on('change', '.file_image', function() {
                var gal_id = $(this).data('gal_id');
                var image = document.getElementById('file-' + gal_id).files[0];
                var form_data = new FormData();
                form_data.append("file", image);
                form_data.append("gal_id", gal_id);

                $.ajax({
                    url: "{{ url('/update-gallery') }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        if (data.success) {
                            $('#error_gallery').html('<span class="text-success">' + data.message + '</span>');
                            load_gallery();
                        } else {
                            $('#error_gallery').html('<span class="text-danger">' + data.message + '</span>');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#error_gallery').html('<span class="text-danger">An error occurred: ' + error + '</span>');
                    }
                });
            });
        });
    </script>
</head>

<body>
    <section id="container">
        <!--header start-->
        <header class="header fixed-top clearfix">
            <!--logo start-->
            <div class="brand">
                <a href="index.html" class="logo">
                    VISITORS
                </a>
                <div class="sidebar-toggle-box">
                    <div class="fa fa-bars"></div>
                </div>
            </div>
            <!--logo end-->

            <div class="top-nav clearfix">
                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                    <li>
                        <input type="text" class="form-control search" placeholder=" Search">
                    </li>
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <img alt="" src="{{asset('admin')}}/images/2.png">
                            <span class="username">
                                <?php
                                $name = session()->get('name');
                                if ($name) {
                                    echo $name;
                                }
                                ?>
                            </span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                            <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                            <li><a href="{{url('admin/logout')}}"><i class="fa fa-key"></i> Log Out</a></li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->

                </ul>
                <!--search & user info end-->
            </div>
        </header>
        <!--header end-->
        <!--sidebar start-->
        <aside>
            <div id="sidebar" class="nav-collapse">
                <!-- sidebar menu start-->
                <div class="leftside-navigation">
                    <ul class="sidebar-menu" id="nav-accordion">
                        <li>
                            <a class="active" href="{{url('/dashboard')}}">
                                <i class="fa fa-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Order</span>
                            </a>
                            <ul class="sub">
                                <li><a href="{{url('manage-order')}}">Manage Order</a></li>
                            </ul>
                        </li>

                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-list"></i>
                                <span>Category</span>
                            </a>
                            <ul class="sub">
                                <li><a href="{{url('add-category')}}">Add Category</a></li>
                                <li><a href="{{url('all-category')}}">List Category</a></li>
                            </ul>
                        </li>

                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-tag"></i>
                                <span>Brand</span>
                            </a>
                            <ul class="sub">
                                <li><a href="{{url('add-brand')}}">Add Brand</a></li>
                                <li><a href="{{url('all-brand')}}">List Brand</a></li>
                            </ul>
                        </li>

                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-cube"></i>
                                <span>Product</span>
                            </a>
                            <ul class="sub">
                                <li><a href="{{url('add-product')}}">Add Product</a></li>
                                <li><a href="{{url('all-product')}}">List Product</a></li>
                            </ul>
                        </li>

                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-inbox"></i>
                                <span>Inbox</span>
                            </a>
                            <ul class="sub">
                                <li><a href="{{url('all-contact')}}">List Inbox</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-comment"></i>
                                <span>Comments</span>
                            </a>
                            <ul class="sub">
                                <li><a href="{{url('comment')}}">List Comment</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-user"></i>
                                <span>Customer</span>
                            </a>
                            <ul class="sub">
                                <li><a href="{{url('manage-customer')}}">Manage Customer</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                @yield('admin_content')
            </section>



            <!-- footer -->
           
            <!-- / footer -->
        </section>
        <!--main content end-->
    </section>
    <script src="{{asset('admin')}}/js/bootstrap.js"></script>
    <script src="{{asset('admin')}}/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="{{asset('admin')}}/js/scripts.js"></script>
    <script src="{{asset('admin')}}/js/jquery.slimscroll.js"></script>
    <script src="{{asset('admin')}}/js/jquery.nicescroll.js"></script>
    <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
    <script src="js/jquery.scrollTo.js"></script>
    <!-- morris JavaScript -->
    <script>
        $(document).ready(function() {
            //BOX BUTTON SHOW AND CLOSE
            jQuery('.small-graph-box').hover(function() {
                jQuery(this).find('.box-button').fadeIn('fast');
            }, function() {
                jQuery(this).find('.box-button').fadeOut('fast');
            });
            jQuery('.small-graph-box .box-close').click(function() {
                jQuery(this).closest('.small-graph-box').fadeOut(200);
                return false;
            });

            //CHARTS
            function gd(year, day, month) {
                return new Date(year, month - 1, day).getTime();
            }

            graphArea2 = Morris.Area({
                element: 'hero-area',
                padding: 10,
                behaveLikeLine: true,
                gridEnabled: false,
                gridLineColor: '#dddddd',
                axes: true,
                resize: true,
                smooth: true,
                pointSize: 0,
                lineWidth: 0,
                fillOpacity: 0.85,
                data: [{
                        period: '2015 Q1',
                        iphone: 2668,
                        ipad: null,
                        itouch: 2649
                    },
                    {
                        period: '2015 Q2',
                        iphone: 15780,
                        ipad: 13799,
                        itouch: 12051
                    },
                    {
                        period: '2015 Q3',
                        iphone: 12920,
                        ipad: 10975,
                        itouch: 9910
                    },
                    {
                        period: '2015 Q4',
                        iphone: 8770,
                        ipad: 6600,
                        itouch: 6695
                    },
                    {
                        period: '2016 Q1',
                        iphone: 10820,
                        ipad: 10924,
                        itouch: 12300
                    },
                    {
                        period: '2016 Q2',
                        iphone: 9680,
                        ipad: 9010,
                        itouch: 7891
                    },
                    {
                        period: '2016 Q3',
                        iphone: 4830,
                        ipad: 3805,
                        itouch: 1598
                    },
                    {
                        period: '2016 Q4',
                        iphone: 15083,
                        ipad: 8977,
                        itouch: 5185
                    },
                    {
                        period: '2017 Q1',
                        iphone: 10697,
                        ipad: 4470,
                        itouch: 2038
                    },

                ],
                lineColors: ['#eb6f6f', '#926383', '#eb6f6f'],
                xkey: 'period',
                redraw: true,
                ykeys: ['iphone', 'ipad', 'itouch'],
                labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
                pointSize: 2,
                hideHover: 'auto',
                resize: true
            });


        });
    </script>
    <!-- calendar -->
    <script type="text/javascript" src="js/monthly.js"></script>
    <script type="text/javascript">
        $(window).load(function() {

            $('#mycalendar').monthly({
                mode: 'event',

            });

            $('#mycalendar2').monthly({
                mode: 'picker',
                target: '#mytarget',
                setWidth: '250px',
                startHidden: true,
                showTrigger: '#mytarget',
                stylePast: true,
                disablePast: true
            });

            switch (window.location.protocol) {
                case 'http:':
                case 'https:':
                    // running on a server, should be good.
                    break;
                case 'file:':
                    alert('Just a heads-up, events will not work when run locally.');
            }

        });
    </script>
    <!-- //calendar -->
</body>

</html>