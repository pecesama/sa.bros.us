#!/bin/sh

xgettext *.php include/*.php --keyword=__ --from-code=ISO-8859-1 --no-wrap --no-location --sort-output
sed -i 's|"Content-Type: text/plain; charset=CHARSET\\n"|"Content-Type: text/plain; charset=UTF-8\\n"|' messages.po

for LANGUAGE in $(ls locale/); do
	msgmerge --update --no-wrap --sort-output locale/${LANGUAGE}/LC_MESSAGES/messages.po messages.po
	msgfmt -o locale/${LANGUAGE}/LC_MESSAGES/messages.mo locale/${LANGUAGE}/LC_MESSAGES/messages.po
	if [ -e locale/${LANGUAGE}/LC_MESSAGES/messages.po~ ]; then
		rm locale/${LANGUAGE}/LC_MESSAGES/messages.po~
	fi
done

rm messages.po
