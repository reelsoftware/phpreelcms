<div class="form-group">
    <label for="series_id">Link season to series</label><br>

    <select name="series_id" class="custom-select" id="series_id">
        @foreach ($series as $s)
            <option value="{{$s->id}}" @if (old('series_id') == $s->id || $content['series_id'] == $s->id) selected @endif>{{$s->title}}</option>   
        @endforeach
    </select>
</div>