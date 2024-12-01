FROM alpine:edge

RUN apk add --no-cache php83 php83-pecl-apcu php83-pdo_mysql php83-pdo_sqlite php83-curl
RUN alias php=php83
RUN mkdir /app
WORKDIR /app

CMD ["php83", "-S", "0.0.0.0:8803","-t", "./public" ]
