#!/bin/bash
docker container run --rm -v $(pwd):/app/ php:8.4.1-cli php /app/$1.php
