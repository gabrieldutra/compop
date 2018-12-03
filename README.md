# Central de Oportunidades - CEFET/MG
## Sobre a plataforma
- Esta plataforma foi desenvolvida durante a competição DECOM Celebrations (https://github.com/cefetmg-decom/2016-celebrations) em comemoração ao aniversário de 10 anos do DECOM. Ela tem o objetivo de atender a demanda dos alunos do curso de Engenharia de Computação de encontrar atividades complementares para cumprir com a obrigatoriedade curricular.

## Linguagem utilizada
O sistema possui backend em PHP usando Slim e frontend utilizando Bootstrap e AngularJS.

## Executando em ambiente local
### 1. Instalar Dependências
- `sudo apt install mysql-server php php-mysql`

### 2. Configurar o banco de dados
Configure o banco de dados **compop** no MySQL:
- `mysql -u root -p -e "create database compop;"`
- `mysql -u root -p compop < api/compop.sql`

Faça a configuração na API:
- `cp api/connection.example.php api/connection.php`

Edite o arquivo `api/connection.php` com um editor de sua preferência (ex: `vim api/connection.php` :grin:) e insira a senha de acesso do seu banco de dados local.


### 3. Execute o servidor
- `php -S 0.0.0.0:3000`

Acesse http://localhost:3000 e o servidor já deverá estar funcionando
