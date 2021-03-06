@extends('layouts.site')
@section('pageTitle') {{ strToUpper(__('Create SubModule')) }} @endsection
@section('subModulePageActive') active @endsection
@section('pageContent')

    <div class="container mt-4 bg-light p-3">
        <div class="row">
                <div class="col-md-12">
                    <div align="left" class="title-section style3 left">
                        <h5 class="title">@yield('pageTitle')</h5>
                        <hr />
                    </div>
                    @includeIf('share.operationCallBackAlert', ['showAlert' => 1])
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center mt-4 mb-4">
                <div class="col-md-12">
                <form  id="submitModuleForm" class="form d-print-none" method="post" action="{{route('addSubModule')}}">
                @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="">
                                <div class="">

                                    <div class="row offset-md-3 mb-3">
                                        <div align="center" class="col-md-8">
                                            <label> Module Name <span class="text-danger"><b>*</b></span> </label>
                                            <select class="form-control" autofocus required name="moduleName" id="moduleName">
                                                <option value="{{ ((isset($editSubModule)) ? $editSubModule->moduleID : '') }}"> {{ ((isset($editSubModule)) ? ($editSubModule->module_name) : 'Select Module Name') }} </option>
                                                @foreach($allModule as $listModule)
                                                    <option value="{{$listModule->moduleID}}" {{ ($listModule->moduleID == old('moduleName')) ? 'Selected' : '' }}>{{$listModule->module_name}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('moduleName'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('moduleName') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label> Route Caption  <span class="text-danger"><b>*</b></span> </label>
                                            <input type="text" class="form-control" required name="routeName" id="routeName" value="{{ ((isset($editSubModule)) ? $editSubModule->submodule_name : old('routeName')) }}">
                                            @if ($errors->has('routeName'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('routeName') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label> {{ __('Route/URL Name') }} <span class="text-danger"><b>*</b></span> </label>
                                            <input type="text" required value="{{ ((isset($editSubModule)) ? $editSubModule->submodule_url : old('routeUrl')) }}" class="form-control" name="routeUrl" id="routeUrl">
                                            @if ($errors->has('routeUrl'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('routeUrl') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div><!--//row-->

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label> Route Rank </label>
                                            <select class="form-control" name="routeRank" id="routeRank">
                                                <option value="{{ ((isset($editSubModule)) ? $editSubModule->module_rank : '') }}"> {{ ((isset($editSubModule)) ? ($editSubModule->submodule_rank) : 'Select') }} </option>
                                                @for($rank = 1; $rank <= 100; $rank ++)
                                                    <option {{ ($rank == old('routeRank')) ? 'Selected' : '' }}>{{$rank}}</option>
                                                @endfor
                                            </select>
                                            @if ($errors->has('routeRank'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('routeRank') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label> Route Status <span class="text-danger"><b>*</b></span> </label>
                                            <select class="form-control" required name="routStatus" id="routStatus">
                                                <option value="{{ ((isset($editSubModule)) ? $editSubModule->module_active : '') }}"> {{ ((isset($editSubModule)) ? ($editSubModule->submodule_active ? 'Enabled' : 'Disabled') : 'Select') }} </option>
                                                <option value="1" {{ (1 == old('routStatus')) ? 'Selected' : '' }}>Enable</option>
                                                <option value="0" {{ (0 and null <> old('routStatus')) ? 'Selected' : '' }}>Disable</option>
                                            </select>
                                            @if ($errors->has('routStatus'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('routStatus') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div><!--//row-->
                                    <!--Active Page-->
                                    <div class="row">
                                        <div class="col-md-6 mt-3">
                                            <label> Active Link Name </span> </label>
                                            <input class="form-control" name="submodulePageActive" placeholder="e.g routePageActive" id="submodulePageActive" value="{{ ((isset($editSubModule)) ? $editSubModule->submodule_active_page : old('submodulePageActive')) }}">
                                            @if ($errors->has('submodulePageActive'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('submodulePageActive') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label> SubModule Icon </label>
                                            <input type="text" value="{{ ((isset($editSubModule)) ? $editSubModule->submodule_icon : old('submoduleIcon')) }}" placeholder="fa fa-star" class="form-control" name="submoduleIcon" id="submoduleIcon">
                                            @if ($errors->has('submoduleIcon'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('submoduleIcon') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div><!--//row-->

                                </div>

                                <div class="mt-3">
                                    <div class="px-3">
                                            <div class="">
                                                <div align="center" class="buttons-group">
                                                    <input type="hidden" name="editSubModuleID" value="{{ ((isset($editSubModule)) ? $editSubModule->submoduleID : '') }}" />
                                                    @if(isset($editSubModule))
                                                    <a href="{{ route('cancelEditSubModule') }}"  class="btn btn-sm btn-warning">
                                                        <i class="fa fa-edit"></i> Cancel Edit
                                                    </a>
                                                    @endif
                                                    <button  id="checkFields" type="button" type="hidden" data-toggle="modal" data-backdrop="false" data-target="#confirmNewModule" class="btn btn-sm btn-success">
                                                        <i class="fa fa-check-square-o"></i> {{ __('Continue') }}
                                                    </button>
                                                </div>
                                            </div>
                                    </div>
                                    <hr />
                                </div>
                            </div><!--//card-->
                        </div><!--col-12-->
                    </div><!--//row-->

                    <!--Confirm operation  Modal -->
                    <div style="z-index: 9999;" class="modal fade text-left d-print-none" id="confirmNewModule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel12" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                <h5 class="modal-title text-white text-success" id="myModalLabel12"><i class="fa fa-star"></i> {{ __('Update/Add New SubModule')}}  </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                <h5 class="text-primary"><i class="fa fa-arrow-right"></i> {{ __('You are about adding new route submodule')}} </h5>
                                <p class="text-center text-warning">
                                    {{ __('Are you sure you want to continue with this operation ?')}}
                                </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn grey btn-outline-primary" data-dismiss="modal">    Cancel</button>
                                    <button type="submit" id="submitForm" class="btn btn-outline-success">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end Modal-->

                    </form>

                        <table class="table table-hover table-stripped table-responsive">
                            <thead class="text-left">
                                <tr class="bg-grey">
                                    <th>{{ __('S/N') }}</th>
                                    <th>{{ __('Module Name') }}</th>
                                    <th>{{ __('SubModule Name') }}</th>
                                    <th>{{ __('URL') }}</th>
                                    <th>{{ __('Rank') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Icon') }}</th>
                                    <th>{{ __('Active Link') }}</th>
                                    <th>{{ __('Last Updated') }}</th>
                                    <th class="d-print-none" colspan="2"></th>
                                </tr>
                            </thead>
                            <tbody class="text-left">
                                @php $serialNo = 1; @endphp
                                @forelse($allModuleLoop as $moduleKey=>$listModule)
                                <tr>
                                    <th colspan="11" class="text-center text-info"><h5>{{ strtoupper($listModule->module_name) }}</h5></th>
                                </tr>
                                @forelse($allSubModule[$moduleKey] as $key=>$list)
                                <tr>
                                    <td>{{ $serialNo ++ }}</td>
                                    <td>{{ ($list->module_name) }}</td>
                                    <td>{{ __($list->submodule_name) }}</td>
                                    <td>{{ __($list->submodule_url) }}</td>
                                    <td>{{ __($list->submodule_rank) }}</td>
                                    <td>
                                        {!! __(($list->submodule_active) ? '<span class="text-success"><small>Enabled</small></span>' : '<span class="text-warning"><small>Disabled</small></span>' ) !!}
                                    </td>
                                    <td><i class="{{ $list->submodule_icon }}"></i></td>
                                    <td>{{ __($list->submodule_active_page) }}</td>
                                    <td>{{ __($list->submodule_updated_at) }}</td>
                                    <td class="d-print-none">
                                        <a href="{{ url('/edit/submodule/' . $list->submoduleID) }}" class=""><i class="fa fa-edit"></i></a>
                                    </td>
                                    <td class="d-print-none">
                                        <a href="javascript:;" data-toggle="modal" data-backdrop="false" data-target="#deleteModule{{$list->submoduleID}}"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                    <!-- Delete Modal -->
                                        <div style="z-index: 9999;" class="modal fade text-left d-print-none" id="deleteModule{{$list->submoduleID}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel12" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-light">
                                                    <h5 class="modal-title text-danger" id="myModalLabel12"><i class="fa fa-trash"></i> {{ __('Delete SubModule/URL!')}}  </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="text-center">  {!! __('Delete SubModule <span class="text-success"><b>' . $list->submodule_name .'</b></span>') !!} ! </div>
                                                        <h5><i class="fa fa-arrow-right"></i> {{ __('Are you sure you want to delete this record?')}} </h5>
                                                    <p>
                                                        <div class="text-danger text-center"> {{ __('You will not be able to recover this record again !')}} </div>
                                                    </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                                        <a href="{{ route('removeSubModule', [$list->submoduleID])}}" class="btn btn-outline-danger">{{ __('Delete') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!--end Modal-->
                                @empty
                                    <tr><td colspan="11" class="text-danger text-center">{{ __('No Submodule found!') }}</td></tr>
                                @endforelse

                                @empty
                                    <tr><td colspan="11" class="text-danger text-center">{{ __('No Module found!') }}</td></tr>
                                @endforelse
                                </tbody>
                            </table>

            </div><!--end content-wrapper-->
        </div><!--end main content-->

</div>
</div>
</div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function(){

        //check Module name
        $("#checkFields").click(function() {
            if(($("#moduleName").val()) == ''){
                alert('You have to select module name !');
                $("#moduleName").focus();
                return false;
            }
            if(($("#routeName").val()) == ''){
                alert('You have to enter route name !');
                $("#routeName").focus();
                return false;
            }
            //check Module URL
            if($("#routeUrl").val() == ''){
                alert('You have to enter route url !');
                $("#routeUrl").focus();
                return false;
            }
            //check Route Status
            if($("#routStatus").val() == ''){
                alert('Select route status !');
                $("#routStatus").focus();
                return false;
            }
        });

        $("#submitForm").click(function() {
            $('#submitModuleForm').submit();
        });
    });//end document
</script>
@endsection
