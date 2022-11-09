<?php

namespace App\Http\Services;

use App\Consts\Rank;
use App\Models\Vote;

/**
 * ランキングサービスクラス
 */
class RankingService
{
    /**
     * ランキング画面
     *
     * @return array
     */
    public function index(): array
    {
        return [
            'rankingList' => $this->getMovieRanking()
        ];
    }

    /**
     * 映画ランキングを集計する
     *
     * @return void
     */
    private function getMovieRanking()
    {
        // 投票数を集計
        $aggregateList = Vote::aggregateMovieVote();

        // 集計結果が存在しない場合はランキングの初期値を返す
        if ($aggregateList->isEmpty()) {
            return $this->getRankingFormat();
        }
        // 投票ポイントを計算
        $aggregateList = $this->calcPoint($aggregateList->toArray());
        // 投票ポイントの多い順にソート
        $aggregateList = $this->sortDescByPoints($aggregateList);
        // 投票ポイント総ポイント数上位3位に絞り込んで返す
        return $this->filterUpperThirdRank($aggregateList);
    }

    /**
     * ランキングフォーマット取得
     *
     * @return array
     */
    private function getRankingFormat(): array
    {
        $format = [];

        foreach (Rank::LIST as $rank) {
            $format[] = [
                'rank' => $rank['rank'] . '位',
                'color' => $rank['color'],
                'name' => $rank['rank'] . '位の結果が存在しません',
                'image' => '/img/no_image.jpg',
                'point' => 0,
            ];
        }
        return $format;
    }

    /**
     * ポイントを計算する
     *
     * @param array $aggregateList
     * @return array
     */
    private function calcPoint(array $aggregateList): array
    {
        foreach ($aggregateList as $index => $aggregate) {
            // 1位投票ポイント
            $aggregateList[$index]['point'] = $aggregate['first'] * Rank::POINT_FIRST;
            // 2位投票ポイント
            $aggregateList[$index]['point'] += $aggregate['second'] * Rank::POINT_SECOND;
            // 3位投票ポイント
            $aggregateList[$index]['point'] += $aggregate['third'] * Rank::POINT_THIRD;
        }
        return $aggregateList;
    }

    /**
     * ランキング上位3位まで絞り込む
     *
     * @param array $aggregateList
     * @return array
     */
    private function filterUpperThirdRank(array $aggregateList): array
    {
        $ranking = [];

        // ポイントの高い順に並び変える
        $pointList = array_unique(array_column($aggregateList, 'point'));
        rsort($pointList);

        foreach (Rank::LIST as $index => $rank) {
            foreach ($aggregateList as $aggregate) {
                // 順位が存在しないまたは、順位に当てはまらない順位は除外
                if (!isset($pointList[$index]) || $aggregate['point'] !== $pointList[$index]) {
                    continue;
                }
                // ランキング結果を格納する
                $ranking[] = [
                    'rank' => $rank['rank'] . '位',
                    'color' => $rank['color'],
                    'name' => $aggregate['movie_name'],
                    'image' => $aggregate['path'],
                    'point' => $aggregate['point'],
                ];
            }
        }
        return $ranking;
    }

    /**
     * 投票ポイントの多い順にソート
     *
     * @param array $aggregateList
     * @return array
     */
    private function sortDescByPoints(array $aggregateList): array
    {
        // ポイントを抽出
        $sort_keys = array_column($aggregateList, 'point');
        // 投票ポイントの多い順にソート
        array_multisort($sort_keys, SORT_DESC, $aggregateList);
        return $aggregateList;
    }
}
