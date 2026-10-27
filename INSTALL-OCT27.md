# Drop-in update, 27 October

These files go into the `perellion` theme folder in Local, over the
top of what is already there. Nothing existing is deleted.

    ~/Local Sites/perellsitedev/app/public/wp-content/themes/perellion/

## What is in this zip

    theme.json                  updated: registers the page templates + template parts
    style.css                   updated: adds the motion layer, hero, card and FAQ styles
    functions.php               updated: enqueues assets/js/motion.js
    templates/page.html         new
    templates/page-wide.html    new
    assets/js/motion.js         new
    patterns/*.php              new (8 files)

## Install

    cd ~/Local\ Sites/perellsitedev/app/public/wp-content/themes/perellion && \
      unzip -o ~/Downloads/perellion-update-oct27.zip && \
      git add -A && \
      git commit -m "Add pattern library, page templates and scroll motion" && \
      git push

## Build the Defense page

1. WP Admin → Pages → Add New
2. Title: `Defense`
3. Page attributes → Template → **Page, full width sections**
4. In the editor, click the **+** → Patterns tab → search "Defense"
5. Insert **Defense industry page**
6. Publish

The whole page appears in one insert. Everything in it is an ordinary
block, so copy and images can be edited in place.

## Replace the placeholder images

The hero and the "How Perellion Helps" section point at images on the
current production site so the page is not empty. Swap them for Haley's
assets from the Google Drive folder: click the image, Replace, Upload.

Hero crop is 2400x1200. Section images are 720x480.

## Note on the jump links

The four links under the hero headline scroll to `#challenges`, `#help`,
`#secure` and `#risk`. Those IDs are already on the sections, so they
work as soon as the page is published.

## Motion

`assets/js/motion.js` runs the six motion behaviours that are inside the
fixed fee: reveal on scroll, headline line by line, jump links 80 to 100
percent opacity, scroll arrow disappearing, background parallax, depth
parallax. All of it is suppressed for visitors with reduced motion turned
on, and the page renders fully visible with JavaScript off.

The three larger items in SOW section 5.5 (clip-path hero reveal, sticky
scroll storytelling, card carousel) are not in this file. It is written so
they layer on top without a rebuild if Sovo approves the change order.
