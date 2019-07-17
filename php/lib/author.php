<?php
namespace djuarez11\objectorientedproject;

require_once ("../Classes/Author.php");

$rowling=new author ("1b08c0eb-7519-4402-92bf-c6b009ba9864",
	"https://proxy.duckduckgo.com/iu/?u=https%3A%2F%2Ftimedotcom.files.wordpress.com%2F2014%2F07%2F187481786.jpg%3Fw%3D720&f=1",
	"snape", "rowling@rowling.com", "eighttwo", "rowlingcool");

var_dump($rowling);



