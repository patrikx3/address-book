<?php
global $config;

$lang['title'] = 'Installation';
$lang['content'] = <<<HEREDOC

<ol>
  <li>PHP 5.3 is needed to run the system</li>
  <li>PHP needed for extra add-ons: PDO, PDO-sqlite</li>
  <li>Because of the simplicity, SQLite was used, only one user can use the application!</li>
  <li>unzip address-book.zip somewhere</li>
  <li>map address-book/www map webserver</li>
  <li>make address-book/data writable by web server</li>
  <li>under address-book/ make all files readable for the web server</li>
  <li>after mapping the application index.php starts the application</li>
  <li>The application is available at the following site: <a href="{$config['deploymented-url']}">{$config['deploymented-url']}</a></li>
</ol>
<h2>Usage and features</h2>
<ul>
  <li>Data can be entered on any page</li>
  <li>Double-clicking on the grid, the data can be edited.</li>
  <li>Fields can be arranged in the data grid - DnD on the header</li>
  <li>There is a column chooser on the grid, so one can select which columns should be displayed</li>
  <li>The datagrid is resizable</li>
  <li>Drag-and-drop multiselect list</li>
</ul>
<h2>Note</h2>
<p>The application does not use any unnecessary framework, since most frameworks only slow down the server unnecessarily. Database abstraction is used via the builtin PHP PDO framwork which is the fastest since it is in C. Instead of slow templates, regular PHP is used in a MVC pattern via the <em>include</em> statement.</p>

HEREDOC;
?>