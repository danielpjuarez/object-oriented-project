<?php
namespace djuarez11\objectorientedproject;

require_once ("../Classes/Author.php");

$rowling=new author ("1b08c0eb-7519-4402-92bf-c6b009ba9864",
	"www.rowling.com",
	"aaaaaaaabbbbbbbbccccccccdddddddd", 'rowling@rowling.com',
	'$argon2i$v=19$m=1024,t=384,p=2$dE55dm5kRm9DTEYxNFlFUA$nNEMItrDUtwnDhZ41nwVm7ncBLrJzjh5mGIjj8RlzVA'
	, 'rowlingiscool');

var_dump($rowling);



