# eventopia
Connecting event creators and participants on one platform.

## Sobre
Projeto desenvolvido por <a href="https://levsistemas.com.br/" target="_blank">Eventopia Team</a> para o projeto Eventopia.

## Instruções de uso

É necessário ter ao menos o php8.2 e Composer instalado localmente (fora do docker), 
pois o auxiliar `sail` fica dentro da pasta `vendor`.

<a href="https://techvblogs.com/blog/install-php-8-2-ubuntu-22-04" target="_blank">Instalar php8.2 no ubuntu 22.04</a>,
<a href="https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos" target="_blank">Instalar composer</a>.

Dê preferencia ao <a href="https://docs.docker.com/engine/install/ubuntu/" target="_blank">Docker Engine</a> executando 
no <a href="https://learn.microsoft.com/pt-br/windows/wsl/install" target="_blank">Wsl2</a> no windows ao 
invés do Docker Desktop e seja feliz!


Obs: Após a instalação do php o `apache` é instalado e iniciado por padrão na porta `80` e gerará conflito 
com o container do `sail`, então é necessário desabilitar o apache com os comandos abaixo.

````
$ sudo apt install php-xml
$ sudo systemctl stop apache2
$ sudo systemctl disable apache2
````


### Baixar e executar o projeto no primeiro uso (dentro do wsl2).

Caso o composer emita erros dizendo faltam extensões do php, 
no próprio aviso descreve a(s) extensão(ẽs) e a forma de ignorar ela(s) na instalação, pois somente usaremos o 
php local para instalar a pasta `vendor` e partir dela usaremos somente o `sail` que executará tudo dentro 
dos containers docker.

Também é necessário criar um token de acesso pessoal no github

````
$ cd ´sua pasta de projetos´
$ git clone https://github.com/eliemarjunior/sisunesc.git sisunesc
$ cd sisunesc
$ cp .env.example .env
$ composer install --ignore-platform-reqs
````

Após o composer instalar a pasta `vendor` **sem erros** use o `sail` para iniciar o projeto do docker.

O caminho para executar o auxiliar `sail` é `./vendor/bin/sail`, e é muito recomendado criar um álias no terminal
traduzindo a palavra `sail` para o comando mencionado acima.

#### <a href="https://br.atsit.in/archives/37429" >Artigo sobre o Sail</a>

### Comandos básicos

Para iniciar os containers do docker
````
$ sail up -d
````

Criar tabelas do banco de dados
```
$ sail artisan migrate
```

Parar os containers
````
$ sail down
````

Executar o artisan 
````
$ sail artisan {comando do artisan}
````

Para saber mais comando dos artisan pesquise na <a href="https://laravel.com/docs/" target="_blank">documentação</a> do laravel ou execute
````
$ sail -h
````


Criar Usuário de teste no banco de dados use o tinker para gerar a senha
```
$ sail tinker
> bcrypt('123456');
> exit();
```

Substitua na SQL a password, pela hash que o tinker gerar no bcrypt()
```
> insert into usuarios (name, email, email_verified_at, password, created_at, updated_at) VALUES ('User1', 'user1@teste.com', now(), 'password aqui', now(), now());
```

## LocalStack
O LocalStack é uma aplicação que simula alguns serviços da AWS localmente para desenvolvimento. 
Este projeto já contem o container iniciado, mas precisamos criar e configurar o bucket do S3 que 
utilizaremos localmente.

Pôr padrão ao iniciar o projeto são criados dois buckets `local-private` e `local-public`, que são, privado e publico respectivamente.

#### Erro URL gerada pelo s3 do LocalStack
Ao usar o AWS S3 como disco de armazenamento sempre é gerado uma url 
do serviço do S3 ao invés de usar a url do aplicativo, pois o objetivo é justamente 
direcionar o trafego de arquivos para fora do aplicativo reduzindo sua carga. Quando o serviço esta em produção o link da aws é resolvido pelo servidor 
de dns configurado na máquina normalmente como qualquer outro site, mas quando usamos o localstack no container localmente é gerado a url apontando 
para o nome do serviço rodando no docker e precisamos apontar manualmente o nome do dns no `hosts` da máquina

Abra o arquivo `hosts` do seu SO (**não é do WSL2**) e cole as seguintes informações.

Linux
```
127.0.0.1   localstack
```

Windows
```
localstack  127.0.0.1
```

#### Instalar AWS CLI no Linux ou Wsl2

Caso precise de modificar o bucket ou criar novos, abaixo alguns comandos de exemplo.

```
$ curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip"
$ unzip awscliv2.zip
$ sudo ./aws/install
```

#### Configurar aws CLI

```
$ aws configure
```
Forneça as informações de configuração da aws de acordo com seu `.env`

#### Criar Bucket local privado
```
$ aws --endpoint-url=http://localhost:4572 s3api create-bucket --bucket local-private
$ aws --endpoint-url=http://localhost:4572 s3api put-bucket-acl --acl private --bucket local-private
```

## Bases teóricas usadas no projeto

* *Obs: Não é aplicado tudo que está abaixo, é somente a base teórica para o projeto*

### SOLID

<a href="https://www.youtube.com/watch?v=6SfrO3D4dHM" target="_blank">SOLID fácil com ilustrações</a>

### Stitcher.io

<a href="https://stitcher.io/blog/laravel-beyond-crud-01-domain-oriented-laravel" target="_blank">01. Domain oriented Laravel</a>

<a href="https://stitcher.io/blog/laravel-beyond-crud-02-working-with-data" target="_blank">02. Working with data</a>

<a href="https://stitcher.io/blog/laravel-beyond-crud-03-actions" target="_blank">03. Actions</a>

<a href="https://stitcher.io/blog/laravel-beyond-crud-04-models" target="_blank">04. Models</a>

<a href="https://stitcher.io/blog/laravel-beyond-crud-05-states" target="_blank">05. States</a>

<a href="https://stitcher.io/blog/laravel-beyond-crud-06-managing-domains" target="_blank">06. Managing domains</a>

<a href="https://stitcher.io/blog/laravel-beyond-crud-07-entering-the-application-layer" target="_blank">07. Entering the application layer</a>

### CODECASTS

<a href="https://www.youtube.com/watch?v=bKhLhkAe28k&list=PLy5T05I_eQYOhdPaE1lO512Bhaqh-RkdV&pp=iAQB" target="_blank">Playlist modularizando Laravel</a>

### BEER AND CODE

<a href="https://www.youtube.com/watch?v=t_KByV1pwgs" target="_blank">Laravel DDD - Estrutura de pastas e arquivos - DDD Domain Driven Design 001</a>

<a href="https://www.youtube.com/watch?v=XG9Y9VFvKag" target="_blank">Laravel DDD - Finalizando a estrutura - DDD Domain Driven Design 002</a>

