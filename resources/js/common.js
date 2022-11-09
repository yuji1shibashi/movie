/**
 * @var {object}
 */
let COMMON = {};
let MOVIE = {};
let USER = {};

$(document).ready(function() {

    // 初期化処理
    COMMON.init();

    /**
     * 映画新規作成ボタン押下処理
     */
    $('.movieCreateBtn').on('click', function() {
        // 映画新規作成画面初期化
        MOVIE.initMovieCreate();
        // 映画詳細画面を表示
        MOVIE.switchMovieDisplay('create');
    });

    /**
     * 映画編集ボタン押下処理
     */
     $('.movieEditBtn').on('click', function() {
        // 映画編集画面初期化
        MOVIE.initMovieEdit($(this).closest('tr').data());
        // 映画詳細画面を表示
        MOVIE.switchMovieDisplay('edit');
    });

    /**
     * 映画削除ボタン押下処理
     */
     $('.movieDeleteBtn').on('click', function() {
        // 映画削除処理
        MOVIE.deleteMovie($(this).closest('tr').data());
    });

    /**
     * 映画詳細ボタン押下処理
     */
    $('.movieDetailBtn').on('click', function() {
        // 選択対象の映画詳細セット
        MOVIE.setMovieDetail($(this).closest('tr').data());
        // 映画詳細画面を表示
        MOVIE.switchMovieDisplay('detail');
    });

    /**
     * ユーザー新規作成ボタン押下処理
     */
     $('.userCreateBtn').on('click', function() {
        // ユーザー新規作成画面初期化
        USER.initUserCreate();
        // ユーザー詳細画面を表示
        USER.switchUserDisplay('create');
    });

    /**
     * ユーザー編集ボタン押下処理
     */
     $('.userEditBtn').on('click', function() {
        // ユーザー編集画面初期化
        USER.initUserEdit($(this).closest('tr').data());
        // ユーザー詳細画面を表示
        USER.switchUserDisplay('edit');
    });

    /**
     * ユーザー削除ボタン押下処理
     */
     $('.userDeleteBtn').on('click', function() {
        // ユーザー削除処理
        USER.deleteUser($(this).closest('tr').data());
    });

    /**
     * ユーザー詳細ボタン押下処理
     */
    $('.userDetailBtn').on('click', function() {
        // 選択対象のユーザー詳細セット
        USER.setUserDetail($(this).closest('tr').data());
        // ユーザー詳細画面を表示
        USER.switchUserDisplay('detail');
    });
});

/**
 * 画面初期化処理
 *
 * @param {void}
 */
COMMON.init = function() {
    // 画面初期表示
    MOVIE.switchMovieDisplay();
    // 画面初期表示
    USER.switchUserDisplay();
}

/**
 * 映画新規作成画面初期化
 *
 * @return {void}
 */
MOVIE.initMovieCreate = function() {
    // アクション設定
    $('#movieForm').attr('action', '/movie/create');
    // 映画画画像
    $('#inputMovieImage').val(null);
    // 映画画像ID
    $('#inputMovieImageId').val(null);
    // 映画名
    $('#inputMovieName').val('');
    // 映画カテゴリー
    $('#inputMovieCategory').val('');
    // 映画備考
    $('#inputMovieComment').val('');
    // ボタン名
    $('#inputMovieSubmit').val('登録');
}

/**
 * 映画編集画面初期化
 *
 * @param {object} params
 * @return {void}
 */
 MOVIE.initMovieEdit = function(params) {
    // アクション設定
    $('#movieForm').attr('action', '/movie/update/' + params.id);
    // 映画画画像
    $('#inputMovieImage').val(null);
    // 映画画像ID
    $('#inputMovieImageId').val(params.image_id);
    // 映画名
    $('#inputMovieName').val(params.name);
    // 映画カテゴリー
    $('#inputMovieCategory').val(params.category_id);
    // 映画備考
    $('#inputMovieComment').val(params.comment);
    // ボタン名
    $('#inputMovieSubmit').val('更新');
}

/**
 * 映画削除処理
 *
 * @param {object} params
 * @return {void}
 */
MOVIE.deleteMovie = function(params) {
    // 削除確認後「OK」の場合は削除
    if (window.confirm(params.name + 'を削除してもよろしいですか？')) {
        let deleteForm = document.getElementById('moviedeleteForm');
        deleteForm.action = '/movie/delete/' + params.id;
        deleteForm.submit();
    }
}

/**
 * 映画詳細セット
 *
 * @param {object} params
 * @return {void}
 */
MOVIE.setMovieDetail = function(params) {
    // 映画画画像
    $('#movieDetailImage').attr('src', params.path);
    // 映画名
    $('#movieDetailName').text(params.name);
    $('#modalMovieTitle').text(params.name);
    // 映画カテゴリー
    $('#movieDetailCategoryName').text(params.category_name);
    // 映画備考
    $('#movieDetailComment').text(params.comment);
    // 投票映画ID
    $('#modalMovieId').val(params.id)
}

/**
 * 映画画面切り替え
 *
 * @param {string} displayType
 * @return {void}
 */
MOVIE.switchMovieDisplay = function(displayType) {
    // 映画詳細画面の場合
    if (displayType === 'detail') {
        $('#displayMovieDetail').css('display','inline-block');
        $('#displayMovieInput').css('display','none');

    // 映画新規作成、編集画面の場合
    } else if (displayType === 'create' || displayType === 'edit') {
        $('#displayMovieDetail').css('display','none');
        $('#displayMovieInput').css('display','inline-block');

    // 初期表示
    } else {
        $('#displayMovieDetail').css('display','none');
        $('#displayMovieInput').css('display','none');
    }
}

/**
 * ユーザー新規作成画面初期化
 *
 * @return {void}
 */
 USER.initUserCreate = function() {
    // アクション設定
    $('#userForm').attr('action', '/user/create');
    // ユーザーID
    $('#inputUserId').val('');
    // ユーザー名
    $('#inputUserName').val('');
    // メールアドレス
    $('#inputUserEmail').val('');
    // パスワード
    $('#inputUserPassword').val('');
    // パスワード（確認）
    $('#inputUserPasswordConfirmation').val('');
    // 権限
    $('input[value="0"]').prop('checked', false);
    $('input[value="1"]').prop('checked', false);
    // ボタン名
    $('#inputUserSubmit').val('登録');
}

/**
 * ユーザー編集画面初期化
 *
 * @param {object} params
 * @return {void}
 */
 USER.initUserEdit = function(params) {
    // アクション設定
    $('#userForm').attr('action', '/user/update/' + params.id);
    // ユーザーID
    $('#inputUserId').val(params.id);
    // ユーザー名
    $('#inputUserName').val(params.name);
    // メールアドレス
    $('#inputUserEmail').val(params.email);
    // パスワード
    $('#inputUserPassword').val('');
    // パスワード（確認）
    $('#inputUserPasswordConfirmation').val('');
    // 権限
    $("input[name=is_admin][value=" + params.is_admin + "]").prop("checked",true);
    // ボタン名
    $('#inputUserSubmit').val('更新');
}

/**
 * ユーザー削除処理
 *
 * @param {object} params
 * @return {void}
 */
USER.deleteUser = function(params) {
    // 削除確認後「OK」の場合は削除
    if (window.confirm(params.name + 'を削除してもよろしいですか？')) {
        let deleteForm = document.getElementById('userdeleteForm');
        deleteForm.action = '/user/delete/' + params.id;
        deleteForm.submit();
    }
}

/**
 * ユーザー詳細セット
 *
 * @param {object} params
 * @return {void}
 */
USER.setUserDetail = function(params) {
    // ユーザー名
    $('#userDetailName').text(params.name);
    // メールアドレス
    $('#userDetailEmail').text(params.email);
}

/**
 * ユーザー画面切り替え
 *
 * @param {string} displayType
 * @return {void}
 */
USER.switchUserDisplay = function(displayType) {
    // ユーザー詳細画面の場合
    if (displayType === 'detail') {
        $('#displayUserDetail').css('display','inline-block');
        $('#displayUserInput').css('display','none');

    // ユーザー新規作成、編集画面の場合
    } else if (displayType === 'create' || displayType === 'edit') {
        $('#displayUserDetail').css('display','none');
        $('#displayUserInput').css('display','inline-block');

    // 初期表示
    } else {
        $('#displayUserDetail').css('display','none');
        $('#displayUserInput').css('display','none');
    }
}
