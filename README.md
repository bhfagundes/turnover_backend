# Desafio Turnover : Backend

> Projeto criado para desenvolver o desafio da turnover

## Instalação

``` bash
# Instalar dependências
composer install

# Gerar arquivo de configuração
cp .env.example .env

# Gerar key
php artisan key:generate

# limpar cache de arquivo de configuração, após configurar as variavel de ambiente como BD
php artisan config:cache

# executar as migration
php artisan migrate

# Startar projeto localmente
php artisan serve

```
## Arquitetura do Projeto
> Escolha do Framework:
- Para desenvolvimento do projeto, foi escolhido o Laravel 8. Escolhi tal framework pois já tenho uma forte atuação com o mesmo, atuando pouco mais de 5 anos. Outro fato é por ser utilizado pelo time.
>> Organização do projeto:
>>> - O backend foi organizado utilizando MVC, e para a maioria das funçoes de salvar no Banco de dados, utilizados respositório pattern.
>>> - /app/Http/Requests/API : Aqui temos um camada que pode ser utilizada para realizar validações. Esta é a camada por onde trafega os dados recebidos.
>>> - /app/Http/Resources : Está é uma camada responsável por padronizar as saídas que serão enviadas ao frontend.
>>> - /app/Http/Models : Nesta camada de Models, temos a responsabilidade de comunicação com o banco, mapeando as entidades.
>>> - /app/Http/Repositories : esta camada está entre o model e o controller. O objetivo é facilitar nas possíveis manutençoes. Esta camada facilita para os padrões de SOLID/clean code. A maioria dos itens que demandam ações em banco, exceto as funções de alterações massivas, que utilizaram model diretamente.
>>> - /app/database/factories : os arquivos contidos neste diretórios, são responsável por gerar registros fakes para executar testes por exemplo
>>> - /app/Http/Migrations : neste diretório temos as migrations, ou seja os arquivos que criarão a estrutura básica de tabelas que foi utilizada no projeto. Atenção especial para o último arquivo, que é a migration de uma trigger. Para trabalhar com log, a trigger se torna uma forte aliada. Uma solução equivalente que poderia ser utilizada através do backend, seria os observers.
>>> - /app/routes/api.php: arquivo responsável por mapear as rotas, ou seja, identificar uma url no navegador e qual deverá ser a ação interna para tal item.
>>> - /app/testes: diretório contendo toda a estrutura para execução dos testes, sendo para testes unitários ou não. Contém todo o mock necessário para os respositórios.

>> Bibliotecas e Componentes:
- Para executar o projeto foi utilizado alguns componentes conhecidos entre eles temos:
>>> -  Eloquent : este ORM é bem completo e de fácil utilização. Como se trata de um projeto pequeno atendia perfeitamente. Outras opções poderiamos ter o doctrine.
>>> - kitloong/laravel-migrations-generator: através desta biblioteca conseguimos criar migration a partir de um banco já existente. é uma poderosissima biblioteca caso tenhamos um bd já modelado e por algum motivo precisamos mudar a plataforma, gerar dump estrutural, migrar framework. Seu uso: php artisan migrate:generate 
>>> - swagger: Importante biblioteca para documentar uma api, apresentando seus json de exemplo e como uma interface bastante intuitiva
>>> - phpunit: ferramenta essencial para execução dos testes.

## Observações
 - Após gerar o projeto, a documentação da API pode ser acessada pelo link : {URL}/api/docs
 - Para este projeto não é utilizado autenticação, mas poderíamos implementar facilmente utilizando a autenticação padrão do laravel, com a biblioteca JWT e fazendo referência ao middleware de auth.api
 - Caso não queira utilizar o php artisan serve, podemos utilizar o meio tradicional, meio que é bem utilizado em ambientes de produção, homologação. Neste método basta configurar o nginx ou apache apontando para a pasta do projeto.
