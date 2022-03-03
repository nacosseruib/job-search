    <div class="col-md-12">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="cvFile"> Select File <span class="text-danger">*</span> <small>Format: {{-- png, jpg, jpe, jpeg, doc, docx,  --}} pdf | Max:5MB</small></label>
                <input type="file" name="cvFile" required class="form-control @error('cvFile') is-invalid @enderror">
                @error('cvFile')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="fileDescription h5"> File Title/Description <span class="text-danger">*</span></label>
                <input typ="text" name="fileDescription" value="{{ (isset($valueCv) && $valueCv) ? $valueCv->file_description : old('fileDescription') }}" required class="form-control @error('fileDescription') is-invalid @enderror" placeholder="E.g My professional cv" />
                @error('fileDescription')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12" align="right">
                <button type="submit" class="btn btn-md ml-sm-auto btn-primary">Upload</button>
            </div>
        </div>
    </div>

