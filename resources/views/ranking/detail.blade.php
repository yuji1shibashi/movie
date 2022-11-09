<!DOCTYPE html>
<html lang="ja">
    @include('layouts.head')
    <body>
        @include('layouts.header')
        <main>
            <div class="ranking-area">
                <div class="rank-area">
                    @foreach ($rankingList as $ranking)
                        <div class="w300px disib mb20 vat">
                            <div class="{{ $ranking['color'] }}">{{ $ranking['rank'] }}</div>
                            <img class="ranking-img" src="{{ $ranking['image'] }}">
                            <div class="disb">{{ $ranking['name'] }}</div>
                            <div class="disb">{{ $ranking['point'] }}ポイント</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </body>
</html>