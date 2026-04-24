<?php
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');
?><!doctype html>
<html lang="it">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ReviewShield</title>
    <meta name="description" content="Rimuoviamo le recensioni negative da Google. Prima analisi gratuita, paghi solo a risultato ottenuto">
    <meta name="author" content="ReviewShield" />
    <link rel="canonical" href="https://reviewshield.it" />

    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://reviewshield.it" />
    <meta property="og:image" content="/og-image.jpg">
    <meta property="og:title" content="ReviewShield">
    <meta property="og:description" content="Rimuoviamo le recensioni negative da Google. Prima analisi gratuita, paghi solo a risultato ottenuto">
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:image" content="/og-image.jpg">
    <meta name="twitter:title" content="ReviewShield">
    <meta name="twitter:description" content="Rimuoviamo le recensioni negative da Google. Prima analisi gratuita, paghi solo a risultato ottenuto">

    <!-- Favicon ReviewShield (scudo verde con spunta) -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/icon-192.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#059669">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <!-- TODO: Google Analytics (GA4) — sostituire G-XXXXXXXXXX col tuo ID -->
    <!-- TODO: Meta Pixel — sostituire YOUR_PIXEL_ID col tuo Pixel ID -->

    <!-- CSS pre-React: nascondi bubble WhatsApp PRIMA che il bundle lo renderizzi -->
    <style>
      /* Nascondi link diretti wa.me/whatsapp (sono sempre solo link specifici) */
      a[href*="wa.me"], a[href*="whatsapp"], a[href*="api.whatsapp"] { display: none !important; }
      /* Nascondi solo anchor/button che contengono SVG WhatsApp - NO div (per non rompere layout) */
      a:has(svg path[d^="M17.472"]),
      button:has(svg path[d^="M17.472"]) {
        display: none !important;
      }
      /* Class/id specifici bubble */
      [class*="whatsapp" i], [id*="whatsapp" i],
      [class*="wa-bubble" i],
      [class*="whats-bubble" i], [aria-label*="whatsapp" i] {
        display: none !important;
      }
    </style>

    <script type="module" crossorigin src="/assets/index-DW4n5zfc.js"></script>
    <link rel="stylesheet" crossorigin href="/assets/index-BNl2Bqut.css">
  </head>

  <body>
    <div id="root"></div>

    <!-- Success banner per lead inviato -->
    <div id="rs-lead-banner" style="display:none;position:fixed;top:20px;left:50%;transform:translateX(-50%);z-index:99999;background:#059669;color:#fff;padding:14px 24px;border-radius:12px;font-family:system-ui,-apple-system,sans-serif;font-size:14px;font-weight:600;box-shadow:0 10px 40px rgba(0,0,0,.3)"></div>

    <script>
    (function(){
      // Text replacements per rimuovere ogni riferimento residuo a WhatsApp
      var TEXT_REPL = [
        [/Scrivici su WhatsApp/g, 'Richiedi Analisi Gratuita'],
        [/Invia su WhatsApp/g, 'Invia richiesta'],
        [/Apri WhatsApp/g, 'Richiedi analisi'],
        [/Compila e ti si apre WhatsApp con il messaggio pronto/g, 'Lascia i tuoi dati: ti ricontattiamo entro 24 ore'],
        [/ti si apre WhatsApp con il messaggio pronto/g, 'ti ricontattiamo entro 24 ore'],
        [/Risposta entro 2 ore/g, 'Ti ricontattiamo entro 24 ore'],
        [/risposta entro 2 ore/g, 'ti ricontattiamo entro 24 ore'],
        [/Rispondiamo in 2 min/g, 'Ti ricontattiamo entro 24 ore'],
        [/Scrivici ora/g, 'Richiedi analisi'],
        [/Scrivici/g, 'Richiedi analisi'],
        [/via WhatsApp/g, ''],
        [/su WhatsApp/g, ''],
        [/tramite WhatsApp/g, ''],
        [/in WhatsApp/g, ''],
        [/\bWhatsApp\b/g, 'Analisi Gratuita'],
      ];

      function patchText(root){
        if(!root) return;
        var w = document.createTreeWalker(root, NodeFilter.SHOW_TEXT, {
          acceptNode: function(n){
            if (!n.textContent || !n.textContent.trim()) return NodeFilter.FILTER_REJECT;
            var tag = n.parentElement && n.parentElement.tagName;
            if (tag === 'SCRIPT' || tag === 'STYLE') return NodeFilter.FILTER_REJECT;
            return NodeFilter.FILTER_ACCEPT;
          }
        });
        var n, toChange=[];
        while (n = w.nextNode()) {
          var orig = n.textContent, ch = orig;
          for (var i=0;i<TEXT_REPL.length;i++) ch = ch.replace(TEXT_REPL[i][0], TEXT_REPL[i][1]);
          if (ch !== orig) toChange.push([n, ch]);
        }
        toChange.forEach(function(p){ p[0].textContent = p[1]; });
      }

      function hideBubbleJS(){
        // Backup del CSS :has() per browser che non lo supportano o per elementi che sfuggono
        document.querySelectorAll('svg path').forEach(function(path){
          var d = path.getAttribute('d') || '';
          if (d.indexOf('M17.472') === 0 || d.indexOf('17.472 14.382') > -1) {
            var el = path;
            for (var i=0; i<10 && el && el !== document.body; i++) {
              if (el.tagName === 'A' || el.tagName === 'BUTTON') { el.style.display = 'none'; return; }
              try {
                var cs = getComputedStyle(el);
                if (cs.position === 'fixed' || cs.position === 'sticky') { el.style.display = 'none'; return; }
              } catch(e){}
              el = el.parentElement;
            }
            var svg = path.closest && path.closest('svg');
            if (svg && svg.parentElement) svg.parentElement.style.display = 'none';
          }
        });
        // Qualsiasi elemento fixed/sticky in basso-destra con innerHTML "WhatsApp"
        document.querySelectorAll('a,button,div,aside').forEach(function(el){
          try {
            var cs = getComputedStyle(el);
            if (cs.position !== 'fixed' && cs.position !== 'sticky') return;
            var b = parseInt(cs.bottom); var r = parseInt(cs.right);
            if (isNaN(b) || isNaN(r) || b > 200 || r > 200) return;
            var inner = (el.innerHTML || '').toLowerCase();
            if (/whatsapp|wa\.me|17\.472|rispondiamo in|risposta in/i.test(inner)) {
              el.style.display = 'none';
            }
          } catch(e){}
        });
      }

      // === PATCH FORM HERO: inietta email+telefono + submit -> submit.php ===
      // Il form React ha solo "Nome e cognome" + "Nome attività". Aggiungo email+telefono
      // prima del bottone submit e intercetto il submit per POST a submit.php.
      function findHeroForm(){
        var forms = document.querySelectorAll('form');
        for (var i=0; i<forms.length; i++) {
          var f = forms[i];
          if (f.dataset.rsPatched) continue;
          var hasNameInput = false;
          var inputs = f.querySelectorAll('input');
          for (var j=0; j<inputs.length; j++) {
            var ph = ((inputs[j].placeholder||'')+' '+(inputs[j].name||'')+' '+(inputs[j].getAttribute('aria-label')||'')).toLowerCase();
            if (/nome|name|mario/i.test(ph)) { hasNameInput = true; break; }
          }
          if (hasNameInput) return f;
        }
        return null;
      }

      function patchHeroForm(){
        var form = findHeroForm();
        if (!form) return;
        if (form.dataset.rsPatched) return;
        form.dataset.rsPatched = '1';

        // Trova il primo input esistente per clonare lo stile
        var templateInput = form.querySelector('input[type="text"], input:not([type])');
        if (!templateInput) return;
        var submitBtn = form.querySelector('button[type="submit"], button:last-of-type') || form.querySelector('button');
        if (!submitBtn) return;

        // Costruisci nuovi input email + telefono clonando il template
        function makeInput(type, placeholder, id){
          var inp = templateInput.cloneNode(false);
          inp.removeAttribute('value');
          inp.removeAttribute('name');
          inp.type = type;
          inp.placeholder = placeholder;
          inp.id = id;
          inp.required = true;
          inp.value = '';
          return inp;
        }
        function makeLabel(text){
          // Prova a clonare una label esistente, se c'è
          var existingLabel = form.querySelector('label');
          var lbl;
          if (existingLabel) {
            lbl = existingLabel.cloneNode(false);
            lbl.textContent = text;
          } else {
            lbl = document.createElement('label');
            lbl.textContent = text;
            lbl.style.display = 'block';
            lbl.style.fontWeight = '600';
            lbl.style.fontSize = '14px';
            lbl.style.marginBottom = '6px';
            lbl.style.marginTop = '12px';
          }
          lbl.htmlFor = '';
          return lbl;
        }

        // Wrapper group: clona il wrapper dell'input esistente
        var templateWrap = templateInput.closest('div[class]') || templateInput.parentElement;
        function makeField(labelText, type, placeholder, id){
          var wrap;
          if (templateWrap) {
            wrap = templateWrap.cloneNode(false);
            wrap.removeAttribute('style');
          } else {
            wrap = document.createElement('div');
            wrap.style.marginBottom = '12px';
          }
          var lbl = makeLabel(labelText);
          var inp = makeInput(type, placeholder, id);
          wrap.appendChild(lbl);
          wrap.appendChild(inp);
          return wrap;
        }

        var emailField = makeField('Email', 'email', 'es. mario@studio.it', 'rs-hero-email');
        var telField = makeField('Numero di telefono', 'tel', 'es. 333 1234567', 'rs-hero-tel');

        // Inserisci prima del bottone (o del suo wrapper se è in un contenitore)
        var anchor = submitBtn.closest('div:not(form)') || submitBtn;
        anchor.parentElement.insertBefore(emailField, anchor);
        anchor.parentElement.insertBefore(telField, anchor);

        // Intercetta submit
        form.addEventListener('submit', function(e){
          e.preventDefault();
          e.stopPropagation();
          handleSubmit(form);
        }, true);
        // Anche click del bottone (nel caso il form non abbia submit listener)
        submitBtn.addEventListener('click', function(e){
          if (submitBtn.type !== 'submit') {
            e.preventDefault();
            e.stopPropagation();
            handleSubmit(form);
          }
        }, true);
      }

      function showBanner(text, ok){
        var b = document.getElementById('rs-lead-banner');
        if (!b) return;
        b.textContent = text;
        b.style.background = ok ? '#059669' : '#dc2626';
        b.style.display = 'block';
        setTimeout(function(){ b.style.display = 'none'; }, 4500);
      }

      function handleSubmit(form){
        // Raccogli nome+cognome dal primo input text
        var txtInputs = form.querySelectorAll('input[type="text"], input:not([type]), input[type="search"]');
        var raw = '';
        for (var i=0; i<txtInputs.length; i++) {
          var v = (txtInputs[i].value||'').trim();
          if (v) { raw = v; break; }
        }
        var parts = raw.split(/\s+/).filter(Boolean);
        var nome = parts[0] || '';
        var cognome = parts.slice(1).join(' ') || '';
        var email = (document.getElementById('rs-hero-email')||{}).value || '';
        var tel = (document.getElementById('rs-hero-tel')||{}).value || '';
        email = email.trim(); tel = tel.trim();

        if (!nome || !cognome) { showBanner('Inserisci nome e cognome', false); return; }
        if (!email) { showBanner('Inserisci email', false); return; }
        if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email)) { showBanner('Email non valida', false); return; }
        if (!tel) { showBanner('Inserisci telefono', false); return; }

        var btn = form.querySelector('button[type="submit"], button:last-of-type') || form.querySelector('button');
        var origText = btn ? btn.textContent : '';
        if (btn) { btn.disabled = true; btn.textContent = 'Invio in corso...'; }

        fetch('submit.php',{
          method:'POST',
          headers:{'Content-Type':'application/json'},
          body: JSON.stringify({nome:nome, cognome:cognome, email:email, telefono:tel})
        }).then(function(r){return r.json();}).then(function(d){
          if (btn) { btn.disabled=false; btn.textContent = origText || 'Invia richiesta'; }
          if (d && d.ok) {
            showBanner('Grazie! Ti ricontattiamo entro 24 ore.', true);
            form.reset();
            var e = document.getElementById('rs-hero-email'); if (e) e.value = '';
            var t = document.getElementById('rs-hero-tel'); if (t) t.value = '';
          } else {
            showBanner((d && d.error) || 'Errore invio', false);
          }
        }).catch(function(){
          if (btn) { btn.disabled=false; btn.textContent = origText || 'Invia richiesta'; }
          showBanner('Errore di connessione', false);
        });
      }

      // CTA esterni al form hero -> scrolla al form hero
      document.addEventListener('click', function(e){
        var el = e.target.closest && e.target.closest('a,button,[role="button"]');
        if (!el) return;
        // Link a sezioni interne anchor: lascia scrollare nativamente
        var href = (el.getAttribute && el.getAttribute('href')) || '';
        if (href && href.indexOf('/privacy') === 0) return;
        if (href && href.indexOf('/termini') === 0) return;
        if (href && href.indexOf('/policy') === 0) return;
        // Se è dentro il form hero, lascia che il form gestisca
        if (el.closest && el.closest('form[data-rs-patched]')) return;
        // Se è un link a wa.me/whatsapp o CTA generica -> scroll al form hero
        var txt = ((el.textContent||'')+' '+(el.getAttribute('aria-label')||'')).toLowerCase();
        var isCta = /wa\.me|whatsapp|^tel:|^mailto:/i.test(href) ||
                    /^#(contatto|contatti|contact|hero)/i.test(href) ||
                    /analisi|richiedi|contatta|contatto|scrivi|prenota|parla con|inizia/i.test(txt);
        if (!isCta) return;
        e.preventDefault();
        e.stopPropagation();
        var form = findHeroForm() || document.querySelector('form[data-rs-patched]') || document.querySelector('form');
        if (form) {
          form.scrollIntoView({behavior:'smooth', block:'center'});
          var firstInp = form.querySelector('input');
          if (firstInp) setTimeout(function(){ firstInp.focus(); }, 400);
        }
      }, true);

      function run(){
        try { patchText(document.body); } catch(e){}
        try { hideBubbleJS(); } catch(e){}
        try { patchHeroForm(); } catch(e){}
      }

      if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', run);
      else run();

      var mo = new MutationObserver(function(){ run(); });
      setTimeout(function(){
        if (document.body) mo.observe(document.body, {childList:true, subtree:true, characterData:true});
      }, 200);

      // Retry veloce per catturare widget con render ritardato
      var ticks = 0;
      var iv = setInterval(function(){
        run();
        if (++ticks > 30) clearInterval(iv);
      }, 500);
    })();
    </script>
  </body>
</html>
