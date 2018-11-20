FROM       ubuntu:18.04

RUN apt-get update

RUN apt-get update && apt-get install -y tzdata && apt-get -y -q install apache2 php libapache2-mod-php
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN rm /var/www/html/index.html
# COPY /source /var/www/html

# add custom cnfig file
ADD ./conf/apache2.conf /etc/apache2/apache2.conf
ADD ./conf/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN cd /
RUN mkdir www
#COPY ./src /www
RUN chmod -Rf 775 www

EXPOSE 80
EXPOSE 443

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]

