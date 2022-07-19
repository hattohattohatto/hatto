@extends('layouts.app')

@section('content')

<main>
    <div class="container">
        <div class="mx-auto">
            <br>
            <h2 class="text-center"></h2>
            <br>
            <!--検索フォーム-->
            <div class="row">
                <div class="col-sm">
                    <form method="GET" action="{{ route('searchTweet')}}">
                        <div class="form-group row">
                        <label class="col-sm-2 col-form-label">ツイート</label>
                        <!--入力-->
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="searchWord" value="{{ $searchWord }}">
                        </div>
                        <div class="col-sm-auto">
                            <button type="submit" class="btn btn-primary ">検索</button>
                        </div>
                        </div>     
                    </form>
                </div>
            </div>
        </div>

        @if (!empty($tweets))
        <div class="productTable">
            <p>全{{ $tweets->count() }}件</p>
            <table class="table table-hover">
                <thead style="background-color: #ffd900">
                    <tr>
                        <th style="width:50%">ツイート内容</th>
                        <th>ツイートしたユーザー</th>
                        <th>ツイートリンク</th>
                    </tr>
                </thead>

                @foreach($tweets as $tweet)
                <tr>
                    <td>{{ $tweet->text }}</td>
                    <td>{{ $tweet->user->name }}</td>
                    <td><a href= "{{ route('tweets.show', $tweet->id) }}" class="btn btn-primary btn-sm">該当ツイートへ</a></td>
                </tr>
                @endforeach   
            </table>
        </div>
        <!--テーブルここまで-->
        <!--ページネーション-->
        <div class="d-flex justify-content-center">
            {{-- appendsでカテゴリを選択したまま遷移 --}}
            {{ $tweets->appends(request()->input())->links() }}
        </div>
        <!--ページネーションここまで-->
        @endif
    </div>
</main>


@endsection