Para arrancar o entorno a primeira vez: docker compose up -d --build

as seguintes veces: docker compose up 

Este entorno está formado por:
    Aplicación PHP: http://localhost:8080
    phpMyAdmin: http://localhost:8081
    MySQL: localhost:3306

Datos de acceso a phpMyAdmin:
    Servidor: mysql
    Usuario: app
    Contraseña: app_password
        ou
    Servidor: mysql
    Usuario: root
    Contraseña: root_password

Comandos habituais:
 Ver los contenedores: docker compose ps
 Ver los logs de PHP: docker compose logs -f php
 Entrar en el contenedor PHP: docker compose exec php bash
 Parar el entorno: docker compose stop (os contenedores quedan creados pero detidos)
                   docker compose down (para o borra os contedores)
                   docker compose down -v (elimina tamén tódolos datos almacenados en MySQL)

Forzar parada e borrado de tódolos contedores que temos no ordenador:
                docker rm -f $(docker ps -aq)

Comprobar que contedores temos:
                docker ps -a

Limpar Docker completamente (contedores, imaxes, redes e volumes)
                docker system prune -a --volumes


