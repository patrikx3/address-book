<?php
global $config;

$lang['title'] = 'Telepítés';
$lang['content'] = <<<HEREDOC

<ol>
  <li>PHP 5.3 szükséges a rendszer futtatásához</li>
  <li>PHP-hez szükséges plusz bővítmények: PDO, PDO-SQLITE</li>
  <li>Mivel az egyszerűség kedvéért SQLite-ot használtam, egyszerre csak egy felhasználó használhatja az alkalmazást!</li>
  <li>address-book.zip kitömörítése valahova</li>
  <li>address-book/www bemeppelése webszerveren</li>
  <li>address-book/data írhatóvá tétele web szerver által</li>
  <li>address-book/ alatt minden fájl olvashatóvá tétele a webszerveren</li>
  <li>a webszerveren ahova bemeppelte az address-book-ot, ott az index.php-vel lehet indítani az alkalmazást</li>
  <li>Az alkalmazás a következő webhelyen érhető el: <a href="{$config['deploymented-url']}">{$config['deploymented-url']}</a></li>
</ol>
<h2>Használat és jellemzők</h2>
<ul>
  <li>Adatot bevinni bármelyik oldalon lehet</li>
  <li>Az adatrácson lévő adatot duplakattintással szerkeszteni lehet.</li>
  <li>Az adatrács mezői rendezhetőek - DnD a fejlécen</li>
  <li>Az adatrácson ki lehet választani mely mezők jelenjenek meg - alul van egy gomb</li>
  <li>Az adatrács méretezhető</li>
  <li>DnD multi választós lista</li>
</ul>

HEREDOC;
?>