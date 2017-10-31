<div class="error_box">
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
<div class="message_box">
    @if (Session::has('message'))
        <!-- will be used to show any messages -->
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
</div>
