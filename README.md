# Projeto Template de Laravel 8

## Sumário

* [Projeto Template de Laravel 8](#projeto-template-de-laravel-8)
    * [Sumário](#sumário)
        * [Pré-requisitos](#pré-requisitos)
            * [Instalando git](#instalando-git)
            * [Instalando docker](#instalando-docker)
            * [Instalando docker-compose](#instalando-docker-compose)
        * [<em>Alias</em> sail](#alias-sail)
        * [Gerar chave de SSH](#gerar-chave-de-ssh)
        * [Baixar código fonte](#baixar-código-fonte)
        * [Logar no hub](#logar-no-hub)
    * [Instalação](#instalação)
        * [Iniciar os serviços](#iniciar-os-serviços)
        * [Parar os serviços](#parar-os-serviços)
    * [Referências](#referências)
        * [Laravel](#laravel)
        * [Jetstream e Livewire](#jetstream-e-livewire)
    * [Tutoriais](#tutoriais)
        * [Laravel 8 - Limewire - Building a Simple CMS](#laravel-8---limewire---building-a-simple-cms)
        * [Laravel 8 - Jetstream - CRUD com TDD](#laravel-8---jetstream---crud-com-tdd)
            * [Erros](#erros)

### Pré-requisitos

Instalado no computador:
* git
* docker
* docker-compose

#### Instalando git

Instalar

```
sudo apt-get install aptitude
sudo aptitude install git
```

#### Instalando docker

Instalar

```
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
```

#### Instalando docker-compose

Instalar

```
sudo curl -L "https://github.com/docker/compose/releases/download/1.25.4/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
```

Dar permissão para o seu usuário executar `docker` sem precisar de `sudo`:

```bash
sudo usermod -aG docker $USER
```

**IMPORTANTE**: será necessário reiniciar a sessão (deslogar e logar novamente).

### *Alias* sail

Edite o arquivo de configuração do seu terminal (Ex: bash: `~/.bashrc`) e adicione um alias para a execução do **sail**:

```shell
alias sail='bash vendor/bin/sail'
```

Depois carregue a configuração:

```shell
source ~/.bashrc
```

Depois disso, sempre que estiver na raiz do seu projeto, poderá acessar diretamente o sail com o *alias* configurado.

### Gerar chave de SSH

Caso não tenha, gerar a chave de ssh (substituir o `email`):

```bash
ssh-keygen -t rsa -b 4096 -C "email@example.com"
```

Pegar o conteúdo da sua chave pública (.pub) e adicionar no Gitlab no seu [Perfil](https://git.dds.ufvjm.edu.br/profile/keys)

Conteúdo da chave:

```bash
cat ~/.ssh/id_rsa.pub
```

### Baixar código fonte

Testando se não existe pasta para o código fonte

```bash
if [ ! -d ~/laravel ]; then
    echo -e "Criando pasta para armazenar códigos das aplicações laravel"
    mkdir ~/laravel
fi
```

Entrando no diretório e baixando:

```bash
cd ~/laravel
git clone git@git.dds.ufvjm.edu.br:dds/laravel-8-dds.git
cd laravel-8-dds
```

### Logar no hub

Logar no hub do repositório do DDS - UFVJM (só precisar ser executado uma vez)
Alterar `nome.sobrenome` para seus dados da conta institucional

```bash
docker login -u nome.subrenome hub.dds.ufvjm.edu.br
```

Deverá ser retornado `Login Succeeded`.

## Instalação

### Iniciar os serviços

Iniciar os containers dos serviços

```shell
sail up -d
```

### Atualizar banco de dados

Atualizar a estrutura do banco do dados:

```shell
sail artisan migrate
```

### Parar os serviços

```shell
sail down
```

## Referências

### Laravel

[Laravel 8](https://laravel.com/docs/8.x/)

### Jetstream e Livewire

[Jetstream e Livewire](https://jetstream.laravel.com/2.x/installation.html)


## Tutoriais

### Laravel 8 - Limewire - Building a Simple CMS

Fonte: [Laravel 8 - Building a Simple CMS](https://www.youtube.com/playlist?list=PLSP81gW0XjNHk2D2NREM8A80xWO19Yulj)

Repositório oficial: [github.com/jackoftraits/laravel8-with-livewire](https://github.com/jackoftraits/laravel8-with-livewire)

* [Aula 1 - Installation](https://www.youtube.com/watch?v=Ub6FMEWw7kA&list=PLSP81gW0XjNHk2D2NREM8A80xWO19Yulj&index=1)
* [Aula 2 - Create Operation using Jetstream Modal](https://www.youtube.com/watch?v=xX1qmJwGqg4&list=PLSP81gW0XjNHk2D2NREM8A80xWO19Yulj&index=2)
* [Aula 3 - Read, Update, Delete w/ Jetstream Modal](https://www.youtube.com/watch?v=G-ngqfbP5Yk&list=PLSP81gW0XjNHk2D2NREM8A80xWO19Yulj&index=3)
* [Aula 4 - Understanding the Jetstream Modal](https://www.youtube.com/watch?v=UEJBlc7uxBE&list=PLSP81gW0XjNHk2D2NREM8A80xWO19Yulj&index=4)
* [Aula 5 - Frontpage Component for Dynamic Pages](https://www.youtube.com/watch?v=GN5BP86VjsE&list=PLSP81gW0XjNHk2D2NREM8A80xWO19Yulj&index=5)
* [Aula 6 - A Brief Intro To Tailwind CSS](https://www.youtube.com/watch?v=ApC723fmV2c&list=PLSP81gW0XjNHk2D2NREM8A80xWO19Yulj&index=6)
* [Aula 7 - Frontend Design Using Tailwind CSS](https://www.youtube.com/watch?v=W1sxcagzjy4&list=PLSP81gW0XjNHk2D2NREM8A80xWO19Yulj&index=7)
* [Aula 8 - Understanding the Basics of Alpine JS](https://www.youtube.com/watch?v=23hFm-HmdGE&list=PLSP81gW0XjNHk2D2NREM8A80xWO19Yulj&index=8)
* [Aula 9 - Implement Dynamic Navigation Menu](https://www.youtube.com/watch?v=A8Tc652gs2E&list=PLSP81gW0XjNHk2D2NREM8A80xWO19Yulj&index=9)
* [Aula 10 - User Access Roles Laravel Middleware](https://www.youtube.com/watch?v=IsmGlPi43hk&list=PLSP81gW0XjNHk2D2NREM8A80xWO19Yulj&index=10)
* [Aula 11 - Create a Livewire CRUD Generator](https://www.youtube.com/watch?v=2ZVpKXrr09Y&list=PLSP81gW0XjNHk2D2NREM8A80xWO19Yulj&index=11)
* [Aula 12 - Finalize Dynamic User Access Roles](https://www.youtube.com/watch?v=m6THBDAmbAw&list=PLSP81gW0XjNHk2D2NREM8A80xWO19Yulj&index=12)
* [Aula 13 - Push Notifications without Pusher](https://www.youtube.com/watch?v=IdlzVl3RDFg&list=PLSP81gW0XjNHk2D2NREM8A80xWO19Yulj&index=13)
* [Aula 14 - Create a Simple Livewire Chat](https://www.youtube.com/watch?v=Sze3SVIakxA&list=PLSP81gW0XjNHk2D2NREM8A80xWO19Yulj&index=14)

### Laravel 8 - Jetstream - CRUD com TDD

Fonte: [CRUD com TDD usando Laravel Jetstream com Livewire](https://www.youtube.com/playlist?list=PL6fICz-Eo7QRIGLhoarXqJ__5FPeD3uKL)

Repositório original: [github.com/Laravel-Road/crud-contacts](https://github.com/Laravel-Road/crud-contacts)

* [Aula 1 - Instalação e customização](https://www.youtube.com/watch?v=srqIQHF1vn8&list=PL6fICz-Eo7QRIGLhoarXqJ__5FPeD3uKL&index=1)
* [Aula 2 - Formulário de cadastro](https://www.youtube.com/watch?v=oMR0-6gXfs8&list=PL6fICz-Eo7QRIGLhoarXqJ__5FPeD3uKL&index=2)
* [Aula 3 - Listagem e Paginação](https://www.youtube.com/watch?v=GGbyUObc1Ck&list=PL6fICz-Eo7QRIGLhoarXqJ__5FPeD3uKL&index=3)
* [Aula 4 - Edição e Remoção](https://www.youtube.com/watch?v=v6AkTiW3lNI&list=PL6fICz-Eo7QRIGLhoarXqJ__5FPeD3uKL&index=4)
* [Aula 5 - Teams, Tenant e Policy](https://www.youtube.com/watch?v=u09wu7NOuBg&list=PL6fICz-Eo7QRIGLhoarXqJ__5FPeD3uKL&index=5)

#### Erros

Erro `  Unable to call lifecycle method [mount] directly on component: [contacts.contact-new]
` nos testes, conferir [este post](https://forum.laravel-livewire.com/t/polling-broken-after-laravel-and-livewire-update/3918).
