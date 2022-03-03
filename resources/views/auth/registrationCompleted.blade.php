
@extends('layouts.site')
@section("pageTitle", "Registration Complete")
@section("registerPageActive", "active")
@section('pageContent')
<!-- Page Content  -->
 <section class="pt-5 bg-grey">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10 col-md-12">
          <div class="login-register p-4" style="border: 2px dotted #eee; background: #f9f9f9;">
           <div class="section-title">
            <h4 class="widget-title">Registration is complete</h4>
           </div>
            
            <div class="tab-content mb-5">

                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <!-- LOGO -->
                        <tr>
                            <td bgcolor="black" align="center">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                                    <tr>
                                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="black" align="center" style="padding: 0px 10px 0px 10px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                                    <tr>
                                        <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-size: 48px; font-weight: 400;">
                                            <h2 style="font-size: 20px; font-weight: 400; margin: 2; color:green">
                                                Congratulations!
                                                <br />
                                                <em>Your registration is successful.</em>

                                                <div class="text-center text-info p-2 m-1">
                                                    <hr />
                                                    You can log in to your account and start your job search. Thank you.
                                                </div>
                                            </h2>
                                           {{--  <img src="{{ asset('assets/img/reg-complete.jpg') }}" width="125" height="120" style="display: block; border: 0px;" /> --}}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <div align="center">
                        <hr />
                        <a href="{{ Route::has('login') ? Route('login') : 'javascript:;' }}" class="btn btn-outline-success">
                            Login Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<!-- /Page Content  -->
@endsection


@section('style')

@endsection
