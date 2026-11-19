<img  src="https://github.com/infinitycube/quicksite/wiki/assets/quicksite-logo.svg?sanitize=true"  alt="QuickSite"  width="200">

_A Slim 4 scaffolding for creating web applications at lightning speed._

QuickSite let you focus on the application and data structure. The scaffolding creates a project structure with an example application for your reference. A powerful view render engine, Twig helps you create awesome templates to render pages. It also has a Database Abstraction Layer (DABL) from Doctrine, your application need not directly interact with the database.

### Prerequisites

For working with QuickSite scaffolding, you need the following

- PHP 8.4 or newer _(not needed locally if you use Docker)_
- Skill: Object Oriented PHP
- Skill: Twig Templating _(if you use Twig)_
- Skill: Doctrine ORM _(if you use Doctrine)_
- Composer installed on your machine
- Docker _(if you use Docker as your server stack)_
- MySQL 8 / MariaDB Server _(if you are not using Docker)_

### Setup Project

You can setup your Slim 4 project with QuickSite in a line of command in terminal / command-prompt.

```bash
$ composer create-project infinitycube/quicksite myproject
```

Go to your project directory

```bash
$ cd myproject
```

If you are have Docker installed and running, you may start your development server immediately by running.

```bash
$ docker compose up
```

### Configuration

Settings are read from environment variables, with sensible defaults in `./app/settings.php`.
`composer create-project` copies `.env.example` to `.env` for you; edit `.env` to override any value.
`.env` is git-ignored and is optional — never commit it.

**No Docker**

For those who don't have Docker, you must create a database and assign user access in your local mysql server. Then set `DB_HOST`, `DB_NAME`, `DB_PORT`, `DB_USER` and `DB_PASSWORD` in your `.env` file (copy it from `.env.example` if it does not exist).

Now you can start local server

```bash
$ composer start
```

### Example Todo App

To make the example todo app working you need to run the migration bundled with this scaffolding.

For those who use Docker, you need to SSH into your docker container while it is running.

```bash
$ docker compose exec site bash
```

Those who don't use Docker can skip the above step.

Now run the bundled migration.

```bash
$ php vendor/bin/doctrine-migrations migrations:migrate
```

You may now view the Todo app by pointing your browser to `http://localhost:8080/todo/`

### Running Tests

Sample unit and feature tests live in `./tests`. They do not need a database.

```bash
$ composer test
```

With Docker: `docker compose run --rm site composer test`

### Note

You may or may not require the pre-bundled packages within QuickSite. You may remove those packages if you know exactly what you are doing. You may find more about QuickSite in the [QuickSite Documentation](https://github.com/infinitycube/quicksite/wiki).
