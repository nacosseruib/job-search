
<!--=================================
banner -->
<section class="banner-bg-slider">
    <div id="bg-slider">
      <img src="{{ asset('assets/images/bg-slider/01.jpg') }}" alt="">
      <img src="{{ asset('assets/images/bg-slider/02.jpg') }}" alt="">
      <img src="{{ asset('assets/images/bg-slider/03.jpg') }}" alt="">
    </div>
    <div class="banner-bg-slider-content">
      <div class="container">
      <div class="row justify-content-center">
        <div class=" col-lg-12 col-md-12 d-flex">

            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h1 class="text-white mb-3">Get Your Desired Job <span class="text-primary"> On MyJobOnTheGo</span></h1>
                        <p class="lead mb-4 mb-lg-5 font-weight-normal text-white">Find Jobs, Employment & Career Opportunities</p>
                        <div class="job-search-field">
                        <div class="job-search-item">

                            @includeif('share.jobSearcView')

                        </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
      </div>
    </div>
    </div>
  </section>
  <!--=================================
  banner -->

  <!--=================================
  Action-box -->
  <section class="bg-primary py-4 py-lg-5 ">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-9 mb-4 mb-sm-4 mb-lg-0">
          <div class="d-sm-flex">
            <h4 class="text-white">Create free account to find the thousands Job Vacancies, Employment &amp; Career Opportunities around you!</h4>
          </div>
        </div>
        <div class="col-md-3 text-lg-right">
          <a class="btn btn-dark" href="{{ Route::has('dashboard') ? Route('dashboard') : 'javascript:;' }}">Post Job</a>
        </div>
      </div>
    </div>
  </section>
  <!--=================================
  Action-box -->
