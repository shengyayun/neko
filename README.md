# Neko-preview
Little and easy robot which based on mojo-webqq

##step 1:

Build this [Mojo-Webqq](https://github.com/sjdy521/Mojo-Webqq) on your linux by cpanm


##step 2:

Edit `neko/neko.pl` for your qq, this file can start your mojo-webq


##step 3:

Edit file `neko/core/config` which desires for your redis and mysql


##step 4:

Excute the sql below in your mysql:

    CREATE DATABASE `neko`  DEFAULT CHARACTER SET utf8;

    CREATE TABLE `neko`.`task` (
      `id` int(11) NOT NULL AUTO_INCREMENT, 
      `time` varchar(20) NOT NULL, 
      `msg` varchar(255) NOT NULL, 
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    CREATE TABLE `neko`.`lexicon` (
      `id` int(11) NOT NULL AUTO_INCREMENT, 
      `key` varchar(255) NOT NULL, 
      `value` varchar(255) NOT NULL, 
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


##step 5:

Put folder `neko` into your website root, 

So the mojo-webqq can access like this http://127.0.0.1/neko/core/sapi.php


##step 6:

Add a crontab `* * * * * php /path/to/your/neko/main.php`

It runs `/path/to/your/neko/main.php` every minute, and this path is not real, it only means the real path of my `neko/main.php` on your linux


##step 7:

Excute `nohup perl /path/to/your/neko/neko.pl &`
and the nohup.out will tell you that you need scan the qrcode.when you done, the robot is on


##step 8:

You found that this README is messy and you fail everywhere, but you are really intersted in it

Ok, my email is 719048774@qq.com