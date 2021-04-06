# bplaat/plaatcrypto
A crypto trading tracker website with tradingbot features

## Todo list
- Admin settings crud
- Portfolios users to edit page
- Admin portfolios users to edit page
- Transactions crud
- Admin transactions crud
- Websocket server
- Portfolio show page
- Admin portfolio show page
- Home page

## Installation

### Windows
- Install [XAMPP](https://www.apachefriends.org/download.html) Apache web server, PHP and MySQL database
- Install [Composer](https://getcomposer.org/download/) PHP package manager
- Clone repo in the `C:/xampp/htdocs` folder
    ```
    cd C:/xampp/htdocs
    git clone https://github.com/bplaat/plaatcrypto.git
    cd plaatcrypto
    ```
- Install deps via Composer
    ```
    cd server
    composer install
    ```
- Copy `server/.env.example` to `server/.env`
- Generate Laravel security key
    ```
    php artisan key:generate
    ```
- Add following lines to `C:/xampp/apache/conf/extra/httpd-vhosts.conf` file
    ```
    # PlaatCrypto vhosts

    <VirtualHost *:80>
        ServerName plaatcrypto.local
        DocumentRoot "C:/xampp/htdocs/plaatcrypto/server/public"
    </VirtualHost>

    <VirtualHost *:80>
        ServerName www.plaatcrypto.local
        Redirect permanent / http://plaatcrypto.local/
    </VirtualHost>
    ```
- Add following lines to `C:/Windows/System32/drivers/etc/hosts` file **with administrator rights**
    ```
    # PlaatCrypto local domains
    127.0.0.1 plaatcrypto.local
    127.0.0.1 www.plaatcrypto.local
    ```
- Start Apache and MySQL via XAMPP control panel
- Create MySQL user and database
- Fill in MySQL user, password and database information in `server/.env`
- Create database tables
    ```
    cd server
    php artisan migrate
    ```
- Start the websocket server with Binance live feed client
    ```
    cd server
    php artisan websockets:serve
    ```
- Goto http://plaatcrypto.local/ and you're done! 🎉

### macOS
TODO

### Linux

#### Ubuntu based distro's
- Install LAMP stack
    ```
    sudo apt install apache2 php php-dom mysql-server composer
    ```
-  Fix `/var/www/html` Unix rights hell
    ```
    # Allow Apache access to the folders and the files
    sudo chgrp -R www-data /var/www/html
    sudo find /var/www/html -type d -exec chmod g+rx {} +
    sudo find /var/www/html -type f -exec chmod g+r {} +

    # Give your owner read/write privileges to the folders and the files, and permit folder access to traverse the directory structure
    sudo chown -R $USER /var/www/html/
    sudo find /var/www/html -type d -exec chmod u+rwx {} +
    sudo find /var/www/html -type f -exec chmod u+rw {} +

    # Make sure every new file after this is created with www-data as the 'access' user.
    sudo find /var/www/html -type d -exec chmod g+s {} +
    ```
- Clone repo in the `/var/www/html` folder
    ```
    cd /var/www/html
    git clone https://github.com/IpsumCapra/plaatcrypto.git
    cd plaatcrypto
    ```
- Install deps via Composer
    ```
    cd server
    composer install
    ```
- Copy `server/.env.example` to `server/.env`
- Generate Laravel security key
    ```
    php artisan key:generate
    ```
- Create the file `/etc/apache2/sites-available/plaatcrypto.conf` **as root**
    ```
    # PlaatCrypto vhosts

    <VirtualHost *:80>
        ServerName plaatcrypto.local
        DocumentRoot "/var/www/html/plaatcrypto/server/public"
    </VirtualHost>

    <VirtualHost *:80>
        ServerName www.plaatcrypto.local
        Redirect permanent / http://plaatcrypto.local/
    </VirtualHost>
    ```
- Enable the site
    ```
    sudo a2ensite plaatcrypto
    ```
- Edit this line in `/etc/apache2/apache2.conf` at `AllowOverride` from `None` to `All` **as root**
    ```
    <Directory /var/www/>
        ...
        AllowOverride All
        ...
    </Directory>
    ```
- Enable the Apache rewrite module
    ```
    sudo a2enmod rewrite
    ```
- Restart apache
    ```
    sudo service apache2 restart
    ```
- Add following lines to `/etc/hosts` file **as root**
    ```
    # PlaatCrypto local domains
    127.0.0.1 plaatcrypto.local
    127.0.0.1 www.plaatcrypto.local
    ```
- Create MySQL user and database
- Fill in MySQL user, password and database information in `server/.env`
- Create database tables
    ```
    cd server
    php artisan migrate
    ```
- Goto http://plaatcrypto.local/ and you're done! 🎉
