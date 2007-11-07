dir /a /b /-p /o:gen *.php > sources.txt
cd include
dir /a /b /-p /o:gen *.php > sources_include.txt
cd ..

PATH C:\Archivos de programa\poEdit\bin

for /f %%a in ('dir /b locale') do call :add_strings "%%a"

cd include
del sources_include.txt
cd ..
del sources.txt

goto :eof

:add_strings
xgettext --keyword=__ --language=PHP --files-from=sources.txt -j --from-code=UTF-8 -d languages/%1/messages
cd include
xgettext --keyword=__ --language=PHP --files-from=sources_include.txt -j --from-code=UTF-8 -d ../languages/%1/messages
cd ..
cd locale/%1/LC_MESSAGES
msgfmt messages.po
cd ../../..