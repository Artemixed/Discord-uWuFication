FROM php:8.1-cli-alpine

WORKDIR /etc/uwuFication
COPY . .

CMD [ "php", "run.php" ]