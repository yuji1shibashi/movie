<!DOCTYPE html>
<html lang="ja">
    @include('layouts.head')
    <body>
        @include('layouts.header')
        <main>
            <div class="list-area">
                @include('layouts.alert')
                @include('layouts.error')
                <button type="button" id="createBtn" class="btn btn-dark userCreateBtn">新規作成</button>
                <table class="table w90per ma">
                    <thead>
                        <tr>
                            <th>ユーザー名</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr data-id="{{ $user->id }}"
                                data-name="{{ $user->name }}"
                                data-email="{{ $user->email }}"
                                data-is_admin="{{ $user->is_admin }}"
                            >
                                <td>{{ $user->name }}</td>
                                <td><button type="button" class="userDetailBtn btn btn-primary w60px">詳細</button></td>
                                <td><button type="button" class="userEditBtn btn btn-success w60px">編集</button></td>
                                <td><button type="button" class="userDeleteBtn btn btn-danger w60px">削除</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- ユーザー詳細画面 -->
            <div class="detail-area">
                <div id="displayUserDetail" class="w100per">
                    <div class="w55per disib vat ml20">
                        <table id="detailTable" class="table">
                            <tr>
                                <th class="w40per">名前</th>
                                <td id="userDetailName" class="w70per"></td>
                            </tr>
                            <tr>
                                <th class="w40per">メールアドレス</th>
                                <td id="userDetailEmail" class="w70per"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- ユーザー入力画面 -->
                <div id="displayUserInput" class="w90per">
                    <form id="userForm" action="" method="post">
                        @csrf
                        <input type="hidden" name="userId" id="inputUserId">
                        <div class="mb-3">
                            <label class="form-label">名前：</label>
                            <input type="text" name="name" id="inputUserName" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">メールアドレス</label>
                            <input type="text" name="email" id="inputUserEmail" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">パスワード：</label>
                            <input type="password" name="password" id="inputUserPassword" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">パスワード確認：</label>
                            <input type="password" name="password_confirmation" id="inputUserPasswordConfirmation" class="form-control">
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_admin" id="inputUserisAdmin1" value="1">
                            <label class="form-check-label" for="inputUserisAdmin1">管理者</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_admin" id="inputUserisAdmin2" value="0">
                            <label class="form-check-label" for="inputUserisAdmin2">一般</label>
                        </div>
                        <div class="mb-3 mt20">
                            <input id="inputUserSubmit" type="submit" class="btn btn-dark">
                        </div>
                    </form>
                </div>
                <form id="userdeleteForm" action="" method="post">@csrf</form>
            </div>
        </main>
    </body>
</html>