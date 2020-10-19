FROM ubuntu:latest
RUN apt update -y && apt -y install tzdata && apt -y install apache2
ADD . /var/www/html
EXPOSE 80
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]