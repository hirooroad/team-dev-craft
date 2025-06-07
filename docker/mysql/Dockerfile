FROM mysql:8

# Oracle Linux のためのパッケージマネージャーのインストール
USER root
RUN microdnf install -y glibc-locale-source glibc-langpack-en

# 日本語ロケールの生成と設定
RUN localedef -i ja_JP -f UTF-8 ja_JP.UTF-8

# 環境変数の設定
ENV LANG ja_JP.UTF-8
ENV LC_ALL ja_JP.UTF-8

# タイムゾーン(東京)
ENV TZ Asia/Tokyo

# MySQLの設定
ENV MYSQL_USER=mysql
ENV MYSQL_CHARACTER_SET_SERVER=utf8mb4
ENV MYSQL_COLLATION_SERVER=utf8mb4_0900_ai_ci
ENV MYSQL_DEFAULT_AUTHENTICATION_PLUGIN=caching_sha2_password
ENV MYSQL_DEFAULT_TIME_ZONE=SYSTEM
ENV MYSQL_LOG_TIMESTAMPS=SYSTEM
ENV MYSQL_DEFAULT_CHARACTER_SET=utf8mb4
ENV MYSQL_CLIENT_DEFAULT_CHARACTER_SET=utf8mb4

# キャッシュと不要なファイルの削除
RUN microdnf clean all
