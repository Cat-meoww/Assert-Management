FROM mcr.microsoft.com/devcontainers/php:0-8.1

# Install MariaDB client
RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y mariadb-client \ 
    && apt-get clean -y && rm -rf /var/lib/apt/lists/*

# Install php-mysql driver
RUN docker-php-ext-install mysqli pdo pdo_mysql 


RUN apt-get update && apt-get install -y libicu-dev && docker-php-ext-install -j$(nproc) intl && apt-get purge -y libicu-dev

WORKDIR /workspaces/Assert-Management

#RUN mysql -h 127.0.0.1 -uroot -pmariadb inventory < inventory.sql
#CMD ['mysql','-h','127.0.0.1', '-uroot','-pmariadb','inventory','<','inventory.sql']

# [Optional] Uncomment this section to install additional OS packages.
# RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
#     && apt-get -y install --no-install-recommends <your-package-list-here>

# [Optional] Uncomment this line to install global node packages.
# RUN su vscode -c "source /usr/local/share/nvm/nvm.sh && npm install -g <your-package-here>" 2>&1

