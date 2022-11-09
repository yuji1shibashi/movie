<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Consts\Rank;
use App\Models\Movie;
use App\Models\Image;
use App\Models\Vote;
use Exception;

/**
 * 映画サービスクラス
 */
class MovieService
{
    /**
     * 映画一覧画面
     *
     * @return array
     */
    public function index(): array
    {
        return [
            'movies' => Movie::list(),
            'votes' => $this->getVoteByUserId()
        ];
    }

    /**
     * 映画新規登録
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request): void
    {
        DB::transaction(function () use ($request) {
            // 映画画像をアップロード
            $imageId = $this->uplodeImage($request);
            // 映画登録
            Movie::create([
                'name' => $request->input('name'),
                'category_id' => $request->input('category_id'),
                'image_id' => $imageId,
                'comment' => $request->input('comment')
            ]);
        });
    }

    /**
     * 映画修正
     *
     * @param Request $request
     * @param int $movieId
     * @return void
     */
    public function update(Request $request, int $movieId): void
    {
        DB::transaction(function () use ($request, $movieId) {
            // 映画画像をアップロード
            $imageId = $this->uplodeImage($request);

            // 映画更新
            Movie::where('id', '=', $movieId)
                ->update([
                    'name' => $request->input('name'),
                    'category_id' => $request->input('category_id'),
                    'image_id' => $imageId,
                    'comment' => $request->input('comment')
                ]);
        });
    }

    /**
     * 映画削除
     *
     * @param int $movieId
     * @return void
     */
    public function delete(int $movieId): void
    {
        Movie::find($movieId)->delete();
    }

    /**
     * 映画を投票する
     *
     * @param Request $request
     * @return void
     */
    public function vote(Request $request): void
    {
        // 映画３回投票済チェック
        if ($this->isMovieThreeTimesVotedUser()) {
            throw new Exception('既に３回投票しているため新たに投票ができません。');
        }

        // 順位選択チェック
        if (empty($request->input('rank'))) {
            throw new Exception('順位が選択されていません。');
        }

        // 映画存在チェック
        if (!$this->existMovie($request->input('movie_id'))) {
            throw new Exception('投票対象の映画が存在しません。');
        }

        // 映画重複投票チェック
        if ($this->isMovieDuplicateVotedUser($request->input('movie_id'))) {
            throw new Exception('既に投票している映画です。');
        }


        // 映画登録
        Vote::create([
            'user_id' => Auth::id(),
            'movie_id' => $request->input('movie_id'),
            'rank' => $request->input('rank')
        ]);
    }

    /**
     * 画像アップロード
     *
     * @param Request $request
     * @return int|null
     */
    private function uplodeImage(Request $request): ?int
    {
        $imageId = $request->input('image_id');
        $uploadImage = $request->file('image');

        // 画像アップロードがされている場合
        if (isset($uploadImage)) {
            $path = $uploadImage->store('images',"public");
            // 画像アップロードに成功した場合はDBに登録
            if (isset($path)) {
                $image = Image::create([
                    'name' => $uploadImage->getClientOriginalName(),
                    'path' => $path
                ]);
                $imageId = $image->id;
            }
        }
        return $imageId;
    }

    /**
     * 対象ユーザーが投票した映画を取得
     *
     * @return array
     */
    private function getVoteByUserId(): array
    {
        $formatVotes = [
            Rank::RANK_FIRST => ['name' => '未投票', 'disabled' => ''],
            Rank::RANK_SECOND => ['name' => '未投票', 'disabled' => ''],
            Rank::RANK_THIRD => ['name' => '未投票', 'disabled' => '']
        ];
        $votes = Vote::getVoteByUserId(Auth::id());

        foreach ($votes as $vote) {
            $formatVotes[$vote->rank]['name'] = $vote->name;
            $formatVotes[$vote->rank]['disabled'] = 'disabled';
        }
        return $formatVotes;
    }

    /**
     * 映画存在チェック
     *
     * @param int $movieId
     * @return bool
     */
    private function existMovie($movieId) : bool
    {
        $movie = Movie::existMovie($movieId);
        return ($movie->exist_movie === 1) ? true : false;
    }


    /**
     * 映画重複投票チェック
     *
     * @param int $movieId
     * @return bool
     */
    private function isMovieDuplicateVotedUser($movieId) : bool
    {
        $vote = Vote::isMovieDuplicateVotedUser($movieId, Auth::id());
        return ($vote->is_voted >= 1) ? true : false;
    }

    /**
     * 映画３回投票済チェック
     *
     * @return bool
     */
    private function isMovieThreeTimesVotedUser() : bool
    {
        $vote = Vote::isMovieThreeTimesVotedUser(Auth::id());
        return ($vote->voted_num >= 3) ? true : false;
    }
}
