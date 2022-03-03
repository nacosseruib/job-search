<fieldset>
    <legend class="px-2">Create Your Account</legend>
    <ul class="nav nav-tabs nav-tabs-border d-flex" role="tablist">
      <li class="nav-item mr-4">
        <a class="nav-link @yield('candidateRegistration')" href="{{ Route::has('registerCandidate') ? Route('registerCandidate') : 'javascript' }}">
          <div class="d-flex">
            <div class="tab-icon">
              <i class="flaticon-users"></i>
            </div>
            <div class="ml-3">
              <h6 class="mb-0">Candidate</h6>
              <p class="mb-0">Looking for your dream job?</p>
            </div>
          </div>
        </a>
      </li>
      <li class="nav-item ml-auto">
        <a class="nav-link  @yield('employerRegistration')" href="{{ Route::has('registerEmployer') ? Route('registerEmployer') : 'javascript' }}">
          <div class="d-flex">
            <div class="tab-icon">
              <i class="flaticon-suitcase"></i>
            </div>
            <div class="ml-3">
              <h6 class="mb-0">Employer</h6>
              <p class="mb-0">Looking for quality candidates?</p>
            </div>
          </div>
        </a>
      </li>
    </ul>
  </fieldset>
  <div class="text-right"><em>All fields with <span class="text-danger">*</span> are important.</em></div>
