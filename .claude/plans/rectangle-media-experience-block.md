# Plan: Support Rectangle Media in Experience Block

## Context
The portfolio page's experience/formation timeline entries display company/school logos using a `100x100` Sulu image format with `mode="outbound"`, which forces a square crop. This distorts non-square logos (e.g. wide company banners). The goal is to preserve the original aspect ratio of uploaded images and display them slightly wider (120px instead of 75px).

## Current Implementation
- **Image format**: `100x100` in `config/image-formats.xml` — forces 100x100px square crop
- **Twig template**: `templates/pages/portfolio.html.twig` line 287 — uses `entry.icon.thumbnails['100x100']`
- **Card component**: `templates/components/frontend/card_info.html.twig` — renders `<img>` at 75px wide with `object-fit: contain`

## Changes (3 files)

### File 1: `config/image-formats.xml`
**Action**: Add a new width-only image format

```xml
<!-- Add after the existing 150x150 format (line 12) -->
<format key="150x">
    <scale x="150" mode="outbound"/>
</format>
```

This follows the same pattern as the existing `500x` format — width constrained to 150px, height auto-calculated to preserve aspect ratio.

### File 2: `templates/pages/portfolio.html.twig` (line 287)
**Action**: Switch from square format to width-only format

```diff
- asset="{{ entry.icon.id is defined ? entry.icon.thumbnails['100x100'] : '' }}"
+ asset="{{ entry.icon.id is defined ? entry.icon.thumbnails['150x'] : '' }}"
```

### File 3: `templates/components/frontend/card_info.html.twig` (lines 34-36)
**Action**: Increase display width from 75px to 120px

```diff
  img {
-     width: 75px;
-     max-width: 75px;
+     width: 120px;
+     max-width: 120px;
      height: auto;
      object-fit: contain;
      flex-shrink: 0;
  }
```

## Verification
1. Run `bin/adminconsole sulu:media:format:cache:clear` to regenerate thumbnails with new format
2. Visit the portfolio page — logos should display with their natural aspect ratio at 120px wide
3. Confirm square logos still look fine (displayed as 120x120)
4. Check mobile layout — card should still work with wider image
