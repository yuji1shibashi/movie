<?php

namespace App\Consts;

/**
 * 順位
 */
class Rank
{
    /**
     * @var int １位
     */
    const RANK_FIRST = 1;

    /**
     * @var int ２位
     */
    const RANK_SECOND = 2;

    /**
     * @var int ３位
     */
    const RANK_THIRD = 3;

    /**
     * @var int １位_３ポイント
     */
    const POINT_FIRST = 3;

    /**
     * @var int ２位_２ポイント
     */
    const POINT_SECOND = 2;

    /**
     * @var int ３位_１ポイント
     */
    const POINT_THIRD = 1;

    /**
     * @var int １位_カラー
     */
    const COLOR_FIRST = 'rank-first';

    /**
     * @var int ２位_カラー
     */
    const COLOR_SECOND = 'rank-second';

    /**
     * @var int ３位_カラー
     */
    const COLOR_THIRD = 'rank-third';

    /**
     * @var array 順位に紐づく情報一覧
     */
    const LIST = [
        ['rank' => self::RANK_FIRST, 'color'=> self::COLOR_FIRST],
        ['rank' => self::RANK_SECOND, 'color'=> self::COLOR_SECOND],
        ['rank' => self::RANK_THIRD, 'color'=> self::COLOR_THIRD]
    ];
}
