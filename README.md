<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects.

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Technologies Used:-

The project is build using Laravel. The framework of the MVC is well maintained. 
SQlite is used as database, ajax and javaScript for the airport autocomplete.
Eloquent is used for creating tables, defining database relation and querrieng values from DB.
Bootstrap, HTML, CSS and the blade templeting is used for front-end
The entire website is responsive so that it can be seamlessly used on mobile device with out breaking any visual representation 


## Steps to run the project:-

1) Install Xampp, composer and npm. If you already have then then it's great.
2) Copy the project and put it to your htdocs folder.
3) Go to your VS code terminal (I prefer using VS code) and if you are not having it then you can simply open any bash            terminal and run the following command:- 
   "composer update" it will  then it will update all the packages in your local copy.
4) Go to your xampp folder then apache->conf->extra and open the httpd-vhosts.conf file. At the bottom add the following          lines:-
            <VirtualHost *:80>
            DocumentRoot "c:/xampp/htdocs/TripBuilder/public"
            ServerName tripbuilder.test
            <Directory "c:/xampp/htdocs/TripBuilder">
            </Directory>
            </VirtualHost>
Make sure to change the directoryName and the DpccumentRoot  as your xampp's drive where you have installed it.

5) Now go to "C:\Windows\System32\Drivers\etc\" and open the "hosts" file in your notepad/nodepad++, make sure you are in       administration mode. At the bottom of the file add "172.0.0.1  tripbuilder.test" and save it.
6) Close the Xampp and start the Apache and MySql again. 

You should be good to start the project. Go to the browser and type tripbuilder.test
