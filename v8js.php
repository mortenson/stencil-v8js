<?php

$v8 = new V8Js();

// Echo a test string to verify that v8js is working.
$v8->test = 'If you read this, v8js is working!';
$v8->executeString('print("\n" + PHP.test + "\n\n")');

// Load required Stencil code. This will fail, for now. :-)
// Vaguely based on https://gist.github.com/yyx990803/9bdff05e5468a60ced06c29c39114c6b#environment-agnostic-ssr
$renderer_source = file_get_contents(__DIR__ . '/node_modules/@stencil/core/server/index.js');
$component_source = file_get_contents(__DIR__ . '/dist/collection/components/my-component/my-component.js');
$app_source = file_get_contents(__DIR__ . '/dist/collection/components/my-component/my-component.js');

$v8->executeString($renderer_source);
$v8->executeString($component_source);

$html = '<my-component first="loving" last="v8js!"></my-component>';
$rendered_html = $v8->executeString('// Magic render call goes here...');

// We expect something like <my-component first="loving" last="v8js!"><div>Hello, World! I'm loving v8js!</div></my-component>
echo "Returned HTML from Stencil: $rendered_html\n";
