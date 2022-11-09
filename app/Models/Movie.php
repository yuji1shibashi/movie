<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Consts\Categories;

/**
 * 映画モデルクラス
 */
class Movie extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * 複数代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'category_id',
        'image_id',
        'comment'
    ];

    /**
     * 映画一覧取得
     *
     * @return Collection
     */
    public static function list()
    {
        return self::select(
                'm.id',
                'm.name AS movie_name',
                'm.category_id',
                'm.comment',
                'm.image_id',
                'i.name AS image_name',
                'i.path'
            )
            ->selectRaw(self::getCategoryNameCaseSql())
            ->from('movies AS m')
            ->leftjoin('images AS i', 'i.id', '=', 'm.image_id')
            ->withTrashed()
            ->whereNull('m.deleted_at')
            ->get();
    }

    /**
     * 対象映画取得
     *
     * @param int $movieId
     * @return Collection
     */
    public static function find(int $movieId)
    {
        return self::select(
                'm.id',
                'm.name AS movie_name',
                'm.category_id',
                'm.comment',
                'm.image_id',
                'i.name AS image_name',
                'i.path'
            )
            ->from('movies AS m')
            ->leftjoin('images AS i', 'i.id', '=', 'm.image_id')
            ->withTrashed()
            ->whereNull('m.deleted_at')
            ->where('m.id', '=', $movieId)
            ->first();
    }

    /**
     * 映画存在チェック
     *
     * @param int $movieId
     * @return Collection
     */
    public static function existMovie(int $movieId)
    {
        return self::selectRaw('COUNT(*) AS exist_movie')
            ->withTrashed()
            ->whereNull('deleted_at')
            ->where('id', '=', $movieId)
            ->first();
    }

    /**
     * カテゴリ名ケース文を取得
     *
     * @return string
     */
    private static function getCategoryNameCaseSql(): string
    {
        $when = [];

        // カテゴリの数だけケースパターン作成
        foreach (Categories::LIST as $id => $name) {
            $when[] = " WHEN m.category_id = {$id} THEN '{$name}'";
        }
        return 'CASE' . implode(' ', $when) . ' ELSE "" END as category_name';
    }
}
