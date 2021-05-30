#!/bin/sh
if [ "$#" -ge 2 ]
then
	user="$1"
	group="$2"
else
	user="$(whoami)"
	group=http
fi
if [ "$(whoami)" = 'root' ]
then
	chown -R "$user:$group" .
	chmod 664 $(find . -type f)
	chmod 775 $(find . -type d)
	chmod 775 $(find . -type f -name '*.sh')
else
	sudo "$0" "$user" "$group"
fi
