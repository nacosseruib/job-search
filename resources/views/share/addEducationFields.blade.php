    <div class="col-md-12">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="certificateTitle h5"> Certificate Title <span class="text-danger">*</span></label>
                <select name="certificateTitle" required class="form-control @error('certificateTitle') is-invalid @enderror">
                    <option value="">Select</option>
                    @if(isset($certificateTitle) && $certificateTitle)
                        @foreach($certificateTitle as $certificate)
                            <option value="{{ $certificate->certificateID }}" {{ ( ((isset($value) && $value) ? $value->certificate_titleID : old('certificateTitle')) == $certificate->certificateID ? 'selected' : '') }}>{{ $certificate->certificate_name }}</option>
                        @endforeach
                    @endif
                </select>
                @error('certificateTitle')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="courseTitle h5"> Course Title <span class="text-danger">*</span></label>
                <input typ="text" name="courseTitle" value="{{ (isset($value) && $value) ? $value->course_title : old('courseTitle') }}" required class="form-control @error('courseTitle') is-invalid @enderror" placeholder="E.g Computer Science" />
                @error('courseTitle')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="dateStarted"> From <span class="text-danger">*</span> </label>
                <input type="date" name="dateStarted" value="{{ (isset($value) && $value) ? $value->date_started : old('dateStarted') }}" max="{{date('Y-m-d')}}" required class="form-control @error('dateStarted') is-invalid @enderror basic-select">
                @error('dateStarted')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="dateCompleted"> To  <span class="text-danger">*</span> </label>
                <input type="date" name="dateCompleted" value="{{ (isset($value) && $value) ? $value->date_completed : old('dateCompleted') }}" required class="form-control @error('dateCompleted') is-invalid @enderror basic-select">
                @error('dateCompleted')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="institute"> Institute  <span class="text-danger">*</span> </label>
                <input type="text"  name="institute" value="{{ (isset($value) && $value) ? $value->institution : old('institute')}}"  required class="form-control @error('institute') is-invalid @enderror" placeholder="University of Lagos">
                @error('institute')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="grade"> Grade/Class  </label>
                <select name="grade" class="form-control @error('grade') is-invalid @enderror basic-select">
                    <option value="" selected="selected">Select</option>
                    @if(isset($grade) && $grade)
                        @foreach($grade as $gradeOrClass)
                            <option value="{{ $gradeOrClass->gradeID  }}" {{ ( ((isset($value) && $value) ? $value->grade_id : old('grade')) == $gradeOrClass->gradeID ? 'selected' : '') }} >{{ $gradeOrClass->grade_name }}</option>
                        @endforeach
                    @endif
                </select>
                @error('grade')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12" align="right">
                <button type="submit" class="btn btn-md ml-sm-auto btn-primary">Save/Update</button>
            </div>
        </div>
    </div>

