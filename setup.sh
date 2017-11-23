#!/bin/bash

fw_depends mysql php7 composer

php $TROOT/server.php start -d
