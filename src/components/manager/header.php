<header class="header" id="js-header">
        <div class="header-container">
            <a href="/manager/menu/index.php" class="header-logo">
                <img src="../../assets/img/craft logo2.png" alt="POSSE③">
                <p>管理者画面</p>
            </a>
            <nav class="header-nav">
                <ul class="header-navList">
                    <li class="header-navItem">
                    <form action="/manager/signout/signout.php" method="POST">
                            <input type="submit" name="destroy" class="header-navLink" value="Logout">
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="header-menu-box">
            <a href="/manager/look/index.php"><p class="header-menu">エージェント管理</p></a>
            <a href="/manager/report response/index.php"><p class="header-menu">通報対応</p></a>
            <a href="/manager/contact response/index.php"><p class="header-menu">お問合せ</p></a>
            <a href="/manager/Q&A edit/index.php"><p class="header-menu">FQA編集</p></a>
        </div>
    </header>