@if(isset($showPageBuildCV) && $showPageBuildCV == 1)


<!--=================================
Manage Jobs -->
<section>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="user-dashboard-info-box mb-0">

            <div class="row">
              <div class="col-md-12 col-sm-12 align-items-center">
                <div class="section-title-02 mb-0 ">
                  <h4 class="mb-0">Build Your CV</h4>
                  <hr />
                  <div align="right">
                        <a href="{{ Route::has('listCVBuildRequest') ? Route('listCVBuildRequest') : 'javascript:;' }}" class="btn btn-outline-dark btn-sm">View Your CV Build Request</a>
                  </div>
                </div>
              </div>
            </div>

            <div class="">
                <div class="row">
                    <div class="col-md-12 p-4">
                       <div class="alert alert-primary text-center">
                            <h4>
                               {{ isset($priceData) ? $priceData->details : '' }}
                            </h4>
                            <h2><b> &#8358;{{isset($priceData) ? $priceData->price_amount : ''}}/CV </b></h2>
                        </div>
                    </div>
                    <div align="center" class="col-md-12">
                            <a href="{{ Route::has('requestBuildCV') ? Route('requestBuildCV') : 'javascript:;'  }}" class="btn btn-primary">Build Now</a>
                     </div>
                </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
  <!--=================================
  Manage Jobs -->


@endif
