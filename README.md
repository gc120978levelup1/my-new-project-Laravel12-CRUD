# Demo CRUD using Laravel + Vue3 ([Laravel 12](https://laravel.com/docs/12.x/installation))
### This is code will be used as reference guide for many purposes and act as a guide to easily implement common practices.

## Pre-requisite before using ss_LAMP_Docker

* [Git](https://git-scm.com/downloads)
* [Composer](https://getcomposer.org/download/)  
* [Laravel](https://laravel.com/docs/12.x/installation) 
* [Nodejs](https://nodejs.org/en/download)

### Initialize your Laravel project (invoke the commands listed to Git Bash Shell)

Note: copy and paste the command listed

```sh
composer install
npm install
npm install leaflet
npm install -D sass-loader sass
npm i @zxing/browser
npm install --save qrcode
npx shadcn-vue@latest add sonner
composer require league/flysystem-aws-s3-v3 "^3.0" --with-all-dependencies
npm run build
php artisan key:generate
php artisan storage:link
php artisan migrate
```
### Invoke Local Server

```sh
composer run dev
```sh

## Capabilitites

* CRUD to Postgres database
* Displays paginated table
* Saves image file to S3 and S3-compatible server
* Write and Read QRCODE used for Search Queue
* Take Pictures

### Deploymnet

* https://cloud.laravel.com/
