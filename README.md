# neko
little and easy robot bases on mojo-webqq

step 1:
build this https://github.com/sjdy521/Mojo-Webqq on your linux by cpanm

step 2:
edit 'neko/neko.pl' for your qq,this file can start your mojo-webq

step 3:
edit file 'neko/core/config' which desires for your redis and mysql

step 4:
create database 'neko' in your mysql,and the table 'lexicon' with its sql below
CREATE TABLE `neko`.`lexicon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

step 5:
put folder 'neko' into your website root,so the mojo-webqq can access like this 'http://127.0.0.1/neko/core/sapi.php'

step 6:
add a crontab "* * * * * php /path/to/your/neko/main.php"
it runs '/path/to/your/neko/main.php' every minute,and this path is not real,it only means the real path of my 'neko/main.php' on your linux

step 7:
excute "nohup perl /path/to/your/neko/neko.pl &"
and the nohup.out will tell you that you need scan the qrcode.when you done,the robot is on





