<?php
/*
 * @package marspress/graphql-fields
 */

namespace MarsPress\GraphQL;

if( ! class_exists( 'Field' ) )
{

    final class Field
    {

        private string $typeName;

        private string $fieldName;

        private string $fieldDescription;

        private string $fieldType;

        private array $fieldArguments;

        /**
         * @var callable $fieldResolve
         */
        private $fieldResolve;

        private string $adminNotices;

        public function __construct(
            string $_typeName,
            string $_fieldName,
            string $_fieldType,
            string $_fieldDescription,
            array $_fieldArguments,
            $_fieldResolve
        ){

            $this->typeName = $_typeName;
            $this->fieldName = $_fieldName;
            $this->fieldType = $_fieldType;
            $this->fieldDescription = $_fieldDescription;
            $this->fieldArguments = $_fieldArguments;
            $this->fieldResolve = $_fieldResolve;

            if( ! is_callable( $this->fieldResolve ) ){

                $this->adminNotices = "The GraphQL Field with the field name of <strong><em>{$this->fieldName}</em></strong> does not have a valid/callable resolve method. Please update your resolve method to something callable/executable.";
                add_action( 'admin_notices', function (){
                    $message = $this->output_admin_notice();
                    echo $message;
                }, 10, 0 );

            }else{

                add_action( 'graphql_register_types', [ $this, 'register_field' ], 10, 1 );

            }

        }

        /**
         * @action graphql_register_types
         * @class \MarsPress\GraphQL\Field
         * @function register_field
         * @priority 10
         * @param \WPGraphQL\Registry\TypeRegistry $_typeRegistry
         * @return void
         */
        public function register_field( object $_typeRegistry ){

            if( is_callable( [ $_typeRegistry, 'register_field' ] ) ){

                $_typeRegistry->register_field(
                    $this->typeName,
                    $this->fieldName,
                    [
                        'type'          => $this->fieldType,
                        'description'   => $this->fieldDescription,
                        'args'          => $this->fieldArguments,
                        'resolve'       => $this->fieldResolve,
                    ]
                );

            }

        }

        private function output_admin_notice(): string{

            if( isset( $this->adminNotices ) && current_user_can( 'administrator' ) ){

                return "<div style='background: white; padding: 12px 20px; border-radius: 3px; border-left: 5px solid #dc3545;' class='notice notice-error is-dismissible'><p style='font-size: 16px;'>$this->adminNotices</p><small><em>This message is only visible to site admins</em></small></div>";

            }

            return '';

        }

    }

}