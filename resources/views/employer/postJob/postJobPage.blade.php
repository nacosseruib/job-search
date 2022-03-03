@extends('layouts.site')
@section("pageTitle", "Post New Job")
@section("postNewJobPageActive", "active")
@section('pageContent')

    @includeIf('share.homeTopMenu', ['data' => '' ])

    @includeIf('employer.postJob.postJobPageView', ['showPagePostJob'=> (isset($showPagePostJob) ? $showPagePostJob : 1)])

@endsection


{{-- Style --}}
@section('style')
    <link href="{{ asset('assets/summernote/summernote-bs4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Script --}}
@section('script')
      <script>
          //Number Format
        $(document).ready(function () {
            $("#formatAmountOnKeyPress").on('keyup', function(evt){
                //if (evt.which != 110 ){//not a fullstop
                    //var n = parseFloat($(this).val().replace(/\,/g,''),10);
                     $(this).val(function (index, value) {
                    return  value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        });
                    //$(this).val(n.toLocaleString());
                //}
            });
        });

      </script>
    <!-- Summernote js -->
    <script src="{{ asset('assets/summernote/summernote-bs4.min.js') }}"></script>
    <!--tinymce js-->
    <script src="{{ asset('assets/summernote/tinymce.min.js') }}"></script>
    <!-- init js -->
    <script src="{{ asset('assets/summernote/form-editor.init.js') }}"></script>
    <script>
        $(document).ready(function() {
            var getVale;
            $('.summernoteShort').summernote({
                height: 100,
                tabsize: 2,
            });
            $('.summernoteLong').summernote({
                height: 200,
                tabsize: 2,
            });

        });
    </script>
@endsection
