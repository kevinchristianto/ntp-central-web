<h1 align="center">NTP Central Web</h1>

## Requirements
- Docker

## Additional Requirements for Windows
- WSL2 enabled and any distro is installed (Ubuntu recommended)
- Store the project folder on the WSL environment
- Enable Docker integration for the installed distro

## Installation
- Clone this repository
- Store the project folder on the WSL environment (if using Windows)
- ```cd``` to project folder
- Run ```cd laradock```
- Run ```docker compose up -d nginx postgres```
- Wait for the build to finish
- Still in ```laradock``` directory, run ```docker compose exec workspace bash```
- Run ```composer install```
- Run ```npm install```
- Run ```php artisan key:generate```
- Run ```php artisan migrate:fresh --seed```
- Run ```php artisan optimize```
- Open ```localhost``` on your browser