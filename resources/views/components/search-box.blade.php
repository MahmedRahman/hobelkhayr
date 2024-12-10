<div class="mb-3">
    <form action="" method="GET" class="d-flex align-items-center">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by phone number..." value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Search</button>
            @if(request('search'))
                <a href="{{ url()->current() }}" class="btn btn-secondary">Clear</a>
            @endif
        </div>
    </form>
</div>
