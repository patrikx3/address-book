<?php
$lang['title'] = 'Requirements';
$lang['content'] = <<<HEREDOC

<p><strong>Task: Create Address Book application</strong></p>
<p>Necessary functions:</p>
<ul>
  <li>Categories: add, edit, delete</li>
  <li>Add address</li>
  <li>Select categories, at least one obligatory, but more can be</li>
  <li>name, e-mail address, date of entry required fields</li>
  <li>mobile number is optional, but if granted, the international format required (36x01112222, x = 2,3,7) </li>
  <li>Browse adresses, paginated, based on the sort fields in the list</li>
  <li>Address edit, delete</li>
  <li>categories, there is a default (&quot;uncategorised&quot; named), not deletable. If a category is deleted, which already has addresses, the addresses are moved here.</li>
</ul>
<p>
Any best practive solution is an advantage (valid HTML/CSS, discrete Javascript, form usability, AdoDB, Smarty, other classes)</p>
<p>Settings: <strong>safe_mode=on</strong>, <strong>magic_quotes_gpc=off</strong>, <strong>error_reporting=E_ALL</strong>.</p>

<p>Any PHP version can be used.</p>

HEREDOC;
?>