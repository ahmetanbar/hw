
<!DOCTYPE html>
<html dir="ltr" lang="{{Config::get('app.locale')}}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/icon.png')}}">
    <title>@lang('lang.article') - Kaan ARI</title>
    <!-- Custom CSS -->
    <link href="{{asset('assets/libs/flot/css/float-chart.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('dist/css/style.min.css')}}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar" data-navbarbg="skin5">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <div class="navbar-header" data-logobg="skin5">
                <!-- This is for the sidebar toggle which is visible on mobile only -->
                <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                <a class="navbar-brand" href="./">
                    <b class="logo-icon p-l-10">
                        <img src="{{asset('img/pp-trans.png')}}" alt="homepage" class="light-logo" height="35" width="35"/>

                    </b>
                    <span class="logo-text">
                             <!-- dark Logo text -->
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;@lang('lang.controlpanel')

                    </span>

                </a>
                <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
            </div>

            <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav float-left mr-auto">
                    <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                    <li class="nav-item search-box"> <a class="nav-link waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>

                        <form class="app-search position-absolute" method="GET" action="search">
                            {{csrf_field()}}
                            <input name="find" type="text" class="form-control" placeholder="@lang('lang.searchplaceholder')"> <a class="srh-btn"><i class="ti-close"></i></a>
                        </form>
                    </li>
                </ul>
                <ul class="navbar-nav float-right">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('img/pp-trans.png')}}" alt="user" class="rounded-circle" width="31"></a>
                        <div class="dropdown-menu dropdown-menu-right user-dd animated">
                            <a class="dropdown-item" href="inbox"><i class="ti-email m-r-5 m-l-5"></i> @lang('lang.inbox')</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="settings"><i class="ti-settings m-r-5 m-l-5"></i> @lang('lang.accountsettings')</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout"><i class="fa fa-power-off m-r-5 m-l-5"></i> @lang('lang.logout')</a>
                            <div class="dropdown-divider"></div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <aside class="left-sidebar" data-sidebarbg="skin5">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav" class="p-t-30">
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="./" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">@lang('lang.dashboard')</span></a></li>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="overview" aria-expanded="false"><i class="mdi mdi-chart-bubble"></i><span class="hide-menu">@lang('lang.general')</span></a></li>
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">@lang('lang.control')</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a href="users" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu"> @lang('lang.users') </span></a></li>
                            <li class="sidebar-item"><a href="articles" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> @lang('lang.articles') </span></a></li>
                        </ul>
                    </li>
                    </li>
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">Form Basic</h4>
                    <div class="ml-auto text-right">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Library</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <form class="form-horizontal">
                            <div class="card-body">
                                <h4 class="card-title">Personal Info</h4>
                                <div class="form-group row">
                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">First Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="fname" placeholder="First Name Here">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="lname" class="col-sm-3 text-right control-label col-form-label">Last Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="lname" placeholder="Last Name Here">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="lname" class="col-sm-3 text-right control-label col-form-label">Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="lname" placeholder="Password Here">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email1" class="col-sm-3 text-right control-label col-form-label">Company</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="email1" placeholder="Company Name Here">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="cono1" class="col-sm-3 text-right control-label col-form-label">Contact No</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="cono1" placeholder="Contact No Here">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="cono1" class="col-sm-3 text-right control-label col-form-label">Message</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="border-top">
                                <div class="card-body">
                                    <button type="button" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Form Elements</h5>
                            <div class="form-group row">
                                <label class="col-md-3 m-t-15">Single Select</label>
                                <div class="col-md-9">
                                    <select class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                        <option>Select</option>
                                        <optgroup label="Alaskan/Hawaiian Time Zone">
                                            <option value="AK">Alaska</option>
                                            <option value="HI">Hawaii</option>
                                        </optgroup>
                                        <optgroup label="Pacific Time Zone">
                                            <option value="CA">California</option>
                                            <option value="NV">Nevada</option>
                                            <option value="OR">Oregon</option>
                                            <option value="WA">Washington</option>
                                        </optgroup>
                                        <optgroup label="Mountain Time Zone">
                                            <option value="AZ">Arizona</option>
                                            <option value="CO">Colorado</option>
                                            <option value="ID">Idaho</option>
                                            <option value="MT">Montana</option>
                                            <option value="NE">Nebraska</option>
                                            <option value="NM">New Mexico</option>
                                            <option value="ND">North Dakota</option>
                                            <option value="UT">Utah</option>
                                            <option value="WY">Wyoming</option>
                                        </optgroup>
                                        <optgroup label="Central Time Zone">
                                            <option value="AL">Alabama</option>
                                            <option value="AR">Arkansas</option>
                                            <option value="IL">Illinois</option>
                                            <option value="IA">Iowa</option>
                                            <option value="KS">Kansas</option>
                                            <option value="KY">Kentucky</option>
                                            <option value="LA">Louisiana</option>
                                            <option value="MN">Minnesota</option>
                                            <option value="MS">Mississippi</option>
                                            <option value="MO">Missouri</option>
                                            <option value="OK">Oklahoma</option>
                                            <option value="SD">South Dakota</option>
                                            <option value="TX">Texas</option>
                                            <option value="TN">Tennessee</option>
                                            <option value="WI">Wisconsin</option>
                                        </optgroup>
                                        <optgroup label="Eastern Time Zone">
                                            <option value="CT">Connecticut</option>
                                            <option value="DE">Delaware</option>
                                            <option value="FL">Florida</option>
                                            <option value="GA">Georgia</option>
                                            <option value="IN">Indiana</option>
                                            <option value="ME">Maine</option>
                                            <option value="MD">Maryland</option>
                                            <option value="MA">Massachusetts</option>
                                            <option value="MI">Michigan</option>
                                            <option value="NH">New Hampshire</option>
                                            <option value="NJ">New Jersey</option>
                                            <option value="NY">New York</option>
                                            <option value="NC">North Carolina</option>
                                            <option value="OH">Ohio</option>
                                            <option value="PA">Pennsylvania</option>
                                            <option value="RI">Rhode Island</option>
                                            <option value="SC">South Carolina</option>
                                            <option value="VT">Vermont</option>
                                            <option value="VA">Virginia</option>
                                            <option value="WV">West Virginia</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 m-t-15">Multiple Select</label>
                                <div class="col-md-9">
                                    <select class="select2 form-control m-t-15" multiple="multiple" style="height: 36px;width: 100%;">
                                        <optgroup label="Alaskan/Hawaiian Time Zone">
                                            <option value="AK">Alaska</option>
                                            <option value="HI">Hawaii</option>
                                        </optgroup>
                                        <optgroup label="Pacific Time Zone">
                                            <option value="CA">California</option>
                                            <option value="NV">Nevada</option>
                                            <option value="OR">Oregon</option>
                                            <option value="WA">Washington</option>
                                        </optgroup>
                                        <optgroup label="Mountain Time Zone">
                                            <option value="AZ">Arizona</option>
                                            <option value="CO">Colorado</option>
                                            <option value="ID">Idaho</option>
                                            <option value="MT">Montana</option>
                                            <option value="NE">Nebraska</option>
                                            <option value="NM" selected>New Mexico</option>
                                            <option value="ND">North Dakota</option>
                                            <option value="UT">Utah</option>
                                            <option value="WY">Wyoming</option>
                                        </optgroup>
                                        <optgroup label="Central Time Zone">
                                            <option value="AL">Alabama</option>
                                            <option value="AR">Arkansas</option>
                                            <option value="IL">Illinois</option>
                                            <option value="IA">Iowa</option>
                                            <option value="KS">Kansas</option>
                                            <option value="KY">Kentucky</option>
                                            <option value="LA">Louisiana</option>
                                            <option value="MN">Minnesota</option>
                                            <option value="MS">Mississippi</option>
                                            <option value="MO">Missouri</option>
                                            <option value="OK">Oklahoma</option>
                                            <option value="SD" selected>South Dakota</option>
                                            <option value="TX">Texas</option>
                                            <option value="TN">Tennessee</option>
                                            <option value="WI">Wisconsin</option>
                                        </optgroup>
                                        <optgroup label="Eastern Time Zone">
                                            <option value="CT">Connecticut</option>
                                            <option value="DE">Delaware</option>
                                            <option value="FL">Florida</option>
                                            <option value="GA">Georgia</option>
                                            <option value="IN">Indiana</option>
                                            <option value="ME">Maine</option>
                                            <option value="MD">Maryland</option>
                                            <option value="MA">Massachusetts</option>
                                            <option value="MI">Michigan</option>
                                            <option value="NH">New Hampshire</option>
                                            <option value="NJ">New Jersey</option>
                                            <option value="NY">New York</option>
                                            <option value="NC">North Carolina</option>
                                            <option value="OH">Ohio</option>
                                            <option value="PA">Pennsylvania</option>
                                            <option value="RI">Rhode Island</option>
                                            <option value="SC">South Carolina</option>
                                            <option value="VT">Vermont</option>
                                            <option value="VA">Virginia</option>
                                            <option value="WV">West Virginia</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3">Radio Buttons</label>
                                <div class="col-md-9">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="customControlValidation1" name="radio-stacked" required>
                                        <label class="custom-control-label" for="customControlValidation1">First One</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="customControlValidation2" name="radio-stacked" required>
                                        <label class="custom-control-label" for="customControlValidation2">Second One</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="customControlValidation3" name="radio-stacked" required>
                                        <label class="custom-control-label" for="customControlValidation3">Third One</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3">Checkboxes</label>
                                <div class="col-md-9">
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input" id="customControlAutosizing1">
                                        <label class="custom-control-label" for="customControlAutosizing1">First One</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input" id="customControlAutosizing2">
                                        <label class="custom-control-label" for="customControlAutosizing2">Second One</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input" id="customControlAutosizing3">
                                        <label class="custom-control-label" for="customControlAutosizing3">Third One</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3">File Upload</label>
                                <div class="col-md-9">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="validatedCustomFile" required>
                                        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                        <div class="invalid-feedback">Example invalid custom file feedback</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3" for="disabledTextInput">Disabled input</label>
                                <div class="col-md-9">
                                    <input type="text" id="disabledTextInput" class="form-control" placeholder="Disabled input" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <button type="button" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Forms Control</h4>
                            <div class="form-group">
                                <label for="hue-demo">Hue</label>
                                <input type="text" id="hue-demo" class="form-control demo" data-control="hue" value="#ff6161">
                            </div>
                            <div class="form-group">
                                <label for="position-bottom-left">Bottom left (default)</label>
                                <input type="text" id="position-bottom-left" class="form-control demo" data-position="bottom left" value="#0088cc">
                            </div>
                            <div class="form-group">
                                <label for="position-top-right">Top right</label>
                                <input type="text" id="position-top-right" class="form-control demo" data-position="top right" value="#0088cc">
                            </div>
                            <label>Datepicker</label>
                            <div class="input-group">
                                <input type="text" class="form-control mydatepicker" placeholder="mm/dd/yyyy">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <label class="m-t-15">Autoclose Datepicker</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="datepicker-autoclose" placeholder="mm/dd/yyyy">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-success">Save</button>
                                <button type="submit" class="btn btn-primary">Reset</button>
                                <button type="submit" class="btn btn-info">Edit</button>
                                <button type="submit" class="btn btn-danger">Cancel</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title m-b-0">Form Elements</h5>
                            <div class="form-group m-t-20">
                                <label>Date Mask <small class="text-muted">dd/mm/yyyy</small></label>
                                <input type="text" class="form-control date-inputmask" id="date-mask" placeholder="Enter Date">
                            </div>
                            <div class="form-group">
                                <label>Phone <small class="text-muted">(999) 999-9999</small></label>
                                <input type="text" class="form-control phone-inputmask" id="phone-mask" placeholder="Enter Phone Number">
                            </div>
                            <div class="form-group">
                                <label>International Number <small class="text-muted">+19 999 999 999</small></label>
                                <input type="text" class="form-control international-inputmask" id="international-mask" placeholder="International Phone Number">
                            </div>
                            <div class="form-group">
                                <label>Phone / xEx <small class="text-muted">(999) 999-9999 / x999999</small></label>
                                <input type="text" class="form-control xphone-inputmask" id="xphone-mask" placeholder="Enter Phone Number">
                            </div>
                            <div class="form-group">
                                <label>Purchase Order <small class="text-muted">aaaa 9999-****</small></label>
                                <input type="text" class="form-control purchase-inputmask" id="purchase-mask" placeholder="Enter Purchase Order">
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Form Elements</h5>
                            <div class="row mb-3 align-items-center">
                                <div class="col-lg-4 col-md-12 text-right">
                                    <span>Tooltip Input</span>
                                </div>
                                <div class="col-lg-8 col-md-12">
                                    <input type="text" data-toggle="tooltip" title="A Tooltip for the input !" class="form-control" id="validationDefault05" placeholder="Hover For tooltip" required>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-lg-4 col-md-12 text-right">
                                    <span>Type Ahead Input</span>
                                </div>
                                <div class="col-lg-8 col-md-12">
                                    <input type="text" class="form-control" placeholder="Type here for auto complete.." required>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-lg-4 col-md-12 text-right">
                                    <span>Prepended Input</span>
                                </div>
                                <div class="col-lg-8 col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">#</span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Prepend" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-lg-4 col-md-12 text-right">
                                    <span>Appended Input</span>
                                </div>
                                <div class="col-lg-8 col-md-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="5.000" aria-label="Recipient 's username" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">$</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-lg-4 col-md-12 text-right">
                                    <span class="text-success">Input with Sccess</span>
                                </div>
                                <div class="col-lg-8 col-md-12">
                                    <input type="text" class="form-control is-valid" id="validationServer01">
                                    <div class="valid-feedback">
                                        Woohoo!
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-lg-4 col-md-12 text-right">
                                    <span class="text-danger">Input with Error</span>
                                </div>
                                <div class="col-lg-8 col-md-12">
                                    <input type="text" class="form-control is-invalid" id="validationServer01">
                                    <div class="invalid-feedback">
                                        Please correct the error
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <input type="text" class="form-control" placeholder="col-md-12">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-11">
                                    <input type="text" class="form-control" placeholder="col-md-11">
                                </div>
                                <div class="col-lg-1 p-l-0">
                                    <input type="text" class="form-control" placeholder="col-md-1">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" placeholder="col-md-10">
                                </div>
                                <div class="col-lg-2">
                                    <input type="text" class="form-control" placeholder="col-md-2">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="col-md-9">
                                </div>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" placeholder="col-md-3">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" placeholder="col-md-8">
                                </div>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" placeholder="col-md-4">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-7">
                                    <input type="text" class="form-control" placeholder="col-md-7">
                                </div>
                                <div class="col-lg-5">
                                    <input type="text" class="form-control" placeholder="col-md-5">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" placeholder="col-md-6">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" placeholder="col-md-6">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-5">
                                    <input type="text" class="form-control" placeholder="col-md-5">
                                </div>
                                <div class="col-lg-7">
                                    <input type="text" class="form-control" placeholder="col-md-7">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <input type="text" class="form-control" placeholder="col-md-2">
                                </div>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" placeholder="col-md-3">
                                </div>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" placeholder="col-md-4">
                                </div>
                                <div class="col-lg-2">
                                    <input type="text" class="form-control" placeholder="col-md-2">
                                </div>
                                <div class="col-lg-1 p-l-0">
                                    <input type="text" class="form-control" placeholder="col-md-1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- editor -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Quill Editor</h4>
                            <!-- Create the editor container -->
                            <div id="editor" style="height: 300px;">
                                <p>Hello World!</p>
                                <p>Some initial <strong>bold</strong> text</p>
                                <p>
                                    <br>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Right sidebar -->
            <!-- ============================================================== -->
            <!-- .right-sidebar -->
            <!-- ============================================================== -->
            <!-- End Right sidebar -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer text-center">
            All Rights Reserved by Matrix-admin. Designed and Developed by <a href="https://wrappixel.com">WrapPixel</a>.
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="../../assets/libs/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="../../assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="../../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="../../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
<script src="../../assets/extra-libs/sparkline/sparkline.js"></script>
<!--Wave Effects -->
<script src="../../dist/js/waves.js"></script>
<!--Menu sidebar -->
<script src="../../dist/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="../../dist/js/custom.min.js"></script>
<!-- This Page JS -->
<script src="../../assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
<script src="../../dist/js/pages/mask/mask.init.js"></script>
<script src="../../assets/libs/select2/dist/js/select2.full.min.js"></script>
<script src="../../assets/libs/select2/dist/js/select2.min.js"></script>
<script src="../../assets/libs/jquery-asColor/dist/jquery-asColor.min.js"></script>
<script src="../../assets/libs/jquery-asGradient/dist/jquery-asGradient.js"></script>
<script src="../../assets/libs/jquery-asColorPicker/dist/jquery-asColorPicker.min.js"></script>
<script src="../../assets/libs/jquery-minicolors/jquery.minicolors.min.js"></script>
<script src="../../assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="../../assets/libs/quill/dist/quill.min.js"></script>
<script>
    //***********************************//
    // For select 2
    //***********************************//
    $(".select2").select2();

    /*colorpicker*/
    $('.demo').each(function() {
        //
        // Dear reader, it's actually very easy to initialize MiniColors. For example:
        //
        //  $(selector).minicolors();
        //
        // The way I've done it below is just for the demo, so don't get confused
        // by it. Also, data- attributes aren't supported at this time...they're
        // only used for this demo.
        //
        $(this).minicolors({
            control: $(this).attr('data-control') || 'hue',
            position: $(this).attr('data-position') || 'bottom left',

            change: function(value, opacity) {
                if (!value) return;
                if (opacity) value += ', ' + opacity;
                if (typeof console === 'object') {
                    console.log(value);
                }
            },
            theme: 'bootstrap'
        });

    });
    /*datwpicker*/
    jQuery('.mydatepicker').datepicker();
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });
    var quill = new Quill('#editor', {
        theme: 'snow'
    });

</script>
</body>

</html>