#!/bin/sh

BASE_DIR=$(dirname $(readlink -f "$0"))
if [ "$1" != "test" ]
then
    psql -h localhost -U liltalk -d liltalk < $BASE_DIR/liltalk.sql
fi
psql -h localhost -U liltalk -d liltalk_test < $BASE_DIR/liltalk.sql
