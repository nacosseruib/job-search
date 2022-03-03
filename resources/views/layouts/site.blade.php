<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="My Job onthgo search job jobber jobberman jobboard board candidate employer postjob" />
    <meta name="description" content="myjobonthgo - Job Board and Job search for both candidates and employers" />
    <meta name="author" content="myjobonthgo.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('pageTitle', 'Welcome to myjobonthgo.com')</title>

    {{-- Favicon  --}}
    <link href="{{ asset('assets/images/favicon.ico') }}" rel="shortcut icon" />

    {{--  Google Font  --}}
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700" rel="stylesheet">

    {{-- CSS Global Compulsory (Do not remove) --}}
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon/flaticon.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.css') }}" />
    {{-- Page CSS Implementing Plugins (Remove the plugin CSS here if site does not use that feature) --}}
    <link rel="stylesheet" href="{{ asset('assets/css/range-slider/ion.rangeSlider.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/owl-carousel/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/subtle-slideshow.css') }}" />
    <!-- chart -->
    <link rel="stylesheet" href="{{ asset('assets/css/apexcharts/apexcharts.css')}}" />
    {{-- Template Style --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />

     <!--Language Translation-->
     <!--<div id="google_translate_element"></div>-->
     <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <script>
         function googleTranslateElementInit() {
             new google.translate.TranslateElement({
                 pageLanguage: 'en'
             }, 'google_translate_element');
         }
     </script>
     <!--//Translation-->
     <style>
         /* Add a black background color to the top navigation */
        .topnav {
        background-color: #333;
        overflow: hidden;
        }

        /* Style the links inside the navigation bar */
        .topnav a {
        float: left;
        display: block;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
        }

        /* Change the color of links on hover */
        .topnav a:hover {
        background-color: #ddd;
        color: black;
        }

        /* Add an active class to highlight the current page */
        .topnav a.active {
        background-color: #4CAF50;
        color: white;
        }

        /* Hide the link that should open and close the topnav on small screens */
        .topnav .icon {
        display: none;
        }

         /* When the screen is less than 600 pixels wide, hide all links, except for the first one ("Home"). Show the link that contains should open and close the topnav (.icon) */
        @media screen and (max-width: 600px) {
        .topnav a:not(:first-child) {display: none;}
        .topnav a.icon {
            float: right;
            display: block;
        }
        }

        /* The "responsive" class is added to the topnav with JavaScript when the user clicks on the icon. This class makes the topnav look good on small screens (display the links vertically instead of horizontally) */
        @media screen and (max-width: 600px) {
        .topnav.responsive {position: relative;}
        .topnav.responsive a.icon {
            position: absolute;
            right: 0;
            top: 0;
        }
        .topnav.responsive a {
            float: none;
            display: block;
            text-align: left;
        }
        }
        caption {
            text-align:right;
        }
    </style>

     @yield('style')


  </head>
<body>

{{-- Header --}}
<header class="header bg-dark">
  <nav class="navbar navbar-static-top navbar-expand-lg header-sticky">
    <div class="container-fluid">
      <button id="nav-icon4" type="button" class="navbar-toggler" data-toggle="collapse" data-target=".navbar-collapse">
          <span></span>
          <span></span>
          <span></span>
      </button>
      <a class="navbar-brand2" href="{{ Route::has('index') ? Route('index') : 'javascript' }}">
        <img class="img-fluid" src="{{ asset('assets/images/logo/logo.png')}}" alt=" ">
      </a>
        <div class="navbar-collapse collapse justify-content-start">
            <ul class="nav navbar-nav">
                <li class="nav-item dropdown ">
                    <a class="nav-link" href="{{ Route::has('index') ? Route('index') : 'javascript:;' }}" role="button"><b> <span class="fa fa-home"></span> </b></a>
                </li>
                <li class="nav-item dropdown ">
                    <a class="nav-link" href="{{ Route::has('aboutus') ? Route('aboutus') : 'javascript:;' }}" role="button"><b> ABOUT US </b></a>
                </li>
                @if(Auth::check() && ((Auth::user()->user_type == 1 && Auth::user()->user_role == 1) ||  (Auth::user()->user_type == 2) && Auth::user()->user_role == 2))
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <b>ADMIN SETUP</b> <i class="fas fa-chevron-down fa-xs"></i></a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ Route::has('viewRegisteredUsers') ? Route('viewRegisteredUsers') : 'javascript:;' }}"> Registered User </a></li>
                           {{--  <li><a class="dropdown-item" href=""> Create Industry </a></li> --}}
                        </ul>
                    </li>
                    @if(Auth::check() && Auth::user()->user_type == 1 && Auth::user()->user_role == 1)
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <b>ROUTE SETUP</b> <i class="fas fa-chevron-down fa-xs"></i></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ Route::has('createRole') ? Route('createRole') : 'javascript:;' }}"> Create Role </a></li>
                                <li><a class="dropdown-item" href="{{ Route::has('createModule') ? Route('createModule') : 'javascript:;' }}">Create Module</a></li>
                                <li><a class="dropdown-item" href="{{ Route::has('createSubModule') ? Route('createSubModule') : 'javascript:;' }}">Create Sub-Module</a></li>
                                <li><a class="dropdown-item" href="{{ Route::has('createSubmoduleAssignment') ? Route('createSubmoduleAssignment') : 'javascript:;' }}">Assign Role To Permission</a></li>
                            </ul>
                        </li>
                    @endif
                @endif

                <li class="nav-item dropdown ">
                    <a class="nav-link" href="{{ Route::has('searchJob') ? Route('searchJob') : 'javascript:;' }}" role="button" ><b>JOB SEARCH</b></a>
                </li>

                @if(Auth::check())
                    <li class="nav-item dropdown ">
                        <a class="nav-link" href="{{ Route::has('dashboard') ? Route('dashboard') : 'javascript' }}" role="button" ><b>MY ACCOUNT</b></a> {{-- data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" --}}
                    </li>
                    @if(Auth::check())
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <b>WALLET</b> <i class="fas fa-chevron-down fa-xs"></i></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ Route::has('wallet') ? Route('wallet') : 'javascript:;' }}"> Balance ({{ (isset($walletBalance) ? number_format($walletBalance, 1) : 0.0) }}NGN) </a></li>
                                <li><a class="dropdown-item" href="{{ Route::has('wallet') ? Route('wallet') : 'javascript:;' }}">Credit Wallet</a></li>
                                <li><a class="dropdown-item" href="{{ Route::has('walletTransaction') ? Route('walletTransaction') : 'javascript:;' }}">Payment History</a></li>
                                <li><a class="dropdown-item" href="{{ Route::has('walletStatmentAccount') ? Route('walletStatmentAccount') : 'javascript:;' }}">Account Statement</a></li>
                            </ul>
                        </li>
                    @endif
                    <li class="nav-item dropdown ">
                        <a class="nav-link" href="{{ Route::has('logout') ? Route('logout') : 'javascript' }}" role="button"><b>LOGOUT</b></a> {{-- data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" --}}
                    </li>
                @else
                    <li class="nav-item dropdown ">
                        <a class="nav-link" href="{{ Route::has('login') ? Route('login') : 'javascript' }}" role="button" ><b>LOG IN</b></a> {{-- data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" --}}
                    </li>

                    <li class="nav-item dropdown ">
                        <a class="nav-link" href="{{ Route::has('registerCandidate') ? Route('registerCandidate') : 'javascript' }}" role="button"><b>SIGN UP</b></a> {{-- data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" --}}
                    </li>
                @endif
            </ul>
        </div>

        @if(Auth::check())
          @if(Auth::user()->user_role == 4)
            <div class="add-listing">
                <a class="btn btn-white btn-md" href="{{ Route::has('createPostJob') ? Route('createPostJob') : 'javascript:;' }}"> <i class="fas fa-plus-circle"></i>POST A JOB</a>
            </div>
          @else
            <div class="add-listing">
                <a class="btn btn-white btn-md" href="{{ Route::has('dashboard') ? Route('dashboard') : 'javascript:;' }}"> <i class="fas fa-user"></i>{{ isset($userFullName) ? $userFullName : 'Administrator' }}</a>
            </div>
          @endif
        @endif

    </div>
  </nav>
</header>
{{-- ================================ Header --}}

        @yield('pageContent')

{{-- ============Footer===================== --}}

<footer class="footer bg-light mt-5">
    <div class="footer-bottom bg-dark d-print-none">
      <div class="container">
        <div class="row">
          <div class="col-md-6 ">
            <div class="d-flex justify-content-md-start justify-content-center">
              <ul class="list-unstyled d-flex mb-0">
                <li><a href="{{ Route::has('readTermCondition') ? Route('readTermCondition') : 'javascript:;' }}">Terms & Condition</a></li>
                {{-- <li><a href="#">Contact</a></li> --}}
              </ul>
            </div>
          </div>
          <div class="col-md-6 text-center text-md-right mt-4 mt-md-0">
            <p class="mb-0"> &copy; Copyright <span id="copyright"> <script>document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))</script></span> All Rights Reserved. | MyJobOnTheGo.com </p>
          </div>
        </div>
      </div>
    </div>
  </footer>
{{-- ===========Footer================== --}}



{{-- Back To Top --}}
   <div id="back-to-top" class="back-to-top">
     <i class="fas fa-angle-up"></i>
   </div>

{{-- Back To Top --}}

    {{-- JS Global Compulsory (Do not remove) --}}
    <script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.min.js') }}"></script>
    {{-- Page JS Implementing Plugins (Remove the plugin script here if site does not use that feature) --}}
    <script src="{{ asset('assets/js/owl-carousel/owl-carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/slideshow/jquery.velocity.min.js') }}"></script>
    <script src="{{ asset('assets/js/slideshow/jquery.kenburnsy.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2.full.js') }}"></script>
    {{-- Template Scripts (Do not remove) --}}
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    @yield('script')

    <script>
        const $dropdown = $(".dropdown");
        const $dropdownToggle = $(".dropdown-toggle");
        const $dropdownMenu = $(".dropdown-menu");
        const showClass = "show";

        $(window).on("load resize", function() {
        if (this.matchMedia("(min-width: 768px)").matches) {
            $dropdown.hover(
            function() {
                const $this = $(this);
                $this.addClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "true");
                $this.find($dropdownMenu).addClass(showClass);
            },
            function() {
                const $this = $(this);
                $this.removeClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "false");
                $this.find($dropdownMenu).removeClass(showClass);
            }
            );
        } else {
            $dropdown.off("mouseenter mouseleave");
        }
        });

        /* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */
        function myFunction() {
            document.getElementsByClassName("topnav")[0].classList.toggle("responsive");
        }
    </script>



</body>
</html>
