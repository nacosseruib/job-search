@if(isset($showPageAboutus) && $showPageAboutus == 1)


<section>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="user-dashboard-info-box mt-4">

            <div class="section-title-02 mb-2">
              <h4>About Us</h4>
              <hr />
            </div>

            <div class="form-row">
                <div class="form-group col-md-12 text-justify">

                    {!! (isset($getAboutus) && $getAboutus) ? $getAboutus->content : '' !!}

                </div>
            </div>
        </div>
      </div>
  </section>


@endif
