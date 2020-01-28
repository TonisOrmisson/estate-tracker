#!/bin/bash

git fetch --all
lastTag=$(git describe --tags $(git rev-list --tags --max-count=1))
echo "Latest version is : "$lastTag
git checkout $lastTag
composer install --no-dev