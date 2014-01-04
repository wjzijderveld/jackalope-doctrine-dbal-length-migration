# Jackalope Doctrine DBAL length migration

To make the PHPCR LENGTH() operand work on all property types, we needed to store the length with all properties. With
this migration all properties get iterated and saved again so all properties have the correct information saved with
them.

Relevant pull request: https://github.com/jackalope/jackalope-doctrine-dbal/pull/156

## Running the migration

To run this migration, you first need install the dependencies.

    $ composer install

You then need to configure your PHPCR workspace by copying the cli-config.php.dist file and filling in you DBAL
information.

After that, just run the migration (it will ask for confirmation).

    $ php bin/migrate.php