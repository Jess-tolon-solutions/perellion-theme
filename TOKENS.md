# Perellion design tokens

Generated from the Sovo Figma file **Perellion Website 2026**, section
*01 — Foundations*, on 19 October 2026.

Every value in the theme comes from here. Nothing is hardcoded. If a colour or
spacing value needs to change, it changes in `theme.json` and updates
everywhere at once.

---

## How the three naming systems line up

Figma publishes variables as `--perellion-*`. WordPress generates its own names
from `theme.json` as `--wp--preset--*`. The aliases at the top of `style.css`
map one to the other.

That means **CSS copied straight out of Figma dev mode works unchanged**, and
there is still only one real source for each value.

```
Figma variable          →  --perellion-brand-azure
WordPress preset        →  --wp--preset--color--brand-azure
Alias in style.css      →  --perellion-brand-azure: var(--wp--preset--color--brand-azure)
```

---

## Colour

| Token | Hex | Used for |
|---|---|---|
| `charcoal` | `#231F20` | Body text, dark section backgrounds |
| `graphite` | `#333333` | Secondary text, captions |
| `white` | `#FFFFFF` | Page background, inverse text |
| `canvas` | `#F5F5F5` | Alternating section background |
| `panel` | `#F0F0F0` | Card and panel fills |
| `subtle` | `#F2F2F2` | Dividers, subtle fills |
| `light-grey` | `#D9D9D9` | Borders, rules |
| `disabled` | `#BDBBBC` | Disabled control states |
| `action-primary` | `#0669FE` | Buttons, links |
| `action-focus` | `#00A9FF` | Focus rings, focus states |
| `brand-azure` | `#009EFF` | Brand accent |
| `brand-violet` | `#6125CE` | Brand accent, active states |
| `brand-orchid` | `#7F52EE` | Brand accent |
| `lavender-tint` | `#EAE6FD` | Tinted section backgrounds |
| `decoration-cyan` | `#32EEFF` | Decorative gradients |
| `ultraviolet` | `#1206FE` | Gradient end, link hover |
| `spectrum-gold` | `#F9DA3C` | Accent |
| `spectrum-amber` | `#F6CD2B` | Accent |
| `spectrum-lemon` | `#FAF262` | Accent |

Transparency variants of charcoal and white are defined in `style.css` as
`--perellion-background-dark-grey-alpha-*` and `--perellion-background-white-alpha-*`,
matching the Figma names.

### Gradients

| Token | Value | Used for |
|---|---|---|
| `azure-ultraviolet` | `#009EFF → #1206FE` | Accent word in hero headlines |
| `cyan-violet` | `#32EEFF → #6125CE` | Decorative treatments |

Apply gradient text with the `.perellion-gradient-text` class. It falls back to
solid azure where `background-clip: text` is unsupported.

---

## Typography

Poppins for display, headings and labels. Inter for body copy. Both are Google
Fonts, so no licensing is required. Variable font files are self-hosted in
`/assets/fonts` rather than loaded from Google, which removes a third-party
request and the privacy question that comes with it.

| Token | Size | Line height | Family | Figma source |
|---|---|---|---|---|
| `display` | 60px | 75px | Poppins Medium | Type/Display/Desktop |
| `heading` | 40px | 44px | Poppins Medium | Type/Heading/Desktop |
| `subheading` | 28px | 36px | Poppins Medium | Poppins/Medium/28-36 |
| `card` | 21px | 28px | Poppins Medium | Type/Card/Desktop |
| `lead` | 21px | 37px | Poppins Regular | Type/Body/Lead |
| `body` | 16px | 24px | Inter Regular | Type/Body/Default |
| `small` | 14px | 20px | Poppins Medium | Poppins/Medium/14-20 |
| `caption` | 13px | 20px | Poppins Regular | Poppins/Regular/13-19.9 |

Display, heading, subheading, card and lead are fluid: they scale down at small
viewport widths. The Figma mobile values are the floor.

`display` scales 50px → 60px, matching Type/Display/Mobile at the low end.

### Letter spacing

| Token | Value | Used for |
|---|---|---|
| `tight` | `-0.24px` | Inter body copy |
| `base` | `1px` | Poppins headings |
| `overline` | `5px` | Uppercase eyebrow labels |

Use `.perellion-overline` for eyebrow text. It applies Poppins Medium at 16px
with 5px tracking, uppercase, matching Poppins/Medium/16-75.

---

## Spacing

Seventeen steps, taken directly from the Figma spacing collection.

`4 · 8 · 10 · 12 · 16 · 20 · 24 · 32 · 40 · 48 · 60 · 64 · 80 · 96 · 120 · 160 · 220`

Available as `--wp--preset--spacing--{n}` and as `--perellion-space-{n}`.
The editor spacing control offers exactly these and nothing else.

---

## Layout

| Token | Value | Notes |
|---|---|---|
| Content width | `840px` | Default for text blocks |
| Wide width | `1280px` | Wide-aligned blocks |
| `card-min` | `240px` | Minimum card width in auto-fit grids |
| `gutter` | `1.5rem` | Page side padding |

The `.perellion-card-grid` utility builds an auto-fitting grid from `card-min`,
so card rows reflow at any width without breakpoint-specific CSS.

---

## Radius, shadow, motion

| Token | Value |
|---|---|
| `radius.sm` | `4px` |
| `radius.md` | `8px` |
| `radius.lg` | `16px` |
| `radius.pill` | `999px` |
| `blur.backdrop` | `14px` |
| `transition.fast` | `120ms ease` |
| `transition.base` | `200ms ease` |
| `transition.slow` | `320ms ease` |

Shadow presets: `glass`, `card`, `lifted`.

The transition tokens are placeholders pending Sovo's motion references. The
values are conventional and will be replaced once those arrive. Every
transition in the theme is suppressed under `prefers-reduced-motion`, which is
handled globally in `style.css` rather than per-component.

---

## Content types

Case studies, team bios and job postings are registered as custom post types in
`/inc/post-types.php`, replacing the previous site's use of blog categories.

Existing URLs are preserved, so these three types need no redirects:

- `/case-studies/{slug}`
- `/meet-the-team/{slug}`
- `/join-the-team/{slug}`

An `industry` taxonomy is attached to case studies and seeded with the six
industry slugs on activation. This lets each industry page pull its own
relevant case studies automatically instead of carrying a hand-maintained list.

---

## Open items

These are pending from Sovo and will change the theme when they land:

1. **Motion references.** Hover, transition and animation behaviour. Current
   transition tokens are placeholders.
2. **Parallax background.** If it goes ahead it must be built into the theme
   foundation rather than added on top.
3. **Mobile section nav.** Behaviour of the industry page section navigation at
   small widths.
4. **Defense headline gradient.** Confirmed as `azure-ultraviolet` pending
   Sovo's confirmation that it is a gradient fill rather than two solid colours.
