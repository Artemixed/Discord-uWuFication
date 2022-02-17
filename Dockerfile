FROM php:8.1-cli-alpine

WORKDIR /etc/uwuFication/src/
COPY src/ .

CMD [ "php", "run.php" ]