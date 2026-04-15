# Instructions

- Following Playwright test failed.
- Explain why, be concise, respect Playwright best practices.
- Provide a snippet of code with the fix, if possible.

# Test info

- Name: crud-lifecycle.spec.js >> UC-CRUD-04: Duplicar proyecto >> Clonar proyecto crea entrada independiente en listado
- Location: tests/E2E/crud-lifecycle.spec.js:185:5

# Error details

```
Error: expect(received).toBeGreaterThan(expected)

Expected: > 20
Received:   20
```

# Page snapshot

```yaml
- generic [active] [ref=e1]:
  - generic [ref=e2]:
    - generic [ref=e3]:
      - heading " Projects" [level=1] [ref=e4]:
        - generic [ref=e5]: 
        - text: Projects
      - generic [ref=e6]:
        - link " New Project" [ref=e7] [cursor=pointer]:
          - /url: /projects/create
          - generic [ref=e8]: 
          - text: New Project
        - link " Back" [ref=e9] [cursor=pointer]:
          - /url: /
          - generic [ref=e10]: 
          - text: Back
    - generic [ref=e11]:
      - table [ref=e13]:
        - rowgroup [ref=e14]:
          - row "Name Code Client Status Budget Date Actions" [ref=e15]:
            - columnheader "Name" [ref=e16]
            - columnheader "Code" [ref=e17]
            - columnheader "Client" [ref=e18]
            - columnheader "Status" [ref=e19]
            - columnheader "Budget" [ref=e20]
            - columnheader "Date" [ref=e21]
            - columnheader "Actions" [ref=e22]
        - rowgroup [ref=e23]:
          - row "Proyecto E2E 1776277914319 (copia) QA-P-1776277914319-C — Planning — 15/04/2026  " [ref=e24]:
            - cell "Proyecto E2E 1776277914319 (copia)" [ref=e25]:
              - strong [ref=e26]: Proyecto E2E 1776277914319 (copia)
            - cell "QA-P-1776277914319-C" [ref=e27]:
              - generic [ref=e28]: QA-P-1776277914319-C
            - cell "—" [ref=e29]
            - cell "Planning" [ref=e30]:
              - generic [ref=e31]: Planning
            - cell "—" [ref=e32]
            - cell "15/04/2026" [ref=e33]
            - cell " " [ref=e34]:
              - link "" [ref=e35] [cursor=pointer]:
                - /url: /projects/23
                - generic [ref=e36]: 
              - link "" [ref=e37] [cursor=pointer]:
                - /url: /projects/23/edit
                - generic [ref=e38]: 
          - row "Proyecto E2E 1776277914319 QA-P-1776277914319 — Planning — 15/04/2026  " [ref=e39]:
            - cell "Proyecto E2E 1776277914319" [ref=e40]:
              - strong [ref=e41]: Proyecto E2E 1776277914319
            - cell "QA-P-1776277914319" [ref=e42]:
              - generic [ref=e43]: QA-P-1776277914319
            - cell "—" [ref=e44]
            - cell "Planning" [ref=e45]:
              - generic [ref=e46]: Planning
            - cell "—" [ref=e47]
            - cell "15/04/2026" [ref=e48]
            - cell " " [ref=e49]:
              - link "" [ref=e50] [cursor=pointer]:
                - /url: /projects/22
                - generic [ref=e51]: 
              - link "" [ref=e52] [cursor=pointer]:
                - /url: /projects/22/edit
                - generic [ref=e53]: 
          - row "Proyecto E2E 1776277782207 (copia) QA-P-1776277782207-C — Planning — 15/04/2026  " [ref=e54]:
            - cell "Proyecto E2E 1776277782207 (copia)" [ref=e55]:
              - strong [ref=e56]: Proyecto E2E 1776277782207 (copia)
            - cell "QA-P-1776277782207-C" [ref=e57]:
              - generic [ref=e58]: QA-P-1776277782207-C
            - cell "—" [ref=e59]
            - cell "Planning" [ref=e60]:
              - generic [ref=e61]: Planning
            - cell "—" [ref=e62]
            - cell "15/04/2026" [ref=e63]
            - cell " " [ref=e64]:
              - link "" [ref=e65] [cursor=pointer]:
                - /url: /projects/21
                - generic [ref=e66]: 
              - link "" [ref=e67] [cursor=pointer]:
                - /url: /projects/21/edit
                - generic [ref=e68]: 
          - row "Proyecto E2E 1776277782207 QA-P-1776277782207 — Planning — 15/04/2026  " [ref=e69]:
            - cell "Proyecto E2E 1776277782207" [ref=e70]:
              - strong [ref=e71]: Proyecto E2E 1776277782207
            - cell "QA-P-1776277782207" [ref=e72]:
              - generic [ref=e73]: QA-P-1776277782207
            - cell "—" [ref=e74]
            - cell "Planning" [ref=e75]:
              - generic [ref=e76]: Planning
            - cell "—" [ref=e77]
            - cell "15/04/2026" [ref=e78]
            - cell " " [ref=e79]:
              - link "" [ref=e80] [cursor=pointer]:
                - /url: /projects/20
                - generic [ref=e81]: 
              - link "" [ref=e82] [cursor=pointer]:
                - /url: /projects/20/edit
                - generic [ref=e83]: 
          - row "Proyecto E2E 1776277665058 (copia) QA-P-1776277665058-C — Planning — 15/04/2026  " [ref=e84]:
            - cell "Proyecto E2E 1776277665058 (copia)" [ref=e85]:
              - strong [ref=e86]: Proyecto E2E 1776277665058 (copia)
            - cell "QA-P-1776277665058-C" [ref=e87]:
              - generic [ref=e88]: QA-P-1776277665058-C
            - cell "—" [ref=e89]
            - cell "Planning" [ref=e90]:
              - generic [ref=e91]: Planning
            - cell "—" [ref=e92]
            - cell "15/04/2026" [ref=e93]
            - cell " " [ref=e94]:
              - link "" [ref=e95] [cursor=pointer]:
                - /url: /projects/19
                - generic [ref=e96]: 
              - link "" [ref=e97] [cursor=pointer]:
                - /url: /projects/19/edit
                - generic [ref=e98]: 
          - row "Proyecto E2E 1776277665058 QA-P-1776277665058 — Planning — 15/04/2026  " [ref=e99]:
            - cell "Proyecto E2E 1776277665058" [ref=e100]:
              - strong [ref=e101]: Proyecto E2E 1776277665058
            - cell "QA-P-1776277665058" [ref=e102]:
              - generic [ref=e103]: QA-P-1776277665058
            - cell "—" [ref=e104]
            - cell "Planning" [ref=e105]:
              - generic [ref=e106]: Planning
            - cell "—" [ref=e107]
            - cell "15/04/2026" [ref=e108]
            - cell " " [ref=e109]:
              - link "" [ref=e110] [cursor=pointer]:
                - /url: /projects/18
                - generic [ref=e111]: 
              - link "" [ref=e112] [cursor=pointer]:
                - /url: /projects/18/edit
                - generic [ref=e113]: 
          - row "Proyecto E2E 1776277266780 QA-P-1776277266780 — Planning — 15/04/2026  " [ref=e114]:
            - cell "Proyecto E2E 1776277266780" [ref=e115]:
              - strong [ref=e116]: Proyecto E2E 1776277266780
            - cell "QA-P-1776277266780" [ref=e117]:
              - generic [ref=e118]: QA-P-1776277266780
            - cell "—" [ref=e119]
            - cell "Planning" [ref=e120]:
              - generic [ref=e121]: Planning
            - cell "—" [ref=e122]
            - cell "15/04/2026" [ref=e123]
            - cell " " [ref=e124]:
              - link "" [ref=e125] [cursor=pointer]:
                - /url: /projects/17
                - generic [ref=e126]: 
              - link "" [ref=e127] [cursor=pointer]:
                - /url: /projects/17/edit
                - generic [ref=e128]: 
          - row "Proyecto E2E 1776277007607 QA-P-1776277007607 — Planning — 15/04/2026  " [ref=e129]:
            - cell "Proyecto E2E 1776277007607" [ref=e130]:
              - strong [ref=e131]: Proyecto E2E 1776277007607
            - cell "QA-P-1776277007607" [ref=e132]:
              - generic [ref=e133]: QA-P-1776277007607
            - cell "—" [ref=e134]
            - cell "Planning" [ref=e135]:
              - generic [ref=e136]: Planning
            - cell "—" [ref=e137]
            - cell "15/04/2026" [ref=e138]
            - cell " " [ref=e139]:
              - link "" [ref=e140] [cursor=pointer]:
                - /url: /projects/16
                - generic [ref=e141]: 
              - link "" [ref=e142] [cursor=pointer]:
                - /url: /projects/16/edit
                - generic [ref=e143]: 
          - row "Proyecto E2E 1776276827713 QA-P-1776276827713 — Planning — 15/04/2026  " [ref=e144]:
            - cell "Proyecto E2E 1776276827713" [ref=e145]:
              - strong [ref=e146]: Proyecto E2E 1776276827713
            - cell "QA-P-1776276827713" [ref=e147]:
              - generic [ref=e148]: QA-P-1776276827713
            - cell "—" [ref=e149]
            - cell "Planning" [ref=e150]:
              - generic [ref=e151]: Planning
            - cell "—" [ref=e152]
            - cell "15/04/2026" [ref=e153]
            - cell " " [ref=e154]:
              - link "" [ref=e155] [cursor=pointer]:
                - /url: /projects/15
                - generic [ref=e156]: 
              - link "" [ref=e157] [cursor=pointer]:
                - /url: /projects/15/edit
                - generic [ref=e158]: 
          - row "Proyecto E2E 1776276561176 QA-P-1776276561176 — Planning — 15/04/2026  " [ref=e159]:
            - cell "Proyecto E2E 1776276561176" [ref=e160]:
              - strong [ref=e161]: Proyecto E2E 1776276561176
            - cell "QA-P-1776276561176" [ref=e162]:
              - generic [ref=e163]: QA-P-1776276561176
            - cell "—" [ref=e164]
            - cell "Planning" [ref=e165]:
              - generic [ref=e166]: Planning
            - cell "—" [ref=e167]
            - cell "15/04/2026" [ref=e168]
            - cell " " [ref=e169]:
              - link "" [ref=e170] [cursor=pointer]:
                - /url: /projects/14
                - generic [ref=e171]: 
              - link "" [ref=e172] [cursor=pointer]:
                - /url: /projects/14/edit
                - generic [ref=e173]: 
          - row "Proyecto E2E 1776275976967 QA-P-1776275976967 — Planning — 15/04/2026  " [ref=e174]:
            - cell "Proyecto E2E 1776275976967" [ref=e175]:
              - strong [ref=e176]: Proyecto E2E 1776275976967
            - cell "QA-P-1776275976967" [ref=e177]:
              - generic [ref=e178]: QA-P-1776275976967
            - cell "—" [ref=e179]
            - cell "Planning" [ref=e180]:
              - generic [ref=e181]: Planning
            - cell "—" [ref=e182]
            - cell "15/04/2026" [ref=e183]
            - cell " " [ref=e184]:
              - link "" [ref=e185] [cursor=pointer]:
                - /url: /projects/13
                - generic [ref=e186]: 
              - link "" [ref=e187] [cursor=pointer]:
                - /url: /projects/13/edit
                - generic [ref=e188]: 
          - row "Proyecto E2E 1776275871481 QA-P-1776275871481 — Planning — 15/04/2026  " [ref=e189]:
            - cell "Proyecto E2E 1776275871481" [ref=e190]:
              - strong [ref=e191]: Proyecto E2E 1776275871481
            - cell "QA-P-1776275871481" [ref=e192]:
              - generic [ref=e193]: QA-P-1776275871481
            - cell "—" [ref=e194]
            - cell "Planning" [ref=e195]:
              - generic [ref=e196]: Planning
            - cell "—" [ref=e197]
            - cell "15/04/2026" [ref=e198]
            - cell " " [ref=e199]:
              - link "" [ref=e200] [cursor=pointer]:
                - /url: /projects/12
                - generic [ref=e201]: 
              - link "" [ref=e202] [cursor=pointer]:
                - /url: /projects/12/edit
                - generic [ref=e203]: 
          - row "Proyecto E2E 1776273855486 QA-P-1776273855486 — Planning — 15/04/2026  " [ref=e204]:
            - cell "Proyecto E2E 1776273855486" [ref=e205]:
              - strong [ref=e206]: Proyecto E2E 1776273855486
            - cell "QA-P-1776273855486" [ref=e207]:
              - generic [ref=e208]: QA-P-1776273855486
            - cell "—" [ref=e209]
            - cell "Planning" [ref=e210]:
              - generic [ref=e211]: Planning
            - cell "—" [ref=e212]
            - cell "15/04/2026" [ref=e213]
            - cell " " [ref=e214]:
              - link "" [ref=e215] [cursor=pointer]:
                - /url: /projects/11
                - generic [ref=e216]: 
              - link "" [ref=e217] [cursor=pointer]:
                - /url: /projects/11/edit
                - generic [ref=e218]: 
          - row "Proyecto E2E 1776273387281 QA-P-1776273387281 — Planning — 15/04/2026  " [ref=e219]:
            - cell "Proyecto E2E 1776273387281" [ref=e220]:
              - strong [ref=e221]: Proyecto E2E 1776273387281
            - cell "QA-P-1776273387281" [ref=e222]:
              - generic [ref=e223]: QA-P-1776273387281
            - cell "—" [ref=e224]
            - cell "Planning" [ref=e225]:
              - generic [ref=e226]: Planning
            - cell "—" [ref=e227]
            - cell "15/04/2026" [ref=e228]
            - cell " " [ref=e229]:
              - link "" [ref=e230] [cursor=pointer]:
                - /url: /projects/10
                - generic [ref=e231]: 
              - link "" [ref=e232] [cursor=pointer]:
                - /url: /projects/10/edit
                - generic [ref=e233]: 
          - row "Proyecto E2E 1776273104997 QA-P-1776273104997 — Planning — 15/04/2026  " [ref=e234]:
            - cell "Proyecto E2E 1776273104997" [ref=e235]:
              - strong [ref=e236]: Proyecto E2E 1776273104997
            - cell "QA-P-1776273104997" [ref=e237]:
              - generic [ref=e238]: QA-P-1776273104997
            - cell "—" [ref=e239]
            - cell "Planning" [ref=e240]:
              - generic [ref=e241]: Planning
            - cell "—" [ref=e242]
            - cell "15/04/2026" [ref=e243]
            - cell " " [ref=e244]:
              - link "" [ref=e245] [cursor=pointer]:
                - /url: /projects/9
                - generic [ref=e246]: 
              - link "" [ref=e247] [cursor=pointer]:
                - /url: /projects/9/edit
                - generic [ref=e248]: 
          - row "Proyecto E2E 1776272739946 QA-P-1776272739946 — Planning — 15/04/2026  " [ref=e249]:
            - cell "Proyecto E2E 1776272739946" [ref=e250]:
              - strong [ref=e251]: Proyecto E2E 1776272739946
            - cell "QA-P-1776272739946" [ref=e252]:
              - generic [ref=e253]: QA-P-1776272739946
            - cell "—" [ref=e254]
            - cell "Planning" [ref=e255]:
              - generic [ref=e256]: Planning
            - cell "—" [ref=e257]
            - cell "15/04/2026" [ref=e258]
            - cell " " [ref=e259]:
              - link "" [ref=e260] [cursor=pointer]:
                - /url: /projects/8
                - generic [ref=e261]: 
              - link "" [ref=e262] [cursor=pointer]:
                - /url: /projects/8/edit
                - generic [ref=e263]: 
          - row "Proyecto E2E 1776272208153 QA-P-1776272208153 — Planning — 15/04/2026  " [ref=e264]:
            - cell "Proyecto E2E 1776272208153" [ref=e265]:
              - strong [ref=e266]: Proyecto E2E 1776272208153
            - cell "QA-P-1776272208153" [ref=e267]:
              - generic [ref=e268]: QA-P-1776272208153
            - cell "—" [ref=e269]
            - cell "Planning" [ref=e270]:
              - generic [ref=e271]: Planning
            - cell "—" [ref=e272]
            - cell "15/04/2026" [ref=e273]
            - cell " " [ref=e274]:
              - link "" [ref=e275] [cursor=pointer]:
                - /url: /projects/7
                - generic [ref=e276]: 
              - link "" [ref=e277] [cursor=pointer]:
                - /url: /projects/7/edit
                - generic [ref=e278]: 
          - row "Proyecto E2E 1776271279687 QA-P-1776271279687 — Planning — 15/04/2026  " [ref=e279]:
            - cell "Proyecto E2E 1776271279687" [ref=e280]:
              - strong [ref=e281]: Proyecto E2E 1776271279687
            - cell "QA-P-1776271279687" [ref=e282]:
              - generic [ref=e283]: QA-P-1776271279687
            - cell "—" [ref=e284]
            - cell "Planning" [ref=e285]:
              - generic [ref=e286]: Planning
            - cell "—" [ref=e287]
            - cell "15/04/2026" [ref=e288]
            - cell " " [ref=e289]:
              - link "" [ref=e290] [cursor=pointer]:
                - /url: /projects/6
                - generic [ref=e291]: 
              - link "" [ref=e292] [cursor=pointer]:
                - /url: /projects/6/edit
                - generic [ref=e293]: 
          - row "Proyecto E2E 1776270095277 QA-P-1776270095277 — Planning — 15/04/2026  " [ref=e294]:
            - cell "Proyecto E2E 1776270095277" [ref=e295]:
              - strong [ref=e296]: Proyecto E2E 1776270095277
            - cell "QA-P-1776270095277" [ref=e297]:
              - generic [ref=e298]: QA-P-1776270095277
            - cell "—" [ref=e299]
            - cell "Planning" [ref=e300]:
              - generic [ref=e301]: Planning
            - cell "—" [ref=e302]
            - cell "15/04/2026" [ref=e303]
            - cell " " [ref=e304]:
              - link "" [ref=e305] [cursor=pointer]:
                - /url: /projects/5
                - generic [ref=e306]: 
              - link "" [ref=e307] [cursor=pointer]:
                - /url: /projects/5/edit
                - generic [ref=e308]: 
          - row "Mc Donals (copia) PRJ01-C Melissa Ortega Planning $1,000.10 10/04/2026  " [ref=e309]:
            - cell "Mc Donals (copia)" [ref=e310]:
              - strong [ref=e311]: Mc Donals (copia)
            - cell "PRJ01-C" [ref=e312]:
              - generic [ref=e313]: PRJ01-C
            - cell "Melissa Ortega" [ref=e314]
            - cell "Planning" [ref=e315]:
              - generic [ref=e316]: Planning
            - cell "$1,000.10" [ref=e317]
            - cell "10/04/2026" [ref=e318]
            - cell " " [ref=e319]:
              - link "" [ref=e320] [cursor=pointer]:
                - /url: /projects/4
                - generic [ref=e321]: 
              - link "" [ref=e322] [cursor=pointer]:
                - /url: /projects/4/edit
                - generic [ref=e323]: 
      - generic [ref=e324]:
        - generic [ref=e325]: Page 1 of 2
        - navigation "Page navigation" [ref=e326]:
          - list [ref=e327]:
            - listitem [ref=e328]:
              - generic: Previous
            - listitem [ref=e329]:
              - link "1" [ref=e330] [cursor=pointer]:
                - /url: /projects/?page=1
            - listitem [ref=e331]:
              - link "2" [ref=e332] [cursor=pointer]:
                - /url: /projects/?page=2
            - listitem [ref=e333]:
              - link "Next" [ref=e334] [cursor=pointer]:
                - /url: /projects/?page=2
  - region "Symfony Web Debug Toolbar" [ref=e335]:
    - generic [ref=e337]:
      - link "200 @ app_project_index" [ref=e339] [cursor=pointer]:
        - /url: http://localhost:8080/_profiler/3c7828?panel=request
        - generic [ref=e340]:
          - generic [ref=e341]: "200"
          - generic [ref=e342]: "@"
          - generic [ref=e343]: app_project_index
      - link "13 ms" [ref=e345] [cursor=pointer]:
        - /url: http://localhost:8080/_profiler/3c7828?panel=time
        - generic [ref=e346]:
          - generic [ref=e347]: "13"
          - generic [ref=e348]: ms
      - link "4.0 MiB" [ref=e350] [cursor=pointer]:
        - /url: http://localhost:8080/_profiler/3c7828?panel=time
        - generic [ref=e351]:
          - generic [ref=e352]: "4.0"
          - generic [ref=e353]: MiB
      - link "Logger 10" [ref=e355] [cursor=pointer]:
        - /url: http://localhost:8080/_profiler/3c7828?panel=logger
        - generic [ref=e356]:
          - img "Logger" [ref=e357]
          - generic [ref=e361]: "10"
      - link "17" [ref=e363] [cursor=pointer]:
        - /url: http://localhost:8080/_profiler/3c7828?panel=translation
        - generic [ref=e364]:
          - img [ref=e365]
          - generic [ref=e370]: "17"
      - link "Security admin@abc.com" [ref=e372] [cursor=pointer]:
        - /url: http://localhost:8080/_profiler/3c7828?panel=security
        - generic [ref=e373]:
          - img "Security" [ref=e374]
          - generic [ref=e378]: admin@abc.com
      - link "Twig 2 ms" [ref=e380] [cursor=pointer]:
        - /url: http://localhost:8080/_profiler/3c7828?panel=twig
        - generic [ref=e381]:
          - img "Twig" [ref=e382]
          - generic [ref=e386]: "2"
          - generic [ref=e387]: ms
      - link "7 in 0.90 ms" [ref=e389] [cursor=pointer]:
        - /url: http://localhost:8080/_profiler/3c7828?panel=db
        - generic [ref=e390]:
          - img [ref=e391]
          - generic [ref=e396]: "7"
          - generic [ref=e397]: in 0.90 ms
      - link "Symfony 7.4.7" [ref=e399] [cursor=pointer]:
        - /url: http://localhost:8080/_profiler/3c7828?panel=config
        - generic [ref=e400]:
          - img "Symfony" [ref=e402]
          - generic [ref=e404]: 7.4.7
      - button "Close Toolbar" [expanded] [ref=e405] [cursor=pointer]:
        - img [ref=e406]
```

# Test source

```ts
  117 |         const nombreInput = page.locator('input[name="nombre"]').first();
  118 |         const codigoInput = page.locator('input[name="codigo"]').first();
  119 | 
  120 |         if ((await nombreInput.count()) > 0) await nombreInput.fill(PROJECT_NAME);
  121 |         if ((await codigoInput.count()) > 0) await codigoInput.fill(PROJECT_CODE);
  122 | 
  123 |         await page.locator('button[type="submit"]').first().click();
  124 |         await page.waitForLoadState('networkidle');
  125 | 
  126 |         const url = page.url();
  127 |         // No debe estar en /create ni redirigir a login
  128 |         expect(url).not.toContain('/login');
  129 |     });
  130 | });
  131 | 
  132 | // ────────────────────────────────────────────────────────────
  133 | // UC-CRUD-04: Duplicar (clonar) proyecto
  134 | // ────────────────────────────────────────────────────────────
  135 | test.describe('UC-CRUD-04: Duplicar proyecto', () => {
  136 |     test.beforeEach(async ({ page }) => {
  137 |         await loginAsAdmin(page);
  138 |     });
  139 | 
  140 |     test('Existe un botón o enlace para duplicar/clonar desde el listado o detalle', async ({
  141 |         page,
  142 |     }) => {
  143 |         await page.goto('/projects/');
  144 |         await page.waitForLoadState('networkidle');
  145 | 
  146 |         // Buscar enlace de duplicar (puede variar en texto e idioma)
  147 |         const cloneLink = page
  148 |             .locator(
  149 |                 'a[href*="duplic"], a[href*="clone"], a[href*="copy"], form[action*="duplicate"], button:has-text("Duplicar"), button:has-text("Clonar"), button:has-text("Duplicate"), button:has-text("Clone")'
  150 |             )
  151 |             .first();
  152 | 
  153 |         const cloneCount = await cloneLink.count();
  154 |         if (cloneCount === 0) {
  155 |             // Puede estar dentro del detalle del proyecto
  156 |             // Buscar el primer link de un proyecto específico (URL con ID numérico)
  157 |             // Excluir /create y la URL raíz de la lista
  158 |             const allLinks = page.locator('a[href*="/projects/"]');
  159 |             const count = await allLinks.count();
  160 |             let firstProject = null;
  161 |             for (let i = 0; i < count; i++) {
  162 |                 const href = await allLinks.nth(i).getAttribute('href');
  163 |                 if (href && /\/projects\/\d+/.test(href)) {
  164 |                     firstProject = allLinks.nth(i);
  165 |                     break;
  166 |                 }
  167 |             }
  168 |             if (firstProject) {
  169 |                 await firstProject.click();
  170 |                 await page.waitForLoadState('networkidle');
  171 |                 const innerClone = page
  172 |                     .locator(
  173 |                         'a[href*="duplic"], a[href*="clone"], a[href*="copy"], form[action*="duplicate"], button:has-text("Duplicar"), button:has-text("Clonar"), button:has-text("Duplicate"), button:has-text("Clone")'
  174 |                     )
  175 |                     .first();
  176 |                 expect(await innerClone.count()).toBeGreaterThan(0);
  177 |             } else {
  178 |                 test.skip(true, 'No hay proyectos con los que probar la clonación');
  179 |             }
  180 |         } else {
  181 |             await expect(cloneLink).toBeVisible();
  182 |         }
  183 |     });
  184 | 
  185 |     test('Clonar proyecto crea entrada independiente en listado', async ({ page }) => {
  186 |         // Contar proyectos antes (navegar a la show page donde está el botón duplicar)
  187 |         const projectId = await getFirstProjectId(page);
  188 |         if (!projectId) {
  189 |             test.skip(true, 'No hay proyectos disponibles para clonar');
  190 |             return;
  191 |         }
  192 | 
  193 |         // Contar proyectos antes
  194 |         await page.goto('/projects/');
  195 |         await page.waitForLoadState('networkidle');
  196 |         const countBefore = await page.locator('table tbody tr').count();
  197 | 
  198 |         // Ir a la show page del proyecto y ejecutar duplicar desde ahí
  199 |         await page.goto(`/projects/${projectId}`);
  200 |         await page.waitForLoadState('networkidle');
  201 | 
  202 |         const dupForm = page.locator('form[action*="duplicate"]');
  203 |         if ((await dupForm.count()) === 0) {
  204 |             test.skip(true, 'Sin formulario de duplicado en show del proyecto');
  205 |             return;
  206 |         }
  207 | 
  208 |         await dupForm.locator('button[type="submit"]').click();
  209 |         await page.waitForLoadState('networkidle');
  210 | 
  211 |         // Volver al listado
  212 |         await page.goto('/projects/');
  213 |         await page.waitForLoadState('networkidle');
  214 |         const countAfter = await page.locator('table tbody tr').count();
  215 | 
  216 |         // Debe haber al menos uno más
> 217 |         expect(countAfter).toBeGreaterThan(countBefore);
      |                            ^ Error: expect(received).toBeGreaterThan(expected)
  218 |     });
  219 | });
  220 | 
  221 | // ────────────────────────────────────────────────────────────
  222 | // UC-CRUD-06: Crear Plantilla dentro de Proyecto
  223 | // ────────────────────────────────────────────────────────────
  224 | test.describe('UC-CRUD-06: Crear Plantilla dentro de Proyecto', () => {
  225 |     test.beforeEach(async ({ page }) => {
  226 |         await loginAsAdmin(page);
  227 |     });
  228 | 
  229 |     test('Listado de proyectos permite navegar a plantillas del primer proyecto', async ({
  230 |         page,
  231 |     }) => {
  232 |         const projectId = await getFirstProjectId(page);
  233 |         if (!projectId) {
  234 |             test.skip(true, 'No hay proyectos disponibles');
  235 |             return;
  236 |         }
  237 | 
  238 |         await page.goto(`/projects/${projectId}/templates`);
  239 |         await page.waitForLoadState('networkidle');
  240 | 
  241 |         // No debe redirigir a login
  242 |         expect(page.url()).not.toContain('/login');
  243 |     });
  244 | 
  245 |     test('Formulario de nueva plantilla tiene campo nombre', async ({ page }) => {
  246 |         const projectId = await getFirstProjectId(page);
  247 |         if (!projectId) {
  248 |             test.skip(true, 'No hay proyectos disponibles');
  249 |             return;
  250 |         }
  251 | 
  252 |         await page.goto(`/projects/${projectId}/templates/create`);
  253 |         await page.waitForLoadState('networkidle');
  254 | 
  255 |         if (page.url().includes('/login')) {
  256 |             test.skip(true, 'Ruta de creación redirige a login (permisos insuficientes)');
  257 |             return;
  258 |         }
  259 | 
  260 |         const nombreInput = page.locator('input[name="nombre"]').first();
  261 |         if ((await nombreInput.count()) > 0) {
  262 |             await expect(nombreInput).toBeVisible();
  263 |         } else {
  264 |             // Puede tener otro name
  265 |             await expect(page.locator('form input').first()).toBeVisible();
  266 |         }
  267 |     });
  268 | });
  269 | 
```