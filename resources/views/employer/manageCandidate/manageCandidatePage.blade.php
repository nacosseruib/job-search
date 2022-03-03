@extends('layouts.site')
@section("pageTitle", "Manage Candidate Application")
@section("employerManageCandidatePageActive", "active")
@section('pageContent')

    @includeIf('share.homeTopMenu', ['data' => '' ])

    @includeIf('employer.manageCandidate.manageCandidatePageView', ['showPageManageCandidate'=> (isset($showPageManageCandidate) ? $showPageManageCandidate : 1)])

@endsection

{{-- Style --}}
@section('style')

@endsection

{{-- Script --}}
@section('script')
    <script>
        $("#jobTitleChanged").change(function(){
            var getID = $('#jobTitleChanged').val();
            if(getID != "")
            {
                $.ajax({
                    url: '{{url("/get-job-and-candidate/")}}' + '/' + getID,
                    type: 'get',
                    data: { format: 'json' },
                    dataType: 'json',
                    success: function(data){
                        location.reload(true);
                    },
                    error: function(error) {
                        location.reload(true);
                        //alert('Sorry, we cannot process your action. Refresh this page and try again!');
                        return;
                    }
                });
            }else{}//end if
        });
    </script>
@endsection
