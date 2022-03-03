    <div class="col-md-12">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="jobTitle h5"> Job Title <span class="text-danger">*</span></label>
                <input type="text" name="jobTitle" value="{{ (isset($valueWork) && $valueWork) ? $valueWork->job_title : old('jobTitle') }}" required class="form-control @error('jobTitle') is-invalid @enderror" placeholder="UI/UX Developer">
                @error('jobTitle')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="companyName h5"> Company Name <span class="text-danger">*</span></label>
                <input typ="text" name="companyName" value="{{ (isset($valueWork) && $valueWork) ? $valueWork->company_name : old('companyName') }}" required class="form-control @error('companyName') is-invalid @enderror" placeholder="XYZ company limited" />
                @error('companyName')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="dateStarted"> From <span class="text-danger">*</span> </label>
                <input type="date" name="dateStarted" value="{{ (isset($valueWork) && $valueWork) ? $valueWork->date_started : old('dateStarted') }}" max="{{date('Y-m-d')}}" required class="form-control @error('dateStarted') is-invalid @enderror">
                @error('dateStarted')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="dateStop"> To  <span class="text-danger">*</span> </label>
                <input type="date" name="dateStop" value="{{ (isset($valueWork) && $valueWork) ? $valueWork->date_stop : old('dateStop') }}" required class="form-control @error('dateStop') is-invalid @enderror">
                @error('dateStop')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="jobDescription"> Job Description  <span class="text-danger">*</span> </label>
                <textarea name="jobDescription" required class="form-control @error('jobDescription') is-invalid @enderror">{{ (isset($valueWork) && $valueWork) ? $valueWork->job_description : old('jobDescription')}}</textarea>
                @error('jobDescription')
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

