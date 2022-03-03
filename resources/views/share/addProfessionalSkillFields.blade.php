    <div class="col-md-12">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="skillTitle h5"> Skill Title <span class="text-danger">*</span></label>
                <input type="text" name="skillTitle" value="{{ (isset($valueSkill) && $valueSkill) ? $valueSkill->skill_title : old('skillTitle') }}" required class="form-control @error('skillTitle') is-invalid @enderror" placeholder="Mass Communication">
                @error('skillTitle')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="efficiency h5"> Efficiency <span class="text-danger">*</span></label>
                <select name="efficiency" required class="form-control @error('efficiency') is-invalid @enderror basic-select">
                    <option value="">Select</option>
                    @for($per = 100; $per >= 1; $per --)
                        <option value="{{ $per }}" {{ (isset($valueSkill) && $valueSkill->efficiency == $per) ? 'selected' : '' }}> {{ $per }}% </option>
                    @endfor
                </select>
                @error('efficiency')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="yearOfExperience h5"> Year of Experience <span class="text-danger">*</span></label>
                <select name="yearOfExperience" required class="form-control @error('yearOfExperience') is-invalid @enderror basic-select">
                    <option value="">Select</option>
                    <option value="1" {{ (isset($valueSkill) && $valueSkill) ? 'selected' : '' }}>1 Year</option>
                    @for($per = 2; $per <= 100; $per ++)
                        <option value="{{ $per }}" {{ (isset($valueSkill) && $valueSkill->year_of_experience == $per) ? 'selected' : '' }}> {{ $per }} Years </option>
                    @endfor
                </select>
                @error('yearOfExperience')
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

