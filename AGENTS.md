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
- [ ] Suíte completa: 20 testes passando (7 DonationForm + 3 MemberRegistration + 3 PrayerRequest + 2 PrayerRequestsAdmin + 4 Atendimento + 1 Unit).