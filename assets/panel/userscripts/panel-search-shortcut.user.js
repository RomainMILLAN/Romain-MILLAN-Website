// ==UserScript==
// @name         Panel — raccourci recherche dans les iframes
// @namespace    panel-search-shortcut
// @version      1.0.0
// @description  Relaie CTRL+Shift+K depuis l'iframe d'une application vers le panel parent pour ouvrir la recherche, même en cross-origin.
// @match        *://*/*
// @run-at       document-idle
// @grant        none
// ==/UserScript==

// ─────────────────────────────────────────────────────────────────────────────
// POURQUOI CE SCRIPT
// Le panel écoute CTRL+Shift+K sur son propre document pour ouvrir la recherche.
// Mais quand le focus est dans l'iframe d'une application (cross-origin), le
// navigateur livre le keydown au document de l'iframe, jamais au parent, et la
// Same-Origin Policy interdit au panel d'y accéder. Ce userscript s'exécute DANS
// l'iframe, capte la touche, et la relaie au panel via postMessage.
//
// INSTALLATION
//   1. Installer Tampermonkey (ou Violentmonkey).
//   2. Créer un nouveau script et y coller ce fichier.
//   3. Adapter PANEL_ORIGIN ci-dessous à l'origine exacte de votre panel.
//   4. Sauvegarder. Le raccourci fonctionne désormais y compris focus dans une iframe.
// ─────────────────────────────────────────────────────────────────────────────

(function () {
    'use strict';

    // ── Contrat partagé avec le panel ───────────────────────────────────────
    // À ADAPTER : origine exacte (schéma + domaine + port) de votre panel.
    const PANEL_ORIGIN = 'https://romainmillan.fr';

    // Moitié distante du contrat partagé avec search_controller.ts.
    // Version de PROTOCOLE : doit rester IDENTIQUE des deux côtés. Changer cette
    // valeur ici sans changer le panel (et inversement) casse le lien.
    const OPEN_SEARCH_MESSAGE = 'panel:open-search:v1';

    // Convention de touche, miroir du handler natif du panel.
    const isSearchShortcut = (e) =>
        (e.ctrlKey || e.metaKey) && e.shiftKey && e.key.toLowerCase() === 'k';

    // ── Double garde : n'agir que dans NOTRE iframe, jamais ailleurs ─────────
    // 1. seulement dans une iframe (le top window du panel gère déjà la touche).
    if (window.self === window.top) return;

    // 2. seulement si c'est LE PANEL qui nous embarque. Sans ce test, le script
    //    volerait CTRL+Shift+K dans n'importe quelle iframe de n'importe quel
    //    site visité. (ancestorOrigins quand dispo, document.referrer en fallback.)
    const parentOrigin = (window.location.ancestorOrigins && window.location.ancestorOrigins[0])
        ? window.location.ancestorOrigins[0]
        : (document.referrer ? new URL(document.referrer).origin : null);
    if (parentOrigin !== PANEL_ORIGIN) return;

    // [DIAG] À retirer une fois validé : confirme que le script tourne dans l'iframe.
    console.log('[panel-search] userscript actif dans l\'iframe, parent =', parentOrigin);

    // ── Relais ──────────────────────────────────────────────────────────────
    // capture: true → on intercepte AVANT que l'app (ExtJS/Proxmox) ne puisse
    // stopper la propagation et nous priver de l'événement.
    document.addEventListener('keydown', (e) => {
        if (!isSearchShortcut(e)) return;

        // [DIAG] À retirer une fois validé.
        console.log('[panel-search] raccourci détecté → postMessage vers', PANEL_ORIGIN);

        e.preventDefault();
        // targetOrigin = PANEL_ORIGIN : le message n'est livré qu'au panel.
        window.parent.postMessage({ type: OPEN_SEARCH_MESSAGE }, PANEL_ORIGIN);
    }, true);
})();
