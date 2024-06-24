@section('search')

<main>
    <div class="container">
        <div class="mx-auto">
            <br>
            <h2 class="text-center bold-bk">ツイート検索</h2>
            <br>
            <!--検索フォーム-->
            <div class="row">
                <div class="col-sm">
                    <form method="GET" action="{{ route('searchTweet')}}">
                        <div class="form-group row">
                            <label class="col-form-label  bold-bk">ツイートをあいまい検索できます</label>

                            <div>
                            <!--入力-->
                                <div class="col-sm-5">
                                    <input type="text" class="form-control form-width" name="searchWord" value="{{ $searchWord }}">
                                </div>
                            <div class="col-sm-auto">
                                <button type="submit" class="btn btn-primary">検索</button>
                            </div>
                        </div>     
                    </form>
                </div>
            </div>
        </div>
@endsection
