FROM nginx:alpine

COPY default.conf /etc/nginx/conf.d/default.conf

RUN apk --no-cache add acf-openssl
RUN openssl req \
    -subj '/CN=localhost' \
    -x509 \
    -newkey rsa:4096 \
    -nodes \
    -keyout /etc/nginx/conf.d/key.pem \
    -out /etc/nginx/conf.d/cert.pem \
    -days 365

WORKDIR /app/public
