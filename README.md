# Demo CRUD using Laravel + Vue3 ([Laravel 12](https://laravel.com/docs/12.x/installation))

This code is used as reference control for many purposes and act as a guide to easily implement common BE+FE practices.

## Pre-requisite before using serving this web app

* [Postgres Database](https://www.postgresql.org/download/)
* [Git](https://git-scm.com/downloads)
* [Composer](https://getcomposer.org/download/)  
* [Laravel](https://laravel.com/docs/12.x/installation) 
* [Nodejs](https://nodejs.org/en/download)

## Sites Services Used

* For Components: https://www.shadcn-vue.com/
* For SVG Icons: https://lucide.dev/icons/
* JPG to SVG Converter: https://www.freeconvert.com/svg-converter

## Initialize your Laravel project (invoke the commands listed to Git Bash Shell)

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
```

## Capabilitites

* CRUD to Postgres database
* Displays paginated table
* Saves image file to S3 and S3-compatible server
* Write and Read QRCODE used for Search Queue
* Take Pictures

## Deploymnet

### Host

* https://cloud.laravel.com/

### Deployment Site

* https://c2custcomplaints-master-h24dus.laravel.cloud/
