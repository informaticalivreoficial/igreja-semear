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