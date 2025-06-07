<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRAFT 就活エージェント比較サイト</title>
    <link rel="stylesheet" href="../../assets/css/user.css">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/sp/user.css">
    <link rel="stylesheet" href="../../assets/css/splide.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
<?php include(dirname(__FILE__) . '../../components/user/header2.php'); ?>
    <main>
        <section class="mainvisual" id="js-mainVisual">
            <div class="mainvisual-inner">
                <div class="mainvisual-head">
                    <p class="mainvisual-lead1">就活エージェントを</p>
                    <div class="lead2-box">
                        <p class="mainvisual-lead2">簡単</p>
                        <p class="mainvisual-lead2 mainvisual-space">比較</p>
                    </div>
                    <p class="mainvisual-lead3">就活に答えを</p>
                    <a href="./beginner/index.php" class="mainvisual-button">就活初心者はこちら</a>
                </div>
            </div>
        </section>
        <section class="introduce-body">
            <div class="introduce-container">
                <div class="introduce-box1">
                    <img src="../assets/img/craft logo3.png" alt="" class="introduce-img">
                    <p class="introduce-text1">を使うことで</p>
                </div>
                <div class="introduce-box2">
                    <img src="../assets/img/check.png" alt="" class="introduce-check">
                    <p class="introduce-text2">
                        <span class="introduce-text3">自分に合ったエージェント</span>が見つかる！
                    </p>
                </div>
                <div class="introduce-box2">
                    <img src="../assets/img/check.png" alt="" class="introduce-check">
                    <p class="introduce-text2">
                        <span class="introduce-text3">複数のエージェント</span>に申し込める！
                    </p>
                </div>
                <div class="introduce-box2"> 
                    <img src="../assets/img/check.png" alt="" class="introduce-check">
                    <p class="introduce-text2">
                        <span class="introduce-text3">簡単登録</span>で初心者も安心！
                    </p>
                </div>
                <div class="introduce-button-box">
                    <a href="./beginner/index.php#merit"  class="introduce-button">もっと見る</a>
                </div>
                
            </div>
        </section>
        <section class="HowTo-body">
            <div class="HowTo-title-box">
                <div class="HowTo-subtitle-box">
                    <h1 class="HowTo-subtitle">(how to)</h1>
                </div>
                <h1 class="HowTo-title">使い方</h1>
            </div>
            <div class="HowTo-img">
                <img src="../assets/img/How to.png" alt="">
            </div>
            <div class="sp-splide">
                <div class="sp-splide-body">
                    <div id="js-dailySlide" class="splide daily-slide">
                        <div class="splide__track">
                            <ul class="splide__list daily-list">
                                <li class="splide__slide daily-item"><img src="../assets/img/step1.png" alt="" class="splide-img2"></li>
                                <li class="splide__slide daily-item"><img src="../assets/img/step2.png" alt="" class="splide-img2"></li>
                                <li class="splide__slide daily-item"><img src="../assets/img/step3.png" alt="" class="splide-img2"></li>
                                <li class="splide__slide daily-item"><img src="../assets/img/step4.png" alt="" class="splide-img2"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
        </section>
        <section>
            <div class="subsearch-body">
                <p class="subsearch-title">お気に入りのエージェントを見つけよう！</p>
                <form action="./search/index.php" method="POST">
                    <div class="subsearch-container">
                        <div class="subsearch-box">
                            <label for="industry">
                                <p class="subsearch-box-top">業種</p>
                            </label>
                            <select name="industry" id="industry" class="subsearch-box-main search-box-main1">
                                <option value="0">すべて</option>
                                <option value="1">総合型</option>
                                <option value="2">理系職業</option>
                                <option value="3">IT</option>
                                <option value="4">芸術</option>
                            </select>
                        </div>
                        <img src="../assets/img/image 14.png" alt="" class="subsearch-img">
                        <div class="subsearch-box">
                            <label for="area">
                                <p class="subsearch-box-top">エリア</p>
                            </label>
                            <select name="area" id="area" class="subsearch-box-main">
                                <option value="1">全国</option>
                                <option value="2">北海道・東北</option>
                                <option value="3">関東</option>
                                <option value="4">中部</option>
                                <option value="5">近畿</option>
                                <option value="6">中国・四国</option>
                                <option value="7">九州・沖縄</option>
                            </select>
                        </div>
                        <img src="../assets/img/image 14.png" alt="" class="subsearch-img">
                        <div class="subsearch-box">
                            <label for="form">
                                <p class="subsearch-box-top">形態</p>
                            </label>
                            <select name="form" id="form" class="subsearch-box-main">
                                <option value="0">すべて</option>
                                <option value="1">大手</option>
                                <option value="2">中小</option>
                                <option value="3">ベンチャー</option>
                                <option value="4">外資</option>
                            </select>
                        </div>
                    </div>
                    <div class="subsearch-button">
                        <button type="submit" class="subsearch-box-button"><img src="../../assets/img/image 10.png" alt="">検索</button>
                    </div>
                </form>
                
            </div>
        </section>
    </main>
    <?php include(dirname(__FILE__) . '../../components/user/footer.php'); ?>
    <script src="../../assets/js/splide.min.js"></script>
    <script>
        const header = document.getElementById("js-header");

        // メインビジュアルの要素を取得
        const mainVisual = document.getElementById("js-mainVisual");

        // スクロールした時の処理
        window.addEventListener("scroll", () => {
        // [スクロールした分の高さ] が [メインビジュアルの高さ - ヘッダーの高さ] より大きい時
        if (window.scrollY > mainVisual.clientHeight - header.clientHeight) {
            header.classList.remove("is-transparent");
        } else {
            header.classList.add("is-transparent");
        }
        });


        const dailySlideOptions = {
            type: string = 'loop',
            gap: 34,
            padding: { left: 38, right: 38 },
            mediaQuery: 'min',
            perPage: 1,
        }

        new Splide('#js-dailySlide', dailySlideOptions).mount();
    </script>
</body>
