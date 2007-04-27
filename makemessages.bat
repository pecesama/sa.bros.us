dir /a /b /-p /o:gen *.php > sources.txt
cd include
dir /a /b /-p /o:gen *.php > sources_include.txt
cd ..

PATH C:\Program Files\GnuWin32\bin

for /f %%a in ('dir /b locale') do call :add_strings "%%a"

cd include
del sources_include.txt
cd ..
del sources.txt

goto :eof

:add_strings
xgettext --keyword=__ --language=PHP --files-from=sources.txt -j --from-code=UTF-8 -d locale/%1/LC_MESSAGES/messages
cd include
xgettext --keyword=__ --language=PHP --files-from=sources_include.txt -j --from-code=UTF-8 -d ../locale/%1/LC_MESSAGES/messages
cd ..
cd locale/%1/LC_MESSAGES
msgfmt messages.po
cd ../../..