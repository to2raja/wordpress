#!/usr/bin/env bash

sudo su

rpm -Uvh http://mirror.webtatic.com/yum/el6/latest.rpm

yum install httpd -y
yum install mysql-server -y
yum install php55w -y
yum install php55w-mysqlnd -y
yum install php55w-mbstring -y
yum install php55w-xml -y
yum install php55w-gd -y

rm -rf /var/www/html
ln -fs /vagrant /var/www/html

cat /vagrant/Vagrant/httpd.conf >> /etc/httpd/conf/httpd.conf
echo "date.timezone = \"America/New_York\";" >> /etc/php.ini

chkconfig httpd on
chkconfig mysqld on

service httpd start
service mysqld start

#setting mysql root creds
/usr/bin/mysqladmin -u root password ''
/usr/bin/mysqladmin -u root -h localhost.localdomain password ''

#allow remote mysql access so that you can connect to this instance from your local sequel pro client
/usr/bin/mysql -u root -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY '' WITH GRANT OPTION; FLUSH PRIVILEGES;"

#create database
/usr/bin/mysqladmin -u root create v_content

#add user + access to database
/usr/bin/mysql -uroot -e "GRANT ALL PRIVILEGES ON v_content.* TO bn_wordpress@localhost IDENTIFIED BY '83adaf1969'"

#import existing production database
#the admin user has been removed from wordpress for security precautions
#all user names and passwords are the same as they are on the production server
/usr/bin/mysql -uroot v_content < /vagrant/database/v_content.sql
/usr/bin/mysql -uroot -e "UPDATE v_content.wp_options SET option_value = 'http://localhost:8075' WHERE option_name = 'siteurl'"
/usr/bin/mysql -uroot -e "UPDATE v_content.wp_options SET option_value = 'http://localhost:8075' WHERE option_name = 'home'"

#adds apache user to vagrant group for read/write/execute access to wp-content
#usermod -a -G vagrant apache

#export SISA_ENVIRONMENT="dev"
cd /var/www/html
#./framework/sake dev/build flush=all

