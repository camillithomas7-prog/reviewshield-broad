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
    <meta property="og:image" content="https://reviewshieldita.lovable.app/og-image.jpg">
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:image" content="https://reviewshieldita.lovable.app/og-image.jpg">

    <!-- TODO: Google Analytics (GA4) — sostituire G-XXXXXXXXXX con il tuo ID -->
    <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-XXXXXXXXXX');
    </script> -->

    <!-- TODO: Meta Pixel — sostituire YOUR_PIXEL_ID col tuo Pixel ID -->
    <!-- <script>
      !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', 'YOUR_PIXEL_ID');
      fbq('track', 'PageView');
    </script> -->

    <meta property="og:title" content="ReviewShield">
    <meta name="twitter:title" content="ReviewShield">
    <meta property="og:description" content="Rimuoviamo le recensioni negative da Google. Prima analisi gratuita, paghi solo a risultato ottenuto">
    <meta name="twitter:description" content="Rimuoviamo le recensioni negative da Google. Prima analisi gratuita, paghi solo a risultato ottenuto">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#059669">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" href="/icon-192.png">
    <script type="module" crossorigin src="/assets/index-DW4n5zfc.js"></script>
    <link rel="stylesheet" crossorigin href="/assets/index-BNl2Bqut.css">
  </head>

  <body>
    <!-- TODO: Meta Pixel noscript fallback -->
    <!-- <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=YOUR_PIXEL_ID&ev=PageView&noscript=1"/></noscript> -->
    <div id="root"></div>

    <!-- LEAD FORM OVERLAY -->
    <div id="lead-form-overlay" style="display:none;position:fixed;inset:0;z-index:99999;background:rgba(0,0,0,.7);backdrop-filter:blur(8px);align-items:center;justify-content:center;padding:20px">
      <div style="background:#0f1a14;border:1px solid rgba(5,150,105,.2);border-radius:16px;padding:32px;max-width:440px;width:100%;position:relative;box-shadow:0 20px 60px rgba(0,0,0,.5)">
        <button type="button" onclick="closeLeadForm()" style="position:absolute;top:12px;right:14px;background:none;border:none;color:#666;font-size:22px;cursor:pointer;line-height:1">&times;</button>
        <h3 style="color:#fff;font-size:22px;font-weight:800;margin-bottom:4px;font-family:system-ui">Analisi Gratuita</h3>
        <p style="color:#888;font-size:13px;margin-bottom:20px;font-family:system-ui">Lascia i tuoi dati e ti ricontattiamo entro 24h con l'analisi delle tue recensioni Google.</p>
        <div id="lead-form-msg" style="display:none;padding:10px;border-radius:8px;margin-bottom:12px;font-size:13px;font-family:system-ui"></div>
        <input id="lf-nome" type="text" placeholder="Nome" style="width:100%;padding:12px 16px;background:#1a2a20;border:1px solid #2a3a30;border-radius:10px;color:#fff;font-size:14px;margin-bottom:10px;outline:none;font-family:system-ui">
        <input id="lf-cognome" type="text" placeholder="Cognome" style="width:100%;padding:12px 16px;background:#1a2a20;border:1px solid #2a3a30;border-radius:10px;color:#fff;font-size:14px;margin-bottom:10px;outline:none;font-family:system-ui">
        <input id="lf-email" type="email" placeholder="Email" required style="width:100%;padding:12px 16px;background:#1a2a20;border:1px solid #2a3a30;border-radius:10px;color:#fff;font-size:14px;margin-bottom:10px;outline:none;font-family:system-ui">
        <input id="lf-telefono" type="tel" placeholder="Numero di telefono" required style="width:100%;padding:12px 16px;background:#1a2a20;border:1px solid #2a3a30;border-radius:10px;color:#fff;font-size:14px;margin-bottom:16px;outline:none;font-family:system-ui">
        <button type="button" onclick="submitLead()" id="lf-submit" style="width:100%;padding:14px;background:#059669;color:#fff;border:none;border-radius:10px;font-size:15px;font-weight:700;cursor:pointer;font-family:system-ui">Richiedi Analisi Gratuita</button>
      </div>
    </div>

    <script>
    function preloadFromPage(){
      // Cerca un form/input con nome+cognome pre-compilato nel React app
      var inputs = document.querySelectorAll('input[type="text"]:not([id^="lf-"]), input[type="tel"]:not([id^="lf-"]), input[type="email"]:not([id^="lf-"])');
      inputs.forEach(function(inp){
        var v = (inp.value||'').trim();
        if (!v) return;
        var ph = ((inp.placeholder||'')+' '+(inp.name||'')+' '+(inp.getAttribute('aria-label')||'')).toLowerCase();
        if (inp.type === 'tel' || /tel|phone|numero/i.test(ph)) {
          var t = document.getElementById('lf-telefono');
          if (t && !t.value) t.value = v;
        } else if (inp.type === 'email' || /email|mail/i.test(ph)) {
          var e = document.getElementById('lf-email');
          if (e && !e.value) e.value = v;
        } else if (/nome|name/i.test(ph)) {
          // Splitta "Mario Rossi" in nome + cognome se possibile
          var parts = v.split(/\s+/);
          var n = document.getElementById('lf-nome');
          var c = document.getElementById('lf-cognome');
          if (n && !n.value) n.value = parts[0] || '';
          if (c && !c.value && parts.length > 1) c.value = parts.slice(1).join(' ');
        }
      });
    }
    function openLeadForm(){
      try { preloadFromPage(); } catch(e){}
      var ov=document.getElementById('lead-form-overlay');
      ov.style.display='flex';
      setTimeout(function(){
        var n=document.getElementById('lf-nome');
        if(n && !n.value) n.focus();
        else {
          var t=document.getElementById('lf-telefono');
          if(t && !t.value) t.focus();
        }
      },100);
    }
    function closeLeadForm(){
      document.getElementById('lead-form-overlay').style.display='none';
    }
    window.openLeadForm=openLeadForm;

    function submitLead(){
      var nome=document.getElementById('lf-nome').value.trim();
      var cognome=document.getElementById('lf-cognome').value.trim();
      var email=document.getElementById('lf-email').value.trim();
      var telefono=document.getElementById('lf-telefono').value.trim();
      var msg=document.getElementById('lead-form-msg');
      var btn=document.getElementById('lf-submit');
      function showErr(t){msg.style.display='block';msg.style.background='rgba(239,68,68,.15)';msg.style.color='#ef4444';msg.textContent=t;}
      function showOk(t){msg.style.display='block';msg.style.background='rgba(34,197,94,.15)';msg.style.color='#22c55e';msg.textContent=t;}
      if(!nome||!cognome||!email||!telefono){showErr('Compila tutti i campi: nome, cognome, email e telefono');return}
      // Valida email base
      if(!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email)){showErr('Email non valida');return}
      btn.disabled=true;btn.textContent='Invio in corso...';
      fetch('submit.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({nome:nome,cognome:cognome,email:email,telefono:telefono})})
      .then(function(r){return r.json()}).then(function(d){
        btn.disabled=false;btn.textContent='Richiedi Analisi Gratuita';
        if(d.ok){
          showOk('Grazie! Ti ricontattiamo entro 24 ore.');
          document.getElementById('lf-nome').value='';
          document.getElementById('lf-cognome').value='';
          document.getElementById('lf-email').value='';
          document.getElementById('lf-telefono').value='';
          setTimeout(closeLeadForm, 2200);
        } else {showErr(d.error||'Errore');}
      }).catch(function(){btn.disabled=false;btn.textContent='Richiedi Analisi Gratuita';showErr('Errore di connessione');});
    }

    // === PATCH React bundle: rimuovi riferimenti WhatsApp, usa solo form lead ===
    (function(){
      var TEXT_REPL = [
        [/Scrivici su WhatsApp/g, 'Richiedi Analisi Gratuita'],
        [/Invia su WhatsApp/g, 'Invia richiesta'],
        [/Apri WhatsApp/g, 'Richiedi analisi'],
        [/Compila e ti si apre WhatsApp con il messaggio pronto/g, 'Lascia i tuoi dati: ti ricontattiamo entro 24 ore'],
        [/ti si apre WhatsApp con il messaggio pronto/g, 'ti ricontattiamo entro 24 ore'],
        [/Risposta entro 2 ore/g, 'Ti ricontattiamo entro 24 ore'],
        [/risposta entro 2 ore/g, 'ti ricontattiamo entro 24 ore'],
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
            if (n.parentElement && n.parentElement.closest && n.parentElement.closest('#lead-form-overlay')) return NodeFilter.FILTER_REJECT;
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
      function hideWhatsappBubble(){
        // Hide any fixed-position WhatsApp link (floating bubble)
        document.querySelectorAll('a[href*="wa.me"], a[href*="whatsapp"], a[href*="api.whatsapp"]').forEach(function(a){
          if (a.closest && a.closest('#lead-form-overlay')) return;
          try {
            var cs = getComputedStyle(a);
            if (cs.position === 'fixed' || cs.position === 'sticky') {
              a.style.display = 'none';
            }
          } catch(e){}
        });
        // Also hide any explicit floating-chat container
        document.querySelectorAll('[class*="whatsapp" i], [id*="whatsapp" i], [class*="wa-bubble" i], [class*="floating-chat" i]').forEach(function(el){
          if (el.closest && el.closest('#lead-form-overlay')) return;
          el.style.display = 'none';
        });
      }
      function run(){ try { patchText(document.body); hideWhatsappBubble(); } catch(e){} }
      if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', run);
      else run();
      var mo = new MutationObserver(function(){ run(); });
      setTimeout(function(){ if (document.body) mo.observe(document.body, {childList:true, subtree:true, characterData:true}); }, 300);
    })();

    // === INTERCETTA TUTTI I CTA DEL FUNNEL ===
    function isCtaEl(el){
      if(!el) return false;
      if(el.closest && el.closest('#lead-form-overlay')) return false;
      var href=(el.getAttribute && el.getAttribute('href'))||'';
      if(href && (href.indexOf('/privacy')===0 || href.indexOf('/termini')===0 || href.indexOf('/policy')===0)) return false;
      if(href){
        if(/wa\.me|whatsapp|api\.whatsapp|^tel:|^mailto:/i.test(href)) return true;
        if(/^#(contatto|contatti|contact|hero|form)/i.test(href)) return true;
      }
      var txt=((el.textContent||'')+' '+(el.getAttribute('aria-label')||'')+' '+(el.getAttribute('title')||'')).toLowerCase();
      if(/analisi|richiedi|contatta|contatto|scrivi|invia|prenota|candidati|parla con|scopri di pi|ricevi|inizia ora|inizia adesso|prova ora|richiesta/i.test(txt)) return true;
      return false;
    }
    document.addEventListener('click',function(e){
      var el=e.target.closest && e.target.closest('a,button,[role="button"]');
      if(!el)return;
      if(!isCtaEl(el))return;
      e.preventDefault();
      e.stopPropagation();
      openLeadForm();
    },true);

    // Intercetta submit di qualsiasi form (non il nostro) -> apri overlay con dati precompilati
    document.addEventListener('submit',function(e){
      var f=e.target;
      if (!f) return;
      if (f.closest && f.closest('#lead-form-overlay')) return;
      e.preventDefault();
      e.stopPropagation();
      openLeadForm();
    },true);
    </script>
  </body>
</html>
