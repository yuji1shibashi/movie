<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MovieRequest;
use App\Http\Services\MovieService;
use Exception;

/**
 * 映画コントローラークラス
 */
class MovieController extends Controller
{
    /**
     * 映画サービス
     *
     * @var MovieService
     */
    private $service;

    /**
     * construct
     *
     * @param MovieService $service
     * @return void
     */
    public function __construct(MovieService $service)
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
        return view('movie.list', $data);
    }

    /**
     * 映画新規登録
     *
     * @param MovieRequest $request
     * @return \Illuminate\Routing\Redirector
     */
    public function create(MovieRequest $request)
    {
        try {
            $this->service->create($request);
            $request->session()->flash('successMessage', '登録に成功しました。');
        } catch (Exception $e) {
            $request->session()->flash('errorMessage', '登録に失敗しました。');
        } finally {
            return redirect('movie/list');
        }
    }

    /**
     * 映画更新
     *
     * @param MovieRequest $request
     * @param int $movieId
     * @return \Illuminate\Routing\Redirector
     */
    public function update(MovieRequest $request, int $movieId)
    {
        try {
            $this->service->update($request, $movieId);
            $request->session()->flash('successMessage', '更新に成功しました。');
        } catch (Exception $e) {
            $request->session()->flash('errorMessage', '更新に失敗しました。');
        } finally {
            return redirect('movie/list');
        }
    }

    /**
     * 映画削除
     *
     * @param Request $request
     * @param int $movieId
     * @return \Illuminate\Routing\Redirector
     */
    public function delete(Request $request, int $movieId)
    {
        try {
            $this->service->delete($movieId);
            $request->session()->flash('successMessage', '削除に成功しました。');
        } catch (Exception $e) {
            $request->session()->flash('errorMessage', '削除に失敗しました。');
        } finally {
            return redirect('movie/list');
        }
    }

    /**
     * 映画を投票する
     *
     * @param Request $request
     * @return void
     */
    public function vote(Request $request)
    {
        try {
            $this->service->vote($request);
            $request->session()->flash('successMessage', '投票に成功しました。');
        } catch (Exception $e) {
            $errorMessage = ($e->getMessage() !== '') ? $e->getMessage() : '投票に失敗しました。';
            $request->session()->flash('errorMessage', $errorMessage);
        } finally {
            return redirect('movie/list');
        }
    }
}
