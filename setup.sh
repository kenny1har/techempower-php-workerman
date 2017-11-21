#!/bin/bash

fw_depends mysql php7 nginx composer

php $TROOT/server.php
