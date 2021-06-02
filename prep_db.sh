#!/bin/sh
if [ "$(whoami)" = 'root' ]
then
	echo -e "\e[93mLoading credentials\e[0m"
	source ./credentials.sh
	if [ "$?" -ne 0 ]
	then
		echo -e "\e[91mCan't load credentials from 'credentials.sh'\e[0m"
		exit 1
	fi
	echo "<?php
	define('DB_USER', '$DB_USER');
	define('DB_PASSWORD', '$DB_PASSWORD');
	?>" > php/credentials.php
	echo "CREATE DATABASE abirvalarg_tk CHARACTER SET 'utf8';
	GRANT INSERT, SELECT, UPDATE, DROP ON abirvalarg_tk.* TO '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASSWORD';" > migrations/credentials.sql
	echo -e "\e[93mMigrating DB\e[0m"
	for migFile in migrations/credentials.sql migrations/*.sql
	do
		if ! [ -f "$migFile.done" ]
		then
			echo -n "$migFile... "
			if mysql < "$migFile"
			then
				touch "$migFile.done"
				echo -e "\e[32mOK\e[0m"
			else
				code=$?
				echo -e "\e[31mFAILED\e[0m"
				exit $code
			fi
		fi
	done
else
	sudo "$0" $@
fi
