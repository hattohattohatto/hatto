@section('link')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-3 text-center  space">
            <a class="bold h4" href="{{ route('users.index') }}">ユーザ一覧 <i class="fas fa-users" class="fa-fw"></i> </a>
        </div>

        <div class="col-md-8 mb-3 text-center  space">
            <a class="bold h4" href="{{ route('tweets.index') }}">タイムライン <i class="fas fa-home" class="fa-fw"></i> </a>
        </div>
    </div>
</div>

@endsection
