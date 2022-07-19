@extends('layouts.app')

@extends('layouts.link')

@extends('layouts.searchUser')

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
                    <form method="GET" action="{{ route('searchUser')}}">
                        <div class="form-group row">
                        <label class="col-sm-2 col-form-label">name</label>
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

        @if (!empty($users))
        <div class="productTable">
            <p>全{{ $users->count() }}件</p>
            <table class="table table-hover">
                <thead style="background-color: #ffd900">
                    <tr>
                        <th style="width:50%">ユーザーネーム</th>
                        <th>ユーザー画面リンク</th>
                    </tr>
                </thead>

                @foreach($users as $user)
                <tr>
                    <td>{{ $user->screen_name }}</td>
                    <td><a href= "{{ route('users.show', $user->id) }}" class="btn btn-primary btn-sm">該当ユーザーへ</a></td>
                </tr>
                @endforeach   
            </table>
        </div>
        <!--テーブルここまで-->
        <!--ページネーション-->
        <div class="d-flex justify-content-center">
            {{-- appendsでカテゴリを選択したまま遷移 --}}
            {{ $users->appends(request()->input())->links() }}
        </div>
        <!--ページネーションここまで-->
        @endif
    </div>
</main>

@endsection
