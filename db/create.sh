#!/bin/sh

if [ "$1" = "travis" ]
then
    psql -U postgres -c "CREATE DATABASE liltalk_test;"
    psql -U postgres -c "CREATE USER liltalk  PASSWORD 'liltalk' SUPERUSER;"
else
    [ "$1" != "test" ] && sudo -u postgres dropdb --if-exists liltalk
    [ "$1" != "test" ] && sudo -u postgres dropdb --if-exists liltalk_test
    [ "$1" != "test" ] && sudo -u postgres dropuser --if-exists liltalk
    sudo -u postgres psql -c "CREATE USER liltalk PASSWORD 'liltalk' SUPERUSER;"
    [ "$1" != "test" ] && sudo -u postgres createdb -O liltalk liltalk
    sudo -u postgres createdb -O liltalk liltalk_test
    LINE="localhost:5432:*:liltalk:liltalk"
    FILE=~/.pgpass
    if [ ! -f $FILE ]
    then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE
    then
        echo "$LINE" >> $FILE
    fi
fi
