<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;

/**
 * ユーザーサービスクラス
 */
class UserService
{
    public function index()
    {
        return ['users' => User::all()];
    }

    /**
     * ユーザー新規登録
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request): void
    {
        DB::transaction(function () use ($request) {
            // ユーザー登録
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_admin' => $request->is_admin,
            ]);
        });
    }

    /**
     * ユーザー修正
     *
     * @param Request $request
     * @param int $userId
     * @return void
     */
    public function update(Request $request, int $userId): void
    {
        DB::transaction(function () use ($request, $userId) {
            // ユーザー更新
            User::where('id', '=', $userId)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'is_admin' => $request->is_admin,
                ]);
        });
    }

    /**
     * ユーザー削除
     *
     * @param int $userId
     * @return void
     */
    public function delete(int $userId): void
    {
        // 削除ユーザーがログイユーザーかチェック
        if (Auth::id() === $userId) {
            throw new Exception('ログインユーザーは削除できません。');
        }
        User::find($userId)->delete();
    }
}
