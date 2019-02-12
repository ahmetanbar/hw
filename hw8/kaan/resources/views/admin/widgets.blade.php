
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
    <title>@lang('lang.general') - Kaan ARI</title>
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
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">General</h4>
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
                        <div class="card-body">
                            <h4 class="card-title m-b-0">Recent Comments</h4>
                        </div>
                        <div class="comment-widgets scrollable">
                            <!-- Comment Row -->
                            <div class="d-flex flex-row comment-row m-t-0">
                                <div class="p-2"><img src="../../assets/images/users/1.jpg" alt="user" width="50" class="rounded-circle"></div>
                                <div class="comment-text w-100">
                                    <h6 class="font-medium">James Anderson</h6>
                                    <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing and type setting industry. </span>
                                    <div class="comment-footer">
                                        <span class="text-muted float-right">April 14, 2016</span>
                                        <button type="button" class="btn btn-cyan btn-sm">Edit</button>
                                        <button type="button" class="btn btn-success btn-sm">Publish</button>
                                        <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Comment Row -->
                            <div class="d-flex flex-row comment-row">
                                <div class="p-2"><img src="../../assets/images/users/4.jpg" alt="user" width="50" class="rounded-circle"></div>
                                <div class="comment-text active w-100">
                                    <h6 class="font-medium">Michael Jorden</h6>
                                    <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing and type setting industry. </span>
                                    <div class="comment-footer">
                                        <span class="text-muted float-right">May 10, 2016</span>
                                        <button type="button" class="btn btn-cyan btn-sm">Edit</button>
                                        <button type="button" class="btn btn-success btn-sm">Publish</button>
                                        <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Comment Row -->
                            <div class="d-flex flex-row comment-row">
                                <div class="p-2"><img src="../../assets/images/users/5.jpg" alt="user" width="50" class="rounded-circle"></div>
                                <div class="comment-text w-100">
                                    <h6 class="font-medium">Johnathan Doeting</h6>
                                    <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing and type setting industry. </span>
                                    <div class="comment-footer">
                                        <span class="text-muted float-right">August 1, 2016</span>
                                        <button type="button" class="btn btn-cyan btn-sm">Edit</button>
                                        <button type="button" class="btn btn-success btn-sm">Publish</button>
                                        <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Comment Row -->
                            <div class="d-flex flex-row comment-row">
                                <div class="p-2"><img src="../../assets/images/users/4.jpg" alt="user" width="50" class="rounded-circle"></div>
                                <div class="comment-text w-100">
                                    <h6 class="font-medium">Johnathan Doeting</h6>
                                    <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing and type setting industry. </span>
                                    <div class="comment-footer">
                                        <span class="text-muted float-right">August 1, 2016</span>
                                        <button type="button" class="btn btn-cyan btn-sm">Edit</button>
                                        <button type="button" class="btn btn-success btn-sm">Publish</button>
                                        <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Comment Row -->
                            <div class="d-flex flex-row comment-row">
                                <div class="p-2"><img src="../../assets/images/users/3.jpg" alt="user" width="50" class="rounded-circle"></div>
                                <div class="comment-text w-100">
                                    <h6 class="font-medium">Johnathan Doeting</h6>
                                    <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing and type setting industry. </span>
                                    <div class="comment-footer">
                                        <span class="text-muted float-right">August 1, 2016</span>
                                        <button type="button" class="btn btn-cyan btn-sm">Edit</button>
                                        <button type="button" class="btn btn-success btn-sm">Publish</button>
                                        <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title m-b-0">Recent Login</h4>
                        </div>
                        <ul class="list-style-none">
                            <li class="d-flex no-block card-body">
                                <i class="fa fa-check-circle w-30px m-t-5"></i>
                                <div>
                                    <a href="#" class="m-b-0 font-medium p-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a>
                                    <span class="text-muted">dolor sit amet, consectetur adipiscing</span>
                                </div>
                                <div class="ml-auto">
                                    <div class="tetx-right">
                                        <h5 class="text-muted m-b-0">20</h5>
                                        <span class="text-muted font-16">Jan</span>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex no-block card-body border-top">
                                <i class="fa fa-gift w-30px m-t-5"></i>
                                <div>
                                    <a href="#" class="m-b-0 font-medium p-0">Congratulation Maruti, Happy Birthday</a>
                                    <span class="text-muted">many many happy returns of the day</span>
                                </div>
                                <div class="ml-auto">
                                    <div class="tetx-right">
                                        <h5 class="text-muted m-b-0">11</h5>
                                        <span class="text-muted font-16">Jan</span>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex no-block card-body border-top">
                                <i class="fa fa-plus w-30px m-t-5"></i>
                                <div>
                                    <a href="#" class="m-b-0 font-medium p-0">Maruti is a Responsive Admin theme</a>
                                    <span class="text-muted">But already everything was solved. It will ...</span>
                                </div>
                                <div class="ml-auto">
                                    <div class="tetx-right">
                                        <h5 class="text-muted m-b-0">19</h5>
                                        <span class="text-muted font-16">Jan</span>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex no-block card-body border-top">
                                <i class="fa fa-leaf w-30px m-t-5"></i>
                                <div>
                                    <a href="#" class="m-b-0 font-medium p-0">Envato approved Maruti Admin template</a>
                                    <span class="text-muted">i am very happy to approved by TF</span>
                                </div>
                                <div class="ml-auto">
                                    <div class="tetx-right">
                                        <h5 class="text-muted m-b-0">20</h5>
                                        <span class="text-muted font-16">Jan</span>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex no-block card-body border-top">
                                <i class="fa fa-question-circle w-30px m-t-5"></i>
                                <div>
                                    <a href="#" class="m-b-0 font-medium p-0"> I am alwayse here if you have any question</a>
                                    <span class="text-muted">we glad that you choose our template</span>
                                </div>
                                <div class="ml-auto">
                                    <div class="tetx-right">
                                        <h5 class="text-muted m-b-0">15</h5>
                                        <span class="text-muted font-16">Jan</span>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex no-block card-body border-top">
                                <i class="fa fa-plus w-30px m-t-5"></i>
                                <div>
                                    <a href="#" class="m-b-0 font-medium p-0">Maruti is a Responsive Admin theme</a>
                                    <span class="text-muted">But already everything was solved. It will ...</span>
                                </div>
                                <div class="ml-auto">
                                    <div class="tetx-right">
                                        <h5 class="text-muted m-b-0">19</h5>
                                        <span class="text-muted font-16">Jan</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title m-b-0">Tasks</h5>
                        </div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Articles</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Making The New Suit</td>
                                <td class="text-success">Finished</td>
                                <td>
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="View">
                                        </i><i class="mdi mdi-eye"></i>
                                    </a>
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Confirmation">
                                        <i class="mdi mdi-check"></i>
                                    </a>

                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Rejection">
                                        </i><i class="mdi mdi-close"></i>
                                    </a>
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Archive">
                                        </i><i class="mdi mdi-archive"></i>
                                    </a>
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Delete Forever">
                                        </i><i class="mdi mdi-delete-forever"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Luanch My New Site</td>
                                <td class="text-warning">Writing</td>
                                <td>
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="View">
                                        </i><i class="mdi mdi-eye"></i>
                                    </a>
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Confirmation">
                                        <i class="mdi mdi-check"></i>
                                    </a>

                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Rejection">
                                        </i><i class="mdi mdi-close"></i>
                                    </a>
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Archive">
                                        </i><i class="mdi mdi-archive"></i>
                                    </a>
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Delete Forever">
                                        </i><i class="mdi mdi-delete-forever"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Maruti Excellant Theme</td>
                                <td class="text-danger">Canceled</td>
                                <td>
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="View">
                                        </i><i class="mdi mdi-eye"></i>
                                    </a>
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Confirmation">
                                        <i class="mdi mdi-check"></i>
                                    </a>

                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Rejection">
                                        </i><i class="mdi mdi-close"></i>
                                    </a>
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Archive">
                                        </i><i class="mdi mdi-archive"></i>
                                    </a>
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Delete Forever">
                                        </i><i class="mdi mdi-delete-forever"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- card new -->
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title m-b-0">Recent Admin Panel Activity</h4>
                        </div>
                        <ul class="list-style-none">
                            <li class="card-body">
                                <a href="#" class="m-b-0 p-0">
                                    <div class="d-flex no-block">
                                        <i class="fa fa-check-circle w-30px m-t-5"></i>
                                        <div>
                                            <span class="font-bold">Themeforest</span> Approved My college <span class="font-bold">1 user</span>
                                            <span>2 Hours Ago</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="card-body border-top">
                                <a href="#" class="m-b-0 p-0">
                                    <div class="d-flex no-block">
                                        <i class="fa fa-gift w-30px m-t-5"></i>
                                        <div>
                                            <span class="font-bold">My College is PSD Template</span> Theme
                                            <span>2 Months Ago</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="card-body border-top">
                                <a href="#" class="m-b-0 p-0">
                                    <div class="d-flex no-block">
                                        <i class="fa fa-plus w-30px m-t-5"></i>
                                        <div>
                                            <span class="font-bold">Lorem ipsum doler set</span> adadas
                                            <span>21 Days Ago</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="card-body border-top">
                                <a href="#" class="m-b-0 p-0">
                                    <div class="d-flex no-block">
                                        <i class="fa fa-leaf w-30px m-t-5"></i>
                                        <div>
                                            <span class="font-bold">ITs my first admin</span> so very excited.
                                            <span>20 Days Ago</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="card-body border-top">
                                <a href="#" class="m-b-0 p-0">
                                    <div class="d-flex no-block">
                                        <i class="fa fa-user w-30px m-t-5"></i>
                                        <div>
                                            <span class="font-bold"> I am alwayse here </span>you have any question
                                            <span>12 Days Ago</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="card-body border-top">
                                <a href="#" class="m-b-0 p-0">
                                    <div class="d-flex no-block">
                                        <i class="fa fa-user w-30px m-t-5"></i>
                                        <div>
                                            <span class="font-bold"> I am alwayse here </span>you have any question
                                            <span>12 Days Ago</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Tabs -->
                    <!-- Card -->
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">To Do List</h4>
                            <div class="todo-widget scrollable" style="height:450px;">
                                <ul class="list-task todo-list list-group m-b-0" data-role="tasklist">
                                    <li class="list-group-item todo-item" data-role="task">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck">
                                            <label class="custom-control-label todo-label" for="customCheck">
                                                <span class="todo-desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</span> <span class="badge badge-pill badge-danger float-right">Today</span>
                                            </label>
                                        </div>
                                        <ul class="list-style-none assignedto">
                                            <li class="assignee"><img class="rounded-circle" width="40" src="../../assets/images/users/1.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Steave"></li>
                                            <li class="assignee"><img class="rounded-circle" width="40" src="../../assets/images/users/2.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Jessica"></li>
                                            <li class="assignee"><img class="rounded-circle" width="40" src="../../assets/images/users/3.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Priyanka"></li>
                                            <li class="assignee"><img class="rounded-circle" width="40" src="../../assets/images/users/4.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Selina"></li>
                                        </ul>
                                    </li>
                                    <li class="list-group-item todo-item" data-role="task">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label todo-label" for="customCheck1">
                                                <span class="todo-desc">Lorem Ipsum is simply dummy text of the printing</span><span class="badge badge-pill badge-primary float-right">1 week </span>
                                            </label>
                                        </div>
                                        <div class="item-date"> 26 jun 2017</div>
                                    </li>
                                    <li class="list-group-item todo-item" data-role="task">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck2">
                                            <label class="custom-control-label todo-label" for="customCheck2">
                                                <span class="todo-desc">Give Purchase report to</span> <span class="badge badge-pill badge-info float-right">Yesterday</span>
                                            </label>
                                        </div>
                                        <ul class="list-style-none assignedto">
                                            <li class="assignee"><img class="rounded-circle" width="40" src="../../assets/images/users/3.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Priyanka"></li>
                                            <li class="assignee"><img class="rounded-circle" width="40" src="../../assets/images/users/4.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Selina"></li>
                                        </ul>
                                    </li>
                                    <li class="list-group-item todo-item" data-role="task">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck3">
                                            <label class="custom-control-label todo-label" for="customCheck3">
                                                <span class="todo-desc">Lorem Ipsum is simply dummy text of the printing </span> <span class="badge badge-pill badge-warning float-right">2 weeks</span>
                                            </label>
                                        </div>
                                        <div class="item-date"> 26 jun 2017</div>
                                    </li>
                                    <li class="list-group-item todo-item" data-role="task">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck4">
                                            <label class="custom-control-label todo-label" for="customCheck4">
                                                <span class="todo-desc">Give Purchase report to</span> <span class="badge badge-pill badge-info float-right">Yesterday</span>
                                            </label>
                                        </div>
                                        <ul class="list-style-none assignedto">
                                            <li class="assignee"><img class="rounded-circle" width="40" src="../../assets/images/users/3.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Priyanka"></li>
                                            <li class="assignee"><img class="rounded-circle" width="40" src="../../assets/images/users/4.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Selina"></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- card -->
                </div>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title m-b-0">Top Visited Articles</h5>
                        </div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Browser</th>
                                <th scope="col">Visits</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Chrome</td>
                                <td>8850</td>
                            </tr>
                            <tr>
                                <td>Firefox</td>
                                <td>1200</td>
                            </tr>
                            <tr>
                                <td>Internet Explorer</td>
                                <td>1540</td>
                            </tr>
                            <tr>
                                <td>Opera</td>
                                <td>1230</td>
                            </tr>
                            <tr>
                                <td>Safari</td>
                                <td>1590</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title m-b-0">Top Liked Articles</h5>
                        </div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Site</th>
                                <th scope="col">Visits</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><a href="#" class="link">Themeforest.com</a></td>
                                <td>1240</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="link">Themedesigner.in</a></td>
                                <td>1200</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="link">Themedesigner.in</a></td>
                                <td>1542</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="link">Themedesigner.in</a></td>
                                <td>1230</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="link">Themedesigner.in</a></td>
                                <td>1542</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title m-b-0">Top Visited User</h5>
                        </div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Page</th>
                                <th scope="col">Visits</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><a href="#" class="link">Freebies</a></td>
                                <td>1240</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="link">Blog</a></td>
                                <td>1200</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="link">Work</a></td>
                                <td>1542</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="link">Site Template</a></td>
                                <td>1230</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="link">All categories</a></td>
                                <td>1542</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
</body>

</html>