# Igreja Semear

Sistema web da **Comunidade Cristã Semear** — site institucional com blog, notícias e eventos, além de um painel administrativo completo para gerenciamento de conteúdo e membros.

## Stack

| Camada     | Tecnologia                                   |
| ---------- | -------------------------------------------- |
| Backend    | PHP 8.3 · Laravel 10                         |
| Frontend   | Livewire 3 · Alpine.js · Tailwind CSS 3 · Vite |
| Banco      | MySQL / MariaDB                              |
| Ambiente   | Docker (Laravel Sail)                        |
| Extras     | Quill (editor), Flatpickr, Tom Select, FontAwesome, SweetAlert2 |

## Funcionalidades

### Site público
- Página inicial, blog com artigos e categorias, notícias
- Página de atendimento, cadastro de novos membros
- Busca, feed RSS e sitemap
- Política de privacidade e páginas dinâmicas

### Painel administrativo (`/admin`)
- **Dashboard** com resumo de membros, posts, eventos e ofertas
- **Usuários**: membros, equipe, perfil, cadastro com foto, CEP automático e máscaras
- **Posts**: gerenciamento com editor Quill, categorias, imagens e SEO
- **Slides** (banners), **Ministérios**, **Eventos** e **Ofertas**
- **Cargos e Permissões** (Spatie) — disponível para super administrador
- **Configurações**: dados do site, SEO/meta tags, contato, redes sociais e uploads de logo/imagens
- **Notificações** em tempo real e **gerador de sitemap**
- Layout responsivo em Tailwind com a identidade visual da igreja (verde-floresta e dourado)

## Pré-requisitos

- [Docker](https://www.docker.com/) com `docker compose`
- PHP 8.3 · Composer
- Node.js 20+ · npm

## Instalação

```bash
# 1. Suba o ambiente com Laravel Sail
./vendor/bin/sail up -d

# 2. Instale as dependências PHP e JS
./vendor/bin/sail composer install
./vendor/bin/sail npm install

# 3. Configure o ambiente
cp .env.example .env
./vendor/bin/sail artisan key:generate

# 4. Rode as migrações e os seeders
./vendor/bin/sail artisan migrate --seed
```

O seeder cria um usuário super administrador:

- **E-mail:** `admin@semear.com.br`
- **Senha:** valor de `ADMIN_PASS` no `.env` (padrão `password`)

Acesse o painel em `http://localhost/admin` e o site em `http://localhost`.

## Comandos úteis

```bash
# Subir / derrubar o ambiente
./vendor/bin/sail up -d
./vendor/bin/sail down

# Compilar os assets (CSS/JS)
./vendor/bin/sail npm run dev     # em desenvolvimento
./vendor/bin/sail npm run build   # em produção

# Rodar migrações e seeders
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed

# Conferir rotas e limpar cache de views
./vendor/bin/sail artisan route:list
./vendor/bin/sail artisan view:cache
```

## Estrutura de rotas

### Web (`routes/web.php`)
| Rota                 | Função                              |
| -------------------- | ----------------------------------- |
| `/`                  | Página inicial                      |
| `/blog`              | Blog com artigos e categorias       |
| `/noticias`          | Notícias                            |
| `/atendimento`       | Página de atendimento               |
| `/cadastro-novo-membro` | Cadastro de novos membros        |
| `/feed`              | Feed RSS                            |
| `/sitemap`           | Sitemap                             |

### Admin (prefixo `/admin`)
| Rota                            | Função                          |
| ------------------------------- | ------------------------------- |
| `/admin`                        | Dashboard                       |
| `/admin/usuarios/membros`       | Lista de membros                |
| `/admin/usuarios/time`          | Equipe                          |
| `/admin/posts`                  | Posts                           |
| `/admin/slides`                 | Slides (banners)                |
| `/admin/ministerios`            | Ministérios                     |
| `/admin/eventos`                | Eventos                         |
| `/admin/ofertas`                | Ofertas                         |
| `/admin/cargos`, `/admin/permissoes` | Cargos e permissões       |
| `/admin/configuracoes`          | Configurações do sistema        |
| `/admin/notificacoes`           | Notificações                    |
| `/admin/sitemap-generator`      | Gerador de sitemap              |

## Convenções do projeto

- **Layout do admin:** `resources/views/components/layouts/app.blade.php` (padrão do Livewire)
- **Componentes Livewire:** `app/Livewire/Dashboard/**` com views em `resources/views/livewire/dashboard/**`
- **Paleta visual:** `forest` (verde), `gold` (dourado) e `paper` definidas em `tailwind.config.js`
- **Assets:** `resources/css/app.css` e `resources/js/app.js` (admin), `resources/js/front.js` (site)

## Licença

Projeto de uso interno da igreja.
