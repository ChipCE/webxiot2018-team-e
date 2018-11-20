# ubuntu-apache-php-dev
Apache+php image based on ubuntu.(default configuration)   

### To build the image 
<code>docker build -t [image-name] .</code>

### To run it
<code>docker run -p [host-port]:[container-port] --name [container-name] -d [image-name]</code>
or with bind
<code>docker run -p [host-port]:[container-port] --mount type=bind,source=[source-dir],target=/var/www/html --name [container-name] -d [image-name]</code>
