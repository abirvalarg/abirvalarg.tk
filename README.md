# deployment
## requirments
- Linux
- Apache
- PHP7 with `Mysqli` support
- MySQL or MariaDB. Developed for MariaDB, may have problems with MySQL

## apache config
configurations for different systems are a bit different, make sure to check paths.

here's a working example for Arch linux
```apache
<VirtualHost *:80>
	DocumentRoot /srv/http/abirvalarg.tk/web	# directory 'web' in repository
	ServerName localhost	# change to you host name

	php_value include_path ".:/srv/http/abirvalarg.tk/php"	# directory 'php' in repository
</VirtualHost>
```

## SSL/TLS/HTTPS
:)

## adding credentials
create file `credentials.sh` in root directory of repository. it should look like example below:
```sh
DB_USER='username'
DB_PASSWORD='password'
```
replace `<username>` and `<password>` with information that'll be used to connect to database. you don't have to create database or user with those credentials

## prepare database
start your database service then go to root directory of repository and run following command
```sh
./prep_db.sh
```
this will set up database. you have to be able to use `sudo` on the machine because it's needed to connect to database. make sure that that script doesn't output any errors. if there were any errors then it'll return non-zero value so it can be safely used in other scripts.

## start server
just start Apache as wiki your system says

# updating
you may want to stop Apache before updating the server to make sure there won't be any bad requests to database. pull new versioning of server
```ssh
git pull
```
update database
```sh
./prep_db.sh
```
then start Apache, if you stopped it earlier. this update will not change DB credentials in database but will update them in the server and make it impossible to connect to DB so **make sure to keep `credentials.sh` without changes**
