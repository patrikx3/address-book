<?php
$lang['title'] = 'Követelmények';
$lang['content'] = <<<HEREDOC

<p><strong>Feladat: címjegyzék alkalmazás készítése</strong></p>
<p>Szükséges funkciók:</p>
<ul>
  <li>kategóriák felvitele, módosítása, törlése,</li>
  <li>címzettek felvitele,</li>
  <li>kategóriák kiválasztása, kötelezően legalább egy, de több is lehet</li>
  <li>név, e-mail cím, felvitel időpontja kötelező mezők</li>
  <li>mobiltelefonszám opcionális, de ha megadják, nemzetközi formátumban (36x01112222, x = 2,3,7) kötelező</li>
  <li>címzettek böngészése lapozható, a mezők alapján rendezhető listában</li>
  <li>címzettek módosítása, törlése</li>
  <li>kategóriák   között létezik egy alapértelmezett (&quot;besorolatlan&quot;néven), ami nem   törölhető. Ha olyan kategóriát törölnek, amelyben már vannak címzettek,   azok ide kerülnek át.</li>
</ul>
<p>Természetesen   minden &quot;best practice&quot; megoldás alkalmazása előnyt jelent (pl. valid   HTML/CSS; ha JavaScript-et használ, diszkrét JavaScript; form   használhatósági megoldások; AdoDB, Smarty vagy más osztály használata   stb).</p>
<p>Beállítások: safe_mode=on, magic_quotes_gpc=off, error_reporting=E_ALL.</p>
<p>Szükség esetén PHP4 vagy 5 ág legújabb verzió választható.</p>
<h2>Átadandó   anyagok</h2>
<p>PHP kódok és minden egyéb zip állományban, valamint egy pontos   telepítési leírás. Ha van rá lehetősége, kérem, tegye az alkalmazást   online elérhetővé, ilyen esetben egy URL-t is kérek.</p>

HEREDOC;
?>