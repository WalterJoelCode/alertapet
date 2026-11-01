# Sistema de diseño 2.0 — AlertaPet

## Dirección y principios

AlertaPet es una comunidad digital para proteger, encontrar y acompañar animales. La identidad visual es editorial, sobria y cálida: informa con claridad, permite actuar con rapidez y deja que las fotografías auténticas aporten humanidad. Se toma como referencia la facilidad de uso de productos de hospitalidad modernos, sin reproducir su lenguaje visual.

- Una acción principal visible por contexto; las acciones secundarias nunca compiten con ella.
- Espacio negativo, tipografía legible y composiciones apropiadas a cada tipo de información.
- Uso contenido de tarjetas: reservarlas para unidades comparables, no para envolver cada bloque.
- Contenido real, demostración, carga, vacío y error deben diferenciarse explícitamente.
- La accesibilidad y la confianza son requisitos de diseño, no acabados posteriores.

## Identidad y tokens

| Token | Hex | Uso |
|---|---:|---|
| `pet-primary` | `#C8A11F` | Acción principal, marca e indicadores |
| `pet-surface` | `#E6E8EA` | Fondo secundario, separadores y skeletons |
| `pet-slate` | `#6F7A85` | Texto y controles secundarios |
| `pet-charcoal` | `#2C3136` | Texto principal, navegación, footer y fondos oscuros |
| `pet-taupe` | `#8F7D5B` | Acentos editoriales cálidos |
| `pet-gold-strong` | `#806400` | Oro derivado para texto, iconos y foco de contraste alto |

Los tokens se declaran en `resources/css/app.css`, mediante `@theme` y variables CSS. Las clases de compatibilidad `pet-marine`, `pet-deep`, `pet-cream`, `pet-sepia` y `pet-leather` apuntan a los nuevos tokens para no romper vistas existentes; no se deben utilizar en componentes nuevos. No dispersar hexadecimales en plantillas.

El oro principal se usa con texto Charcoal, nunca con texto blanco. El oro derivado se usa para texto pequeño sobre blanco. Blanco y tonos derivados pueden emplearse cuando hacen falta para contraste y superficies.

## Tipografía y espaciado

La fuente es Lato; los fallbacks son Segoe UI, Arial y sans-serif. La jerarquía prioriza titulares 700–900, cuerpo 400 y acciones 700. Los títulos principales son fluidos entre 36 y 60 px; los títulos de sección entre 30 y 36 px; el cuerpo se mantiene en 16 px o más con altura de línea de 1.5–1.75. Evitar párrafos de más de 65–75 caracteres por línea.

La escala de espacio es 4, 8, 12, 16, 24, 32, 48, 64 y 96 px. Usar `gap` entre elementos hermanos. Radios: 12 px para controles, 16 px para superficies y 24–32 px solo para piezas protagonistas. Las sombras son tenues y funcionales; los bordes sutiles separan contenido antes de añadir elevación.

## Componentes

- `button-primary`: oro Mustard Gold, texto Charcoal, altura táctil mínima de 48 px.
- `button-secondary`: borde Charcoal sutil, fondo blanco; alternativa visible y no dominante.
- `button-tertiary`: navegación y acciones de baja prioridad.
- `surface-card`: borde fino, radio 16 px y sombra leve; hover de 2 px máximo solo con puntero preciso.
- `status-badge`: etiqueta compacta con texto, icono y significado explícito.
- `skeleton-card`: componente Blade reutilizable (`<x-skeleton-card />`) con dimensiones estables.
- FAQ: `details` y `summary` nativos para conservar teclado y semántica sin JavaScript adicional.

Todo control interactivo debe contemplar default, hover, active, focus-visible y disabled o loading cuando corresponda. Los estados de éxito y error combinan icono, texto y color; el color no puede ser su única señal.

## Contenido asincrónico

Los skeletons utilizan Light Gray y blanco derivado con shimmer tenue. Mantienen la geometría del contenido final para proteger CLS y respetan `prefers-reduced-motion`. Sustituirlos por contenido, estado vacío o error tan pronto se resuelva la carga; nunca dejarlos indefinidamente. La sección de opiniones permanece como placeholder hasta contar con reseñas verificadas. Las adopciones actuales son una demostración visual, no información real.

## Responsividad y navegación

El sistema es mobile-first. El contenedor es `max-w-7xl`, con 20 px de relleno en móvil, 32 px en tablet y 40 px en escritorio. Validar a 320, 375, 768, 1024 y 1440 px. Las acciones se apilan cuando sea necesario, las imágenes conservan proporción y los grids cambian de una a dos, tres o cuatro columnas según el contenido. La navegación de escritorio pasa a un menú nativo desplegable en móvil; sus destinos deben seguir siendo rutas reales o anclas de la página.

No ocultar información importante para simplificar móvil. No debe existir desplazamiento horizontal accidental, acciones menores de 44–48 px, texto truncado ni imágenes deformadas.

## Accesibilidad, interacción y rendimiento

La meta es WCAG 2.2 AA: estructura semántica, un único `h1`, jerarquía de encabezados, foco visible, controles etiquetados, texto alternativo contextual y contraste verificable. La interfaz respeta `prefers-reduced-motion`; las transiciones duran 150–250 ms y se limitan a color, opacidad, sombra y transformaciones pequeñas. No usar animaciones automáticas distractoras ni información dependiente solo de hover.

El hero puede usar `fetchpriority="high"`; las imágenes no críticas usan `loading="lazy"`, `aspect-ratio` y `object-fit: cover`. Evitar bibliotecas adicionales, carruseles automáticos y fuentes o imágenes innecesariamente pesadas.

## Criterios para evitar una interfaz genérica

- No aplicar gradientes, glassmorphism o sombras grandes como decoración.
- No repetir grids de tres tarjetas si el contenido necesita otra composición.
- No usar iconos sin función informativa o de acción.
- Dar protagonismo a la fotografía y al mensaje de ayuda, no a adornos de UI.
- Limitar cada sección a una jerarquía clara: contexto, mensaje, acción y contenido.
- Marcar las demostraciones con honestidad y no crear estadísticas, testimonios o flujos inexistentes.

## Auditoría visual

Antes de entregar un cambio visual: compilar los assets; inspeccionar la landing y navegación en 320, 375, 768, 1024 y 1440 px cuando exista una instancia local; revisar contraste, foco, composición, carga de imágenes, skeletons y ausencia de overflow. Repetir tras corregir cualquier problema. Informar de forma explícita si la instancia o la herramienta de auditoría no están disponibles.

## Restricciones de implementación

Usar Blade y Tailwind v4 existentes. Reutilizar tokens y componentes antes de añadir estilos locales. No modificar reglas de negocio, autenticación, rutas ni datos reales para fines visuales. Toda acción debe conducir a una ruta existente o a un ancla válida.
