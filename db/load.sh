#!/bin/sh

BASE_DIR=$(dirname $(readlink -f "$0"))
if [ "$1" != "test" ]
then
    psql -h localhost -U p -d p < $BASE_DIR/p.sql
fi
psql -h localhost -U p -d p_test < $BASE_DIR/p.sql
