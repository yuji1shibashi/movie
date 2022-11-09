<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\RankingService;

/**
 * ランキングコントローラークラス
 */
class RankingController extends Controller
{
    /**
     * ランキングサービス
     *
     * @var RankingService
     */
    private $service;

    /**
     * construct
     *
     * @param MovieService $service
     * @return void
     */
    public function __construct(RankingService $service)
    {
        $this->service = $service;
    }

    /**
     * 映画一覧画面
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data = $this->service->index();
        return view('ranking.detail', $data);
    }
}
