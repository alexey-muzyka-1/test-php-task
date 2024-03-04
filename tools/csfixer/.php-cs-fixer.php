<?php

$finder = \PhpCsFixer\Finder::create()
    ->in(['src', 'tests', 'fixtures'])
    ->notName([
        'bootstrap.php',
        'Media.php'
    ])
;

$config = new PhpCsFixer\Config();
return $config->setRules([
    '@PSR12' => true,
    '@Symfony' => true,
    '@PHP71Migration' => true,
    'class_attributes_separation' => [
        'elements' => ['method' => 'one', 'property' => 'one', 'trait_import' => 'one']
    ],
    'concat_space' => ['spacing' => 'one'],
    'phpdoc_summary' => false,
    'no_useless_else' => true,
    'is_null' => true,
    'multiline_whitespace_before_semicolons' => true,
    'no_null_property_initialization' => true,
    'list_syntax' => ['syntax' => 'short'],
    'array_syntax' => ['syntax' => 'short'],
    'strict_comparison' => true,
    'strict_param' => true,
    'declare_strict_types' => true,
    'ordered_class_elements' => true,
    'date_time_immutable' => true,
    'no_unused_imports' => true,
    'ordered_imports' => ['sort_algorithm' => 'alpha'],
    'no_trailing_comma_in_singleline' => true,
    'trailing_comma_in_multiline' => true,
    'whitespace_after_comma_in_array' => true,
    'native_function_invocation' => [
        'include' => ['@compiler_optimized']
    ],
    'method_argument_space' => [
        'on_multiline' => 'ensure_fully_multiline'
    ],
    'fully_qualified_strict_types' => true,
    'no_unreachable_default_argument_value' => true,
    'static_lambda' => true,
    'no_superfluous_phpdoc_tags' => true,
    'single_line_throw' => false,
    'blank_line_before_statement' => [
        'statements' => [
            'break',
            'continue',
            'declare',
            'do',
            'for',
            'foreach',
            'if',
            'include',
            'include_once',
            'require',
            'require_once',
            'return',
            'switch',
            'throw',
            'try',
            'while',
            'yield',
        ],
    ],
    'compact_nullable_typehint' => true,
    'global_namespace_import' => [
        'import_classes' => true,
        'import_constants' => true,
        'import_functions' => true,
    ],
    'logical_operators' => true,
    'native_constant_invocation' => false,
    'no_alternative_syntax' => true,
    'no_unset_cast' => true,
    'no_useless_return' => true,
    'nullable_type_declaration_for_default_null_value' => true,
    'ordered_interfaces' => true,
    'phpdoc_align' => [
        'align' => 'left',
    ],
    'php_unit_dedicate_assert' => true,
    'php_unit_method_casing' => [
        'case' => 'snake_case',
    ],
    'php_unit_set_up_tear_down_visibility' => true,
    'php_unit_strict' => true,
    'phpdoc_order_by_value' => true,
    'php_unit_test_case_static_method_calls' => [
        'call_type' => 'self',
    ],
    'phpdoc_no_empty_return' => true,
    'phpdoc_order' => true,
    'self_static_accessor' => true,
    'yoda_style' => [
        'equal' => true,
        'identical' => true,
        'less_and_greater' => false,
    ],
    'blank_line_between_import_groups' => false,
//    'final_public_method_for_abstract_class' => true,
])
    ->setFinder($finder)
    ;
