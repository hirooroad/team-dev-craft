FROM nginx:latest
# タイムゾーン(東京)
ENV TZ Asia/Tokyo

# Nginxの設定を直接定義
RUN echo "\
server {\
    listen 80;\
    server_name localhost;\
    location / {\
        root /var/www/html;\
        index index.html index.htm;\
    }\
}" > /etc/nginx/conf.d/default.conf
# このコンテナに入った時のカレントディレクトリ
WORKDIR /var/www/html