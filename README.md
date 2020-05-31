## About project
- This project is Pharmacy Manage System it will help you to store data and enables functionality that organizes sells within pharmacies 

- You will need at least laravel 7.2.

## Clone Project

Open cmd on a file to download the project in it then write this command line.

If you didn't download the project you will need to write this command.

 - "git clone https://github.com/ahmedsalah674/PMS_project_researsh.git" 

then you will countinue.

## After Clone

If you already downloaded it from the link or you cloned it , you will open cmd or countinue in your cmd and start from here.

- cd (the dirction of project file).... For example : cd G:\pms\pms_project_researsh 

- composer install 

- copy .env.example .env

- php artisan key:generate

Now you need to open phpmyadmin and create a new database and name it ('pms_project')

- php artisan migrate

- php artisan db:seed

- php artisan serve

Now the project is ready but please note that you cannot rejester with pharmcist you will use this pharmcist account .

- username:pharmcist@pharmcist.com .

- password:pharmcist .