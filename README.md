<img  src="https://github.com/infinitycube/quicksite/wiki/assets/quicksite-logo.svg?sanitize=true"  alt="QuickSite"  width="200">

_A Slim 4 scaffolding for creating web applications at lightning speed._

QuickSite let you focus on the application and data structure. The scaffolding creates a project structure with an example application for your reference. A powerful view render engine, Twig helps you create awesome templates to render pages. It also has a Database Abstraction Layer (DABL) from Doctrine, your application need not directly interact with the database.

### Prerequisites

For working with QuickSite scaffolding, you need the following

- Skill: Object Oriented PHP
- Skill: Twig Templating _(if you use Twig)_
- Skill: Doctrine ORM _(if you use Doctrine)_
- Composer installed on your machine
- Docker _(if you use Docker as your server stack)_
- MySQL _(if you are not using Docker)_
- PHP 7.2 or greater

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
$ docker-compose up
```

**No Docker**
For those who don't have Docker, you must create a database and assign user access in your local mysql server. Then you need to edit the file
`./app/settings.php` look for `db` and give values to `host` `dbname` `port` `user` and `password`

Now you can start local server

```bash
$ composer start
```

### Example Todo App

To make the example todo app working you need to run the migration bundled with this scaffolding.

For those who use Docker, you need to SSH into your docker container while it is running.

```bash
$ docker exec -it quick_site bash
```

Those who don't use Docker can skip the above step.

Now run the bundled migration.

```bash
$ php vendor/bin/doctrine-migrations migrations:migrate
```

You may now view the Todo app by pointing your browser to `http://localhost:8080/todo/`

### Note

You may or may not require the pre-bundled packages within QuickSite. You may remove those packages if you know exactly what you are doing. You may find more about QuickSite in the [QuickSite Documentation](https://github.com/infinitycube/quicksite/wiki).
