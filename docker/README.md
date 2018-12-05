# docker-examples
Nothing special , just a collection of some docker's Dockerfile for testing   

<code> docker-compose up -d</code>

## apache-php
The default mount folder is ~/Code/www

## mysql
- Run first-login-mysql.sh to login as root with default password.   
<code>./first-login-mysql.sh</code>   
- Change root password   
<code>ALTER USER 'root'@'localhost' IDENTIFIED BY 'password';</code>
- Example of create other user   
<code>CREATE USER 'test'@'localhost' IDENTIFIED BY 'password';</code>   
<code>GRANT ALL PRIVILEGES ON *.* TO 'test'@'localhost' WITH GRANT OPTION;</code>   
<code>CREATE USER 'test'@'%' IDENTIFIED BY 'password';</code>   
<code>GRANT ALL PRIVILEGES ON *.* TO 'test'@'%' WITH GRANT OPTION;</code>   
<code>FLUSH PRIVILEGES;</code>   
<code>ALTER USER 'test'@'%' IDENTIFIED WITH mysql_native_password BY 'password';</code>   
or   
<code>ALTER USER 'test'@'%' IDENTIFIED WITH caching_sha2_password BY 'password';</code>   
- Login in with new user   
<code>docker exec -it mysql-dev mysql -u test -p</code>
