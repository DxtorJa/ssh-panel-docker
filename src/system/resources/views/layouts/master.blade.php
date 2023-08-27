<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta content="{{csrf_token()}}" name="csrf-token">
    <title>{{@$site_setting->site_title}} | @yield('title')</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Meta Tags -->
    <meta name="author" content="{{@$site_setting->site_author}}">
    <meta name="description" content="{{@$site_setting->site_description}}">

    <!-- Facebook Open Graph Meta -->
    <meta property="og:title" content="{{@$site_setting->site_title}}">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{@$site_setting->site_url}}"/>
    <meta property="og:image" content="{{@$site_setting->site_thumbnails}}">
    <meta property="og:description" content="{{@$site_setting->site_description}}">

    <!-- Google Fonts -->
    <link href="//fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="/assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="/assets/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="/assets/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="/assets/plugins/morrisjs/morris.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/master.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="/assets/css/themes/all-themes.css" rel="stylesheet" />
    <link href="/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <!-- Toastr Notification -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- SweetAlert -->
    <link href="/assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://assets-cdn.github.com/assets/gist-embed-1baaff35daab552f019ad459494450f1.css">

    <!-- Material Date Picker -->
    {{--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/css/bootstrap-material-datetimepicker.min.css" />  --}}

    @yield('css')
    <!-- Syntax Highlighter -->
    <link rel="stylesheet" href="/assets/css/atom.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.10.0/highlight.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.8&appId=1794437970823430";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>
</head>
<body class="theme-light-blue">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="{{url('/')}}">{{@$site_setting->site_name}} - {{(Auth::user()->role == 'admin') ? 'Admin' : 'Reseller'}} Panel</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">

            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="{{$user->images}}" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$user->name}}</div>
                    <div class="email">{{$user->email}}</div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{url('/profile')}}"><i class="material-icons">person</i>Profile ({{$user->balance}})</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="{{url('/logout')}}"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="active">
                        <a href="{{url('/')}}">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>
                    @if($user->role == 'reseller')
                        @if(feature('dns')->status)
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <i class="material-icons">language</i>
                                    <span>DNS</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
                                        <a href="{{url('/dns/list')}}">List DNS</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/dns/create')}}">Create DNS</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">dns</i>
                                <span>Server</span>
                            </a>
                            <ul class="ml-menu">
                                <li>
                                    <a href="{{url('/server/monitor')}}">Cek Service</a>
                                </li>
                            </ul>
                        </li>
                        @if(feature('vpn')->status)
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <i class="material-icons">vpn_key</i>
                                    <span>VPN Account</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
                                        <a href="{{url('/vpn/create')}}">Create VPN Account</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/vpn/list')}}">List VPN Account</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/vpn/cert')}}">Download Certificate</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if(feature('tickets')->status)
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <i class="material-icons">feedback</i>
                                    <span>Tickets</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
                                        <a href="{{url('/tickets')}}">All Tickets</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/tickets/create')}}">Create New Ticket</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <li>
                            <a href="{{url('/information')}}">
                                <i class="material-icons">sms</i>
                                <span>Information</span>
                            </a>
                        </li>

                    @else

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">dns</i>
                                <span>Server</span>
                            </a>
                            <ul class="ml-menu">
                                <li>
                                    <a href="{{url('/server/add')}}">Add Server</a>
                                </li>
                                <li>
                                    <a href="{{url('/server/list')}}">List Server</a>
                                </li>
                                <li>
                                    <a href="{{url('/server/monitor')}}">Monitor Server</a>
                                </li>
                            </ul>
                        </li>
                        @if(feature('vpn')->status)
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <i class="material-icons">vpn_key</i>
                                    <span>VPN Account</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
                                        <a href="{{url('/vpn/create')}}">Create VPN Account</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/vpn/list')}}">List VPN Account</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/vpn/cert')}}">Download Certificate</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if(feature('vpn')->status)
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <i class="material-icons">class</i>
                                    <span>VPN Certificate</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
                                        <a href="{{url('/vpn/cert')}}">All Certificate</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/vpn/cert/add')}}">Add Ceritifcate</a>
                                    </li>
                                </ul>
                            </li>
                        @endif 
                        @if(feature('dns')->status)
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <i class="material-icons">language</i>
                                    <span>DNS</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
                                        <a href="{{url('/dns/create')}}">Create DNS</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/dns/list')}}">List DNS</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/dns/add')}}">Add DNS Parent</a>
                                    </li>
                                </ul>
                            </li>
                        @endif 
                        @if(feature('coupon')->status)
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <i class="material-icons">card_giftcard</i>
                                    <span>Coupon</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
                                        <a href="{{url('/coupon/create')}}">Coupon Code</a>
                                    </li>
                                </ul>
                            </li>
                        @endif 
                        @if(feature('reseller')->status)
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <i class="material-icons">group</i>
                                    <span>Reseller</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
                                        <a href="{{url('/reseller/create')}}">Add Reseller</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/reseller/list')}}">List Reseller</a>
                                    </li>
                                </ul>
                            </li>
                        @endif 
                        @if(feature('tickets'))
                            <li>
                                <a href="{{url('/tickets')}}">
                                    <i class="material-icons">feedback</i>
                                    <span>Tickets</span>
                                </a>
                            </li>
                        @endif 
                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">info</i>
                                <span>Information</span>
                            </a>
                            <ul class="ml-menu">
                                <li>
                                    <a href="{{url('/info/list')}}">List Info</a>
                                </li>
                                <li>
                                    <a href="{{url('/info/create')}}">Create Info</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">build</i>
                                <span>Admin Setting</span>
                            </a>
                            <ul class="ml-menu">
                                <li>
                                    <a href="{{url('/admin')}}">Panel Setting</a>
                                </li>
                                <li>
                                    <a href="{{url('/admin/features')}}">Features</a>
                                </li>
                            </ul>
                        </li>
                    @endif 
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                   Copyright &copy; 2023 <a href="{{@$site_setting->site_url}}">{{@$site_setting->site_name}}</a>.
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
                <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                        <li data-theme="red" class="active">
                            <div class="red"></div>
                            <span>Red</span>
                        </li>
                        <li data-theme="pink">
                            <div class="pink"></div>
                            <span>Pink</span>
                        </li>
                        <li data-theme="purple">
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>
                        <li data-theme="deep-purple">
                            <div class="deep-purple"></div>
                            <span>Deep Purple</span>
                        </li>
                        <li data-theme="indigo">
                            <div class="indigo"></div>
                            <span>Indigo</span>
                        </li>
                        <li data-theme="blue">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="light-blue">
                            <div class="light-blue"></div>
                            <span>Light Blue</span>
                        </li>
                        <li data-theme="cyan">
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <li data-theme="teal">
                            <div class="teal"></div>
                            <span>Teal</span>
                        </li>
                        <li data-theme="green">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="light-green">
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                        <li data-theme="lime">
                            <div class="lime"></div>
                            <span>Lime</span>
                        </li>
                        <li data-theme="yellow">
                            <div class="yellow"></div>
                            <span>Yellow</span>
                        </li>
                        <li data-theme="amber">
                            <div class="amber"></div>
                            <span>Amber</span>
                        </li>
                        <li data-theme="orange">
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <li data-theme="deep-orange">
                            <div class="deep-orange"></div>
                            <span>Deep Orange</span>
                        </li>
                        <li data-theme="brown">
                            <div class="brown"></div>
                            <span>Brown</span>
                        </li>
                        <li data-theme="grey">
                            <div class="grey"></div>
                            <span>Grey</span>
                        </li>
                        <li data-theme="blue-grey">
                            <div class="blue-grey"></div>
                            <span>Blue Grey</span>
                        </li>
                        <li data-theme="black">
                            <div class="black"></div>
                            <span>Black</span>
                        </li>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="settings">
                    <div class="demo-settings">
                        <p>GENERAL SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Report Panel Usage</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Email Redirect</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>SYSTEM SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Notifications</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Auto Updates</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>ACCOUNT SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Offline</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Location Permission</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        @yield('body')
    </section>



    <!-- Jquery Core Js -->
    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <script src="/assets/plugins/jquery-knob/jquery.knob.min.js" ></script>
    <script type="text/javascript" src="/assets/js/pages/timeago.js"></script>

    <script src="/assets/js/pages/charts/jquery-knob.js"></script>


    <!-- Bootstrap Core Js -->
    <script src="/assets/plugins/bootstrap/js/bootstrap.js"></script>
    <script src="/assets/js/pages/ui/tooltips-popovers.js"></script>

    <!-- Select Plugin Js -->
    <script src="/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="/assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="/assets/plugins/node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="/assets/plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="/assets/plugins/raphael/raphael.min.js"></script>
    <script src="/assets/plugins/morrisjs/morris.js"></script>

    <!-- ChartJs -->
    <script src="/assets/plugins/chartjs/Chart.bundle.js"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="/assets/plugins/jquery-sparkline/jquery.sparkline.js"></script>

    <!-- SweetAlert -->
    <script src="/assets/plugins/sweetalert/sweetalert.min.js"></script>

    <!-- Custom Js -->
    <script src="/assets/js/admin.js"></script>
    <script src="/assets/js/pages/index.js"></script>

    <!-- editor -->
    <script src="/assets/plugins/tinymce/tinymce.js"></script>

    <!-- Plugins -->
    <script type="text/javascript" src=//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/js/bootstrap-material-datetimepicker.min.js"></script>

    
    <script>tinymce.init(
    {
        selector:'textarea#editor',
        theme: "modern",
        height: 300,
        plugins: [
            'advlist autolink lists link image charmap preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        image_advtab: true

    });
    </script>

    <!-- Demo Js -->
    <script src="/assets/js/demo.js"></script>
    <script src="/assets/js/script.js"></script>
    
    @yield('js')

</body>
