## IMMO (SYMFONY 3)
### Installattion

- $ git clone git@github.com:MWCorentin/Agile-Skeleton.git

- in your project folder run `composer install`

- add `192.168.33.1    agile-skeleton.sf` in your hosts file
    - `/etc/hosts` on Linux and MAC
    - `C:\WINDOWS\system32\drivers\etc\hosts` on Windows

- in your project folder run `vagrant up`

- in your project folder run `vendor/bin/phing update:dev`

- go to http://agile-skeleton.sf/app_dev.php/

- accces to vm phpmyadmin : http://agile-skeleton.sf/phpmyadmin

### Configuration before installation for new projet 

edit next files :

 - app/config/agile.yml
 
```yaml
    agile.host_env: "%agile_host_env%"
    agile.project_domain: "%agile_project_domain%"
    agile.project_url: "%agile_project_url%"
    agile.developer_email: "%agile_developer_email%"
    agile.contact_email: "%agile_contact_email%"
    agile.project_name: "%agile_project_name%"
    agile.project_title: "%agile_project_title%"
    agile.vagrant_ip: 192.168.33.2 # edit this line and put the ip address vagrant you want (192.168.33.xxx)
    agile.email_sender_name: "%agile_email_sender_name%"
```

 - app/config/parameters.yml.dist
 
```yaml
    parameters:
        database_host:     192.168.33.2 # insert the new ip address
        database_port:     3302 #insert the same porte as the last number of the ip address (Here is 01)
        database_name:     agile_skeleton # your database name
        database_user:     root
        database_password: 1234
    
    
        mailer_transport:  smtp
        mailer_host:       in-v3.mailjet.com
        mailer_user:       ~
        mailer_password:   ~
        mailer_port:       ~
    
        session_prefix:    agile-skeleton
    
        secret:            ThisTokenIsNotSoSecretChangeIt
    
        session_path:           "%kernel.root_dir%/../var/sessions/%kernel.environment%"
    
        no_reply_email:    corentin.regnier59@gmail.com 
        no_reply_sender:    Agile Skeleton #Change it
        agile_host_env: dev 
        agile_project_domain: agile-skeleton.sf # Change it
        agile_project_url: https://agile-skeleton.sf/ # Change it
        agile_project_name: agile-skeleton # Change it
        agile_project_title: Agile Skeleton # Change it
        agile_email_sender_name: Agile Skeleton # Change it
        agile_developer_email: corentin.regnier59@gmail.com
        agile_contact_email:    corentin.regnier59@gmail.com
        agile_vagrant_smb_user: # Change it , if you use Windows
        agile_vagrant_smb_password: # Change it , if you use Windows
```

 - deploy/script.sh
 
```bash
    #!/bin/bash
    
    # Update repository
    sudo apt-get -y update
    
    # Install OpenSSL
    sudo apt-get install openssl
    
    # Add locale FR
    sudo locale-gen fr_FR.UTF-8
    
    # Install Apache
    sudo apt-get -y install apache2
    
    # Install MySQL
    sudo debconf-set-selections <<< "mysql-server-5.5 mysql-server/root_password password $4"
    sudo debconf-set-selections <<< "mysql-server-5.5 mysql-server/root_password_again password $4"
    sudo apt-get -y install mysql-server
    
    sudo sed -i "s/3306/3302/" /etc/mysql/mysql.conf.d/mysqld.cnf # Change the second port as defined in parameters.yml.dist
    sudo sed -i "s/127.0.0.1/0.0.0.0/" /etc/mysql/mysql.conf.d/mysqld.cnf
    
    mysql -u root -p$4 -e "CREATE USER 'root'@'%' IDENTIFIED BY '$4'; GRANT ALL PRIVILEGES ON * . * TO 'root'@'%' IDENTIFIED BY '$4'; FLUSH PRIVILEGES;"
    
    sudo service mysql restart
    
    # Install PHPMyAdmin
    sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/dbconfig-install boolean true"
    sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/app-password-confirm password $4"
    sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/admin-pass password $4"
    sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/app-pass password $4"
    sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2"
    sudo apt-get -y install phpmyadmin
    
    # Edit PHPMyAdmin config
    sudo rm /etc/phpmyadmin/config.inc.php
    sudo mv /var/www/config.inc.php /etc/phpmyadmin/config.inc.php
    sudo chmod 644 /etc/phpmyadmin/config.inc.php
    
    # Install PHP7
    sudo apt-get -y install php php7.0-mysql php7.0-cli php7.0-intl php7.0-curl php7.0-gd php-apcu php7.0-mcrypt
    
    # Enable PHP7 mod
    sudo phpenmod mcrypt
    
    # Edit PHP7 Config
    sudo sed -i "s/post_max_size = 8M/post_max_size = 600M/" /etc/php/7.0/apache2/php.ini
    sudo sed -i "s/upload_max_filesize = 2M/upload_max_filesize = 500M/" /etc/php/7.0/apache2/php.ini
    sudo sed -i "s/display_errors = Off/display_errors = On/" /etc/php/7.0/apache2/php.ini
    
    # Delete default Apache web directory and vhost
    sudo rm -rf /var/www/html
    sudo rm -rf /etc/apache2/sites-enabled/000-default.conf
    
    # Add Apache vhost
    sudo mv /var/www/apache.conf /etc/phpmyadmin/apache.conf
    sudo mv /var/www/project.conf /etc/apache2/sites-available/
    sudo mkdir /etc/apache2/ssl
    sudo mv /var/www/project.crt /etc/apache2/ssl/project.crt
    sudo mv /var/www/project.key /etc/apache2/ssl/project.key
    sudo sed -i "s/project_url/$3/g" /etc/apache2/sites-available/project.conf
    
    # Edit Apache config
    sudo sed -i "s/export APACHE_RUN_USER=www-data/export APACHE_RUN_USER=ubuntu/" /etc/apache2/envvars
    sudo sed -i "s/export APACHE_RUN_GROUP=www-data/export APACHE_RUN_GROUP=ubuntu/" /etc/apache2/envvars
    
    # Enable Apache mod and vhost
    sudo a2enmod rewrite
    sudo a2enmod ssl
    sudo a2ensite project
    
    # Restart Apache
    sudo service apache2 restart
    
    
    # Install Java
    # sudo apt-get install default-jre -y
    # sudo apt-get install default-jdk -y
    
    # Install elastic search
    # sudo wget -qO - https://packages.elastic.co/GPG-KEY-elasticsearch | sudo apt-key add -
    # echo "deb https://packages.elastic.co/elasticsearch/2.x/debian stable main" | sudo tee -a /etc/apt/sources.list.d/elasticsearch-2.x.list
    # sudo apt-get update
    # sudo apt-get -y install elasticsearch
    # sudo echo "network.bind_host: 0" >> /etc/elasticsearch/elasticsearch.yml
    # sudo echo "network.host: 0.0.0.0" >> /etc/elasticsearch/elasticsearch.yml
    # sudo echo "http.port: 9202" >> /etc/elasticsearch/elasticsearch.yml # if you use elastic search uncomment java and elasticsearch installation and set the port as you want
    # sudo service elasticsearch restart
    # sudo update-rc.d elasticsearch defaults 95 10

```

 - deploy/script.sh
 
```ruby# -*- mode: ruby -*-
       # vi: set ft=ruby :
       
       module OS
           def OS.windows?
               (/cygwin|mswin|mingw|bccwin|wince|emx/ =~ RUBY_PLATFORM) != nil
           end
       
           def OS.mac?
               (/darwin/ =~ RUBY_PLATFORM) != nil
           end
       
           def OS.unix?
               !OS.windows?
           end
       
           def OS.linux?
               OS.unix? and not OS.mac?
           end
       end
       
       require 'yaml'
       current_dir    = File.dirname(File.expand_path(__FILE__))
       config     = YAML.load_file("#{current_dir}/app/config/agile.yml")
       
       if File.exists? ("#{current_dir}/app/config/parameters.yml")
           params = YAML.load_file("#{current_dir}/app/config/parameters.yml")
           smb_username = params['parameters']['agile_vagrant_smb_user']
           smb_password = params['parameters']['agile_vagrant_smb_password']
       else
           smb_username = ''
           smb_password = ''
       end
       
       ip = config['parameters']['agile.vagrant_ip']
       name = config['parameters']['agile.project_name']
       url = config['parameters']['agile.project_url']
       
       Vagrant.configure(2) do |config|
         config.vm.box = "ubuntu/xenial64"
         config.vm.box_check_update = false
       
         config.vm.network "forwarded_port", guest: 80, host: 8002 # change port as you defined you last number ip adress
         config.vm.network "forwarded_port", guest: 3306, host: 3302 # change port as you defined you last number ip adress
         config.vm.network "forwarded_port", guest: 9200, host: 9202 # change port as you defined you last number ip adress
         config.vm.network "private_network", ip: ip
       
          if Vagrant::Util::Platform.windows? then
            config.vm.synced_folder ".", "/var/www", type: "smb", smb_username: smb_username, smb_password: smb_password
          elsif OS.mac?
            config.vm.synced_folder ".", "/var/www", type: "nfs", :linux__nfs_options => ["rw","no_root_squash","no_subtree_check"]
          else
            config.vm.synced_folder ".", "/var/www", type: "nfs", :linux__nfs_options => ["rw", "no_root_squash", "no_subtree_check"], nfs_version: "4", nfs_udp: false
          end
       
          config.vm.provider "virtualbox" do |vb|
            vb.gui = false
            vb.memory = "2048"
          end
       
         config.vm.provision "file", source: "./deploy/apache/project.conf", destination: "/var/www/project.conf"
         config.vm.provision "file", source: "./deploy/apache/ssl/project.crt", destination: "/var/www/project.crt"
         config.vm.provision "file", source: "./deploy/apache/ssl/project.key", destination: "/var/www/project.key"
         config.vm.provision "file", source: "./deploy/phpmyadmin/config.inc.php", destination: "/var/www/config.inc.php"
         config.vm.provision "file", source: "./deploy/phpmyadmin/apache.conf", destination: "/var/www/apache.conf"
         config.vm.provision "shell", path: "./deploy/script.sh", args: [ip, name, url, '1234']
       end
```
