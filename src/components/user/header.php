<header class="header is-open" id="js-header">
        <a href="/user/index.php">
            <img src="../../assets/img/craft logo3.png" alt="POSSE③" class="header-logo">
        </a>
        <button class="header-button" id="js-headerButton">
            <span class="header-buttonLine"></span>
            <span class="header-buttonLine"></span>
            <span class="header-buttonLine"></span>
        </button>
        <nav class="header-nav">
            <ul class="header-navList">
                <li class="header-navItem">
                    <a href="/user/search/index.php" class="header-navLink">
                        <img src="../../assets/img/image 10.png" alt="検索" class="header-search-logo">
                    </a>
                </li>
            </ul>
            <ul class="header-navList">
                <li class="header-navItem">
                    <a href="/user/beginner/index.php" class="header-navLink">就活入門</a>
                </li>
            </ul>
            <ul class="header-navList">
                <li class="header-navItem">
                    <a href="/user/Q&A/index.php" class="header-navLink">Q & A</a>
                </li>
            </ul>
        </nav>
        <nav class="header-nav2">
            <ul class="header-navList">
                <li class="header-navItem">
                    <button onclick="location.href='/user/search/index.php'" class="header-navLink">
                        <img src="../../assets/img/image 10.png" alt="検索" class="header-search-logo">
                        探してみる
                    </button>
                </li>
            </ul>
            <ul class="header-navList">
                <li class="header-navItem">
                    <button onclick="location.href='/user/beginner/index.php'" class="header-navLink">就活入門</button>
                </li>
            </ul>
            <ul class="header-navList">
                <li class="header-navItem">
                    <button onclick="location.href='/user/Q&A/index.php'" class="header-navLink">Q & A</button>
                </li>
            </ul>
        </nav>
        <style>
        @media (max-width: 768px) {
            .header-go {
                height: 60px;
                }

            .header {
                padding: 0 12px;
                height: 60px;
            }

            .header-logo {
                width: 100px;
            }

            .header-nav {
                display: none;
            }

            .header-nav2 {
                display: flex;
                flex-direction: column;
                position: fixed;
                inset: 0 0 auto 0;
                background-color: rgba(0,139,226,0.8);
                visibility: hidden;
                flex-direction: column;
                gap: 0;
                padding: 60px 0px 0px;
                height: auto;
            }
            .header-navList {
                border: #FFFFFF solid 0px;
                background-color: transparent;
                border-top: #FFFFFF solid 1px;
            }

            .header-navLink{
                width: 100%;
                padding: 10px 0 10px 0;
            }

            .header-buttonLine {
                display: block;
                width: 30px;
                height: 2px;
                background-color: #0071BC;
                position: absolute;
                left: 50%;
                transform: translateX(-50%);
            }

            .header-search-logo {
                width: 35px;
            }

            .header-logo {
            position: relative;
            width: 100px;
            height: 50px;
            z-index: 200;
            margin-top: 5px;
            }

            .header-buttonLine:nth-of-type(1) {
                top: 13px;
            }

            .header-buttonLine:nth-of-type(2) {
                top: 20px;
            }

            .header-buttonLine:nth-of-type(3) {
                top: 27px;
            }

            .header.is-open .header-buttonLine:nth-of-type(1) {
            transform: translateX(-50%) rotate(45deg);
            top: 20px;
            background-color: #FFFFFF;
            }

            .header.is-open .header-buttonLine:nth-of-type(2) {
            opacity: 0;
            background-color: #FFFFFF;
            }

            .header.is-open .header-buttonLine:nth-of-type(3) {
            transform: translateX(-50%) rotate(-45deg);
            top: 20px;
            background-color: #FFFFFF;
            }

            .header.is-open .header-logo {
                filter: brightness(0) invert(1);
            }


            .header-button {
            width: 42px;
            height: 42px;
            position: relative;
            margin-left: auto;
            z-index: 1;
            margin-top: 8px;
            }

            .header.is-open .header-nav2 {
            visibility: visible;
            opacity: 1;
            width: 100%;
            }
        }
        </style>
        <script>
            // ヘッダー・ボタンの要素を取得
            const header = document.getElementById("js-header");
            const button = document.getElementById("js-headerButton");

            // ボタンをクリックした時の処理
            button.addEventListener("click", () => {
            header.classList.toggle("is-open");
            });

            
            window.onload = function() {
            var element = document.getElementById("js-header");
            if (element) {
                element.classList.remove('is-open'); // クラスを削除
            }
    };
        </script>
    </header>