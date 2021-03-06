#!/bin/bash
# Copyright (c) 2017 OpenStack Foundation
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#    http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or
# implied.
# See the License for the specific language governing permissions and
# limitations under the License.

# install virtual env for python
sudo pip install virtualenv;

# update php.ini settings
upload_max_filesize=240M
post_max_size=240M
max_execution_time=300
max_input_time=223
display_errors=On
error_reporting=E_ALL
memory_limit=512M

for key in memory_limit upload_max_filesize post_max_size max_execution_time max_input_time display_errors error_reporting
do
 sed -i "s/^\($key\).*/\1 $(eval echo \=\${$key})/" /etc/php/7.2/fpm/php.ini
done
sudo service php7.2-fpm start;
sudo service php7.2-fpm restart;

cd /var/www/www.openstack.org;
# create local folder for ss cache
mkdir -p /var/www/www.openstack.org/silverstripe-cache;
sudo -H -u vagrant bash -c "composer install --ignore-platform-reqs --prefer-dist";
sudo ./framework/sake installsake;

if [[ -f scripts/setup_python_env.sh ]]; then
	echo "installing python virtual env";
	chmod 775 scripts/setup_python_env.sh;
	./scripts/setup_python_env.sh;
fi

