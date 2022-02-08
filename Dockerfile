FROM php:8.1-cli-alpine

WORKDIR /etc/uwuFication
COPY src/ .

CMD [ "php", "run.php" ]