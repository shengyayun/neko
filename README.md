# Neko-preview
Little and easy robot which based on mojo-webqq

##step 1:

Build this [Mojo-Webqq](https://github.com/sjdy521/Mojo-Webqq) on your linux by cpanm


##step 2:

Edit file `neko/core/config` which desires for your redis and mysql


##step 3:

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

    insert into `neko`.`task` (`time`, `msg`) values ('22:00', '最后冒泡，冒完睡觉');

    insert into `neko`.`lexicon` (`key`, `value`) values ('*愚蠢的丝丝*', '[1]天真的丝丝[2]');


##step 4:

Put folder `neko` into your website root, so the mojo-webqq can access it in `http://127.0.0.1/neko/core/sapi.php`


##step 5:

Add a crontab `* * * * * php /path/to/your/neko/main.php`

It runs `/path/to/your/neko/main.php` every minute, and this path is not real, it only means the real path of my `neko/main.php` on your linux


##step 6:

Excute `nohup perl /path/to/your/neko/neko.pl &`

and the nohup.out will tell you that you need scan the qrcode.when you done, the robot is on


##step 7:

You found that this README is messy and you fail everywhere, but you are really intersted in it

OK, my email is 719048774@qq.com