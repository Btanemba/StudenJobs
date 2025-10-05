@extends(backpack_view('blank'))

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h2>Send Email to {{ $entry->email }}</h2>

        <form method="post" action="{{ url($crud->route.'/'.$entry->getKey().'/email') }}">
            @csrf
            <div class="form-group">
                <label>Subject</label>
                <input type="text" name="subject" class="form-control" value="{{ old('subject') }}">
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea name="message" rows="6" class="form-control">{{ old('message') }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">
                <i class="la la-paper-plane"></i> Send
            </button>
            <a href="{{ url($crud->route) }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
