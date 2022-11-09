<?php

namespace App\Consts;

/**
 * カテゴリ
 */
class Categories
{
    /**
     * @var int ID_アクション
     */
    const ID_ACTION = 1;

    /**
     * @var int ID_アニメ
     */
    const ID_ANIME = 2;

    /**
     * @var int ID_恋愛
     */
    const ID_LOVE = 3;

    /**
     * @var int ID_ファンタジー
     */
    const ID_FANTASY = 4;

    /**
     * @var int ID_ホラー
     */
    const ID_HORROR = 5;

    /**
     * @var string アクション
     */
    const NAME_ACTION = 'アクション';

    /**
     * @var string アニメ
     */
    const NAME_ANIME = 'アニメ';

    /**
     * @var string 恋愛
     */
    const NAME_LOVE = '恋愛';

    /**
     * @var string ファンタジー
     */
    const NAME_FANTASY = 'ファンタジー';

    /**
     * @var string ホラー
     */
    const NAME_HORROR = 'ホラー';

    /**
     * @var array カテゴリ一覧
     */
    const LIST = [
        self::ID_ACTION => self::NAME_ACTION,
        self::ID_ANIME => self::NAME_ANIME,
        self::ID_LOVE => self::NAME_LOVE,
        self::ID_FANTASY => self::NAME_FANTASY,
        self::ID_HORROR => self::NAME_HORROR
    ];
}
