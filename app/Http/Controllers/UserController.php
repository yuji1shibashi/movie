<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Services\UserService;
use Exception;

/**
 * ユーザーコントローラークラス
 */
class UserController extends Controller
{
    /**
     * ユーザーサービス
     *
     * @var UserService
     */
    private $service;

    /**
     * construct
     *
     * @param UserService $service
     * @return void
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * ユーザー一覧画面
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $data = $this->service->index();
        return view('user.list', $data);
    }

    /**
     * 映画新規登録
     *
     * @param CreateUserRequest $request
     * @return \Illuminate\Routing\Redirector
     */
    public function create(CreateUserRequest $request)
    {
        try {
            $this->service->create($request);
            $request->session()->flash('successMessage', '登録に成功しました。');
        } catch (Exception $e) {
            $request->session()->flash('errorMessage', '登録に失敗しました。');
        } finally {
            return redirect('user/list');
        }
    }

    /**
     * 映画更新
     *
     * @param UpdateUserRequest $request
     * @param int $userId
     * @return \Illuminate\Routing\Redirector
     */
    public function update(UpdateUserRequest $request, int $userId)
    {
        try {
            $this->service->update($request, $userId);
            $request->session()->flash('successMessage', '更新に成功しました。');
        } catch (Exception $e) {
            $request->session()->flash('errorMessage', '更新に失敗しました。');
        } finally {
            return redirect('user/list');
        }
    }

    /**
     * 映画削除
     *
     * @param Request $request
     * @param int $userId
     * @return \Illuminate\Routing\Redirector
     */
    public function delete(Request $request, int $userId)
    {
        try {
            $this->service->delete($userId);
            $request->session()->flash('successMessage', '削除に成功しました。');
        } catch (Exception $e) {
            $errorMessage = ($e->getMessage() !== '') ? $e->getMessage() : '削除に失敗しました。';
            $request->session()->flash('errorMessage', $errorMessage);
        } finally {
            return redirect('user/list');
        }
    }
}
