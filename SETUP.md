<h1>Local deployment</h1>
<b>Required:</b> Composer, Docker Desktop, MariaDB

1. Pull latest version.
2. RUN ```composer update``` command in project directory from terminal (CMD, PowerShell etc.).
3. RUN ```docker-compose up -d``` command in project directory from terminal (make sure Docker-Desktop is running).
4. RUN ```docker ps``` command and copy on of CONTAINER ID.
   ```
   CONTAINER ID   IMAGE          COMMAND                  CREATED      STATUS       PORTS                   NAMES
   ca9c5e8e66d2   poc-frontend   "docker-php-entrypoi…"   4 days ago   Up 2 hours   0.0.0.0:20080->80/tcp   poc-frontend-1
   ```
5. RUN ```docker exec -it {copied-id} bash``` command to enter your container (your local development "server").
6. RUN ```php init``` inside docker container to initiate your project. Choose option ```0``` for development.
7. To exit docker container RUN ```exit``` command.
8. Edit ```project/common/main-local.php``` to your needs. Example DB configuration:
   ```'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=host.docker.internal;dbname=poc',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ],```
9. Repeat step 4 and 5 to enter Docker container.
10. RUN ```php yii migrate``` and type ```yes``` to apply DB migrations.