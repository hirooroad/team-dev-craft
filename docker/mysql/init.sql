DROP DATABASE IF EXISTS  posse;

CREATE DATABASE posse;

USE posse;

DROP TABLE IF EXISTS agents;
CREATE TABLE agents (
    id INT AUTO_INCREMENT PRIMARY KEY, /*ID*/
    login_id VARCHAR(255) NOT NULL, /*ログインID*/
    password VARCHAR(255) NOT NULL, /*パスワード*/
    name VARCHAR(255) NOT NULL, /*名前*/
    industry TINYINT NOT NULL, /*業種*/
    area TINYINT NOT NULL, /*エリア*/
    information VARCHAR(255) NOT NULL, /*特徴*/
    image VARCHAR(255) NOT NULL, /*画像*/
    claim_money INT NOT NULL, /*請求金額*/
    claim_confirm bit NOT NULL, /*請求確認*/
    alert_number INT NOT NULL, /*通報件数*/
    start_period DATE NOT NULL, /*掲載開始日時*/
    end_period DATE NOT NULL, /*掲載終了日時*/
    display bit NOT NULL /*表示*/
);

DROP TABLE IF EXISTS form;
CREATE TABLE form (
    id INT AUTO_INCREMENT PRIMARY KEY, /* ID */
    agent_id INT NOT NULL, /* エージェントID */
    form INT NOT NULL /* 形態内容 */
);

DROP TABLE IF EXISTS applicants;
CREATE TABLE applicants (
    id INT AUTO_INCREMENT PRIMARY KEY, /* ID */
    day DATE NOT NULL, /* 申込日時 */
    name VARCHAR(255) NOT NULL, /* 名前 */
    furigana VARCHAR(255) NOT NULL, /* フリガナ */
    birthday DATE NOT NULL, /* 生年月日 */
    gender TINYINT NOT NULL, /* 性別 */
    mail_address VARCHAR(255) NOT NULL, /* メールアドレス */
    address VARCHAR(255) NOT NULL, /* 住所 */
    tele_number VARCHAR(15) NOT NULL, /* 電話番号 */
    huma_science TINYINT NOT NULL, /* 文理区分 */
    academic VARCHAR(255) NOT NULL, /* 最終学歴 */
    graduation_YEAR INT NOT NULL, /* 卒業見込年 */
    graduation_MONTH INT NOT NULL, /* 卒業見込月 */
    send_status bit NOT NULL /* メール送信状態 */
);

DROP TABLE IF EXISTS submit;
CREATE TABLE submit (
    id INT AUTO_INCREMENT PRIMARY KEY, /* ID */
    applicant_id INT NOT NULL, /* 申込者ID */
    agent_id INT NOT NULL /* 申し込みエージェントID */
);

DROP TABLE IF EXISTS questions;
CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY, /* ID */
    name VARCHAR(255) NOT NULL, /* 氏名 */
    furigana VARCHAR(255) NOT NULL, /* フリガナ */
    mail_address VARCHAR(255) NOT NULL, /* メールアドレス */
    tele_number VARCHAR(15) NOT NULL, /* 電話番号 */
    company VARCHAR(255) NOT NULL, /* 貴社名 */
    content VARCHAR(1000) NOT NULL, /* お問い合わせ内容 */
    day DATE NOT NULL, /* 問い合わせ日時 */
    status bit NOT NULL /* 対応状況 */
);

DROP TABLE IF EXISTS fqa;
CREATE TABLE fqa (
    id INT AUTO_INCREMENT PRIMARY KEY, /* ID */
    destination TINYINT NOT NULL, /* 宛先 */
    question VARCHAR(255) NOT NULL, /* 質問 */
    answer VARCHAR(255) NOT NULL, /* 回答 */
    start_day DATE NOT NULL, /* 掲載開始日 */
    status bit NOT NULL /* 掲載状態 */
);

DROP TABLE IF EXISTS alert;
CREATE TABLE alert (
    id INT AUTO_INCREMENT PRIMARY KEY, /* ID */
    agent_id INT NOT NULL, /* 通報者ID */
    applicant_id INT NOT NULL, /* 通報対象者ID */
    place TINYINT NOT NULL, /* 通報箇所 */
    reason VARCHAR(1000) NOT NULL, /* 通報理由 */
    day DATE NOT NULL /* 通報日時 */
);

DROP TABLE IF EXISTS manager;
CREATE TABLE manager (
    id INT AUTO_INCREMENT PRIMARY KEY, /* ID */
    login_id VARCHAR(255) NOT NULL, /* ログインID */
    password VARCHAR(255) NOT NULL /* パスワード */
);

DROP TABLE IF EXISTS money;
CREATE TABLE money (
    id INT AUTO_INCREMENT PRIMARY KEY, /* ID */
    money VARCHAR(255) NOT NULL /* 1人当たりの金額 */
);

INSERT INTO agents (login_id, password, name, industry, area, information, image, claim_money, claim_confirm, alert_number, start_period, end_period, display)
VALUES
 ('rikunabi@gmail.com', '$2a$12$7Df.TKmsVgQXicKiHsk0R.4lT99uOocg1KKFHj0iM1P.1MNzo7Jty', 'リクナビ就活エージェント', 1, 1, '専属のアドバイザーが就活をサポート。企業の選考ポイントも把握しており、面接や履歴書についてもサポートされる。', 'A0001.png', 100000, 0, 0, '2025-03-24', '2026-3-23', 1),
 ('mynabi@gmail.com', '$2a$12$7Df.TKmsVgQXicKiHsk0R.4lT99uOocg1KKFHj0iM1P.1MNzo7Jty', 'マイナビ新卒紹介', 1, 1, 'キャリカウンセリングで、自分の良さを発見できる。非公開求人やセミナーなど、充実したサポートも提供している。','A0002.png', 150000, 0, 0, '2025-03-24', '2026-3-23', 1),
 ('doda@gmail.com', '$2a$12$7Df.TKmsVgQXicKiHsk0R.4lT99uOocg1KKFHj0iM1P.1MNzo7Jty', 'doda新卒エージェント', 1, 1, '丁寧なカウンセリングによって強みや適性を明確にすることができる。厳選された優良企業6000社を紹介。', 'A0003.png', 240000, 0, 0, '2025-03-24', '2026-3-23', 1),
 ('rikeineo@gmail.com', '$2a$12$7Df.TKmsVgQXicKiHsk0R.4lT99uOocg1KKFHj0iM1P.1MNzo7Jty', '理系就活エージェントneo', 2, 1, '理系学生に特化したエージェント。理系学生のための就活イベントやセミナーを開催。非公開求人も多い。', 'A0004.png', 100000, 0, 0, '2025-03-11', '2026-3-10', 1),
 ('syutokyari@gmail.com', '$2a$12$7Df.TKmsVgQXicKiHsk0R.4lT99uOocg1KKFHj0iM1P.1MNzo7Jty', 'シュトキャリ', 1, 3, '首都圏に就職したい就活生のための就活支援サービス。就活生の強みを引き出すためのカウンセリングを行っている。', 'A0005.png', 150000, 0, 0, '2025-03-16', '2026-3-15', 1);

INSERT INTO form (agent_id, form)
VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 2),
(2, 3),
(3, 1),
(3, 2),
(4,1),
(4,2),
(5,1),
(5,2),
(5,3);

INSERT INTO manager (login_id, password)
VALUES
('craft@gmail.com', '$2a$12$7Df.TKmsVgQXicKiHsk0R.4lT99uOocg1KKFHj0iM1P.1MNzo7Jty');

INSERT INTO money (money)
VALUES
('10000');
