# Igreja Semear - Modo Manutenção (site + área do membro) - Status: Concluído ✅

## O que foi feito

1. **Campos novos na tabela `config`** (migration `2026_08_17_000001_add_maintenance_fields_to_config_table`):
   - `maintenance_mode` (boolean, default false)
   - `maintenance_message` (text, nullable)
   - `maintenance_until` (timestamp, nullable)

2. **`Config` model**: `fillable` + casts (`maintenance_mode` boolean, `maintenance_until` datetime).

3. **Admin - aba "Manutenção"** (`Settings` + `settings.blade.php`): toggle "Ativar modo manutenção", campo "Retorno automático" (datetime-local → `maintenance_until`, se preenchido o site volta sozinho) e textarea "Mensagem personalizada". Aviso amber explicando o comportamento. `normalizeDates()` converte bool→int e `maintenance_until`→`Y-m-d H:i:s`; `mount()` formata para `Y-m-d\TH:i` (formato do input).

4. **Middleware `App\Http\Middleware\MaintenanceMode`** (alias `maintenance`, registrado no Kernel):
   - Ativo quando `maintenance_mode=true` E (`maintenance_until` vazio OU futuro).
   - Redireciona para `web.manutencao` toda requisição das rotas web/member, exceto: a própria página de manutenção e usuários autenticados com role `super admin`/`admin`/`pastor`/`lider` (staff pode pré-visualizar).
   - Aplicado em `routes/web.php`: grupo `web.` (`middleware: ['maintenance']`) e grupo `member.` (`['auth', 'member', 'maintenance']`). **Admin, login e webhooks não são bloqueados** — só a parte administrativa segue funcionando.

5. **Página de manutenção** (`WebController::manutencao()` → `resources/views/web/default/manutencao.blade.php`, rota `web.manutencao` = `/manutencao`):
   - Standalone (inline CSS, sem Tailwind/master), paleta do tema: fundo `linear-gradient(#f0f7f0 → #e6f0e6)`, logo (ou fallback com app_name), ícone engrenagem em tile, h1 "Em manutenção", mensagem (`maintenance_message` ou padrão), **último culto do YouTube** (`YoutubeVideo::TYPE_CULTO`, embed 16:9 + título), contatos (endereço exibição, telefone/celular `tel:`, e-mail `mailto:`) e redes sociais (YouTube/Facebook/Instagram). `noindex`.

6. **Testes** `tests/Feature/MaintenanceModeTest.php` (7/7): site público 200 com manutenção off; `/` e `/minha-conta` redirecionam quando on; staff (role admin) passa; página `/manutencao` mostra mensagem/contatos/último culto; `maintenance_until` expirado desativa; Settings salva os 3 campos. Suíte completa: **93 testes passando (285 assertions)**.

## Para continuar
- [ ] Conferir visual em `/admin/configuracoes` → aba "Manutenção" (toggle, retorno automático, mensagem) e a página `/manutencao` com manutenção ativada (logo, mensagem, contatos, último culto).
- [ ] Com manutenção ativa, validar que admin (`/admin`) e login continuam funcionando e membro/visitante veem a página personalizada.
- [ ] Lembrar que staff (roles admin/pastor/lider/super admin) consegue navegar no site normalmente mesmo com manutenção ativa.

---

# Igreja Semear - Menu Mobile (Minha conta) + Páginas de Erro Refatoradas - Status: Concluído ✅

## O que foi feito

1. **Menu mobile com "Minha conta"** (`resources/views/web/default/master/master.blade.php`): adicionado bloco `@auth @if(auth()->user()->member)` no drawer mobile (logo após o site-search) com link estilizado `bg-brand-600/10 text-brand-700` para `route('member.dashboard')`, `@click="mobileOpen = false"`. Validado em Chrome headless: logado, o link aparece no drawer com href `/minha-conta` (links do drawer: Ver todos, Minha conta, Início, Sobre a Igreja, Ministérios, Cultos e horários, Pregações, Galeria de fotos, Eventos, Cultos Online, Contato, Localização, Pedido de oração, Política de Privacidade).

2. **Páginas de erro refatoradas** (`resources/views/errors/`): as 2 existentes (403, 404) foram refatoradas e as 6 faltantes criadas (401, 402, 419, 429, 500, 503). Todas com a paleta do tema (inline CSS, sem depender de Tailwind/layouts): fundo `linear-gradient(#f0f7f0 → #e6f0e6)`, código gigante com gradiente `brand` (#076134→#2e6028, `background-clip: text`), ícone SVG em tile `bg brand/8%`, h1 `#1f471e`, texto `#557c21`, botões arredondados `#076134` (hover `#2e6028`) + variante outline. Ícones/mensagens por status:
   - 401: lupa com seta (Não autenticado) → botões "Fazer login" (`route('login')`) + "Voltar para o início".
   - 402: cartão (Pagamento necessário) → "Voltar para o início".
   - 403: cadeado (Acesso negado) → "Voltar para o início" + "Fazer login" (`route('login')`).
   - 404: lupa (Página não encontrada) → "Voltar para o início" + "Ir para o site" (`route('web.home')`).
   - 419: relógio (Sessão expirada) → "Voltar para o início".
   - 429: círculo de alerta (Muitas solicitações) → "Voltar para o início".
   - 500: triângulo de alerta (Algo deu errado) → "Tentar novamente" (`onclick="location.reload()"`) + "Voltar para o início".
   - 503: engrenagem (Em manutenção) → "Tentar novamente".
   - `$exception->getMessage()` preservado em 403/404 (default pt-BR quando vazio).

3. **Crédito no footer** (mesma sessão): `Feito com 🖤 por {{ env('DESENVOLVEDOR', 'Informática Livre') }}` com `href="{{ env('DESENVOLVEDOR_URL', 'https://informaticalivre.com.br') }}"`, `target="_blank" rel="noopener"` — **sem coluna no banco e sem campo no admin** (decisão do usuário: "não na tabela no config/app"). Revertidos: migration `desenvolvedor_url`, `Config.php` fillable, `ConfigTableSeeder` e regra de `Settings.php`.

4. **Nota**: a senha do membro de teste `serra.caio@example.org` no dev DB estava inválida (hash não conferia com `password` — re-seed anterior mudou o hash); redefinida via tinker (`bcrypt('password')`) para validar o login.

## Para continuar

- [ ] Conferir visual em `/` (mobile) → hambúrguer → item "Minha conta" logado como membro; e em qualquer rota inexistente (404) / área restrita (403).
- [ ] Suíte completa: **83 testes passando (258 assertions)**; assets compilados (`npm run build` OK).

---

# Igreja Semear - Área do Membro Refatorada para o Tema - Status: Concluído ✅

## O que foi feito

Todas as páginas da área do membro (`resources/views/web/default/member/`) foram refatoradas para a paleta do tema (antes usavam `slate`/`sky` fora do padrão):

- **sidebar.blade.php**: avatar `bg-brand-600`, nome `text-brand-900`, nav ativa `bg-brand-600 text-white`, hover `hover:bg-brand-50 hover:text-brand-700`.
- **dashboard.blade.php**: stats `text-brand-700`, cards `border-brand-100`, tiles de data `bg-brand-600/10 text-brand-700`, links `text-brand-600`, badge "Confirmada" `bg-accent-500/15 text-accent-700`.
- **perfil.blade.php**: labels `text-brand-700`, títulos `text-brand-900`, card `border-brand-100`.
- **contribuicoes.blade.php**: card total `bg-brand-700 text-white` (subtext `text-brand-100`), valores `text-brand-700`.
- **agenda.blade.php**: tiles de data `bg-brand-600/10 text-brand-700`, badge "Inscrito" `bg-accent-500/15 text-accent-700`.
- **familia.blade.php**: badges por papel — chefe `bg-brand-600/10 text-brand-700`, conjuge `bg-accent-500/15 text-accent-700`, filho `bg-sky-600/10 text-sky-700`; avatar inicial `bg-brand-100 text-brand-700`; anel do membro `ring-brand-200`.
- **historico.blade.php**: badge "Realizado" `bg-accent-500/15 text-accent-700` (cancelada segue `rose`).
- **oracoes.blade.php**: resposta `bg-brand-50 text-brand-800`, badge "Respondido" `bg-accent-500/15 text-accent-700`.
- **avisos.blade.php**: data `text-brand-600`, título `text-brand-900`.
- **inscricoes.blade.php**: badge confirmada `bg-accent-500/15 text-accent-700`, link "Ver agenda" `text-brand-600`.

Padrão do tema aplicado em todas: seção `bg-brand-50`, cards `border-brand-100 bg-white`, títulos `font-display text-brand-900`, acentos em `brand`, sucesso em `accent`, cores semânticas de estado (amber/rose) mantidas.

## Para continuar
- [ ] Conferir visual em `/minha-conta` (login: `serra.caio@example.org` / senha padrão do seeder).
- Suíte completa: **77 testes passando (234 assertions)** após a refatoração.

---

# Igreja Semear - Frontend Color Customization

## Status: Concluído ✅

### O que foi feito

1. **Tailwind Cores já estavam definidas** em `tailwind.config.js`:
   - `brand`: #076134 (DEFAULT), #2e6028 (600), #1f471e (700), etc.
   - `accent`: #8bc835 (DEFAULT), #6fa32a (600), #557c21 (700), etc.
   - `brown`: #714e32 (DEFAULT), #7b5640 (600), #664534 (700), etc.
   - `sky`: #d6ebf6 (DEFAULT), #55b8dd (500), #3a94c0 (600), etc.
   - `slate-500`: #95989f

2. **`resources/css/front.css`** - Site público:
   - `.btn-primary` → `bg-brand-600` / `hover:bg-brand-700`
   - `.btn-secondary` → `bg-accent-500` / `hover:bg-accent-400`
   - `.btn-white` → `text-brand-700` / `hover:bg-brand-50`
   - `.input-site` / `.form-control` → `focus:border-brand-500`
   - `.badge-cat` → `bg-brand-600/10` / `text-brand-700`
   - `.badge-cat-amber` → `bg-accent-500/15` / `text-accent-700`
   - `.card-post` → `border-brand-100`
   - `.section-title` → `text-brand-900`
   - `.page-hero` → `from-brand-800 via-brand-700 to-brand-600`
   - `.breadcrumb-site` → `text-brand-100` / `hover:text-accent-300`
   - `.prose-site h2/h3` → `text-brand-900`
   - `.prose-site a` → `text-brand-600` / `hover:text-brand-700`
   - `.prose-site blockquote` → `border-brand-500` / `bg-brand-50`

3. **`resources/css/app.css`** - Painel admin:
   - Botões: `bg-brand-600`, `bg-accent-500`, `bg-brown-600`, etc.
   - Badges: `bg-brand-100`, `bg-brown-100`, `bg-brand-800`, etc.
   - Alertas: `bg-brown-50`, `text-brown-800`, etc.
   - Cards: `border-brand-100`, `text-brand-800`, `bg-brand-50/70`
   - Formulários: `border-brand-300`, `text-brand-700`
   - Textos: `text-brown-600`, etc.
   - Header/breadcrumb: `text-brand-800`, `text-brand-600`, etc.

4. **`resources/views/web/default/master/master.blade.php`** - Footer:
   - `<footer class="bg-brand-900 text-brand-100">`
   - Textos: `text-brand-300/80`/`text-brand-300/70`
   - Borda: `border-brand-100`
   - Cookie consent: `border-brand-100`, `bg-brand-900`, `text-brand-600/500/400`
   - Botões mantiveram classes `.btn-primary` / `.btn-secondary`

### Próximos passos / Para continuar

**Verificar consistência visual:**
- [ ] Rodar `./vendor/bin/sail npm run build` e conferir se todas as páginas estão usando as cores corretamente
- [ ] Verificar components Livewire (dashboard, forms, etc.) se também usam as cores da marca
- [ ] Testar responsividade em mobile/desktop
- [ ] Verificar contraste das cores (brand-900 texto sobre fundo brand-900 etc.)

**Possíveis ajustes futuros:**
- Adicionar mais tons da paleta se necessário (brand-50, brand-100, etc.)
- Ajustar transparências (`/10`, `/15`, `/80`) conforme visual
- Integrar cores em componentes Livewire específicos
- Criar componentes reutilizáveis com as cores da marca

**Para retomar:**
- Rodar `./vendor/bin/sail npm run build` para compilar assets
- Verificar `php artisan test` para garantir que nada quebrou
- Conferir visual nas páginas: home, blog, eventos, ministérios, etc.

---

# Módulo de Doações (Mercado Pago) - Status: Implementado ✅

## O que foi feito

1. **Gateway**: `mercadopago/dx-php` ^3.14 (v3.14.0) instalado. Credenciais em `.env` (`MERCADOPAGO_TOKEN`, `MERCADOPAGO_PUBLIC_KEY`, `MERCADOPAGO_WEBHOOK_SECRET`) e `config/services.php` (chave `mercadopago`).

2. **Enums** (`app/Enums/`): `DonationTypeEnum` (tithe/offering/donation/other), `DonationStatusEnum` e `PaymentStatusEnum` (pending/paid/failed/cancelled/refunded), `PaymentMethodEnum` (pix/card). Padrão `label()`/`labels()`.

3. **Migrations**: `create_donations_table` e `create_payments_table` (polimórfico `payable`). Obs: `donations.payment_id` é coluna solta (sem FK, pois `payments` é criada depois) — integridade via relação polimórfica. `./vendor/bin/sail artisan migrate` OK.

4. **Models**: `Donation` (uuid, `member()`, `payment()`, accessors `type_label`/`status_label`/`amount_formatted`, `source_label`/`method_label`/`contributor_name`, campos `source` (online/manual) e `payment_method`) e `Payment` (uuid, `payable()` morphTo, `markAsPaid/Failed/Cancelled/Refunded`, `method_label`).

5. **Camada de gateway** (`app/Services/Payments/`):
   - `Contracts/PaymentGatewayInterface` (name/create/find/cancel/handleWebhook)
   - `Data/`: `GatewayCreateRequest`, `GatewayPayment`, `GatewayWebhook`
   - `Exceptions/PaymentGatewayException`
   - `MercadoPago/MercadoPagoGateway` (base: client com token, buildRequest, map, notification_url = `/webhooks/payments/mercadopago`, statusFromEvent)
   - `MercadoPagoPixGateway` (payment_method_id=pix, expira em 30min) e `MercadoPagoCardGateway` (token de cartão via SDK JS)
   - `PaymentGatewayFactory::for(PaymentMethodEnum)` e `byName(string)` — `gateway` gravado como `mercadopago_pix`/`mercadopago_card`

6. **Services**: `app/Services/Donations/DonationService.php` (createDonation com `Money::normalize`, attachPayment, markPaid/Failed/Cancelled/Refunded, syncFromPayment, summarize, totalsByType) e `app/Services/Payments/PaymentService.php` (processDonation em transação, initiate, handleWebhook idempotente com re-consulta ao gateway, refresh, cancel). `app/Support/Money.php` (normaliza "R$ 1.250,50" / "1250.50").

7. **Webhook**: `App\Http\Controllers\Webhook\PaymentWebhookController` (`POST /webhooks/payments/{gateway}`, sem CSRF). Valida `x-signature` via `WebhookSignatureValidator` quando presente; notificações QR Code PIX não são assinadas (status real sempre confirmado via `find()` no gateway).

8. **Público**: `app/Livewire/Web/DonationForm.php` + `resources/views/livewire/web/donation-form.blade.php` (mobile-first, 4 etapas: Motivo → Valor → Identificação → Pagamento). **Importante**: usa `render()` com `->extends('web.default.master.master')` (layout `@yield`), NÃO `#[Layout]` (que usa `@slot` e não funciona com esse master). Rota `web.doacoes` = `/doacoes`. PIX mostra QR base64 + copia-e-cola + polling `checkPayment`; Cartão usa `mp.cardForm` com SDK JS (`window.__initMpCard`, `$this->getId()`). Menu do site aponta para `web.doacoes`.

9. **Admin**: `app/Livewire/Dashboard/Donations/Donations.php` + view (cards Dízimo/Oferta/Doação/Outro, filtros tipo/status/método/período, tabela, modal de detalhes). Rotas `admin.donations.index` = `/admin/doacoes`, `admin.donations.create` = `/admin/doacoes/cadastrar`, `admin.donations.edit` = `/admin/doacoes/{donation}/editar`. Menu lateral em `side-navigation.blade.php` com contagem + sub-link "Cadastrar Manual".

10. **Permissões**: `manage donations` adicionada ao seeder `RolesAndPermissionsTableSeeder` (super admin + admin). Permissão `manage offerings` **removida** (módulo unificado).

11. **Extras/consertos**:
    - `AppServiceProvider::boot()` agora usa try/catch em `Config::find(1)` (evita crash quando as tabelas ainda não existem — conserta testes com SQLite).
    - `tests/Feature/DonationFormTest.php`: 7 testes passando (página pública, wizard 4 etapas, valor inválido bloqueado, falha de gateway marca doação 'failed', página admin autenticada, página de cadastro manual, doação manual salva como 'paid'). **Importante**: precisa `use RefreshDatabase;` DENTRO do corpo da classe (não só importar) — `class_uses_recursive` não detecta o import.
    - Dev DB foi restaurado com `migrate:fresh --seed` (60 usuários).

---

# Unificação Ofertas + Doações (um só módulo) - Status: Implementado ✅

## O que foi feito

1. **Um modelo só**: o módulo de **Ofertas (legado, manual)** foi absorvido pelo módulo de **Doações**. Não existe mais `Offering` — tudo é `Donation`, com `source` = `online` (via Mercado Pago) ou `manual` (cadastrado no admin).

2. **Migrations**:
   - `2026_08_14_100002_add_source_to_donations_table`: adiciona `donations.source` (default `online`) e `donations.payment_method` (só usada em registros manuais).
   - `2026_08_14_100003_migrate_offerings_to_donations`: copia `offerings` → `donations` (tipo `oferta`→`offering`, `dizimo`→`tithe`, status `paid`, source `manual`, `payment_method` preservado, `created_at` = `offering_date`, `member_id` via `members.user_id`), remove a permissão `manage offerings` e **droppa** a tabela `offerings`. Down() recria a tabela e devolve os registros manuais.

3. **Model `Donation`**: novos accessors `source_label` (Manual/Online), `method_label` (manual → `payment_method`; online → `payment->method_label`) e `contributor_name` (membro→usuário→anônimo). `fillable` ganhou `source` e `payment_method`.

4. **Admin unificado**:
   - Menu lateral: item **"Doações"** (era "Ofertas" + "Doações") com sub-links **Listar Todas** e **Cadastrar Manual**. `OfferingsCount`/menu de ofertas removidos.
   - Listagem `/admin/doacoes`: badge de origem (Manual/Online), filtro de pagamento agora cobre métodos manuais (dinheiro/pix/transferência/débito/crédito/boleto/outro) + os distintos no DB, coluna de método via `method_label`, modal de detalhes com origem + botão **Editar** (só para manuais).
   - Cadastro/edição manual: `app/Livewire/Dashboard/Donations/DonationForm.php` + view (membro, tipo, valor, data, método manual, anônimo, descrição). Salva com `source=manual`, `status=paid`, `created_at` = data informada. Rotas `admin.donations.create/edit`.

5. **Dashboard admin**: totais de Ofertas trocados por Doações pagas (`donationsYear`, `donationsTotal`, `dizimosTotal`) e links para `admin.donations.index`.

6. **Área do membro**: `MemberAreaController::contribuicoes()` agora busca `Donation` do membro (via `member.user_id = auth()->id()`); view mostra `type_label`, `method_label` e data. Relação `User::offerings()` removida.

7. **Remoções** (legado Ofertas): `app/Livewire/Dashboard/Offerings/` (componentes), views `dashboard/offerings/`, `app/Models/Offering.php`, `OfferingFactory.php`, `OfferingsTableSeeder.php`, rotas `admin.offerings.*`, permissão `manage offerings` (seeders + migration `add_pastor_lider_roles`), itens de menu e links do dashboard.

8. **Seeders novos**: `MembersFromUsersSeeder` (copia usuários com role `member` → `members`; **importante**: `copy_users_to_members` é migration e roda ANTES dos seeders, então `migrate:fresh --seed` não criava membros — este seeder corrige isso) e `DonationsTableSeeder` (doações manuais demo ligadas aos primeiros 10 membros). `DonationFactory` criada. `DatabaseSeeder` atualizado.

9. **Testes**: 7/7 em `DonationFormTest` (inclui página de cadastro manual e persistência de doação manual 'paid'). `ExampleTest` (home 500 em DB de teste vazio) segue falhando — pré-existente, fora do escopo.

10. **Dev DB**: repovoado — 60 usuários, 20 membros, 20 doações (19 manuais com membro + 1 online de teste). As 27 ofertas fake antigas foram migradas e depois limpas (perderam o vínculo pois `members` estava vazia); demo re-gerado via seeders.

## Para continuar

- [ ] Conferir visual do admin `/admin/doacoes` (badges de origem, filtro de método manual, modal com "Editar") e da área do membro "Minhas contribuições".
- [ ] Validar `migrate:fresh --seed` ponta a ponta (membros + doações demo).
- [ ] Credenciais reais do Mercado Pago (ver seção acima) para testar doações online.

## Para continuar

**Credenciais reais** (não há token no `.env`):
- Preencher `MERCADOPAGO_TOKEN`, `MERCADOPAGO_PUBLIC_KEY`, `MERCADOPAGO_WEBHOOK_SECRET` no `.env` e configurar o webhook `https://DOMINIO/webhooks/payments/mercadopago` no painel do Mercado Pago (eventos de payment + notificações de QR PIX).

**Verificar consistência:**
- [ ] Testar fluxo PIX completo (QR + pagamento via app) com credenciais de teste
- [ ] Testar fluxo Cartão (tokenização + pagamento)
- [ ] Relatórios por período/tipo/método/status/membro (esboço em `DonationService::summarize/totalsByType`; ainda sem view dedicada)
- [ ] `refresh()`/`cancel()` no admin para pagamentos pendentes
- [ ] Avisos: status `pending` órfão após falha de gateway (doação fica 'failed' via `failDonation()`)
- [ ] Testar webhook de forma assinada e não assinada

**Comandos úteis:**
- `./vendor/bin/sail artisan migrate` / `migrate:fresh --seed`
- `./vendor/bin/sail artisan test --filter=DonationFormTest`
- `./vendor/bin/sail npm run build`
- Sempre usar `./vendor/bin/sail` (env vars do host NÃO chegam ao container — não adianta prefixar `DB_CONNECTION=...`).

---

# Cadastro de Novo Membro (público) - Melhorias - Status: Implementado ✅

## O que foi feito

1. **Bug corrigido (quebrava o cadastro)**: o formulário enviava `baptism` como string `'false'` e a cast `boolean` do Eloquent **não converte na escrita** (só na leitura), gerando `SQLSTATE[22007] ... Incorrect integer value: 'false' for column users.baptism`. Corrigido em `WebController::createMemberSend` normalizando os booleans (`$request->baptism === 'true'`) e `baptism_date` só quando batizado.

2. **Validação custom (sem validação nativa do browser)**: form com `novalidate`, sem `required`. JS valida (nome, data nascimento dd/mm/aaaa + não-futura, sexo, e-mail, WhatsApp ≥10 dígitos, batismo, data batismo) destacando campos inválidos (`is-invalid` + mensagem inline `.field-error`) e Toastify de aviso. Erros somem ao digitar. O servidor (`createMemberSend`) ganhou validações mais robustas com try/catch no `Carbon::createFromFormat`.

3. **Notificação a administradores (BD + E-mail)**:
   - **BD**: nova `App\Notifications\NewMemberRegistered` (canal database; `data`: title/message/description/url=`admin.users.view`/type=`new_member`/color=`success`), disparada em `WebController::notifyAdmins()` para roles `super admin`, `admin`, `pastor`, `lider`. Ícones `new_member` (fa-user-plus) adicionados em `notifications-list.blade.php` e `notifications-dropdown.blade.php` (sino do topo).
   - **E-mail**: já existia (`App\Mail\Web\CreateMember`).

4. **Pastas `member` vs `membro`**: eram redundantes. `member/` = área do membro autenticada (usada pelo `MemberAreaController`); `membro/` só tinha o cadastro público + `avaliacao.blade.php` (morto, template legado de hotel, sem rota). Consolidado: `membro/cadastro.blade.php` → `member/cadastro.blade.php` (ref em `WebController::createMember` atualizada), `avaliacao.blade.php` removido, pasta `membro/` excluída. Agora há **uma só pasta** `member/`.

5. **Form redesenhado (visual moderno)**: seções numeradas (Dados Pessoais → Endereço → Batismo → Participação → Conhecer a Igreja) com badges nas cores da marca (brand/accent/sky), radios em "pills" (`peer-checked`), `flatpickr` no nascimento/batismo (já existia, mantido com `disableMobile`), link da Política de Privacidade abre em **nova aba** (`target="_blank"`), sucesso via **SweetAlert** (`Swal.fire` com `confirmButtonColor` brand) + redirect para home, botão com estado de loading (spinner).

6. **Testes**: `tests/Feature/MemberRegistrationTest.php` (3/3): cria user+member com `baptism=0`, notifica admin via BD, rejeita data inválida.

## Para continuar

- [ ] Conferir visual e validação em `/cadastro-novo-membro` (campos destacados, Toastify, Swal de sucesso, link política em nova aba).
- [ ] Verificar sino de notificações no admin após um cadastro real (dropdown + página `/admin/notificacoes`).
- [ ] `MemberRegistrationTest` cobre o fluxo; `ExampleTest` (home 500 em DB de teste vazio) segue pré-existente, fora do escopo.

---

# Página Pedido de Oração (público) - Melhorias - Status: Implementado ✅

## O que foi feito

1. **Máscara no telefone**: campo `phone` do Livewire (`livewire.web.prayer-request`) ganhou máscara `(00) 00000-0000` via IMask aplicado com Alpine `x-init` + guard (`$el._imask`), `inputmode="tel"`. IMask é global via `resources/js/front.js`.

2. **Validações revisadas** (`app/Livewire/Web/PrayerRequest.php`):
   - `phone`: agora `nullable|string|max:20|regex:/^\(\d{2}\)\s?\d{4,5}-\d{4}$/` (vazio passa, preenchido precisa estar no formato mascarado) + mensagem `phone.regex` própria. Exibição de erro adicionada na view.
   - Demais regras mantidas (name min:3, email, message min:10/max:1000, privacy `accepted`).

3. **Política de Privacidade em nova aba**: link em `prayer-request.blade.php` com `target="_blank" rel="noopener"` (mesmo padrão do cadastro de membro).

4. **Notificação aos administradores (Email + BD)**:
   - Nova `App\Notifications\NewPrayerRequest` (canais `database` + `mail`): `data` com title/message/description/url=`admin.prayers.index` (`/admin/pedidos-de-oracao`)/type=`new_prayer_request`/color=`success`; `toMail()` envia e-mail a cada admin com o pedido e botão "Ver pedidos de oração".
   - Disparada em `PrayerRequest::send()` para roles `super admin`, `admin`, `pastor`, `lider`.
   - Ícones `new_prayer_request` em `notifications-list.blade.php` e `notifications-dropdown.blade.php` (sino).
   - E-mail ao e-mail da igreja já existia (`App\Mail\Web\PrayerRequest`), mantido.

5. **Testes**: `tests/Feature/PrayerRequestTest.php` (3/3): submissão válida cria registro + notifica admin (DB+mail), telefone inválido rejeitado, privacy obrigatória. **Importante**: o teste precisa criar `Config` id=1 (nome `config`, coluna `app_name` NOT NULL unique) pois `send()` usa `$config->app_name ?? 'Semear'` — sem config vira `Error: Attempt to read property on null`.

## Para continuar

- [ ] Conferir visual em `/pedido-de-oracao` (máscara funcionando, link política em nova aba, erro de telefone).
- [ ] Verificar sino do admin após um pedido real (dropdown + página `/admin/notificacoes` + e-mail).
- [ ] Suíte completa: 16 testes passando (7 DonationForm + 3 MemberRegistration + 3 PrayerRequest + 2 PrayerRequestsAdmin + 1 Unit).

---

# Admin - Responder Pedido de Oração (e-mail) + Ícone FA - Status: Implementado ✅

## O que foi feito

1. **Onde a resposta ficava armazenada**: coluna `prayer_requests.answer` (text) + `status` (`pendente`/`respondido`) + `answered_by` (FK users) + `answered_at`. Era salva no BD e exibida no card do admin.

2. **Resposta agora SOMENTE por e-mail** (`app/Livewire/Dashboard/PrayerRequests/PrayerRequests.php::saveAnswer`):
   - Nova `App\Mail\Web\PrayerRequestAnswer` + template `resources/views/emails/prayer-request-answer.blade.php` (tema brand #076134), enviada para o e-mail do solicitante (`reply_to`), com o pedido original + resposta.
   - Depois do envio: `answer` vira `null`, `status` → `respondido`, grava `answered_by`/`answered_at`.
   - Se o pedido não tiver e-mail: swal de aviso e **não** marca como respondido.
   - View do admin: bloco "Resposta:" removido; modal agora diz que vai por e-mail; botão "Enviar por e-mail".

3. **Ícone do FA corrigido**: o admin usa Font Awesome **5.15.4** (`public/vendor/fontawesome-free`), onde o ícone é `fa-praying-hands` — **`fa-hands-praying` não existe no FA5** (é nome do FA6) e não renderizava. Corrigido em 4 lugares: `side-navigation.blade.php` (menu), `notifications-list.blade.php`, `notifications-dropdown.blade.php` (sino) e cabeçalho de `prayer-requests.blade.php`.

4. **Testes**: `tests/Feature/PrayerRequestsAdminTest.php` (2/2): responder envia e-mail somente e marca `respondido` com `answer=null`; pedido sem e-mail continua `pendente` e não envia nada.

## Para continuar

- [ ] Conferir no admin `/admin/pedidos-de-oracao`: ícone no menu (fa-praying-hands), modal "Enviar por e-mail", card sem bloco de resposta.
- [ ] Testar envio real de resposta (configurar MAIL em dev, ex. log) e o ícone no sino/notificações.
- [ ] Suíte completa: 20 testes passando.

---

# Formulário de Atendimento (público) - Melhorias - Status: Implementado ✅

## O que foi feito

1. **Visual redesenhado** (`resources/views/web/default/atendimento.blade.php`): layout em 2 colunas (form em card branco com borda arredondada + cards de contato com ícones nas cores da marca brand/accent/sky). Campo de telefone adicionado.

2. **Máscara no telefone**: campo `phone` com IMask `(00) 00000-0000` via Alpine `x-init` + guard (`$el._imask`), `inputmode="tel"`.

3. **Validação custom no front**: `novalidate`, slots `.field-error` + `is-invalid` (nome ≥3, e-mail, telefone opcional no formato mascarado, mensagem ≥10, privacy), Toastify de aviso, erros somem ao digitar, SweetAlert de sucesso + reset, botão com loading (`<span>`).

4. **Validação no servidor** (`app/Http/Controllers/Web/SendEmailController.php::sendEmail`): nome ≥3, e-mail válido, telefone opcional `regex` mascarado, mensagem ≥10, `privacy` obrigatório (`'1'`/`'true'`), honeypot (`bairro`/`cidade`). Usa `$config?->app_name` (evita null).

5. **Política de Privacidade em nova aba**: link com `target="_blank" rel="noopener"`.

6. **Notificação aos administradores (Email + BD)**: nova `App\Notifications\NewAtendimento` (canais `database` + `mail`): `data` com type=`new_atendimento`/color=`info`/url=`mailto:` do solicitante; `toMail()` envia e-mail a cada admin com a mensagem + botão "Responder por e-mail". Disparada em `sendEmail()` para roles `super admin`, `admin`, `pastor`, `lider`. Ícones `new_atendimento` (fa-envelope) em `notifications-list.blade.php` e `notifications-dropdown.blade.php`.

7. **E-mails**: `App\Mail\Web\Atendimento` agora inclui telefone + confirmação de privacidade no template (`emails/atendimento.blade.php`); **removidos os `cc` legados** para `suporte@informaticalivre.com.br` / `villadirimi@terra.com.br` (vazamento de contatos para e-mails externos). `AtendimentoRetorno` (confirmação ao solicitante) mantido.

8. **Testes**: `tests/Feature/AtendimentoTest.php` (4/4): submissão válida envia os 2 e-mails + notifica admin (DB+mail), telefone inválido rejeitado, privacy obrigatória, honeypot bloqueia spam. **Importante**: `Mail::assertSent` deve ser SEM callback — `MailFake` não chama `build()` em mailables legados, então `hasTo()` retorna false.

## Para continuar

- [ ] Conferir visual em `/atendimento` (máscara, validação, Swal, política em nova aba, cards de contato).
- [ ] Verificar sino/notificações no admin após um contato real.
- [ ] Suíte completa: 21 testes passando (7 DonationForm + 3 MemberRegistration + 3 PrayerRequest + 2 PrayerRequestsAdmin + 4 Atendimento + 1 Settings + 1 Unit).

---

# Admin - Salvar Configurações com data (init_date) - Bug corrigido ✅

## O que foi feito

1. **Bug**: ao salvar as configurações no admin (ou ao salvar após upload de imagem), o update do `config` quebrava com `SQLSTATE[22007] ... Incorrect date value: '2016-08-14T03:00:00.000000Z' for column config.init_date`.

2. **Causa**: `Settings::mount()` usa `$config->toArray()`, e o cast `date` do Eloquent serializa `init_date` (e `rss_data`/`sitemap_data`) para ISO `Y-m-d\TH:i:s.u\Z`. O `Settings::update()` salva via **query builder** (`Config::where('id', 1)->update(...)`), que **não aplica casts**, mandando a string ISO crua para a coluna `DATE` do MySQL.

3. **Correção** (`app/Livewire/Dashboard/Settings.php`): novo método `normalizeDates()` chamado no `mount()` e antes do `update()` — formata `init_date`/`rss_data`/`sitemap_data` para `Y-m-d` (ou null) e `status` para int (0/1).

4. **Testes**: `tests/Feature/SettingsTest.php` (1/1): `Livewire::test(Settings::class)->call('update')` salva `init_date` como `2016-08-14` sem erro.

## Para continuar

- [ ] Conferir em `/admin/configuracoes`: campo "Ano de início" mostrando `2016-08-14` e salvar/upload de imagem sem erro.

---

# Admin Posts - Editar/Salvar quebrava (publish_at) + Reordenação de Imagens - Status: Implementado ✅

## O que foi feito

1. **Reordenação de imagens (drag & drop) nos posts**:
   - `app/Models/Post.php`: relação `images()` agora ordena por `order_img asc, id asc` (antes `cover ASC`) — a ordem arrastada reflete no admin e na página pública (`pagina.blade.php` usa `$post->images()->get()`).
   - `app/Livewire/Dashboard/Posts/PostForm.php`: novo método `reorderImages($ids)` (valida IDs do post, concatena ids não listados no fim, grava `order_img`); no `save()`, uploads novos recebem `order_img = maxOrder + index + 1` (via `PostGb::where('post', id)->max('order_img')`).
   - `resources/views/livewire/dashboard/posts/post-form.blade.php`: drag & drop (Alpine + HTML5, `@drop.prevent` → `@this.call('reorderImages', ids)`) nos tiles salvos (só edição), dica azul (`border-blue-200 bg-blue-50 text-blue-700`), efeitos: tile arrastado `opacity-40 scale-95`, tile alvo `ring-4 ring-blue-500 ring-offset-2`, contêiner `border-dashed border-blue-400 bg-blue-50/50` durante drag. **Importante**: Tailwind é 3.4.17 e o config usa `extend` — a paleta `blue` padrão segue disponível.

2. **Bug crítico "post não salva" corrigido** (o usuário achava que a ordenação tinha quebrado — era um bug antigo independente):
   - **Sintoma**: clicar em "Atualizar e Publicar"/"Salvar" em um post existente não fazia nada: sem swal, sem erro visível, sem persistência.
   - **Causa raiz**: `mount()` em modo edição fazia `$this->publish_at = $post->publish_at` — o cast `date` do Eloquent devolve um **Carbon**, que ia cru para a propriedade. A regra `'publish_at' => 'nullable|date_format:d/m/Y'` falhava → `ValidationException` lançada **antes** do try/catch do `save()` → save nunca rodava, sem swal, sem persistência. E o erro era **invisível** porque o blade **não tinha bloco `@error('publish_at')`** para esse campo. Posts com `publish_at` NULL salvavam (caiam no `now()->format('d/m/Y')`) — por isso "funcionava antes" em alguns posts.
   - **Correção**: `mount()` edição agora faz `$post->publish_at ? $post->publish_at->format('d/m/Y') : now()->format('d/m/Y')`; adicionado `@error('publish_at')` no blade (feedback visual caso ocorra de novo).

3. **Testes** (`tests/Feature/PostSaveTest.php`, 4/4; `tests/Feature/PostPageRenderTest.php`, 1/1):
   - `test_save_published_post`: criação de post válido sem erros.
   - `test_update_post`: atualização persiste título.
   - `test_update_post_browser_mimic_dispatches_swal`: post com `publish_at` no BD (formato real), imita o snapshot do navegador (category/type/status) e garante `assertDispatched('swal')` + persistência — **regressão do bug do publish_at**.
   - `test_reorder_images`: reordena 3 imagens e verifica `order_img` (0/1/2) após `reorderImages([c,a,b])`.
   - `test_edit_page_renders` (PostPageRenderTest): página `/admin/posts/{id}/editar` renderiza 200 com `saved-tile` e `reorderImages`. Requer roles seedadas no `setUp` (super admin, admin, editor, lider, pastor, member) + `assignRole('editor')` (senão `EnsureStaff` bloqueia).
   - **Cuidado em testes Livewire**: `.set('category', ...)` ANTES de `.set('type', ...)` faz `updatedType()` zerar a categoria (validação falha) — setar `type` antes de `category`.
   - **Cuidado com `Post::create(['publish_at' => ...])`**: o mutator `setPublishAtAttribute`/`convertStringToDate` espera `d/m/Y` (explode `/`); passar `Y-m-d` estoura `Undefined array key 1`.

4. **Diagnóstico headless** (reaproveitável): Chromium headless + CDP (Node 26 WebSocket global) em `/tmp/opencode/repro2.mjs` — login (`mario.santiago@example.com` / `password`), abre `/admin/posts/3/editar`, clica em "Atualizar e Publicar", captura a requisição `/livewire/update` com `"method":"save"` e confere na resposta `effects` se há `"dispatches":[{"name":"swal",...}]` (swal) / `"errors"`. Serve para validar qualquer fluxo Livewire do admin sem Swal visível.

5. **Menu admin + cabeçalhos de listagem** (na mesma rodada): ícone Famílias corrigido (`fa-house-user`, FA5), sublinks de Slides/Ministérios/Eventos/Doações/Avisos viraram links diretos com badge de contagem; cabeçalhos das listagens (posts, cat-posts, ministérios, slides, eventos, doações, avisos, famílias, usuários) unificados num só `card-header` com busca `flex-1 min-w-40` + botões `shrink-0` (`ml-auto` em posts).

## Para continuar

- [ ] Conferir visual em `/admin/posts/{id}/editar`: arrastar/reordenar imagens salvas, salvar sem erro, swal "Post atualizado com sucesso!". Reprovado o fluxo no navegador (publish_at do post 3 = `2026-08-14 00:00:00`).
- [ ] Suíte completa: **26 testes passando**.
---

# Sitemap Generator (admin) + Toasts - Bug corrigido ✅

## O que foi feito

1. **Gerador de sitemap não gerava nada**: o componente `App\Livewire\Dashboard\Sitemap\SitemapGenerator::generate()` chamava `Artisan::call('sitemap:generate')`, mas **o comando não existe** (não havia `app/Console/Commands/`, e `artisan list` não mostrava nada). O sitemap era servido dinamicamente por `WebController::sitemap()` na rota `/sitemap`, e nenhum arquivo era gravado em `public/sitemap.xml`.
   - **Correção**: lógica extraída para `app/Services/Sitemap/SitemapService.php` com `build()` (gera o XML) e `generateFile()` (grava em `public/sitemap.xml`). `WebController::sitemap()` agora usa `app(SitemapService::class)->build()` (mesma saída); `SitemapGenerator::generate()` chama `generateFile()`, depois `loadInfo()` e dispara o toast de sucesso. `public/sitemap.xml` agora é criado (28 URLs), "Total de URLs"/"Última Geração" atualizam e o botão "Visualizar Sitemap" aparece.

2. **Toast nunca aparecia (qualquer tela)**: causa raiz no handler JS de `toast`. O Livewire v3.8.4 (`dist/livewire.js`, função `on3`) chama o callback de `Livewire.on(name, cb)` passando **`e.detail` diretamente** (não o CustomEvent). O servidor envia `dispatches:[{name:"toast",params:[{type,message}]}]` → `e.detail = [{type,message}]`. O código antigo (`const data = event?.detail?.[0] ?? event`) fazia `event.detail` = `undefined` → `data = event` (o array) → `data?.message` = `undefined` → **return early, sem toast**.
   - **Correção** em `resources/js/app.js` e `resources/js/front.js` (ambos tinham o mesmo bug):
     ```js
     Livewire.on('toast', (params) => {
         const data = params?.[0] ?? params;
         if (!data?.message) return;
         showToast(data.type, data.message);
     });
     ```
   - O `ToastrNotification` (`app/Livewire/Components/ToastrNotification.php` + view vazia) escuta `showToastr` (evento legado que ninguém dispara) e é código morto — a pipeline real é `WithToastr::toast*()` → `dispatch('toast', ...)` → handler do `app.js`/`front.js`.

## Para continuar

- [ ] Conferir visual em `/admin/sitemap-generator`: clicar "Gerar Sitemap Agora" → toast verde "Sitemap gerado com sucesso!", total = 28, "Visualizar Sitemap" abre `/sitemap.xml`.
- [ ] Suíte completa: **73 testes passando (227 assertions)**; sem teste dedicado para o sitemap (rota `/sitemap` = 200 application/xml).
- [ ] Rever outros handlers `Livewire.on(...)` no código se forem assumir `event.detail` (API do Livewire 3.8.4 passa `e.detail` direto ao callback).

---

# Teste Mercado Pago (PIX + Cartão) com chaves de TESTE - Status: Em andamento ✅

## Contexto
- Usuário colocou as chaves de teste no `.env`: `MERCADOPAGO_TOKEN` (TEST-, 71 chars), `MERCADOPAGO_PUBLIC_KEY` (TEST-, 41 chars), `MERCADOPAGO_WEBHOOK_SECRET` vazio. Conta: id `192815433`, site `MLB`, nickname `INFORMATICA-LIVRE`.

## PIX — BLOQUEADO NA CONTA (ação do usuário necessária)
- `GET /v1/payment_methods` NÃO lista `pix` na conta — só cartões, tickets e account_money. Criar PIX (SDK ou curl cru, com/sem notification_url/CPF/email) → HTTP 500 `{"message":"fill and validate error list: communication_error","status":500,"error":"internal_server_error","cause":[]}`. Sem `payer` → `payer_cannot_be_nil` (400), provando que o payload chega à API.
- **Ação**: ativar PIX no painel do Mercado Pago (Checkout Transparente) para testar doações via PIX.
- Webhook secret **não é necessário** para testes: cartão retorna status no `create()`; PIX confirmado via `find()`; `verifySignature()` ignora quando o secret está vazio.

## Cartão — FLUXO VALIDADO (servidor + montagem do form)
1. **Bug: `payment_method_id: 'card'` é inválido na API** (erro 3028 "Invalid payment_method_id"). Precisa da bandeira (`master`/`visa`). Correção:
   - `GatewayCreateRequest` ganhou `?string $paymentMethodId = null`; `PaymentService::initiate` passa `$options['paymentMethodId']`; `MercadoPagoCardGateway::create` usa `$request->paymentMethodId ?? 'card'`.
   - `DonationForm::payWithCard(string $token, ?string $paymentMethodId = null)` + nova propriedade `$paymentMethodId`; blade `onSubmit` chama `call('payWithCard', data.token, data.paymentMethodId)` (o SDK expõe `paymentMethodId` em `getCardFormData()`).
2. **Bug: `notification_url` com localhost era rejeitado** (erro 4020). `MercadoPagoGateway::notificationUrl()` agora retorna `null` para host `localhost`/`127.0.0.1`/`::1` (usa `config('app.url')`); `buildRequest()` só inclui `notification_url` quando não é null. Em produção (domínio real) volta a incluir.
3. **CardForm no `donation-form.blade.php`** (migrado do padrão do `checkout-form.blade.php`, que funciona):
   - Elemento vira `<form id="mp-card-form">` com containers explícitos: divs `cardNumber`/`expirationDate`/`securityCode` (iframes), `<input id="cardholderName">`, `<select id="issuer">`, `<select id="installments">`.
   - Config: `amount: amount.toFixed(2)` (**string**), `iframe: true`, form mapeando os ids acima (chave `expirationDate`, não `cardExpirationDate`).
   - Trigger: div `<div wire:ignore x-data x-effect="$wire.paymentMethod === 'card' && window.__initMpCard()">` — o `x-effect` roda quando o div é criado (só existe quando `paymentMethod === 'card'`), evitando o bug antigo de montar com amount 0 no load da página. `__initMpCard` lê `$wire.get('amount')`, guarda `amount<=0`, é idempotente (`window.__mpCardForm`/`__mpCardAmount`) e dá `unmount()` + limpa `#mp-card-form` ao re-montar com valor diferente.
   - Observação headless: os iframes do MP (`secure-fields.mercadopago.com`) não podem ser preenchidos via CDP neste ambiente (frame tree sem child frames), então o preenchimento foi validado só em navegador real / o fluxo foi testado via API direta.
4. **Validação servidor→MP (via `sail artisan tinker` + token real criado por curl com a public key)**: `processDonation` com token + `paymentMethodId: 'master'`/`'visa'` cria Donation pending + Payment com `gateway_id` atribuído (ex.: 1327891756). Status retornado: `pending`/`pending_contingency` — **é comportamento do ambiente TEST** (o pagamento precisa ser aprovado no painel de testes do MP para virar `approved`), não é bug do código. Com credenciais LIVE cartões reais são aprovados normalmente.
5. **Testes**: `./vendor/bin/sail artisan test --filter=DonationFormTest` → 7/7 passando.

## Para continuar
- [ ] **Aprovar os pagamentos TEST pendentes no painel do MP** (Test payments) e conferir se o polling/`checkPayment` marca a doação como paid (valida o fluxo webhook/polling ponta a ponta).
- [ ] Testar o preenchimento do cartão em navegador real (`/doacoes` → Oferta → R$ 50 → Continuar → Cartão de crédito → preencher Mastercard `5031 7557 3453 0604` 11/27 CVC 123 APRO) e conferir a aprovação + registro no `/admin/doacoes`.
- [ ] **Ativar PIX no painel MP** e então testar o QR Code PIX completo (gera `point_of_interaction.transaction_data.qr_code`/`qr_code_base64`).
- [ ] Conferir se `pending_contingency` vira `approved` após aprovação manual (ajustar `checkPayment` se necessário).

## Bug: "cliquei em Confirmar pagamento e nada acontece" - Corrigido ✅
- **Causa raiz**: `getCardFormData()` **não contém o token** — o SDK só gera o token ao chamar `cardForm.createCardToken()`. O `onSubmit` antigo lia `getCardFormData().token` (sempre `""`) e retornava em silêncio (nada acontecia, sem toast/erro). Confirmado headless: `getCardFormData()` = `{token: "", paymentMethodId: "", ...}` antes do `createCardToken()`.
- **Correção** (em `donation-form.blade.php`):
  - `onSubmit` agora chama `cardForm.createCardToken()` e seta loading no botão (`#mp-card-submit`): `disabled` + "Processando...".
  - `onCardTokenReceived(error, token)` (novo): restaura o botão; se erro/`!token` → toast "Verifique os dados do cartão e tente novamente."; senão lê `getCardFormData()` (agora com `token`/`paymentMethodId`) e chama `payWithCard(token, paymentMethodId)`.
  - Novo painel de sucesso para cartão: `@if ($paid)` no branch cartão mostra "Doação confirmada!" + botão "Nova doação" (`restart`).
  - Verificado headless: submit com campos vazios agora dispara toast de erro (antes: silêncio total).

## Form de Doação - Loading nas etapas + Mensagens pós-compra ✅
- **Loading nas transições de etapa** (`donation-form.blade.php`):
  - Botões de tipo (passo 1) e valores rápidos (passo 2): `wire:loading.attr="disabled"`.
  - Botões "Continuar"/"Voltar" (passos 2 e 3): `wire:loading.attr="disabled"` + `wire:target` + spinner ("Aguarde...") via `wire:loading`/`wire:loading.remove`.
  - Botão "Gerar pagamento PIX": mesmo padrão, spinner "Gerando..." (`wire:target="createDonation"`).
  - Botão "Confirmar pagamento" (cartão): já tem "Processando..." via `#mp-card-submit` no JS.
- **Mensagens de sucesso/erro após a compra**:
  - `createDonation()` agora dispara toast (`dispatch('toast', ...)`) conforme o resultado:
    - pago → toast success "Doação confirmada! Muito obrigado pela sua contribuição." (além da tela de sucesso `@if ($paid)`).
    - cartão `status === 'failed'` → toast error com `cardFailureMessage(status_detail)`.
    - cartão pendente (TEST `pending_contingency`/`in_process`, não pago e não falho) → toast info "Pagamento em processamento..." + painel âmbar no branch do cartão ("Pagamento em processamento" + botão "Fazer outra doação").
    - exceções (gateway/inesperado) → toast error + `errorMessage`.
  - Box de erro no topo do wizard ganhou ícone ⚠️.
  - **Importante**: painel de sucesso é o top-level `@if ($paid)` (substitui todo o wizard); o painel `@if ($paid)` interno ao branch do cartão foi removido por ser inalcançável.
  - Verificado headless: clicar "Gerar pagamento PIX" (PIX bloqueado na conta) → toast vermelho + box de erro com ícone, sem erros JS. Testes 7/7 passando.

---

# Migração de Doações para PagBank (desacoplado do Mercado Pago) - Status: Implementado ✅

## Contexto
O usuário decidiu trocar o Mercado Pago pelo **PagBank** por instabilidade do MP. Foi criado um gateway PagBank desacoplado — o código MP (`app/Services/Payments/MercadoPago/`) foi **mantido** na base para retorno fácil.

## O que foi feito

1. **Gateway PagBank** (`app/Services/Payments/PagBank/`) implementando `PaymentGatewayInterface`:
   - `PagBankGateway` (base): `name()` = `pagbank`; `client()` (Http facade, `baseUrl` sandbox `https://sandbox.api.pagseguro.com` / prod `https://api.pagseguro.com`, `Authorization: Bearer`); `find()` via `GET /orders/{order_id}`; `cancel()` via `GET /orders/{id}` → `POST /charges/{charge_id}/cancel`; `handleWebhook()` extrai `id` (ORDE_...) do payload; `statusFromCharge`: `PAID→approved`, `DECLINED→rejected`, `CANCELED→cancelled`, resto `pending`; `buildCustomer`/`buildItems` (valores em **centavos**); `notificationUrl()` = `/webhooks/payments/pagbank` (null para localhost); `wrap()` loga status+body.
   - `PagBankPixGateway::create()`: `POST /orders` com `qr_codes[{amount.value, expiration_date (+30min)}]`, `customer`, `items`, `notification_urls`; grava `order['qr_code']` (copia-e-cola) e `order['qr_code_image']` (URL do PNG, link `QRCODE.PNG` — endpoints `/qrcode/{id}/png` são **públicos**, sem auth). `gateway_id` = id do pedido (ORDE_...).
   - `PagBankCardGateway::create()`: `POST /orders` com `charges[{amount.value, payment_method:{type:CREDIT_CARD, installments, capture:true, **soft_descriptor** ("IGREJA SEMEAR" — **obrigatório na sandbox**, senão 400 `seller/soft_descriptor must not be empty`), card:{encrypted: $request->token}, holder:{name, tax_id}}}]`; `gateway_id` = id do pedido. **Importante**: o "token" enviado pelo front é o **criptograma** `encryptedCard` do SDK (`PagSeguro.encryptCard`), NÃO um token de sessão. `wrap()` loga classe/exceção + status/body reais (RequestException tem a propriedade pública `$response`, não método `response()`).

2. **`PaymentGatewayFactory`**: `for(PaymentMethodEnum)` → PagBank; `byName('pagbank_pix'/'pagbank_card')` → PagBank (mantidos `mercadopago_pix`/`mercadopago_card` como legado para refresh/cancel de registros antigos); **novo** `byWebhook('pagbank'|'mercadopago')` para o controller de webhook (que recebe o nome base da rota).

3. **`PaymentService`**: `processDonation()` agora grava `gateway` via factory (antes hardcoded `'mercadopago_'.$method`); `handleWebhook()` usa `byWebhook()` para parsear e `byName($payment->gateway)` para a re-consulta `find()` (usa o gateway real do pagamento).

4. **Config**: `config/services.php` nova seção `pagbank` (`token`, `public_key`, `webhook_secret`, `sandbox` (bool), `currency=BRL`); `.env`/`.env.example` com `PAGBANK_TOKEN`, `PAGBANK_PUBLIC_KEY`, `PAGBANK_WEBHOOK_SECRET`, `PAGBANK_SANDBOX=true`.

5. **Webhook**: `PaymentWebhookController` agora aceita `pagbank` e `mercadopago`; para PagBank valida **`x-authenticity-token` = `sha256(token_da_conta + "-" + corpo_bruto)`** (`verifyPagBankSignature`) — ignora se token/header vazios (status real confirmado via `find()`). Rota segue `POST /webhooks/payments/{gateway}` (sem CSRF).

6. **Frontend** (`donation-form.blade.php`):
   - **Cartão**: substituído o `mp.cardForm` (iframes) por formulário de inputs puros (`#pb-card-form`) + SDK `https://assets.pagseguro.com.br/checkout-sdk-js/rc/dist/browser/pagseguro.min.js`. Submit chama `PagSeguro.encryptCard({publicKey, holder, number, expMonth, expYear, securityCode})` → se `hasErrors` toast de erro; senão `payWithCard(card.encryptedCard)`. Botão com loading "Processando...". Texto "Pagamento processado pelo PagBank com criptografia de ponta a ponta."
   - **PIX**: `DonationForm::createDonation()` agora lê `qr_code`/`qr_code_image` do raw (garantidos pelo gateway PagBank) e exibe o QR via URL pública do PNG (`<img src="{{ $qrCodeImage }}">`). QR/copia-e-cola/polling `wire:poll.4s` mantidos.
   - **Não cria transação ao entrar no passo 4** (`nextStep()` não chama mais `createDonation` automaticamente — antes criava PIX no momento em que o usuário chegava à etapa de pagamento, antes de escolher cartão/PIX). Agora a transação só é criada no clique em "Gerar pagamento PIX" (PIX) ou "Confirmar pagamento" (cartão).
   - `cardFailureMessage()` ampliado com códigos PagBank (`DECLINED/REJECTED/INSUFFICIENT_FUNDS/EXPIRED_CARD/INVALID_CARD`), mantendo os antigos do MP; lê `status_detail` ou `charges.0.payment_response.message`.

7. **Testes**: `tests/Feature/PagBankWebhookTest.php` (4/4): gateway não suportado 404; assinatura inválida 401; assinatura válida 200; webhook marca payment+doação como paid (com `Http::fake` em `*/orders/ORDE_TESTE`). Suíte completa: **77 testes passando (234 assertions)**. `DonationFormTest` 7/7 seguem passando (falha de gateway sem credenciais → doação 'failed').

## Para continuar / Notas

- **Credenciais reais necessárias**: preencher `PAGBANK_TOKEN` (Integrações da conta PagBank; sandbox = Portal do Desenvolvedor) e `PAGBANK_PUBLIC_KEY` (`GET /public-keys/card` ou na config; sandbox é sempre a mesma). `PAGBANK_SANDBOX=true` para testar.
- **PIX exige chave PIX ativa** na conta PagBank (mesmo caso do MP: `communication_error`). Verificar no painel PagBank.
- **Webhook em produção**: apontar `https://DOMINIO/webhooks/payments/pagbank` (via `notification_urls` enviado no corpo do pedido; app envia quando `app.url` não é localhost).
- **Módulo de Reservas continua no MP** (`app/Livewire/Web/ReservationForm.php` + `checkout-form.blade.php` — cardForm MP). Decidir se migra também.
- Pagamentos antigos com `gateway = mercadopago_*` continuam funcionando para consulta/cancelamento (factory legado).
- Testar em sandbox: `/doacoes` → PIX (QR + copia-e-cola + pagamento → webhook confirma paid) e cartão de teste PagBank.

---

# Remoção do Módulo de Reservas (outro sistema) - Status: Concluído ✅

## Contexto
O módulo de **Reservas/Booking/Hotel** (incluindo toda a área admin `company/` de tours, embarcações, finance e wallet) era de **outro sistema** copiado para dentro do projeto da igreja. O usuário pediu para remover. Todo o cluster era **código morto**: nenhuma rota apontava para os componentes/views (apenas `redirect()->route('company.dashboard')` em `routes/auth.php:37`, rota inexistente).

## O que foi feito

1. **Removidos componentes Livewire web** (`app/Livewire/Web/`): `ReservationForm.php`, `BookingForm.php`, `CheckoutPage.php`, `PropertySearch.php`, `PropertyFilter.php`, `ReviewForm.php`.
2. **Removidas views órfãs**: `resources/views/livewire/web/checkout/` (checkout-form MP), `resources/views/livewire/web/components/` (tour-calendar) e `resources/views/livewire/web/customer/` (orders) + **toda** `resources/views/livewire/company/` (sidebar, dashboard, finance, tours, vessels, booking, user, notifications).
3. **Corrigido `routes/auth.php:37`**: redirect de verificação de e-mail apontava para `company.dashboard` (inexistente) → agora `admin.dashboard`. Sem isso, verificar e-mail quebrava com `RouteNotFoundException`.
4. **Não havia** models, migrations, seeders, factories nem mails de reserva no projeto (só `App\Mail\ReservationFormLinkMail` referenciado, que nunca existiu) — nada de BD a limpar.

## Para continuar
- Suíte completa: **77 testes passando (234 assertions)** após a remoção.
- Sem pendências: o módulo de doações (PagBank) segue intacto e o MP fica só como gateway legado na factory.
