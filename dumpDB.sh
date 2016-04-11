#!/usr/bin/env bash

#!/bin/sh

# include parse_yaml function
. parse_yaml.sh

# read yaml file
eval $(parse_yaml app/config/parameters.yml config_)

# access yaml content

filename="~/mysql_dumps/${config_parameters_database_name}_`date +"%s"`.sql"
echo "Dumping Database ${config_parameters_database_name} to ${filename} ."
#mysqldump -u "$config_parameters_database_user" --password="$config_parameters_database_password" "$config_parameters_database_name" > "./mysql_dumps/"${config_parameters_database_name}"_`date +"%s"`.sql"

mysqldump -u "$config_parameters_database_user" --password="$config_parameters_database_password" "$config_parameters_database_name" > {$filename}
res=$?
echo "Finished with Code $res"
exit $res
