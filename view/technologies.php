<script type="text/javascript">
$(document).ready(function() {
	$('#technologies-list a').each(function() {
		$el = $(this);
		$el.attr('title', $el.attr('href'));
	});

	lm.tooltip('#technologies-list a', {
		defaultPosition: 'top',
		attribute: 'title',
		maxWidth: '400px'
	});

});
</script>
<h1>Software technology</h1>
<ul id="technologies-list">
  <li><a href="http://en.wikipedia.org/wiki/Software_design">Software Design</a>
    <ul>
      <li><a href="http://en.wikipedia.org/wiki/Design_Patterns">Design Patterns</a>
        <ul>
          <li><a href="http://en.wikipedia.org/wiki/MVC">MVC</a></li>
          <li><a href="http://en.wikipedia.org/wiki/Prototype-based_programming">Prototype</a></li>
        </ul>
      </li>
      <li><a href="http://en.wikipedia.org/wiki/Object-oriented_programming">OOP</a></li>
      <li><a href="http://en.wikipedia.org/wiki/Service-oriented_architecture">SOA</a></li>
      <li><a href="http://en.wikipedia.org/wiki/Convention_over_configuration">CoC</a></li>
      <li><a href="http://en.wikipedia.org/wiki/Search_engine_optimization">SEO</a></li>
      <li><a href="http://en.wikipedia.org/wiki/Internationalization_and_localization">i18n</a></li>
    </ul>
  </li>
  <li><a href="http://en.wikipedia.org/wiki/Server_(computing)">Server</a>
    <ul>
      <li><a href="http://php.net/releases/5_3_0.php">PHP 5.3</a>
        <ul>
          <li><a href="http://php.net/manual/en/language.namespaces.php">PHP Namespaces</a></li>
          <li><a href="http://php.net/manual/en/book.pdo.php">PDO</a></li>
        </ul>
      </li>
      <li><a href="http://www.sqlite.org/">SQLite</a></li>
    </ul>
  </li>
  <li><a href="http://en.wikipedia.org/wiki/Fat_client">Fat client</a>
    <ul>
      <li><a href="http://www.w3.org/TR/xhtml1/">XHTML 1.0</a></li>
      <li><a href="http://www.w3.org/TR/CSS21/">CSS2.1</a></li>
      <li><a href="http://en.wikipedia.org/wiki/JavaScript">JavaScript</a>
        <ul>
          <li><a href="http://en.wikipedia.org/wiki/Ajax_(programming)">Ajax</a></li>
          <li><a href="http://www.json.org/">JSON</a></li>
          <li><a href="http://jquery.com/">jQuery</a>
            <ul>
              <li><a href="http://jqueryui.com/">jQuery UI</a></li>
              <li><a href="https://github.com/stanlemon/jGrowl">jGrowl</a></li>
              <li><a href="https://github.com/drewwilson/TipTip">tipTip</a></li>
              <li><a href="https://github.com/makotokw/jquery.ui.potato.menu/">Potato Menu</a></li>
              <li><a href="http://www.trirand.com/blog/">jqGrid</a></li>
              <li><a href="http://jquery.malsup.com/block/">blockUI</a></li>
              <li><a href="http://quasipartikel.at/multiselect/">Multiselect</a></li>   
              <li><a href="http://www.asual.com/jquery/address/">Address</a></li>                           
            </ul>
          </li>
        </ul>
      </li>
    </ul>
  </li>
</ul>
