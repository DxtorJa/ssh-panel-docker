<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Welcome To SSH Panel Installation! | The best Panel to start selling SSH & VPN Services.</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

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

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="/assets/css/themes/all-themes.css" rel="stylesheet" />

    <link href="/assets/plugins/dropzone/dropzone.css" rel="stylesheet">


</head>
<body class="theme-red" style="margin-top: 75px;">

    
    
    <div class="container">
        <div class="block-header">
            <h2 class="text-center">WELCOME TO SSHPANEL INSTALLATION</h2>
        </div>



        <form action="/install" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="row clearfix">

                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                    @if($errors->count() > 0)
                        <div class="alert alert-danger">
                            <h2>Whoops! Please fix error below.</h2>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                ADMIN DETAILS
                            </h2>
                        </div>
                        <div class="body">
                            <h2 class="card-inside-title">Create your first admin user.</h2>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Username" name="username" required value="{{old('username')}}" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="email" class="form-control" placeholder="Email Address" name="email" required value="{{old('email')}}" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="password" class="form-control" placeholder="Password" name="password" required/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>WEBSITE DETAILS</h2>
                        </div>
                        <div class="body">
                            <h2 class="card-inside-title">Basic Details</h2>
                            
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line focused">
                                            <input type="text" class="form-control" placeholder="Website Name" name="site_name" required value="{{old('site_name')}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line focused">
                                            <input type="text" class="form-control" placeholder="Website URL (With http:// or https://)" name="site_url" required value="{{old('site_url')}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line focused">
                                            <input type="text" class="form-control" placeholder="Website Title" name="site_title" required value="{{old('site_title')}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line focused">
                                            <input type="text" class="form-control" placeholder="Website Author" name="site_author" required value="{{old('site_author')}}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="4" class="form-control no-resize" placeholder="Website Description" name="site_description" required value="{{old('site_description')}}"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line focused">
                                            <label>Website Banner</label>
                                            <input type="file" class="form-control" placeholder="Website Banner" name="site_banner" required/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>ADVANCED DETAILS</h2>
                        </div>
                        <div class="body">                        
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line focused">
                                            <input type="email" class="form-control" placeholder="Cloudflare API Email" name="cloudflare_email" required value="{{old('cloudflare_email')}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line focused">
                                            <input type="password" class="form-control" placeholder="Cloudflare API Key" name="cloudflare_key" required/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>MESSAGES DETAILS</h2>
                        </div>
                        <div class="body">                        
                            <div class="row clearfix">
                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="4" class="form-control no-resize" placeholder="Message if successfully create SSH Account" name="ssh_success"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="4" class="form-control no-resize" placeholder="Message if Failed to create SSH Account" name="ssh_failed"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="4" class="form-control no-resize" placeholder="Message if Successfully create VPN Account" name="vpn_success"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="4" class="form-control no-resize" placeholder="Message if Failed to create VPN Account" name="vpn_failed"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="4" class="form-control no-resize" placeholder="Message if Successfully create Trial Account" name="trial_success"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="4" class="form-control no-resize" placeholder="Message if Failed to create Trial account." name="trial_failed"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="4" class="form-control no-resize" placeholder="Message if balance or point is lower than account prices" name="balance_min"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>MESSAGES DETAILS (FOR ADMIN)</h2>
                        </div>
                        <div class="body">                        
                            <div class="row clearfix">
                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="4" class="form-control no-resize" placeholder="Message if successfully create SSH Account" name="ssh_success_admin"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="4" class="form-control no-resize" placeholder="Message if Failed to create SSH Account" name="ssh_failed_admin"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="4" class="form-control no-resize" placeholder="Message if Successfully create VPN Account" name="vpn_success_admin"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="4" class="form-control no-resize" placeholder="Message if Failed to create VPN Account" name="vpn_failed_admin"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="4" class="form-control no-resize" placeholder="Message if Successfully create Trial Account" name="trial_success_admin"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-lg-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="4" class="form-control no-resize" placeholder="Message if Failed to create Trial account." name="trial_failed_admin"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="4" class="form-control no-resize" placeholder="Message if balance or point is lower than account prices" name="balance_min_admin"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success text-center" style="width: 100%;" >SAVE</button>
            <hr />
            <p class="text-center"> Copyright &copy; {{date('Y')}} SSH Panel. </p>
        </form>

    </div>

    <!-- end body -->

    <!-- Jquery Core Js -->
    <script src="/assets/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="/assets/plugins/bootstrap/js/bootstrap.js"></script>

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

    <!-- Flot Charts Plugin Js -->
    <script src="/assets/plugins/flot-charts/jquery.flot.js"></script>
    <script src="/assets/plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="/assets/plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="/assets/plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="/assets/plugins/flot-charts/jquery.flot.time.js"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="/assets/plugins/jquery-sparkline/jquery.sparkline.js"></script>

    <!-- Custom Js -->
    <script src="/assets/js/admin.js"></script>
    <script src="/assets/js/pages/index.js"></script>

    <!-- Demo Js -->
    <script src="/assets/plugins/dropzone/dropzone.js"></script>
    <script src="/assets/js/demo.js"></script>
</body>

</html>