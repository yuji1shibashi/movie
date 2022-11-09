<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Consts\Rank;

/**
 * 投票モデルクラス
 */
class Vote extends Model
{
    use HasFactory;

    /**
     * 複数代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'movie_id',
        'rank'
    ];

    /**
     * 対象ユーザーが投票した映画を取得
     *
     * @param int $userId
     * @return Collection
     */
    public static function getVoteByUserId(int $userId)
    {
        return self::select()
            ->from('votes AS v')
            ->join('movies AS m', 'm.id', '=', 'v.movie_id')
            ->where('v.user_id', '=', $userId)
            ->get();
    }

    /**
     * 映画投票数集計結果取得
     *
     * @return Collection
     */
    public static function aggregateMovieVote()
    {
        return self::select('m.name AS movie_name')
            ->selectRaw('CONCAT("/storage/", i.path) AS path')
            ->selectRaw('
                COUNT(case v.rank when ? then v.rank else null end) AS first,
                COUNT(case v.rank when ? then v.rank else null end) AS second,
                COUNT(case v.rank when ? then v.rank else null end) AS third
            ', [Rank::RANK_FIRST, Rank::RANK_SECOND, Rank::RANK_THIRD])
            ->from('votes AS v')
            ->join('movies AS m', 'm.id', '=', 'v.movie_id')
            ->leftjoin('images AS i', 'i.id', '=', 'm.image_id')
            ->whereNull('m.deleted_at')
            ->groupByRaw('movie_name, i.path')
            ->get();
    }

    /**
     * 映画重複投票チェック
     *
     * @param int $userId
     * @param int $movieId
     * @return Collection
     */
    public static function isMovieDuplicateVotedUser(int $movieId, int $userId)
    {
        return self::selectRaw('COUNT(*) AS is_voted')
            ->where('movie_id', '=', $movieId)
            ->where('user_id', '=', $userId)
            ->first();
    }

    /**
     * 映画３回投票済チェック
     *
     * @param int $userId
     * @return Collection
     */
    public static function isMovieThreeTimesVotedUser(int $userId)
    {
        return self::selectRaw('COUNT(*) AS voted_num')
            ->where('user_id', '=', $userId)
            ->first();
    }
}
