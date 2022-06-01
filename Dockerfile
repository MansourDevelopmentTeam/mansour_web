FROM nimmis/apache-php7

MAINTAINER Sherif <sherif@soleeklab.com>

RUN apt-get update -yqq \
#	&& apt-get install sudo -yqq \ 
#	&& apt-get install beanstalkd -yqq \ 
	&& apt-get install supervisor -yqq \ 
	&& apt-get install php-xml php-zip php-mbstring php-mysql -yqq \ 
	 && rm -rf  /var/lib/apt/lists

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

#COPY supervisord.conf /etc/supervisor/supervisord.conf

#RUN service supervisor restart

#COPY laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

COPY start.sh /

RUN a2enmod rewrite

RUN service apache2 restart

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]

