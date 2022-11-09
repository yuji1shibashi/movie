<!DOCTYPE html>
<html lang="ja">
    @include('layouts.head')
    <body>
        @include('layouts.header')
        <main>
            <div class="list-area">
                @include('layouts.alert')
                @include('layouts.error')
                <button type="button" id="createBtn" class="btn btn-dark movieCreateBtn">新規作成</button>
                <table class="table w90per ma">
                    <thead>
                        <tr>
                            <th>映画名</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($movies as $movie)
                            <tr data-id="{{ $movie->id }}"
                                data-name="{{ $movie->movie_name }}"
                                data-image_id="{{ $movie->image_id }}"
                                data-path="{{ isset($movie->path) ? \Storage::url($movie->path) : "/img/no_image.jpg" }}"
                                data-category_id="{{ $movie->category_id }}"
                                data-category_name="{{ $movie->category_name }}"
                                data-comment="{{ $movie->comment }}"
                            >
                                <td>{{ $movie->movie_name }}</td>
                                <td><button type="button" class="movieDetailBtn btn btn-primary w60px">詳細</button></td>
                                <td><button type="button" class="movieEditBtn btn btn-success w60px">編集</button></td>
                                <td><button type="button" class="movieDeleteBtn btn btn-danger w60px">削除</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- 映画詳細画面 -->
            <div class="detail-area">
                <div id="displayMovieDetail" class="w100per">
                    <div class="w40per disib">
                        <img id="movieDetailImage" class="w100per">
                    </div>
                    <div class="w55per disib vat ml20">
                        <table id="detailTable" class="table">
                            <tr>
                                <th class="w20per">名前</th>
                                <td id="movieDetailName" class="w70per"></td>
                            </tr>
                            <tr>
                                <th class="w20per">カテゴリー</th>
                                <td id="movieDetailCategoryName" class="w70per"></td>
                            </tr>
                            <tr>
                                <th class="w20per">備考</th>
                                <td id="movieDetailComment" class="w70per"></td>
                            </tr>
                        </table>
                        <button type="button" class="btn btn-dark mb50" data-bs-toggle="modal" data-bs-target="#movieVoteModal">この映画に投票する</button>
                    </div>
                </div>
                <!-- 映画入力画面 -->
                <div id="displayMovieInput" class="w90per">
                    <form id="movieForm" action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">名前：</label>
                            <input type="text" name="name" id="inputMovieName" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">画像：</label>
                            <input type="file" name="image" id="inputMovieImage" class="form-control">
                            <input type="hidden" name="image_id" id="inputMovieImageId">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">カテゴリ：</label>
                            <select name="category_id" id="inputMovieCategory" class="form-select">
                                <option value="">未選択</option>
                                @foreach(\App\Consts\Categories::LIST as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">備考：</label>
                            <textarea name="comment" id="inputMovieComment" class="form-control h300px"></textarea>
                        </div>
                        <input id="inputMovieSubmit" type="submit" class="btn btn-dark">
                    </form>
                </div>
                <form id="moviedeleteForm" action="" method="post">@csrf</form>
                <!-- モーダル -->
                <div class="modal fade" id="movieVoteModal" tabindex="-1" aria-labelledby="movieVoteModalLabel" aria-hidden="true">
                    <div class="modal-dialog wmmodal">
                        <div class="modal-content wmodal">
                            <form id="voteForm" action="/movie/vote" method="post">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="movieVoteModalLabel">投票</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="movie_id" id="modalMovieId">
                                    <h5>投票映画名：<span id="modalMovieTitle"></span></h5>
                                    @foreach ($votes as $rank => $vote)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="rank" id="rank{{ $rank }}" {{ $vote['disabled'] }} value="{{ $rank }}">
                                            <label class="form-check-label" for="rank{{ $rank }}">
                                                {{ $rank }}位：<span>{{ $vote['name'] }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                    <div class="description">※各順位に対して１度のみ投票が可能です。</div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                                    <button type="submit" id="voteBtn" class="btn btn-primary">投票する</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>