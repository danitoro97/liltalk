#!/bin/sh

if [ "$1" = "travis" ]
then
    psql -U postgres -c "CREATE DATABASE p_test;"
    psql -U postgres -c "CREATE USER p PASSWORD 'p' SUPERUSER;"
else
    [ "$1" != "test" ] && sudo -u postgres dropdb --if-exists p
    [ "$1" != "test" ] && sudo -u postgres dropdb --if-exists p_test
    [ "$1" != "test" ] && sudo -u postgres dropuser --if-exists p
    sudo -u postgres psql -c "CREATE USER p PASSWORD 'p' SUPERUSER;"
    [ "$1" != "test" ] && sudo -u postgres createdb -O p p
    sudo -u postgres createdb -O p p_test
    LINE="localhost:5432:*:p:p"
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
