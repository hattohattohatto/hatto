@extends('layouts.app')

@extends('layouts.link')

@extends('layouts.searchUser')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach ($allUsers as $user)
                    <div class="card">
                        <div class="card-haeder p-3 w-100 d-flex">
                            <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" class="rounded-circle" width="50" height="50">
                            <div class="ml-2 d-flex flex-column">
                                <p class="mb-0">{{ $user->name }}</p>
                                <a href="{{ route('users.show', $user->id) }}" class="text-secondary">{{ $user->screen_name }}</a>
                            </div>
                            @if (auth()->user()->isFollowed($user->id))
                                <div class="px-2">
                                    <span class="px-1 bg-secondary text-light">フォローされています</span>
                                </div>
                            @endif
                            <div class="d-flex justify-content-end flex-grow-1">
                                @if (auth()->user()->isFollowing($user->id))
                                    <span class="follow">
                                        @csrf

                                        <button type="submit" class="btn btn-danger follow-toggle follow{{ $user->id }}" data-follow-review-id="{{ $user->id }}" id="followBtn{{ $user->id }}">フォロー解除</button>
                                    </span>
                                @else
                                    <span class="follow">
                                        @csrf

                                        <button type="submit" class="btn btn-primary follow-toggle follow{{ $user->id }}" data-follow-review-id="{{ $user->id }}" id="followBtn{{ $user->id }}">フォローする</button>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="my-4 d-flex justify-content-center">
            {{ $allUsers->links() }}
        </div>
    </div>
@endsection
<script src ="{{ asset('/js/follow.js/') }}" defer></script>
