NFormBuilder
============

This tool can load metadata from database, doctrine metadata, symfony validation annotations or whatewer you want (if you implement simple interface) and then it helps you create forms in Nette framework.

<?php

$form = new UI\Form();
$dbTable = 'blog';

$formBuilderFactory->create($form, $dbTable)
	->add('name', 'slug', 'text', 'allowed');

// this syntax can be changed in future