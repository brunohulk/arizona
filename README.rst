Teste Arizona - Bruno Borges
============================

Teste desenvolvido com o framework Silex, seguindo o `Escopo`_

Requirementos
----------------------------
* PHP 7
* Apache ou Nginx
* MongoDb

Instalar dependências
----------------------------
Como quase todo o projeto hoje em dia em PHP é necessário utilizar o composer para instalar
as dependências do projeto.
.. code-block:: console
    $ composer install

Configuração
----------------------------
A aplicação está já está pré-configurada para os ambientes de Dev e Prod:
.. code-block:: php
    $app['host_country_data'] = "http://www.umass.edu/microbio/rasmol/country-.txt";
    $app['db_name'] = 'arizona';
    $app['csv_file'] = "/tmp/countries.csv";

O host do banco de dados também já está configurado no service provider do mongo no arquivo app.php conforme abaixo:
.. code-block:: php
    $app->register(new MongoDBServiceProvider(), [
        'mongodb.config' => [
            'server' => 'mongodb://localhost:27017',
            'options' => [],
            'driverOptions' => []
        ]
    ]);

Popular banco de dados
----------------------------

Para executar o teste é necessário popular o banco de dados, para o teste foi escolhido o
MongoDb, através do comando abaixo é possível fazer isso. Esse command utiliza guzzle como client para
recuperar os dados do host remoto dado no scopo do site, após isso os dadis são inseridos em lote na
collection `countries` no database `arizona`
.. code-block:: console

    $ bin/console generate-data-countries

Iniciar a aplicação
-----------------------------

É possível iniciar a aplicação utilizando os comandos abaixo:

.. code-block:: console

    $ cd path/app
    $ COMPOSER_PROCESS_TIMEOUT=0 composer run

ou

.. code-block:: console

    $ cd path/app
    $ php -S localhost:8888 -t web

O primeiro comando é um aliás para o segundo.

Acessar aplicaçao
--------------------------

Para acessar a aplicação basta abrir o navegador e acessar: http://localhost:8888

Coding Standards
---------------------------

Adotei o padrão de codificação da `PSR-2`_ com uma pequena ajuda do `PHP-CS`_ =D

Rodar os testes
----------------------------
Escrevi alguns testes de unidade para cobrir a lógica da aplicação, porém não neste presente momento ainda não configurei
corretamento o phpunit.xml.dist =(, portando eles devem ser rodados separadamente e arquivo por arquivo.
.. code-block:: console
    $ phpunit tests/Unit/Repository/CountryTest.php
    $ phpunit tests/Unit/Model/CountryModelTest.php
    $ phpunit tests/Unit/Resources/CsvTest.php

TODO e Technical Debts
----------------------------
* Configurar bootstrap dos testes do PHPUNIT
* Mover configuração do banco de dados para fora do provider
* Serializar objetos do Mongo automaticamente ao invés de hidratá-los manualmente.
* Escrever mais testes
* Adicionar LOG
* Melhorar tratamento de erros

Autor
----------------------------
Bruno Borges - http://brunoborges.info

Enjoy!

.. _Escopo:: https://gist.github.com/ivanrosolen/ab14da0485bcc24a2ca3ac0cff351e56
.. _PSR-2:: http://www.php-fig.org/psr/psr-2/
.. _PHP-CS: https://github.com/squizlabs/PHP_CodeSniffer