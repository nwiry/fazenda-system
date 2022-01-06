# Fazenda System

Sistema para auxíliar no controle de uma fazenda de bovinos.

## Recursos

- Cadastro, edição, listagem, e visualização do gado da fazenda;
- Relatório de animais disponíveis para abate, seguindo as condições: (Possui mais de 5 anos de idade, produz menos de 40l de leite, produz menos de 70l de leite e ingere mais de 50kg de ração por dia, possui peso maior que 18@);
- Relatório da quantidade total de produzido por semana;
- Relatório de animais abatidos;
- Relatório da quantidade total de ração necessária por semana;

## Dependências

- PHP 7.4+
- Composer 2.x+

## Instalação

Clone o repositório utilizando o git com o código abaixo:
```sh
git clone https://github.com/diogocqr/fazenda-system.git
```
Após a clonagem, acesse o diretório do repositório: `cd fazenda-system`.
Dentro do diretório, execute os comandos:
```sh
composer install --no-dev
php artisan install:farm
php artisan key:generate
```
Após rodar os comandos, basta inicializar o projeto em um servidor da sua preferência, ou utilize o comando abaixo para visualização local:
```sh
php artisan serve
```
Caso deseje utilizar o projeto em um servidor apache (hospedagem cloud/compartilhada/xampp, etc...), renomeie o arquivo `.oldhtaccess` para `.htaccess`, e mova os arquivos da pasta `fazenda-system` para o diretório raiz (normalmente _htdocs_/_public_html_/_etc..._).