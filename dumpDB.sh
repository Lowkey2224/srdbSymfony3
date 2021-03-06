#!/usr/bin/env bash

#!/bin/sh

# include parse_yaml function
. parse_yaml.sh

# read yaml file
eval $(parse_yaml app/config/parameters.yml config_)

# access yaml content

echo "Dumping Database ${config_parameters__database_name} to /home/mysql_dump/${config_parameters__database_name}_`date +"%s"`.sql.gz ."
mysqldump -u "$config_parameters__database_user" --password="$config_parameters__database_password" "$config_parameters__database_name" | gzip -9 > /home/mysql_dump/${config_parameters__database_name}_`date +"%s"`.sql.gz
res=$?
echo "Finished with Code $res"
exit $res
