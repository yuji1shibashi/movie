<header>
    <h1>
        <a href="/movie/list">FOX MOVIE</a>
    </h1>
    <nav class="pc-nav">
        <ul>
            @auth
                <li><a href="/movie/list">映画一覧</a></li>
                @can('admin')
                    <li><a href="/user/list">ユーザー一覧</a></li>
                @endcan
                <li><a href="/ranking">ランキング</a></li>
                <li><a href="/logout">ログアウト</a></li>
            @endauth
            @guest
                <li><a href="/login">ログイン</a></li>
                <li><a href="/register">ユーザー作成</a></li>
            @endguest
        </ul>
    </nav>
</header>