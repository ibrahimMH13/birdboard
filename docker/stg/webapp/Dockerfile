FROM centos:7

RUN rpm -Uv https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
RUN rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-7.rpm

RUN yum -y install yum-utils
RUN yum-config-manager --enable remi-php74

RUN yum -y update

RUN yum --enablerepo=remi-php74 install -y openssl php php-opcache php-xml php-phpiredis php-pdo php-soap php-xmlrpc php-mbstring php-json php-gd php-mcrypt php-bcmath php-gd php-mbstring php-zip php-imagick php-tokenizer php-mysql
RUN yum install -y httpd

RUN yum install -y ImageMagick.x86_64 vim git cronie.x86_64
RUN yum groupinstall -y "Development Tools"

VOLUME ["/var/www/html/", "/etc/httpd/", "/var/log/"]

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
php composer-setup.php --install-dir=/usr/local/bin  --filename=composer && \
php -r "unlink('composer-setup.php');"

# Install NodeJs
RUN cd /tmp && curl https://nodejs.org/dist/v12.13.1/node-v12.13.1-linux-x64.tar.xz -O
RUN tar -xf /tmp/node-v12.13.1-linux-x64.tar.xz -C /usr/local/
ENV PATH "${PATH}:/usr/local/node-v12.13.1-linux-x64/bin/"
RUN npm install yarn -g

COPY files/httpd.conf /etc/httpd/conf/httpd.conf

# Install MongoDB
RUN yum install -y php74-php-pecl-mongodb.x86_64
RUN yum install -y libpng-devel.x86_64

# Install Newrelic
#RUN rpm -Uvh http://yum.newrelic.com/pub/newrelic/el5/x86_64/newrelic-repo-5-3.noarch.rpm
#RUN yum install -y newrelic-php5.x86_64
#RUN mkdir -p /var/log/newrelic && chmod 777 /var/log/newrelic

# Install Supervisor
RUN yum install -y supervisor.noarch

# Install Yacron
RUN yum install -y python3-pip.noarch
RUN pip3 install yacron==0.3.3

CMD /usr/sbin/httpd -k start -DFOREGROUND

#Set default work directory
WORKDIR /var/www/html