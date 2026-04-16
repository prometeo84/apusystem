## Casos de Uso Críticos y Estrategia de Tests

Resumen corto de los principales flujos de negocio que cubrimos con E2E y las pruebas añadidas.

- **Remember-me / Persistent login**: Compatibilidad con implementaciones legacy y modernas de UserProvider. Añadido test unitario para `DoctrineTokenProvider` que verifica persistencia y carga de tokens.
- **Cambio de locale**: Backwards-compatible `/locale/{locale}` añadido; tests E2E cubren redirecciones y seguridad de referer.
- **APU flows**: E2E modificados para aceptar ausencia de APUs como caso válido; recomendar añadir seeder/migration para datos de prueba.

Recomendaciones:

- Añadir tests unitarios para `LocaleController` y pruebas de integración que validen la seguridad del referer.
- Alinear `bin/create_test_apu.php` con el esquema de BD actual o provisionar migraciones de test.
- Revertir cambios temporales (p.ej. `perPage` y elevación de niveles de logging) antes de merge, o documentarlos claramente en el PR.

Próximos pasos propuestos:

- Commit + PR documentando mitigaciones temporales.
- Añadir coverage pipeline que ejecute `composer test` y `npx playwright test` en CI.
