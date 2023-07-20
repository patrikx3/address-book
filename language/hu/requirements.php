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
  <li>kategóriák   között létezik egy alapértelmezett (&quot;besorolatlan&quot; néven), ami nem   törölhető. Ha olyan kategóriát törölnek, amelyben már vannak címzettek,   azok ide kerülnek át.</li>
</ul>
<p>Természetesen   minden &quot;best practice&quot; megoldás alkalmazása előnyt jelent (pl. valid   HTML/CSS; ha JavaScript-et használ, diszkrét JavaScript; form   használhatósági megoldások; AdoDB, Smarty vagy más osztály használata   stb).</p>
<p>Beállítások: <strong>safe_mode=on</strong>, <strong>magic_quotes_gpc=off</strong>, <strong>error_reporting=E_ALL</strong>.</p>
<p>Bármelyik PHP működik.</p>

HEREDOC;
?>