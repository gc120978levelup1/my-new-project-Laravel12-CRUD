# my-new-project-Laravel12-CRUD
Laravel 12 CRUD example with Docker Setup

## Pre-requisite before using ss_LAMP_Docker
* [Docker + WSL2](https://docs.docker.com/get-started/get-docker/) + [Ubuntu](https://documentation.ubuntu.com/wsl/en/latest/howto/install-ubuntu-wsl2/) + [Git](https://git-scm.com/downloads) + [Composer](https://getcomposer.org/download/) + [Laravel](https://laravel.com/docs/12.x/installation) + [Nodejs](https://nodejs.org/en/download) + [Vue3](https://vuejs.org/) + [VSCode](https://code.visualstudio.com/Download)
* [Setup Docker to work nicely with WSL2.](https://learn.microsoft.com/en-us/windows/wsl/tutorials/wsl-containers)
* Make sure DOCKER is running when executing the command lines below

## Set All the Docker Services Names to point to 127.0.0.1 Hostname (use WSL2 terminal)

### Run WSL2 as an administrator mode

All this Host Names can be found in docker-compose.yml file
```sh
sudo nano /mnt/c/windows/system32/drivers/etc/hosts
```

### add the following items at the bottom of the list and save the file

```sh
127.0.0.1 database.garry.com
127.0.0.1 www.garry.com
127.0.0.1 phpmyadmin.garry.com
```

## Open this LARAVEL Project Folder using [VSCode](https://code.visualstudio.com/)

### From VSCode, launch Git Bash Terminal

### Check Docker Containers Status in (Git Bash Terminal)

```sh
./ss check
```

## Launch Containers in  (Git Bash Terminal) (node + composer)

```sh
./ss up
```

### Launch Initial Data Migration in  (Git Bash Terminal)

```sh
php artisan key:generate
php artisan storage:link
./ss migrate
```

### Now Your Project (Production) is ONLINE!!!!
* In your project .env file change DB_PORT=33061 to DB_PORT=3306 in order to open production site [WWW_SERVER](http://www.garry.com)

* Using your browser, visit the phpmyadmin address as per specified in the service (docker-compose.yml file)
ex. [PhpMyAdminServer](http://phpmyadmin.garry.com:8001/)

* mysql_dbase_port: 33061
* mysql_dbase_name: www-garry-com
* user : xuser5345345
* password: 234we3243345353
* user : root
* password:

### Run The Development Mode to Edit Things  (Git Bash Terminal)
* In your project .env file change DB_PORT=3306 to DB_PORT=33061
```sh
./ss dev
```
### You can NOW Open Your [Development Site!!!](http://127.0.0.1:8000/)

You can now be able to start coding your application and see the changes on the development site rite away.

### Shut Down Container in  (Git Bash Terminal)

```sh
./ss down
```

### List of ss_LAMP_Docker commands
    =====================================================================
      Usage: ./ss check     - Check the status of the containers
             ./ss merge     - Merge this ss_DOCKER_LAMP to main project
             ./ss up        - Start the Garry's Mod server
             ./ss down      - Stop the Garry's Mod server
             ./ss migrate   - Execute database migration
             ./ss dev       - Launch the development server
             ./ss bkup      - Backup the database
             ./ss visit-db  - Visit the database container
             ./ss visit-www - Visit the web server container
             ./ss help      - Show this help message
             ./ss -h        - Show this help message

# [Guide For BackEnd Coding](https://github.com/gc120978levelup1/ss_LAMP_Docker/blob/master/README%20file%20Backend%20Guide.md)

# [Guide For FrontEnd Coding](https://github.com/gc120978levelup1/ss_LAMP_Docker/blob/master/README%20file%20Frontend%20Guide.md)
